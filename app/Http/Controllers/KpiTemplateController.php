<?php

namespace App\Http\Controllers;

use App\Models\Aspect;
use App\Models\KpiTemplate;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;

class KpiTemplateController extends DefaultController
{
    protected $modelClass = KpiTemplate::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Kpi Template';
        $this->generalUri = 'kpi-template';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true],
                    ['name' => 'Aspect', 'column' => 'aspect', 'order' => true],
                    ['name' => 'Title', 'column' => 'title', 'order' => true],
                    ['name' => 'Description', 'column' => 'description', 'order' => true],
                    ['name' => 'Measurement instruction', 'column' => 'measurement_instruction', 'order' => true],
                    ['name' => 'Measurement formula', 'column' => 'measurement_formula', 'order' => true],
                    ['name' => 'Measurement unit', 'column' => 'measurement_unit', 'order' => true],
                    ['name' => 'Kpi type', 'column' => 'kpi_type', 'order' => true],
                    ['name' => 'Period', 'column' => 'period', 'order' => true],
                    ['name' => 'Data source', 'column' => 'data_source', 'order' => true], 
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => ['aspect_id'],
            'headers' => [
                    ['name' => 'Aspect id', 'column' => 'aspect_id'],
                    ['name' => 'Title', 'column' => 'title'],
                    ['name' => 'Description', 'column' => 'description'],
                    ['name' => 'Measurement instruction', 'column' => 'measurement_instruction'],
                    ['name' => 'Measurement formula', 'column' => 'measurement_formula'],
                    ['name' => 'Measurement unit', 'column' => 'measurement_unit'],
                    ['name' => 'Kpi type', 'column' => 'kpi_type'],
                    ['name' => 'Period', 'column' => 'period'],
                    ['name' => 'Data source', 'column' => 'data_source'], 
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
        $unitOptions = [
            ['text' => 'Percentage', 'value' => 'Percentage',],
            ['text' => 'Number', 'value' => 'Number',],
            ['text' => 'Currency', 'value' => 'Currency',],
        ];
        $kpiTypeOptions = [
            ['text' => 'Maximize', 'value' => 'Maximize',],
            ['text' => 'Minimize', 'value' => 'Minimize',],
        ];
        $periodOptions = [
            ['text' => 'Monthly', 'value' => 'Monthly',],
            ['text' => 'Quarterly', 'value' => 'Quarterly',],
            ['text' => 'Yearly', 'value' => 'Yearly',],
        ];

        $fields = [
                    [
                        'type' => 'select',
                        'label' => 'Aspect',
                        'name' =>  'aspect_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('aspect_id', $id),
                        'value' => (isset($edit)) ? $edit->aspect_id : '',
                        'options' => $aspectOptions
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Title',
                        'name' =>  'title',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('title', $id),
                        'value' => (isset($edit)) ? $edit->title : ''
                    ],
                    [
                        'type' => 'textarea',
                        'label' => 'Description',
                        'name' =>  'description',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('description', $id),
                        'value' => (isset($edit)) ? $edit->description : ''
                    ],
                    [
                        'type' => 'textarea',
                        'label' => 'Measurement instruction',
                        'name' =>  'measurement_instruction',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('measurement_instruction', $id),
                        'value' => (isset($edit)) ? $edit->measurement_instruction : ''
                    ],
                    [
                        'type' => 'textarea',
                        'label' => 'Measurement formula',
                        'name' =>  'measurement_formula',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('measurement_formula', $id),
                        'value' => (isset($edit)) ? $edit->measurement_formula : ''
                    ],
                    [
                        'type' => 'select',
                        'label' => 'Measurement unit',
                        'name' =>  'measurement_unit',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('measurement_unit', $id),
                        'value' => (isset($edit)) ? $edit->measurement_unit : '',
                        'options' => $unitOptions,
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
                    [
                        'type' => 'select',
                        'label' => 'Period',
                        'name' =>  'period',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('period', $id),
                        'value' => (isset($edit)) ? $edit->period : '',
                        'options' => $periodOptions,
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Data source',
                        'name' =>  'data_source',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('data_source', $id),
                        'value' => (isset($edit)) ? $edit->data_source : ''
                    ],
        ];
        
        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [
                    'aspect_id' => 'required|string',
                    'title' => 'required|string',
                    'description' => 'required|string',
                    'measurement_instruction' => 'required|string',
                    'measurement_formula' => 'required|string',
                    'measurement_unit' => 'required|string',
                    'kpi_type' => 'required|string',
                    'period' => 'required|string',
                    'data_source' => 'required|string',
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

        $dataQueries = $this->modelClass::where($filters)
            ->join('aspects', 'aspects.id', '=', 'kpi_templates.aspect_id')
            ->where(function ($query) use ($orThose) {
                $query->where('aspects.name', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('kpi_templates.title', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('kpi_templates.description', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('kpi_templates.measurement_instruction', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('kpi_templates.measurement_formula', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('kpi_templates.measurement_unit', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('kpi_templates.kpi_type', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('kpi_templates.period', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('kpi_templates.data_source', 'LIKE', '%' . $orThose . '%');
            })
            ->orderBy($orderBy, $orderState)
            ->select('kpi_templates.*', 'aspects.name as aspect');

        return $dataQueries;
    }

    protected function show($id)
    {
        $singleData = $this->defaultDataQuery()->where('kpi_templates.id', $id)->first();
        unset($singleData['id']);
        
        // hapus yang tidak perlu ditampilkan
        unset($singleData['aspect_id']);

        $data['detail'] = $singleData;

        return view('easyadmin::backend.idev.show-default', $data);
    }

}
