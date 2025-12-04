<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\GradingController;
use App\Http\Controllers\AspectController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\IndicatorController;
use App\Http\Controllers\KpiTemplateController;
use App\Http\Controllers\EvaluatorController;
use App\Http\Controllers\KpiEntryController;

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

Route::resource('indicator', IndicatorController::class);
Route::get('indicator-api', [IndicatorController::class, 'indexApi'])->name('indicator.listapi');
Route::get('indicator-export-pdf-default', [IndicatorController::class, 'exportPdf'])->name('indicator.export-pdf-default');
Route::get('indicator-export-excel-default', [IndicatorController::class, 'exportExcel'])->name('indicator.export-excel-default');
Route::post('indicator-import-excel-default', [IndicatorController::class, 'importExcel'])->name('indicator.import-excel-default');

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

Route::resource('kpi-entry', KpiEntryController::class);
Route::get('kpi-entry-api', [KpiEntryController::class, 'indexApi'])->name('kpi-entry.listapi');
Route::get('kpi-entry-export-pdf-default', [KpiEntryController::class, 'exportPdf'])->name('kpi-entry.export-pdf-default');
Route::get('kpi-entry-export-excel-default', [KpiEntryController::class, 'exportExcel'])->name('kpi-entry.export-excel-default');
Route::post('kpi-entry-import-excel-default', [KpiEntryController::class, 'importExcel'])->name('kpi-entry.import-excel-default');
