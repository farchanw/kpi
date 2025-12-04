<?php

namespace App\Http\Controllers;

use App\Models\KpiEntry;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;

class KpiEntryController extends DefaultController
{
    protected $modelClass = KpiEntry::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Kpi Entry';
        $this->generalUri = 'kpi-entry';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true],
                    ['name' => 'User id', 'column' => 'user_id', 'order' => true],
                    ['name' => 'Evaluator id', 'column' => 'evaluator_id', 'order' => true],
                    ['name' => 'Key perf area', 'column' => 'key_perf_area', 'order' => true],
                    ['name' => 'Kpi template id', 'column' => 'kpi_template_id', 'order' => true],
                    ['name' => 'Weight', 'column' => 'weight', 'order' => true],
                    ['name' => 'Target', 'column' => 'target', 'order' => true],
                    ['name' => 'Actual', 'column' => 'actual', 'order' => true],
                    ['name' => 'Score', 'column' => 'score', 'order' => true],
                    ['name' => 'Final score', 'column' => 'final_score', 'order' => true], 
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => ['user_id'],
            'headers' => [
                    ['name' => 'User id', 'column' => 'user_id'],
                    ['name' => 'Evaluator id', 'column' => 'evaluator_id'],
                    ['name' => 'Key perf area', 'column' => 'key_perf_area'],
                    ['name' => 'Kpi template id', 'column' => 'kpi_template_id'],
                    ['name' => 'Weight', 'column' => 'weight'],
                    ['name' => 'Target', 'column' => 'target'],
                    ['name' => 'Actual', 'column' => 'actual'],
                    ['name' => 'Score', 'column' => 'score'],
                    ['name' => 'Final score', 'column' => 'final_score'], 
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
                    [
                        'type' => 'text',
                        'label' => 'Evaluator id',
                        'name' =>  'evaluator_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('evaluator_id', $id),
                        'value' => (isset($edit)) ? $edit->evaluator_id : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Key perf area',
                        'name' =>  'key_perf_area',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('key_perf_area', $id),
                        'value' => (isset($edit)) ? $edit->key_perf_area : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Kpi template id',
                        'name' =>  'kpi_template_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('kpi_template_id', $id),
                        'value' => (isset($edit)) ? $edit->kpi_template_id : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Weight',
                        'name' =>  'weight',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('weight', $id),
                        'value' => (isset($edit)) ? $edit->weight : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Target',
                        'name' =>  'target',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('target', $id),
                        'value' => (isset($edit)) ? $edit->target : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Actual',
                        'name' =>  'actual',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('actual', $id),
                        'value' => (isset($edit)) ? $edit->actual : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Score',
                        'name' =>  'score',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('score', $id),
                        'value' => (isset($edit)) ? $edit->score : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Final score',
                        'name' =>  'final_score',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('final_score', $id),
                        'value' => (isset($edit)) ? $edit->final_score : ''
                    ],
        ];
        
        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [
                    'user_id' => 'required|string',
                    'evaluator_id' => 'required|string',
                    'key_perf_area' => 'required|string',
                    'kpi_template_id' => 'required|string',
                    'weight' => 'required|string',
                    'target' => 'required|string',
                    'actual' => 'required|string',
                    'score' => 'required|string',
                    'final_score' => 'required|string',
        ];

        return $rules;
    }

}
