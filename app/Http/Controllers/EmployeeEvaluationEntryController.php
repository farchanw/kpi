<?php

namespace App\Http\Controllers;

use App\Models\EmployeeEvaluation;
use App\Models\EmployeeEvaluationEntry;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;
use App\Models\KpiTemplate;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use Idev\EasyAdmin\app\Helpers\Validation;

class EmployeeEvaluationEntryController extends DefaultController
{
    protected $modelClass = EmployeeEvaluationEntry::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Employee Evaluation Entry';
        $this->generalUri = 'employee-evaluation-entry';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true],
                    ['name' => 'Employee evaluation id', 'column' => 'employee_evaluation', 'order' => true],
                    ['name' => 'Key perf area', 'column' => 'key_perf_area', 'order' => true],
                    ['name' => 'Kpi template id', 'column' => 'kpi_template', 'order' => true],
                    ['name' => 'Weight', 'column' => 'weight', 'order' => true],
                    ['name' => 'Target', 'column' => 'target', 'order' => true],
                    ['name' => 'Actual', 'column' => 'actual', 'order' => true],
                    ['name' => 'Score', 'column' => 'score', 'order' => true], 
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => ['employee_evaluation_id'],
            'headers' => [
                    ['name' => 'Employee evaluation id', 'column' => 'employee_evaluation_id'],
                    ['name' => 'Key perf area', 'column' => 'key_perf_area'],
                    ['name' => 'Kpi template id', 'column' => 'kpi_template_id'],
                    ['name' => 'Weight', 'column' => 'weight'],
                    ['name' => 'Target', 'column' => 'target'],
                    ['name' => 'Actual', 'column' => 'actual'],
                    ['name' => 'Score', 'column' => 'score'], 
            ]
        ];
    }


    protected function fields($mode = "create", $id = '-')
    {
        $edit = null;
        if ($id != '-') {
            $edit = $this->modelClass::where('id', $id)->first();
        }

        $evaluationOptions = EmployeeEvaluation::join('evaluators', 'evaluators.id', '=', 'employee_evaluations.evaluator_id')
            ->join('users as evaluator_users', 'evaluator_users.id', '=', 'evaluators.user_id')
            ->join('employees as evaluated_users', 'evaluated_users.id', '=', 'employee_evaluations.user_id')
            ->select([
            'employee_evaluations.id as value', 
            DB::raw('CONCAT_WS(" / ", evaluation_date,  evaluator_users.name, evaluated_users.name) as text')
        ])->get();
        $kpiTemplateOptions = KpiTemplate::select(['id as value', 'title as text'])->get();

        $fields = [
                    [
                        'type' => 'select2',
                        'label' => 'Employee evaluation id',
                        'name' =>  'employee_evaluation_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('employee_evaluation_id', $id),
                        'value' => (isset($edit)) ? $edit->employee_evaluation_id : '',
                        'options' => $evaluationOptions,
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
                        'type' => 'select2',
                        'label' => 'Kpi template id',
                        'name' =>  'kpi_template_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('kpi_template_id', $id),
                        'value' => (isset($edit)) ? $edit->kpi_template_id : '',
                        'options' => $kpiTemplateOptions,
                    ],
                    [
                        'type' => 'number',
                        'label' => 'Weight',
                        'name' =>  'weight',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('weight', $id),
                        'value' => (isset($edit)) ? $edit->weight : ''
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
                        'type' => 'number',
                        'label' => 'Actual',
                        'name' =>  'actual',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('actual', $id),
                        'value' => (isset($edit)) ? $edit->actual : ''
                    ],
                    [
                        'type' => 'hidden',
                        'label' => 'Score',
                        'name' =>  'score',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('score', $id),
                        'value' => (isset($edit)) ? $edit->score : ''
                    ],
        ];
        
        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [
                    'employee_evaluation_id' => 'required|string',
                    'key_perf_area' => 'required|string',
                    'kpi_template_id' => 'required|string',
                    'weight' => 'required|string',
                    'target' => 'required|string',
                    'actual' => 'required|string',
                    //'score' => 'required|string',
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
            ->join('kpi_templates', 'kpi_templates.id', '=', 'employee_evaluation_entries.kpi_template_id')
            ->join('employee_evaluations', 'employee_evaluations.id', '=', 'employee_evaluation_entries.employee_evaluation_id')
            ->join('evaluators', 'evaluators.id', '=', 'employee_evaluations.evaluator_id')
            ->join('users as evaluator_users', 'evaluator_users.id', '=', 'evaluators.user_id')
            ->join('users as evaluated_users', 'evaluated_users.id', '=', 'employee_evaluations.user_id')
            ->where(function ($query) use ($orThose) {
                $query->where('kpi_templates.title', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('employee_evaluation_entries.key_perf_area', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('evaluated_users.name', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('evaluator_users.name', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('employee_evaluations.evaluation_date', 'LIKE', '%' . $orThose . '%');
            })
            ->orderBy($orderBy, $orderState)
            ->select(
                'employee_evaluation_entries.*',
                'evaluated_users.name as user',
                'evaluator_users.name as evaluator',
                'kpi_templates.title as kpi_template',
                DB::raw('CONCAT_WS(" / ", evaluation_date,  evaluator_users.name, evaluated_users.name) as employee_evaluation')
            );

        return $dataQueries;
    }

    protected function appendStore($request)
    {
        return [
            'columns' => [
                [
                    'name' => 'score', 
                    'value' => ($request->actual && $request->target) ? intval(($request->actual / $request->target) * 100) : 0
                ],
            ]
        ];
    }

    protected function appendUpdate($request)
    {
        return [
            'columns' => [
                [
                    'name' => 'score', 
                    'value' => ($request->actual && $request->target) ? intval(($request->actual / $request->target) * 100) : 0
                ],
            ]
        ];
    }

    protected function store(Request $request)
    {
        $rules = $this->rules();

        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            $messageErrors = (new Validation)->modify($validator, $rules);

            return response()->json([
                'status' => false,
                'alert' => 'danger',
                'message' => 'Required Form',
                'validation_errors' => $messageErrors,
            ], 200);
        }

        $beforeInsertResponse = $this->beforeMainInsert($request);
        if ($beforeInsertResponse !== null) {
            return $beforeInsertResponse; // Return early if there's a response
        }

        DB::beginTransaction();

        try {
            $appendStore = $this->appendStore($request);
            
            if (array_key_exists('error', $appendStore)) {
                return response()->json($appendStore['error'], 200);
            }

            $insert = new $this->modelClass();
            foreach ($this->fields('create') as $key => $th) {
                if ($request[$th['name']]) {
                    $insert->{$th['name']} = $request[$th['name']];
                }
            }
            if (array_key_exists('columns', $appendStore)) {
                foreach ($appendStore['columns'] as $key => $as) {
                    $insert->{$as['name']} = $as['value'];
                }
            }

            $insert->save();

            $this->afterMainInsert($insert, $request);

            // Update total_weight and final_score in kpi_evaluations table
            $evaluation = EmployeeEvaluation::find($insert->employee_evaluation_id);
            if ($evaluation) {
                $totalWeight = EmployeeEvaluationEntry::where('employee_evaluation_id', $evaluation->id)->sum('weight');
                $finalScore = EmployeeEvaluationEntry::where('employee_evaluation_id', $evaluation->id)
                    ->select(DB::raw('SUM((actual / target) * weight) as final_score'))
                    ->value('final_score');
                $evaluation->total_weight = $totalWeight;
                $evaluation->final_score = $finalScore;
                $evaluation->save();
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'alert' => 'success',
                'message' => 'Data Was Created Successfully',
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
            exit();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    protected function update(Request $request, $id)
    {
        $rules = $this->rules($id);
        
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messageErrors = (new Validation)->modify($validator, $rules);

            return response()->json([
                'status' => false,
                'alert' => 'danger',
                'message' => 'Required Form',
                'validation_errors' => $messageErrors,
            ], 200);
        }

        $beforeUpdateResponse = $this->beforeMainUpdate($id, $request);
        if ($beforeUpdateResponse !== null) {
            return $beforeUpdateResponse; // Return early if there's a response
        }

        DB::beginTransaction();

        try {
            $appendUpdate = $this->appendUpdate($request);

            $change = $this->modelClass::where('id', $id)->first();
            foreach ($this->fields('edit', $id) as $key => $th) {
                if ($request[$th['name']]) {
                    $change->{$th['name']} = $request[$th['name']];
                }
            }
            if (array_key_exists('columns', $appendUpdate)) {
                foreach ($appendUpdate['columns'] as $key => $as) {
                    $change->{$as['name']} = $as['value'];
                }
            }
            
            $change->save();

            $this->afterMainUpdate($change, $request);

            // Update total_weight and final_score in kpi_evaluations table
            $evaluation = EmployeeEvaluation::find($change->employee_evaluation_id);
            if ($evaluation) {
                $totalWeight = EmployeeEvaluationEntry::where('employee_evaluation_id', $evaluation->id)->sum('weight');
                $finalScore = EmployeeEvaluationEntry::where('employee_evaluation_id', $evaluation->id)
                    ->select(DB::raw('SUM((actual / target) * weight) as final_score'))
                    ->value('final_score');
                $evaluation->total_weight = $totalWeight;
                $evaluation->final_score = $finalScore;
                $evaluation->save();
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'alert' => 'success',
                'message' => 'Data Was Updated Successfully',
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    protected function show($id)
    {
        $singleData = $this->defaultDataQuery()->where('employee_evaluation_entries.id', $id)->first();
        unset($singleData['id']);

        // hapus yang tidak perlu ditampilkan
        unset($singleData['employee_evaluation_id']);
        unset($singleData['employee_template_id']);

        $data['detail'] = $singleData;

        return view('easyadmin::backend.idev.show-default', $data);
    }

}
