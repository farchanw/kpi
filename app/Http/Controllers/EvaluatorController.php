<?php

namespace App\Http\Controllers;

use App\Models\Evaluator;
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
                    ['name' => 'User id', 'column' => 'user_id', 'order' => true], 
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => ['user_id'],
            'headers' => [
                    ['name' => 'User id', 'column' => 'user_id'], 
            ]
        ];
    }


    protected function fields($mode = "create", $id = '-')
    {
        $edit = null;
        if ($id != '-') {
            $edit = $this->modelClass::where('id', $id)->first();
        }

        $fields = [
                    [
                        'type' => 'text',
                        'label' => 'User id',
                        'name' =>  'user_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('user_id', $id),
                        'value' => (isset($edit)) ? $edit->user_id : ''
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

}
