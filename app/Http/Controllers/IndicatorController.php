<?php

namespace App\Http\Controllers;

use App\Models\Indicator;
use App\Models\Aspect;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;

class IndicatorController extends DefaultController
{
    protected $modelClass = Indicator::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Indicator';
        $this->generalUri = 'indicator';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true],
                    ['name' => 'Aspect', 'column' => 'aspect_id', 'order' => true],
                    ['name' => 'Parameter', 'column' => 'parameter', 'order' => true],
                    ['name' => 'Weight', 'column' => 'weight', 'order' => true],
                    ['name' => 'Target', 'column' => 'target', 'order' => true],
                    ['name' => 'Measurement unit', 'column' => 'measurement_unit', 'order' => true],
                    ['name' => 'Calculation type', 'column' => 'calculation_type', 'order' => true],
                    ['name' => 'Kpi type', 'column' => 'kpi_type', 'order' => true], 
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => ['aspect_id'],
            'headers' => [
                    ['name' => 'Aspect id', 'column' => 'aspect_id'],
                    ['name' => 'Parameter', 'column' => 'parameter'],
                    ['name' => 'Weight', 'column' => 'weight'],
                    ['name' => 'Target', 'column' => 'target'],
                    ['name' => 'Measurement unit', 'column' => 'measurement_unit'],
                    ['name' => 'Calculation type', 'column' => 'calculation_type'],
                    ['name' => 'Kpi type', 'column' => 'kpi_type'], 
            ]
        ];
    }


    protected function fields($mode = "create", $id = '-')
    {
        $edit = null;
        if ($id != '-') {
            $edit = $this->modelClass::where('id', $id)->first();
        }

        $aspectOptions = Aspect::select(['id as value', 'name as text'])->get();
        $measurementUnitOptions = [
            ['text' => 'Percentage', 'value' => 'Percentage'],
            ['text' => 'Number', 'value' => 'Number'],
            ['text' => 'Currency', 'value' => 'Currency'],
        ];
        $calculationTypeOptions = [
            ['text' => 'Sum', 'value' => 'Sum'],
            ['text' => 'Average', 'value' => 'Average'],
            ['text' => 'End', 'value' => 'End'],
        ];
        $kpiTypeOptions = [
            ['text' => 'Maximize', 'value' => 'Maximize'],
            ['text' => 'Minimize', 'value' => 'Minimize'],
        ];

        $fields = [
                    [
                        'type' => 'select',
                        'label' => 'Aspect',
                        'name' =>  'aspect_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('aspect_id', $id),
                        'value' => (isset($edit)) ? $edit->aspect_id : '',
                        'options' => $aspectOptions,
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Parameter',
                        'name' =>  'parameter',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('parameter', $id),
                        'value' => (isset($edit)) ? $edit->parameter : ''
                    ],
                    [
                        'type' => 'number',
                        'label' => 'Weight',
                        'name' =>  'weight',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('weight', $id),
                        'value' => (isset($edit)) ? $edit->weight : '',
                    ],
                    [
                        'type' => 'number',
                        'label' => 'Target',
                        'name' =>  'target',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('target', $id),
                        'value' => (isset($edit)) ? $edit->target : ''
                    ],
                    [
                        'type' => 'select',
                        'label' => 'Measurement unit',
                        'name' =>  'measurement_unit',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('measurement_unit', $id),
                        'value' => (isset($edit)) ? $edit->measurement_unit : '',
                        'options' => $measurementUnitOptions,
                    ],
                    [
                        'type' => 'select',
                        'label' => 'Calculation type',
                        'name' =>  'calculation_type',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('calculation_type', $id),
                        'value' => (isset($edit)) ? $edit->calculation_type : '',
                        'options' => $calculationTypeOptions,
                    ],
                    [
                        'type' => 'select',
                        'label' => 'Kpi type',
                        'name' =>  'kpi_type',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('kpi_type', $id),
                        'value' => (isset($edit)) ? $edit->kpi_type : '',
                        'options' => $kpiTypeOptions,
                    ],
        ];
        
        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [
                    'aspect_id' => 'required|string',
                    'parameter' => 'required|string',
                    'weight' => 'required|string',
                    'target' => 'required|string',
                    'measurement_unit' => 'required|string',
                    'calculation_type' => 'required|string',
                    'kpi_type' => 'required|string',
        ];

        return $rules;
    }

}
