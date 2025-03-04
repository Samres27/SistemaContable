<?php

namespace App\Http\Controllers;
use App\Models\Venta;
use App\Imports\VentasImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
class VentaController extends Controller
{
    /**
     * Mostrar la lista de ventas.
     */
    public function index()
    {
        $ventas = Venta::paginate(10);
        return view('ventas.index', compact('ventas'));
    }

    /**
     * Mostrar formulario para importar Excel
     */
    public function importForm()
    {
        return view('ventas.import');
    }

    /**
     * Procesar la importación del archivo Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'archivo' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);
        
        try {
            Excel::import(new VentasImport, $request->file('archivo'));
            
            return redirect()->route('ventas.index')
                ->with('success', 'ventas importados correctamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al importar: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar el formulario para editar un venta.
     */
    public function edit(Venta $venta)
    {
        return view('ventas.edit', compact('venta'));
    }

    /**
     * Actualizar un venta específico.
     */
    public function update(Request $request, Venta $venta)
    {
        $request->validate([
            'nombre' => 'required|string',
            'peso' => 'nullable|numeric',
            'precio' => 'nullable|numeric',
            'deuda' => 'nullable|numeric',
        ]);

        $venta->update($request->all());

        return redirect()->route('ventas.index')
            ->with('success', 'venta actualizado correctamente');
    }

    /**
     * Eliminar un venta.
     */
    public function destroy(Venta $venta)
    {
        $venta->delete();
        return redirect()->route('ventas.index')->with('success', 'venta eliminado correctamente');
    }
}
