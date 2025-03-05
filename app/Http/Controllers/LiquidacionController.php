<?php

namespace App\Http\Controllers;

use App\Models\Liquidacion;
use App\Models\Descuento;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LiquidacionController extends Controller
{
    public function index(Request $request)
    {
        $proveedorNombre = $request->input('proveedor');

        $liquidaciones = Liquidacion::with('proveedor')
            ->when($proveedorNombre, function ($query, $proveedorNombre) {
                // Filtrar por nombre del proveedor
                return $query->whereHas('proveedor', function ($query) use ($proveedorNombre) {
                    $query->where('nombre', 'like', '%' . $proveedorNombre . '%');
                });
            })
            ->paginate(10);
        return view('liquidaciones.index', compact('liquidaciones'));
    }

    public function index_all()
    {
        $liquidaciones = Liquidacion::with('proveedor')->get();
        //dd($liquidaciones);
        return view('liquidaciones.index', compact('liquidaciones'));
    }

    public function create()
    {
        $proveedores = Proveedor::all();
        return view('liquidaciones.create', compact('proveedores'));
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'fecha' => 'required|date',
            'nro_pollos' => 'required|integer|min:1',
            'peso_bruto' => 'required|numeric|min:0',
            'peso_tara' => 'required|numeric|min:0',
            'porcentaje_descuento' => 'required|numeric|between:0,100',
            'peso_tiki_buche' => 'required|numeric|min:0',
            'modalidad_calculo' => 'required|in:opcion1,opcion2',
            'precio' => 'required|numeric|min:0',
            'items' => 'required|array',  
            'items.*.nombre_item' => 'required|string|max:255',  
            'items.*.cantidad' => 'required|numeric|min:1',  
            'items.*.precio' => 'required|numeric|min:0.01',  
    
        ]);
    
        $liquidacion = new Liquidacion($request->all());
        
        $liquidacion->peso_neto = $liquidacion->calcularPesoNeto();
        $liquidacion->peso_neto_pagar = $liquidacion->calcularPesoNetoPagar();
        $liquidacion->promedio_peso = $liquidacion->calcularPromedioPeso();
        $liquidacion->total_sin_descuento = $liquidacion->calcularTotal();
        $liquidacion->save();

        $items = $request->input('items');
        
        foreach ($items as $item) {
            $descuento = new Descuento($item);
            $descuento->total = $descuento->calcularTotal();
            $descuento->liquidacion_id = $liquidacion->id;
            $descuento->save();
        }
        
        $liquidacion->comprobante = 'LIQ-' . str_pad($liquidacion->id, 6, '0', STR_PAD_LEFT);
        $liquidacion->total_descuento = $liquidacion->calcularTotalDescuento();
        $liquidacion->save();

        return redirect()->route('liquidaciones.index_all')->with('success', 'Liquidación creada exitosamente');
    }

    public function show(Liquidacion $liquidacion)
    {
        $liquidacion->load('proveedor');
        $descuentos = $liquidacion->descuentos; 
        return view('liquidaciones.show', compact('liquidacion','descuentos'));
    }

    public function edit(Liquidacion $liquidacion)
    {
        $proveedores = Proveedor::all();
        $descuentos = $liquidacion->descuentos; 
        return view('liquidaciones.edit', compact('liquidacion', 'proveedores','descuentos'));
    }

    public function update(Request $request, Liquidacion $liquidacion)
    {
        
        $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'fecha' => 'required|date',
            'nro_pollos' => 'required|integer|min:1',
            'peso_bruto' => 'required|numeric|min:0',
            'peso_tara' => 'required|numeric|min:0',
            'porcentaje_descuento' => 'required|numeric|between:0,100',
            'peso_tiki_buche' => 'required|numeric|min:0',
            'modalidad_calculo' => 'required|in:opcion1,opcion2',
            'precio' => 'required|numeric|min:0',
            'items' => 'required|array',  
            'items.*.nombre_item' => 'required|string|max:255',  
            'items.*.cantidad' => 'required|numeric|min:0',  
            'items.*.precio' => 'required|numeric|min:0',  
        ]);
        
        $liquidacion->fill($request->all());
        $liquidacion->peso_neto = $liquidacion->calcularPesoNeto();
        $liquidacion->peso_neto_pagar = $liquidacion->calcularPesoNetoPagar();
        $liquidacion->promedio_peso = $liquidacion->calcularPromedioPeso();
        $liquidacion->total_sin_descuento = $liquidacion->calcularTotal();
        $liquidacion->save();

        $items = $request->input('items');
        $validIndexes = Descuento::pluck('id')->toArray();
        
        foreach ($items as $item) {
            #agregar
            if ($item["id"] ==-1){
                $descuento = new Descuento($item);
                $descuento->total = $descuento->calcularTotal();
                $descuento->liquidacion_id = $liquidacion->id;
                if($descuento->total){$descuento->save();}
                
            }else{
                #eliminar
                if (in_array($item["id"], $validIndexes)) {
                    $descuento = Descuento::find($item["id"]);
                    $descuento->fill($item);
                    $descuento->total = $descuento->calcularTotal();
                    if ($descuento->total ==0){
                        $descuento->delete();
                    }else{
                        $descuento->save();
                    }
                    
                }

            }
        }

        $liquidacion->total_descuento = $liquidacion->calcularTotalDescuento();
        $liquidacion->save();

        return redirect()->route('liquidaciones.index_all')->with('success', 'Liquidación actualizada exitosamente');
    }

    public function destroy(Liquidacion $liquidacion)
    {
        $liquidacion->delete();
        return redirect()->route('liquidaciones.index_all')->with('success', 'Liquidación eliminada exitosamente');
    }
    
}