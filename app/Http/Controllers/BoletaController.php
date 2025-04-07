<?php

namespace App\Http\Controllers;

use App\Models\Boleta;
use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Envase;
use Illuminate\Http\Request;

class BoletaController extends Controller
{
    public function index(Request $request)
    {
        $proveedorNombre = $request->input('proveedor');

        $liquidaciones = Venta::with('proveedor')
            ->when($proveedorNombre, function ($query, $proveedorNombre) {
                // Filtrar por nombre del proveedor
                return $query->whereHas('proveedor', function ($query) use ($proveedorNombre) {
                    $query->where('nombre', 'like', '%' . $proveedorNombre . '%');
                });
            })
            ->paginate(10);
        return view('ventas.index', compact('liquidaciones'));
    }

    public function index_all()
    {
        $boletas = Boleta::with('cliente')->get();
        //dd($liquidaciones);
        return view('ventas.index', compact('boletas'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $productos = Producto::all();
        $envases = Envase::all();
        return view('ventas.create', compact('clientes','productos','envases'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'ventas' => 'required|array',
            'ventas.*.nombre' => 'required|string|max:255',  
            'ventas.*.cantidad_bruto' => 'required|numeric|min:0.1',
            'ventas.*.peso_envase' => 'required|numeric|min:0.00',
            'ventas.*.cantidad_envase' => 'required|numeric',  
            'ventas.*.precio' => 'required|numeric|min:0.01',  
        ]);
        
        $boleta = new Boleta($request->all());
        $boleta->save();
        
        $ventas = $request->input('ventas');
        foreach ($ventas as $item) {
            $venta = new Venta($item);
            $venta->boleta_id = $boleta->id;
            $venta->peso_envase= $item['cantidad_envase'] * $item['peso_envase'];
            $venta->cantidad_neto = $venta->calcularNeto();
            $venta->total = $venta->calcularTotal();
            $venta->save();
        }
        
        
        $boleta->comprobante = 'BOL-' . str_pad($boleta->id, 6, '0', STR_PAD_LEFT);
        $boleta->total = $boleta->calcularTotalVenta();
        $boleta->save();

        return redirect()->route('ventas.index_all')->with('success', 'Liquidación creada exitosamente');
    }

    public function show(Boleta $boleta)
    {
        $boleta->load('cliente');
        $ventas = $boleta->ventas; 
        
        return view('ventas.show', compact('boleta','ventas'));
    }

    public function edit(Boleta $boleta)
    {
        $clientes = Cliente::all();
        $productos = Producto::all();
        $envases = Envase::all();
        $ventas = $boleta->ventas; 
        return view('ventas.edit', compact('boleta', 'clientes','ventas','productos','envases'));
    }

    public function update(Request $request, Boleta $boleta)
    {
        
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'ventas' => 'required|array',  
            'ventas.*.nombre' => 'required|string|max:255',  
            'ventas.*.cantidad_bruto' => 'required|numeric|min:0',
            'ventas.*.peso_envase' => 'required|numeric|min:0',
            'ventas.*.cantidad_envase' => 'required|numeric',  
            'ventas.*.precio' => 'required|numeric|min:0.00', 
        ]);
        
        $boleta->fill($request->all());
        $boleta->save();

        $items = $request->input('ventas');
        $validIndexes = Venta::pluck('id')->toArray();
        
        
        foreach ($items as $item) {
            #agregar
            if ($item["id"] =="-1"){
                $venta = new Venta($item);
                $venta->boleta_id = $boleta->id;
                $venta->peso_envase= $item['cantidad_envase'] * $item['peso_envase'];
                $venta->cantidad_neto = $venta->calcularNeto();
                $venta->total = $venta->calcularTotal();
                if($venta->total){$venta->save();}
                
            }else{
                #eliminar
                if (in_array($item["id"], $validIndexes)) {
                    $venta = Venta::find($item["id"]);
                    $venta->fill($item);
                    $venta->total = $venta->calcularTotal();
                    if ($venta->total ==0){
                        $venta->delete();
                    }else{
                        $venta->save();
                    }
                    
                }

            }
        }
        
        $boleta->total = $boleta->calcularTotalVenta();
        $boleta->save();

        return redirect()->route('ventas.index_all')->with('success', 'Liquidación actualizada exitosamente');
    }

    public function destroy(Boleta $boleta)
    {
       
        if ($boleta->ventas()->count() > 0) {
            return redirect()->route('ventas.index_all')
                ->with('error', 'No se puede eliminar un proveedor con liquidaciones existentes');
        }
        $boleta->delete();
        return redirect()->route('ventas.index_all')->with('success', 'Liquidación eliminada exitosamente');
    }
}
