<?php

namespace App\Http\Controllers;

use App\Models\Division;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;

class DivisionController extends DefaultController
{
    protected $modelClass = Division::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Division';
        $this->generalUri = 'division';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true],
                    ['name' => 'Name', 'column' => 'name', 'order' => true],
                    ['name' => 'Category', 'column' => 'category', 'order' => true], 
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => ['name'],
            'headers' => [
                    ['name' => 'Name', 'column' => 'name'],
                    ['name' => 'Category', 'column' => 'category'], 
            ]
        ];
    }


    protected function fields($mode = "create", $id = '-')
    {
        $edit = null;
        if ($id != '-') {
            $edit = $this->modelClass::where('id', $id)->first();
        }

        $categoryOptions = [
            ['text' => 'Manufaktur', 'value' => 'Manufaktur'],
            ['text' => 'Non-Manufaktur', 'value' => 'Non-Manufaktur'],
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
                        'label' => 'Category',
                        'name' =>  'category',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('category', $id),
                        'value' => (isset($edit)) ? $edit->category : '',
                        'options' => $categoryOptions,
                    ],
        ];
        
        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [
                    'name' => 'required|string',
                    'category' => 'required|string',
        ];

        return $rules;
    }

}
