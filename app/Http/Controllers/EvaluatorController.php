<?php

namespace App\Http\Controllers;

use App\Models\Evaluator;
use App\Models\User;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;

class EvaluatorController extends DefaultController
{
    protected $modelClass = Evaluator::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Evaluator';
        $this->generalUri = 'evaluator';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true],
                    ['name' => 'User id', 'column' => 'user', 'order' => true], 
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => ['user_id'],
            'headers' => [
                    ['name' => 'User id', 'column' => 'user'], 
            ]
        ];
    }


    protected function fields($mode = "create", $id = '-')
    {
        $edit = null;
        if ($id != '-') {
            $edit = $this->modelClass::where('id', $id)->first();
        }

        $userOptions = User::select(['users.id as value', 'users.name as text'])   
        ->get();

        $fields = [
                    [
                        'type' => 'select2',
                        'label' => 'User',
                        'name' =>  'user_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('user_id', $id),
                        'value' => (isset($edit)) ? $edit->user_id : '',
                        'options' => $userOptions,
                    ],
        ];
        
        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [
                    'user_id' => 'required|string',
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

        $dataQueries = $this->modelClass::join('users', 'users.id', '=', 'evaluators.user_id')
            ->where($filters)
            ->where(function ($query) use ($orThose) {
                $query->where('users.name', 'LIKE', '%' . $orThose . '%');
            })
            ->orderBy($orderBy, $orderState)
            ->select('evaluators.*', 'users.name as user');

        return $dataQueries;
    }

    protected function show($id)
    {
        $singleData = $this->defaultDataQuery()->where('evaluators.id', $id)->first();
        unset($singleData['id']);

        $data['detail'] = $singleData;

        return view('easyadmin::backend.idev.show-default', $data);
    }

}
