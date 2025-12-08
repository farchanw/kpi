<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\GradingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AspectController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\KpiTemplateController;
use App\Http\Controllers\EvaluatorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeEvaluationController;
use App\Http\Controllers\EmployeeEvaluationEntryController;
use App\Http\Controllers\DivisionEvaluationController;
use App\Http\Controllers\DivisionEvaluationEntryController;

Route::post('login', [AuthController::class, 'authenticate'])->middleware('web');
Route::get('/', [AuthController::class, 'login'])->name('login')->middleware('web');


Route::group(['middleware' => ['web', 'auth']], function () {
    Route::resource('dashboard', DashboardController::class);
    Route::get('dashboard-api', [DashboardController::class, 'indexApi'])->name('dashboard.listapi');
    Route::get('dashboard-export-pdf-default', [DashboardController::class, 'exportPdf'])->name('dashboard.export-pdf-default');
    Route::get('dashboard-export-excel-default', [DashboardController::class, 'exportExcel'])->name('dashboard.export-excel-default');
    Route::post('dashboard-import-excel-default', [DashboardController::class, 'importExcel'])->name('dashboard.import-excel-default');

    Route::resource('division', DivisionController::class);
    Route::get('division-api', [DivisionController::class, 'indexApi'])->name('division.listapi');
    Route::get('division-export-pdf-default', [DivisionController::class, 'exportPdf'])->name('division.export-pdf-default');
    Route::get('division-export-excel-default', [DivisionController::class, 'exportExcel'])->name('division.export-excel-default');
    Route::post('division-import-excel-default', [DivisionController::class, 'importExcel'])->name('division.import-excel-default');

    Route::resource('grading', GradingController::class);
    Route::get('grading-api', [GradingController::class, 'indexApi'])->name('grading.listapi');
    Route::get('grading-export-pdf-default', [GradingController::class, 'exportPdf'])->name('grading.export-pdf-default');
    Route::get('grading-export-excel-default', [GradingController::class, 'exportExcel'])->name('grading.export-excel-default');
    Route::post('grading-import-excel-default', [GradingController::class, 'importExcel'])->name('grading.import-excel-default');

    Route::resource('aspect', AspectController::class);
    Route::get('aspect-api', [AspectController::class, 'indexApi'])->name('aspect.listapi');
    Route::get('aspect-export-pdf-default', [AspectController::class, 'exportPdf'])->name('aspect.export-pdf-default');
    Route::get('aspect-export-excel-default', [AspectController::class, 'exportExcel'])->name('aspect.export-excel-default');
    Route::post('aspect-import-excel-default', [AspectController::class, 'importExcel'])->name('aspect.import-excel-default');

    Route::resource('employee', EmployeeController::class);
    Route::get('employee-api', [EmployeeController::class, 'indexApi'])->name('employee.listapi');
    Route::get('employee-export-pdf-default', [EmployeeController::class, 'exportPdf'])->name('employee.export-pdf-default');
    Route::get('employee-export-excel-default', [EmployeeController::class, 'exportExcel'])->name('employee.export-excel-default');
    Route::post('employee-import-excel-default', [EmployeeController::class, 'importExcel'])->name('employee.import-excel-default');

    Route::resource('kpi-template', KpiTemplateController::class);
    Route::get('kpi-template-api', [KpiTemplateController::class, 'indexApi'])->name('kpi-template.listapi');
    Route::get('kpi-template-export-pdf-default', [KpiTemplateController::class, 'exportPdf'])->name('kpi-template.export-pdf-default');       
    Route::get('kpi-template-export-excel-default', [KpiTemplateController::class, 'exportExcel'])->name('kpi-template.export-excel-default'); 
    Route::post('kpi-template-import-excel-default', [KpiTemplateController::class, 'importExcel'])->name('kpi-template.import-excel-default');

    Route::resource('evaluator', EvaluatorController::class);
    Route::get('evaluator-api', [EvaluatorController::class, 'indexApi'])->name('evaluator.listapi');
    Route::get('evaluator-export-pdf-default', [EvaluatorController::class, 'exportPdf'])->name('evaluator.export-pdf-default');
    Route::get('evaluator-export-excel-default', [EvaluatorController::class, 'exportExcel'])->name('evaluator.export-excel-default');
    Route::post('evaluator-import-excel-default', [EvaluatorController::class, 'importExcel'])->name('evaluator.import-excel-default');

    Route::resource('employee-evaluation', EmployeeEvaluationController::class);
    Route::get('employee-evaluation-api', [EmployeeEvaluationController::class, 'indexApi'])->name('employee-evaluation.listapi');
    Route::get('employee-evaluation-export-pdf-default', [EmployeeEvaluationController::class, 'exportPdf'])->name('employee-evaluation.export-pdf-default');
    Route::get('employee-evaluation-export-excel-default', [EmployeeEvaluationController::class, 'exportExcel'])->name('employee-evaluation.export-excel-default');      
    Route::post('employee-evaluation-import-excel-default', [EmployeeEvaluationController::class, 'importExcel'])->name('employee-evaluation.import-excel-default'); 

    Route::resource('employee-evaluation-entry', EmployeeEvaluationEntryController::class);
    Route::get('employee-evaluation-entry-api', [EmployeeEvaluationEntryController::class, 'indexApi'])->name('employee-evaluation-entry.listapi');
    Route::get('employee-evaluation-entry-export-pdf-default', [EmployeeEvaluationEntryController::class, 'exportPdf'])->name('employee-evaluation-entry.export-pdf-default');
    Route::get('employee-evaluation-entry-export-excel-default', [EmployeeEvaluationEntryController::class, 'exportExcel'])->name('employee-evaluation-entry.export-excel-default');
    Route::post('employee-evaluation-entry-import-excel-default', [EmployeeEvaluationEntryController::class, 'importExcel'])->name('employee-evaluation-entry.import-excel-default');

    Route::resource('division-evaluation', DivisionEvaluationController::class);
    Route::get('division-evaluation-api', [DivisionEvaluationController::class, 'indexApi'])->name('division-evaluation.listapi');
    Route::get('division-evaluation-export-pdf-default', [DivisionEvaluationController::class, 'exportPdf'])->name('division-evaluation.export-pdf-default');
    Route::get('division-evaluation-export-excel-default', [DivisionEvaluationController::class, 'exportExcel'])->name('division-evaluation.export-excel-default');      
    Route::post('division-evaluation-import-excel-default', [DivisionEvaluationController::class, 'importExcel'])->name('division-evaluation.import-excel-default');     

    Route::resource('division-evaluation-entry', DivisionEvaluationEntryController::class);
    Route::get('division-evaluation-entry-api', [DivisionEvaluationEntryController::class, 'indexApi'])->name('division-evaluation-entry.listapi');
    Route::get('division-evaluation-entry-export-pdf-default', [DivisionEvaluationEntryController::class, 'exportPdf'])->name('division-evaluation-entry.export-pdf-default');
    Route::get('division-evaluation-entry-export-excel-default', [DivisionEvaluationEntryController::class, 'exportExcel'])->name('division-evaluation-entry.export-excel-default');
    Route::post('division-evaluation-entry-import-excel-default', [DivisionEvaluationEntryController::class, 'importExcel'])->name('division-evaluation-entry.import-excel-default');
});