<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LiquidacionController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\BoletaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\CobroController;

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

Route::prefix('pagos')->group(function () {
    Route::get('/', [PagoController::class, 'index'])->name('pagos.index');
    Route::get('/crear', [PagoController::class, 'create'])->name('pagos.create');
    Route::get('/pagos-provedor/{proveedorId}', [PagoController::class, 'porProveedor'])->name('pagos.por-proveedor');
    Route::post('/', [PagoController::class, 'store'])->name('pagos.store');
    Route::get('/get-liquidaciones-by-proveedor',[PagoController::class, 'getLiquidacionesByProveedor'])->name('pagos.get-liquidacciones');
    Route::get('/{pago}/editar', [PagoController::class, 'edit'])->name('pagos.edit');
    Route::get('/{pago}', [PagoController::class, 'show'])->name('pagos.show');
    Route::put('/{pago}', [PagoController::class, 'update'])->name('pagos.update');
    Route::delete('/{pago}', [PagoController::class, 'destroy'])->name('pagos.destroy');
});

Route::prefix('cobros')->group(function () {
    Route::get('/', [CobroController::class, 'index'])->name('cobros.index');
    Route::get('/cliente/{clienteId}', [CobroController::class, 'clienteDetalle'])->name('cobros.cliente_detalle');
    Route::get('/cliente/{clienteId}/boletas', [CobroController::class, 'getBoletasByCliente'])->name('cobros.cliente.boletas');
    Route::get('/crear', [CobroController::class, 'create'])->name('cobros.create');
    Route::post('/', [CobroController::class, 'store'])->name('cobros.store');
    Route::get('/{cobro}/editar', [CobroController::class, 'edit'])->name('cobros.edit');
    Route::get('/{cobro}', [CobroController::class, 'show'])->name('cobros.show');
    Route::put('/{cobro}', [CobroController::class, 'update'])->name('cobros.update');
    Route::delete('/{cobro}', [CobroController::class, 'destroy'])->name('pagos.destroy');
});

Route::get('/impresiones/{imp}', function ($imp) {
    $viewPath = resource_path("views/impresiones/{$imp}.blade.php");

    // Verificar si el archivo Blade existe
    if (File::exists($viewPath)) {
        // Si el archivo existe, cargar la vista
        return view("impresiones.{$imp}");
    } else {
        // Si el archivo no existe, retornar un 404 o error
        abort(404, 'Vista no encontrada');
    }
});