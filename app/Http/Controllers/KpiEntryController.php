<?php

namespace App\Http\Controllers;

use App\Models\KpiEntry;
use App\Models\KpiEvaluation;
use App\Models\KpiTemplate;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use Idev\EasyAdmin\app\Helpers\Validation;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;


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
                    ['name' => 'Kpi evaluation', 'column' => 'kpi_evaluation', 'order' => true],
                    ['name' => 'Key perf area', 'column' => 'key_perf_area', 'order' => true],
                    ['name' => 'Kpi template', 'column' => 'kpi_template', 'order' => true],
                    ['name' => 'Weight', 'column' => 'weight', 'order' => true],
                    ['name' => 'Target', 'column' => 'target', 'order' => true],
                    ['name' => 'Actual', 'column' => 'actual', 'order' => true], 
                    ['name' => 'Score', 'column' => 'score', 'order' => true], 
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => ['kpi_evaluation_id'],
            'headers' => [
                    ['name' => 'Kpi evaluation id', 'column' => 'kpi_evaluation_id'],
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

        /*
        Jika pakai table `users`
        $kpiEvaluationOptions = KpiEvaluation::join('evaluators', 'evaluators.id', '=', 'kpi_evaluations.evaluator_id')
            ->join('users as evaluator_users', 'evaluator_users.id', '=', 'evaluators.user_id')
            ->join('users as evaluated_users', 'evaluated_users.id', '=', 'kpi_evaluations.user_id')
            ->select([
            'kpi_evaluations.id as value', 
            DB::raw('CONCAT_WS(" / ", evaluation_date,  evaluator_users.name, evaluated_users.name) as text')
        ])->get();
        */

        /*
        Jika pakai table `employees`
        $kpiEvaluationOptions = KpiEvaluation::join('evaluators', 'evaluators.id', '=', 'kpi_evaluations.evaluator_id')
            ->join('users as evaluator_users', 'evaluator_users.id', '=', 'evaluators.user_id')
            ->join('users as evaluated_users', 'evaluated_users.id', '=', 'kpi_evaluations.user_id')
            ->select([
            'kpi_evaluations.id as value', 
            DB::raw('CONCAT_WS(" / ", evaluation_date,  evaluator_users.name, evaluated_users.name) as text')
        ])->get();
        */

        $kpiEvaluationOptions = KpiEvaluation::join('evaluators', 'evaluators.id', '=', 'kpi_evaluations.evaluator_id')
            ->join('users as evaluator_users', 'evaluator_users.id', '=', 'evaluators.user_id')
            ->join('employees as evaluated_users', 'evaluated_users.id', '=', 'kpi_evaluations.user_id')
            ->select([
            'kpi_evaluations.id as value', 
            DB::raw('CONCAT_WS(" / ", evaluation_date,  evaluator_users.name, evaluated_users.name) as text')
        ])->get();
        $kpiTemplateOptions = KpiTemplate::select(['id as value', 'title as text'])->get();

        // 

        $fields = [
                    [
                        'type' => 'select2',
                        'label' => 'Kpi evaluation',
                        'name' =>  'kpi_evaluation_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('kpi_evaluation_id', $id),
                        'value' => (isset($edit)) ? $edit->kpi_evaluation_id : '',
                        'options' => $kpiEvaluationOptions,
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Area kinerja utama',
                        'name' =>  'key_perf_area',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('key_perf_area', $id),
                        'value' => (isset($edit)) ? $edit->key_perf_area : ''
                    ],
                    [
                        'type' => 'select2',
                        'label' => 'Kpi template',
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
        ];
        
        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [
                    'kpi_evaluation_id' => 'required|string',
                    'key_perf_area' => 'required|string',
                    'kpi_template_id' => 'required|string',
                    'weight' => 'required|string',
                    'target' => 'required|string',
                    'actual' => 'required|string',
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
            ->join('kpi_templates', 'kpi_templates.id', '=', 'kpi_entries.kpi_template_id')
            ->join('kpi_evaluations', 'kpi_evaluations.id', '=', 'kpi_entries.kpi_evaluation_id')
            ->join('evaluators', 'evaluators.id', '=', 'kpi_evaluations.evaluator_id')
            ->join('users as evaluator_users', 'evaluator_users.id', '=', 'evaluators.user_id')
            ->join('users as evaluated_users', 'evaluated_users.id', '=', 'kpi_evaluations.user_id')
            ->where(function ($query) use ($orThose) {
                $query->where('kpi_templates.title', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('kpi_entries.key_perf_area', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('evaluated_users.name', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('evaluator_users.name', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('kpi_evaluations.evaluation_date', 'LIKE', '%' . $orThose . '%');
            })
            ->orderBy($orderBy, $orderState)
            ->select(
                'kpi_entries.*',
                'evaluated_users.name as user',
                'evaluator_users.name as evaluator',
                'kpi_templates.title as kpi_template',
                DB::raw('CONCAT_WS(" / ", evaluation_date,  evaluator_users.name, evaluated_users.name) as kpi_evaluation')
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
            $kpiEvaluation = KpiEvaluation::find($insert->kpi_evaluation_id);
            if ($kpiEvaluation) {
                $totalWeight = KpiEntry::where('kpi_evaluation_id', $kpiEvaluation->id)->sum('weight');
                $finalScore = KpiEntry::where('kpi_evaluation_id', $kpiEvaluation->id)
                    ->select(DB::raw('SUM((actual / target) * weight) as final_score'))
                    ->value('final_score');
                $kpiEvaluation->total_weight = $totalWeight;
                $kpiEvaluation->final_score = $finalScore;
                $kpiEvaluation->save();
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
            $kpiEvaluation = KpiEvaluation::find($change->kpi_evaluation_id);
            if ($kpiEvaluation) {
                $totalWeight = KpiEntry::where('kpi_evaluation_id', $kpiEvaluation->id)->sum('weight');
                if($change->kpi_type == 'Maximize'){
                    $finalScore = KpiEntry::where('kpi_evaluation_id', $kpiEvaluation->id)
                    ->select(DB::raw('SUM((actual / target) * weight) as final_score'))
                    ->value('final_score');
                }
                if($change->kpi_type == 'Minimize'){
                    $finalScore = KpiEntry::where('kpi_evaluation_id', $kpiEvaluation->id)
                    ->select(DB::raw('SUM((target / actual) * weight) as final_score'))
                    ->value('final_score');
                }
                $kpiEvaluation->total_weight = $totalWeight;
                $kpiEvaluation->final_score = $finalScore;
                $kpiEvaluation->save();
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
        $singleData = $this->defaultDataQuery()->where('kpi_entries.id', $id)->first();
        unset($singleData['id']);

        // hapus yang tidak perlu ditampilkan
        unset($singleData['kpi_evaluation_id']);
        unset($singleData['kpi_template_id']);
        

        $data['detail'] = $singleData;

        return view('easyadmin::backend.idev.show-default', $data);
    }

}
