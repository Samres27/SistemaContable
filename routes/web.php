<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VentaController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/v1', function () {
    return view('vista1');
});
Route::get('/tabla', function () {
    #$usuarios=[];
    #$usuarios[0]->nombre =samuel;
    return view('tabla');#, compact('usuarios'));
});

Route::get('ventas', [VentaController::class, 'index'])->name('ventas.index');
Route::get('ventas/importar', [VentaController::class, 'importForm'])->name('ventas.import.form');
Route::post('ventas/importar', [VentaController::class, 'import'])->name('ventas.import');
Route::get('ventas/{producto}/edit', [VentaController::class, 'edit'])->name('ventas.edit');
Route::put('ventas/{producto}', [VentaController::class, 'update'])->name('ventas.update');
Route::delete('ventas/{producto}', [VentaController::class, 'destroy'])->name('ventas.destroy');