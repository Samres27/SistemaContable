<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::paginate(10);
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'apellido' => 'nullable|max:255',
            'telefono' => 'nullable|max:20',
            'direccion' => 'nullable|max:255',
            'localizacion' => 'nullable|max:40'
        ]);

        $cliente = Cliente::create($request->all());

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente creado exitosamente');
    }

    public function show(Cliente $cliente)
    {
        #$liquidaciones = $clientes->liquidaciones()->paginate(10);
        $ventas= $cliente->ventas()->paginate(10);
        
        return view('clientes.show', compact('cliente', 'ventas'));
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'apellido' => 'nullable|max:255',
            'telefono' => 'nullable|max:20',
            'direccion' => 'nullable',
            'localizacion' => 'nullable|max:40'
        ]);

        $cliente->update($request->all());

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente actualizado exitosamente');
    }

    public function destroy(Cliente $cliente)
    {
        // Verificar si tiene liquidaciones antes de eliminar
        // if ($cliente->liquidaciones()->count() > 0) {
        //     return redirect()->route('clientes.index')
        //         ->with('error', 'No se puede eliminar un proveedor con liquidaciones existentes');
        // }

        $cliente->delete();

        return redirect()->route('clientes.index')
            ->with('success', 'Proveedor eliminado exitosamente');
    }
}
