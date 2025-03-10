<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Proveedor;
use App\Models\Liquidacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PagoController extends Controller
{
    /**
     * Display a listing of the payments.
     */
    public function index(Request $request)
    {
        $query = Pago::with(['proveedor', 'liquidacion']);

        
        // Filtros
        if ($request->has('proveedor_id') && $request->proveedor_id) {
            $query->where('proveedor_id', $request->proveedor_id);
        }

        if ($request->has('fecha_inicio') && $request->has('fecha_fin') && $request->fecha_inicio && $request->fecha_fin) {
            $query->whereBetween('fecha_pago', [$request->fecha_inicio, $request->fecha_fin]);
        }

        $pagos = $query->latest()->paginate(15);
        $proveedores = Proveedor::orderBy('nombre')->get();

        return view('pagos.index', compact('pagos', 'proveedores'));
    }

    /**
     * Show the form for creating a new payment.
     */
    public function create()
    {
        $proveedores = Proveedor::orderBy('nombre')->get();
        $liquidaciones = collect(); // Se cargará con AJAX según el proveedor seleccionado

        return view('pagos.create', compact('proveedores', 'liquidaciones'));
    }

    /**
     * Store a newly created payment in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'liquidacion_id' => 'required|exists:liquidaciones,id',
            'monto' => 'required|numeric|min:0',
            'metodo_pago' => 'required|string',
            'referencia' => 'nullable|string|max:255',
            'concepto' => 'nullable|string',
            'fecha_pago' => 'required|date',
            'estado' => 'required|in:completado,pendiente,cancelado',
            'comprobante' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Manejo del archivo de comprobante
        if ($request->hasFile('comprobante')) {
            $path = $request->file('comprobante')->store('comprobantes_pagos', 'public');
            $validated['comprobante'] = $path;
        }

        $pago=Pago::create($validated);
        $pago->saldo=$pago->calcularSaldo();
        $pago->save();

        return redirect()->route('pagos.index')
            ->with('success', 'Pago registrado correctamente');
    }

    /**
     * Display the specified payment.
     */
    public function show(Pago $pago)
    {
        return view('pagos.show', compact('pago'));
    }

    /**
     * Show the form for editing the specified payment.
     */
    public function edit(Pago $pago)
    {
        $proveedores = Proveedor::orderBy('nombre')->get();
        $liquidaciones = Liquidacion::where('proveedor_id', $pago->proveedor_id)->get();

        return view('pagos.edit', compact('pago', 'proveedores', 'liquidaciones'));
    }

    /**
     * Update the specified payment in storage.
     */
    public function update(Request $request, Pago $pago)
    {
        $validated = $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'liquidacion_id' => 'nullable|exists:liquidaciones,id',
            'monto' => 'required|numeric|min:0',
            'metodo_pago' => 'required|string',
            'referencia' => 'nullable|string|max:255',
            'concepto' => 'nullable|string',
            'fecha_pago' => 'required|date',
            'estado' => 'required|in:completado,pendiente,cancelado',
            'comprobante' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Manejo del archivo de comprobante
        if ($request->hasFile('comprobante')) {
            // Eliminar comprobante anterior si existe
            if ($pago->comprobante) {
                Storage::disk('public')->delete($pago->comprobante);
            }
            
            $path = $request->file('comprobante')->store('comprobantes_pagos', 'public');
            $validated['comprobante'] = $path;
        }

        $pago->update($validated);

        return redirect()->route('pagos.index')
            ->with('success', 'Pago actualizado correctamente');
    }

    /**
     * Remove the specified payment from storage.
     */
    public function destroy(Pago $pago)
    {
        // Eliminar comprobante si existe
        if ($pago->comprobante) {
            Storage::disk('public')->delete($pago->comprobante);
        }
        
        $pago->delete();

        return redirect()->route('pagos.index')
            ->with('success', 'Pago eliminado correctamente');
    }

    /**
     * Get liquidaciones by proveedor (for AJAX)
     */
    public function getLiquidacionesByProveedor(Request $request)
    {
        $proveedorId = $request->proveedor_id;
        $liquidaciones = Liquidacion::where('proveedor_id', $proveedorId)
            ->doesntHave('pagos')
            ->select('id', 'fecha', 'total_descuento')
            ->get()
            ->map(function($liquidacion) {
                $fecha = \Carbon\Carbon::parse($liquidacion->fecha);
                return [
                    'id' => $liquidacion->id,
                    'texto' => "Liquidación #{$liquidacion->id} - " . 
                        $fecha->format('d/m/Y') . 
                        " - Total: $" . number_format($liquidacion->total_descuento, 2)
                ];
            });

        return response()->json($liquidaciones);
    }

    /**
     * Ver pagos por proveedor
     */
    public function porProveedor($proveedorId)
    {
        $proveedor = Proveedor::findOrFail($proveedorId);
        $pagos = Pago::where('proveedor_id', $proveedorId)
            ->with('liquidacion')
            ->latest()
            ->paginate(15);

        // Calcular totales
        $totalPagado = $pagos->sum('monto');
        $totalDeuda = $pagos->sum('saldo');
        
        return view('pagos.por-proveedor', compact('proveedor', 'pagos', 'totalPagado','totalDeuda'));
    }
}