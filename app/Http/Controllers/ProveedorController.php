<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function index()
    {
        $proveedores = Proveedor::withCount('liquidaciones')->paginate(10);
        return view('proveedores.index', compact('proveedores'));
    }

    public function create()
    {
        return view('proveedores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'alias' => 'nullable|max:255',
            'telefono' => 'nullable|max:20',
            'direccion' => 'nullable',
            'tipo_liquidacion' => 'required|in:fijo,variable,mixto'
        ]);

        $proveedor = Proveedor::create($request->all());

        return redirect()->route('proveedores.index')
            ->with('success', 'Proveedor creado exitosamente');
    }

    public function show(Proveedor $proveedor)
    {
        $liquidaciones = $proveedor->liquidaciones()->paginate(10);
        return view('proveedores.show', compact('proveedor', 'liquidaciones'));
    }

    public function edit(Proveedor $proveedor)
    {
        return view('proveedores.edit', compact('proveedor'));
    }

    public function update(Request $request, Proveedor $proveedor)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'alias' => 'nullable|max:255',
            'telefono' => 'nullable|max:20',
            'direccion' => 'nullable',
            'tipo_liquidacion' => 'required|in:fijo,variable,mixto'
        ]);

        $proveedor->update($request->all());

        return redirect()->route('proveedores.index')
            ->with('success', 'Proveedor actualizado exitosamente');
    }

    public function destroy(Proveedor $proveedor)
    {
        // Verificar si tiene liquidaciones antes de eliminar
        if ($proveedor->liquidaciones()->count() > 0) {
            return redirect()->route('proveedores.index')
                ->with('error', 'No se puede eliminar un proveedor con liquidaciones existentes');
        }

        $proveedor->delete();

        return redirect()->route('proveedores.index_all')
            ->with('success', 'Proveedor eliminado exitosamente');
    }
}