<?php

namespace App\Http\Controllers;

use App\Models\Aspect;
use App\Models\Grading;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;
use Illuminate\Support\Facades\DB;

class AspectController extends DefaultController
{
    protected $modelClass = Aspect::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Aspect';
        $this->generalUri = 'aspect';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true],
                    ['name' => 'Name', 'column' => 'name', 'order' => true],
                    ['name' => 'Grading', 'column' => 'grading', 'order' => true], 
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => ['name'],
            'headers' => [
                    ['name' => 'Name', 'column' => 'name'],
                    ['name' => 'Grading', 'column' => 'grading'], 
            ]
        ];
    }


    protected function fields($mode = "create", $id = '-')
    {
        $edit = null;
        if ($id != '-') {
            $edit = $this->modelClass::where('id', $id)->first();
        }

        $gradingOptions = Grading::join('divisions', 'divisions.id', '=', 'gradings.division_id')
            ->select(DB::raw('CONCAT_WS(" ", gradings.name, divisions.name) as text'), 'gradings.id as value')
            ->get()->toArray();

            
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
                        'label' => 'Grading',
                        'name' =>  'grading_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('grading_id', $id),
                        'value' => (isset($edit)) ? $edit->grading_id : '',
                        'options' => $gradingOptions,
                    ],
        ];
        
        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [
                    'name' => 'required|string',
                    'grading_id' => 'required|string',
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

        $dataQueries = $this->modelClass::join('gradings', 'gradings.id', '=', 'aspects.grading_id')
            ->join('divisions', 'divisions.id', '=', 'gradings.division_id')
            ->where($filters)
            ->where(function ($query) use ($orThose) {
                $query->where('gradings.name', 'LIKE', '%' . $orThose . '%');
            })
            ->orderBy($orderBy, $orderState)
            ->select('aspects.*', DB::raw('CONCAT_WS(" ", gradings.name, divisions.name) as grading'));

        return $dataQueries;
    }

    protected function show($id)
    {
        $singleData = $this->defaultDataQuery()->where('aspects.id', $id)->first();
        unset($singleData['id']);

        $data['detail'] = $singleData;

        return view('easyadmin::backend.idev.show-default', $data);
    }

}
