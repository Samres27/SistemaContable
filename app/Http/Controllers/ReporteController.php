<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Boleta;
use App\Models\Proveedor;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use mPDF;

class ReporteController extends Controller
{
    public function clientes()
    {
        $clientes = Cliente::with(['ventas'])->paginate(10);
        //dd($liquidaciones);
        //return view('impresiones.clientes', compact('clientes'));
        $pdf = PDF::loadView('impresiones.clientes', compact('clientes'));
        return $pdf->download('reporteClientes_.pdf');
    }

    public function cliente($clienteId)
    {
        $cliente = Cliente::findOrFail($clienteId);
        $boletas = Boleta::with(['cobros', 'cliente'])  
            ->where('cliente_id', $clienteId)  
            ->paginate(10);  

        $pdf = PDF::loadView('impresiones.cliente_historial', compact('boletas','cliente'));
        $nombre = Cliente::where('id', $clienteId)->first();
        return $pdf->download('reporteCliente_'.$nombre->nombre.'.pdf');
    }

    public function clientePendientes($clienteId)
    {
        $cliente = Cliente::findOrFail($clienteId);
        $boletasPendientes = Boleta::with(['cliente', 'cobros', 'ventas'])
            ->where('cliente_id', $clienteId) 
            ->paginate(10);

        // Pasar las boletas pendientes a la vista
        $pdf = PDF::loadView('impresiones.cliente_pendiente', compact('boletasPendientes','cliente'));
        $nombre = Cliente::where('id', $clienteId)->first();
        return $pdf->download('reporteCliente_'.$nombre->nombre.'_pendientes.pdf');
    }

    public function proveedores()
    {
        $proveedores = Proveedor::with('liquidaciones')->paginate(10);

        // Pasar los proveedores a la vista
        
        $pdf = PDF::loadView('impresiones.proveedores', compact('proveedores'));
        return $pdf->download('reporteProveedores_'.'.pdf');
    }

    public function proveedor($proveedorId)
    { 
        $proveedor = Proveedor::with(['liquidaciones.pagos'])->findOrFail($proveedorId);

        $liquidaciones = $proveedor->liquidaciones()->paginate(10);
        
        $pdf = PDF::loadView('impresiones.proveedor_historial', compact('proveedor','liquidaciones'));
        $nombre = Proveedor::where('id', $proveedorId)->first();
        return $pdf->download('reporteProveedor_'.$nombre->nombre.'.pdf');
    }

    public function proveedorPendientes($proveedorId){
        // Obtén el proveedor
        $proveedor = Proveedor::with(['liquidaciones.pagos'])->findOrFail($proveedorId);
    
        // Filtra las liquidaciones que tienen saldo pendiente
        $liquidacionesPendientes = $proveedor->liquidaciones()
            ->whereHas('pagos', function ($query) {
                $query->select('liquidacion_id')  // Elimina la selección de pagos.id
                    ->selectRaw('SUM(pagos.monto) as total_pagado')
                    ->groupBy('liquidacion_id')   // Usa liquidacion_id en lugar de liquidaciones.id
                    ->havingRaw('SUM(pagos.monto) < liquidaciones.total_descuento');
            })
            ->orWhereDoesntHave('pagos')
            ->paginate(10);
    
        //return view('impresiones.proveedor_pendientes', compact('proveedor', 'liquidacionesPendientes'));
        $pdf = PDF::loadView('impresiones.proveedor_pendientes', compact('proveedor', 'liquidacionesPendientes'));
        $nombre = Proveedor::where('id', $proveedorId)->first();
        return $pdf->download('reporteProveedor_'.$nombre->nombre.'_pendiente'.'.pdf');

    }

    public function generatePDF()
    {
        // Obtener los datos (por ejemplo, de la base de datos)
        $data = Cliente::paginate(10); // Aquí se hace la paginación con 10 elementos por página
        
        // Cargar la vista con los datos
        $pdf = PDF::loadView('impresiones.index', compact('data'));
        return $pdf->download('archivo.pdf');
    }
}
