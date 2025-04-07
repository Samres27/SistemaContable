<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Envase;

class EnvaseController extends Controller
{
    public function index()
    {
        $envases = Envase::paginate(10);
        return view('envases.index', compact('envases'));
    }

    public function create()
    {
        return view('envases.create');
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'nombre' => 'required|max:255',
            'peso' => 'required|numeric',
        ]);

        $Envase= Envase::create($request->all());
        
        return redirect()->route('envases.index')
            ->with('success', 'Cliente creado exitosamente');
    }

    public function show(Envase $envase)
    {
        return view('envases.show', compact('envase'));
    }    

    public function edit(Envase $envase)
    {
        return view('envases.edit', compact('envase'));
    }

    public function update(Request $request, Envase $envase)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'peso' => 'required|numeric',
        ]);

        $envase->update($request->all());

        return redirect()->route('envases.index')
            ->with('success', 'Cliente actualizado exitosamente');
    }

    public function destroy(Envase $envase)
    {
        // Verificar si tiene liquidaciones antes de eliminar
        // if ($cliente->liquidaciones()->count() > 0) {
        //     return redirect()->route('envases.index')
        //         ->with('error', 'No se puede eliminar un proveedor con liquidaciones existentes');
        // }

        $envase->delete();

        return redirect()->route('envases.index')
            ->with('success', 'Envase eliminado exitosamente');
    }
}
