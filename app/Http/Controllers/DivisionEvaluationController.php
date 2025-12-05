<?php

namespace App\Http\Controllers;

use App\Models\DivisionEvaluation;
use App\Models\Division;
use App\Models\Evaluator;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;
use Termwind\Components\Div;

class DivisionEvaluationController extends DefaultController
{
    protected $modelClass = DivisionEvaluation::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Division Evaluation';
        $this->generalUri = 'division-evaluation';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true],
                    ['name' => 'Division id', 'column' => 'division', 'order' => true],
                    ['name' => 'Evaluator id', 'column' => 'evaluator', 'order' => true],
                    ['name' => 'Evaluation date', 'column' => 'evaluation_date', 'order' => true],
                    ['name' => 'Total weight', 'column' => 'total_weight', 'order' => true],
                    ['name' => 'Final score', 'column' => 'final_score', 'order' => true], 
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => ['division_id'],
            'headers' => [
                    ['name' => 'Division id', 'column' => 'division_id'],
                    ['name' => 'Evaluator id', 'column' => 'evaluator_id'],
                    ['name' => 'Evaluation date', 'column' => 'evaluation_date'],
                    ['name' => 'Total weight', 'column' => 'total_weight'],
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

        $divisionOptions = Division::select(['id as value', 'name as text'])->get();
        $evaluatorOptions = Evaluator::join('users', 'users.id', '=', 'evaluators.user_id')
            ->select('users.name as text', 'evaluators.id as value')
            ->get();

        $fields = [
                    [
                        'type' => 'select2',
                        'label' => 'Division',
                        'name' =>  'division_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('division_id', $id),
                        'value' => (isset($edit)) ? $edit->division_id : '',
                        'options' => $divisionOptions
                    ],
                    [
                        'type' => 'select2',
                        'label' => 'Evaluator',
                        'name' =>  'evaluator_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('evaluator_id', $id),
                        'value' => (isset($edit)) ? $edit->evaluator_id : '',
                        'options' => $evaluatorOptions,
                    ],
                    [
                        'type' => 'date',
                        'label' => 'Evaluation date',
                        'name' =>  'evaluation_date',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('evaluation_date', $id),
                        'value' => (isset($edit)) ? $edit->evaluation_date : ''
                    ],
                    [
                        'type' => 'hidden',
                        'label' => 'Total weight',
                        'name' =>  'total_weight',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('total_weight', $id),
                        'value' => (isset($edit)) ? $edit->total_weight : ''
                    ],
                    [
                        'type' => 'hidden',
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
                    'division_id' => 'required|string',
                    'evaluator_id' => 'required|string',
                    'evaluation_date' => 'required|string',
                    // 'total_weight' => 'required|string',
                    // 'final_score' => 'required|string',
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

        /* Jika pakai table `employees` */
        $dataQueries = $this->modelClass::join('evaluators', 'evaluators.id', '=', 'division_evaluations.evaluator_id')
            ->join('users as evaluator_users', 'evaluator_users.id', '=', 'evaluators.user_id')
            ->join('divisions as evaluated_users', 'evaluated_users.id', '=', 'division_evaluations.division_id')
            ->where($filters)
            ->where(function ($query) use ($orThose) {
                //$query->where('evaluated_users.name', 'LIKE', '%' . $orThose . '%');
                //$query->orWhere('evaluator_users.name', 'LIKE', '%' . $orThose . '%');
                //$query->orWhere('division_evaluations.evaluation_date', 'LIKE', '%' . $orThose . '%');
            })
            ->orderBy($orderBy, $orderState)
            ->select('division_evaluations.*', 'evaluated_users.name as division', 'evaluator_users.name as evaluator');

        return $dataQueries;
    }

    protected function show($id)
    {
        $singleData = $this->defaultDataQuery()->where('division_evaluations.id', $id)->first();
        unset($singleData['id']);

        // hapus yang tidak perlu ditampilkan
        unset($singleData['user_id']);
        unset($singleData['evaluator_id']);

        $data['detail'] = $singleData;

        return view('easyadmin::backend.idev.show-default', $data);
    }

}
