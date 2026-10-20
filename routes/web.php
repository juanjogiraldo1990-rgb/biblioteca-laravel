<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExportController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas de Exportación
Route::get('/export/excel', [ExportController::class, 'excel'])->name('export.excel');
Route::get('/export/pdf', [ExportController::class, 'pdf'])->name('export.pdf');

// Rutas de Carga Masiva
Route::get('/export/import-books', [ExportController::class, 'importForm'])->name('export.import-form');
Route::post('/export/import-books', [ExportController::class, 'import'])->name('export.import');