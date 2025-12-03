<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\GradingController;
use App\Http\Controllers\AspectController;

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
