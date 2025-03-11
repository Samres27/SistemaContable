<?php

namespace App\Http\Controllers;

use App\Models\Cobro;
use App\Models\Boleta;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CobroController extends Controller
{
    // Mostrar lista de cobros
    public function index()
    {
        $clientes = Cliente::with(['ventas.cobros'])->get();
        
        $clientesConDeuda = $clientes->map(function($cliente) {
            $totalDeuda = $cliente->ventas->sum('total');
            $totalCobrado = $cliente->ventas->flatMap(function($boleta) {
                return $boleta->cobros;
            })->sum('monto');
            
            return [
                'cliente' => $cliente,
                'total_deuda' => $totalDeuda,
                'total_cobrado' => $totalCobrado,
                'saldo_pendiente' => $totalDeuda - $totalCobrado
            ];
        });
        
        return view('cobros.index', compact('clientesConDeuda'));
    }
    
    // Mostrar detalle de cobros por cliente
    public function clienteDetalle($clienteId)
    {
        $cliente = Cliente::with(['ventas.cobros'])->findOrFail($clienteId);
        
        $boletas = $cliente->ventas->map(function($boleta) {
            $cobrado = $boleta->cobros->sum('monto');
            
            return [
                'boleta' => $boleta,
                'total' => $boleta->total,
                'cobrado' => $cobrado,
                'pendiente' => $boleta->total - $cobrado
            ];
        });
        
        $totalDeuda = $boletas->sum('total');
        $totalCobrado = $boletas->sum('cobrado');
        $saldoPendiente = $totalDeuda - $totalCobrado;
        
        return view('cobros.cliente_detalle', compact('cliente', 'boletas', 'totalDeuda', 'totalCobrado', 'saldoPendiente'));
    }
    
    // Mostrar formulario para crear cobro
    public function create($boletaId = null)
    {
        $boleta = null;
        $cliente = null;
        
        if ($boletaId) {
            $boleta = Boleta::with('cliente')->findOrFail($boletaId);
            $cliente = $boleta->cliente;
        } else {
            $clientes = Cliente::all();
        }
        
        return view('cobros.create', compact('boleta', 'cliente', 'clientes'));
    }
    
    // Almacenar cobro en la base de datos
    public function store(Request $request)
    {
        $validated = $request->validate([
            'boleta_id' => 'required|exists:boletas,id',
            'fecha' => 'required|date',
            'monto' => 'required|numeric|min:0',
            'metodo_pago' => 'required|string',
            'observacion' => 'nullable|string',
            'comprobante' => 'nullable|string',
        ]);
        
        // Verificar que el monto no supere el saldo pendiente
        $boleta = Boleta::findOrFail($request->boleta_id);
        $totalCobrado = $boleta->cobros->sum('monto');
        $pendiente = $boleta->total - $totalCobrado;
        
        if ($request->monto > $pendiente) {
            return back()->withErrors(['monto' => 'El monto de cobro no puede superar el saldo pendiente de ' . $pendiente]);
        }
        
        $cobro = Cobro::create($validated);
        
        return redirect()->route('cobros.cliente_detalle', $boleta->cliente_id)
            ->with('success', 'Cobro registrado correctamente');
    }
    
    // Mostrar formulario para editar cobro
    public function edit($id)
    {
        $cobro = Cobro::with('boleta.cliente')->findOrFail($id);
        
        return view('cobros.edit', compact('cobro'));
    }
    
    // Actualizar cobro en la base de datos
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'fecha' => 'required|date',
            'monto' => 'required|numeric|min:0',
            'metodo_pago' => 'required|string',
            'observacion' => 'nullable|string',
            'comprobante' => 'nullable|string',
        ]);
        
        $cobro = Cobro::findOrFail($id);
        $boleta = $cobro->boleta;
        
        // Verificar que el nuevo monto no supere el saldo pendiente (sumando el monto actual)
        $totalCobrado = $boleta->cobros->where('id', '!=', $id)->sum('monto');
        $pendiente = $boleta->total - $totalCobrado;
        
        if ($request->monto > $pendiente) {
            return back()->withErrors(['monto' => 'El monto de cobro no puede superar el saldo pendiente de ' . $pendiente]);
        }
        
        $cobro->update($validated);
        
        return redirect()->route('cobros.cliente.detalle', $boleta->cliente_id)
            ->with('success', 'Cobro actualizado correctamente');
    }
    
    // Eliminar cobro
    public function destroy($id)
    {
        $cobro = Cobro::findOrFail($id);
        $clienteId = $cobro->boleta->cliente_id;
        
        $cobro->delete();
        
        return redirect()->route('cobros.cliente.detalle', $clienteId)
            ->with('success', 'Cobro eliminado correctamente');
    }

    public function getBoletasByCliente($id)
    {
        $clientes= Boleta::where('cliente_id',$id)
            ->select('id', 'fecha', 'total')
            ->get()
            ->map(function($cliente) {
                $fecha = \Carbon\Carbon::parse($cliente->fecha);
                return [
                    'id' => $cliente->id,
                    'texto' => "Liquidación #{$cliente->id} - " . 
                        $fecha->format('d/m/Y') . 
                        " - Total: $" . number_format($cliente->calcularTotalSaldo(), 2),
                    'cancelado' => $cliente->calcularCancelacion()
                ];
            });
        
            return response()->json($clientes);
    }
}