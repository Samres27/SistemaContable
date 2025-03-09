<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LiquidacionController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\BoletaController;
use App\Http\Controllers\ProductoController;

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

Route::prefix('clientes')->group(function () {
    Route::get('/', [ClienteController::class, 'index'])->name('clientes.index');
    Route::get('/crear', [ClienteController::class, 'create'])->name('clientes.create');
    Route::post('/', [ClienteController::class, 'store'])->name('clientes.store');
    Route::get('/{cliente}/editar', [ClienteController::class, 'edit'])->name('clientes.edit');
    Route::get('/{cliente}', [ClienteController::class, 'show'])->name('clientes.show');
    Route::put('/{cliente}', [ClienteController::class, 'update'])->name('clientes.update');
    Route::delete('/{cliente}', [ClienteController::class, 'destroy'])->name('clientes.destroy');
});

Route::prefix('ventas')->group(function () {
    Route::get('/', [BoletaController::class, 'index_all'])->name('ventas.index_all');
    //Route::get('/{proveedor}', [BoletaController::class, 'index'])->name('ventas.index');
    Route::get('/crear', [BoletaController::class, 'create'])->name('ventas.create');
    Route::post('/', [BoletaController::class, 'store'])->name('ventas.store');
    Route::get('/{boleta}/editar', [BoletaController::class, 'edit'])->name('ventas.edit');
    Route::get('/{boleta}', [BoletaController::class, 'show'])->name('ventas.show');
    Route::put('/{boleta}', [BoletaController::class, 'update'])->name('ventas.update');
    Route::delete('/{boleta}', [BoletaController::class, 'destroy'])->name('ventas.destroy');
});

Route::prefix('productos')->group(function () {
    Route::get('/', [ProductoController::class, 'index'])->name('productos.index');
    Route::get('/crear', [ProductoController::class, 'create'])->name('productos.create');
    Route::post('/', [ProductoController::class, 'store'])->name('productos.store');
    Route::get('/{producto}/editar', [ProductoController::class, 'edit'])->name('productos.edit');
    Route::get('/{producto}', [ProductoController::class, 'show'])->name('productos.show');
    Route::put('/{producto}', [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');
});