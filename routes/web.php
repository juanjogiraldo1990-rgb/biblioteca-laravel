<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\LectorController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas de Exportación
Route::get('/export/excel', [ExportController::class, 'excel'])->name('export.excel');
Route::get('/export/pdf', [ExportController::class, 'pdf'])->name('export.pdf');

// Rutas de Carga Masiva
Route::get('/export/import-books', [ExportController::class, 'importForm'])->name('export.import-form');
Route::post('/export/import-books', [ExportController::class, 'import'])->name('export.import');

// Rutas para el Lector
Route::get('/registro', [LectorController::class, 'formulario'])->name('registro');
Route::post('/registro', [LectorController::class, 'guardar'])->name('registro.guardar');

// Ruta de solicitud (POST)
Route::post('/solicitar-prestamo/{book}', [LectorController::class, 'solicitar'])->name('lector.solicitar')->middleware('auth:moonshine');