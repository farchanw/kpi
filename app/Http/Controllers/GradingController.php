<?php

namespace App\Http\Controllers;

use App\Models\Grading;
use App\Models\Division;
use Idev\EasyAdmin\app\Helpers\Constant;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;

class GradingController extends DefaultController
{
    protected $modelClass = Grading::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Grading';
        $this->generalUri = 'grading';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true],
                    ['name' => 'Name', 'column' => 'name', 'order' => true],
                    ['name' => 'Division', 'column' => 'division', 'order' => true], 
                    ['name' => 'Level', 'column' => 'level', 'order' => true], 
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => ['name'],
            'headers' => [
                    ['name' => 'Name', 'column' => 'name'],
                    ['name' => 'Division', 'column' => 'division_id'], 
            ]
        ];
    }


    protected function fields($mode = "create", $id = '-')
    {
        $edit = null;
        if ($id != '-') {
            $edit = $this->modelClass::where('id', $id)->first();
        }

        $divisionOptions = Division::select(['id as value', 'name as text'])->get();
        $levelOptions = [
            ['text' => '1', 'value' => 1],
            ['text' => '2', 'value' => 2],
            ['text' => '3', 'value' => 3],
            ['text' => '4', 'value' => 4],
            ['text' => '5', 'value' => 5],
            ['text' => '6', 'value' => 6],
        ];

        $fields = [
                    [
                        'type' => 'text',
                        'label' => 'Name',
                        'name' =>  'name',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('name', $id),
                        'value' => (isset($edit)) ? $edit->name : ''
                    ],
                    [
                        'type' => 'select',
                        'label' => 'Division',
                        'name' =>  'division_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('division_id', $id),
                        'value' => (isset($edit)) ? $edit->division_id : '',
                        'options' => $divisionOptions,
                    ],
                    [
                        'type' => 'select',
                        'label' => 'Level',
                        'name' =>  'level',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('level', $id),
                        'value' => (isset($edit)) ? $edit->level : '',
                        'options' => $levelOptions,
                    ],
        ];
        
        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [
                    'name' => 'required|string',
                    'division_id' => 'required|string',
        ];

        return $rules;
    }

    protected function defaultDataQuery()
    {
        $filters = [];
        $orThose = null;
        $orderBy = 'id';
        $orderState = 'DESC';
        if (request('search')) {
            $orThose = request('search');
        }
        if (request('order')) {
            $orderBy = request('order');
            $orderState = request('order_state');
        }

        $dataQueries = $this->modelClass::join('divisions', 'divisions.id', '=', 'gradings.division_id')
            ->where($filters)
            ->where(function ($query) use ($orThose) {
                $query->where('divisions.name', 'LIKE', '%' . $orThose . '%');
            })
            ->orderBy($orderBy, $orderState)
            ->select('gradings.*', 'divisions.name as division');

        return $dataQueries;
    }

    protected function show($id)
    {
        $singleData = $this->defaultDataQuery()->where('gradings.id', $id)->first();
        unset($singleData['id']);

        $data['detail'] = $singleData;

        return view('easyadmin::backend.idev.show-default', $data);
    }

}
