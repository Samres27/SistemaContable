<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::paginate(10);
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        return view('productos.create');
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'nombre' => 'required|max:255',
            'precio' => 'required|numeric',
        ]);

        $producto= Producto::create($request->all());
        
        return redirect()->route('productos.index')
            ->with('success', 'Cliente creado exitosamente');
    }

    public function show(Producto $producto)
    {
        return view('productos.show', compact('producto'));
    }    

    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'precio' => 'required|numeric',
        ]);

        $producto->update($request->all());

        return redirect()->route('productos.index')
            ->with('success', 'Cliente actualizado exitosamente');
    }

    public function destroy(Producto $producto)
    {
        // Verificar si tiene liquidaciones antes de eliminar
        // if ($cliente->liquidaciones()->count() > 0) {
        //     return redirect()->route('productos.index')
        //         ->with('error', 'No se puede eliminar un proveedor con liquidaciones existentes');
        // }

        $producto->delete();

        return redirect()->route('productos.index')
            ->with('success', 'Producto eliminado exitosamente');
    }
}
