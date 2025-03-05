<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\LiquidacionController;
use App\Http\Controllers\ProveedorController;

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

Route::prefix('liquidaciones')->group(function () {
    Route::get('/', [LiquidacionController::class, 'index_all'])->name('liquidaciones.index_all');
    //Route::get('/{proveedor}', [LiquidacionController::class, 'index'])->name('liquidaciones.index');
    Route::get('/crear', [LiquidacionController::class, 'create'])->name('liquidaciones.create');
    Route::post('/', [LiquidacionController::class, 'store'])->name('liquidaciones.store');
    Route::get('/{liquidacion}/editar', [LiquidacionController::class, 'edit'])->name('liquidaciones.edit');
    Route::get('/{liquidacion}', [LiquidacionController::class, 'show'])->name('liquidaciones.show');
    Route::put('/{liquidacion}', [LiquidacionController::class, 'update'])->name('liquidaciones.update');
    Route::delete('/{liquidacion}', [LiquidacionController::class, 'destroy'])->name('liquidaciones.destroy');
});

Route::prefix('proveedores')->group(function () {
    Route::get('/', [ProveedorController::class, 'index'])->name('proveedores.index');
    Route::get('/crear', [ProveedorController::class, 'create'])->name('proveedores.create');
    Route::post('/', [ProveedorController::class, 'store'])->name('proveedores.store');
    Route::get('/{proveedor}/editar', [ProveedorController::class, 'edit'])->name('proveedores.edit');
    Route::get('/{proveedor}', [ProveedorController::class, 'show'])->name('proveedores.show');
    Route::put('/{proveedor}', [ProveedorController::class, 'update'])->name('proveedores.update');
    Route::delete('/{proveedor}', [ProveedorController::class, 'destroy'])->name('proveedores.destroy');
});