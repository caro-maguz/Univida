<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Psicologo;

class PsicologoController extends Controller
{
    // Mostrar lista de psicólogos (CONSULTAR)
    public function index()
    {
        if (!session('psicologo_id')) {
            return redirect()->route('login.psychologist');
        }
        
        $psicologos = Psicologo::all();
        return view('psychologist.psicologos.index', compact('psicologos'));
    }

    // Mostrar formulario para crear nuevo psicólogo (REGISTRAR)
    public function create()
    {
        if (!session('psicologo_id')) {
            return redirect()->route('login.psychologist');
        }
        
        return view('psychologist.psicologos.create');
    }

    // Guardar nuevo psicólogo en la base de datos (REGISTRAR)
    public function store(Request $request)
    {
        if (!session('psicologo_id')) {
            return redirect()->route('login.psychologist');
        }
        
        $request->validate([
            'nombre' => 'required|string|max:100',
            'correo' => 'required|email|unique:psicologo,correo',
            'contrasena' => 'required|min:6',
            'telefono' => 'nullable|string|max:30'
        ]);

        Psicologo::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'contrasena' => Hash::make($request->contrasena),
            'telefono' => $request->telefono,
            'disponible' => $request->has('disponible')
        ]);

        return redirect()->route('psicologos.index')->with('success', 'Psicólogo registrado exitosamente.');
    }

    // Mostrar formulario para editar psicólogo (MODIFICAR)
    public function edit($id)
    {
        if (!session('psicologo_id')) {
            return redirect()->route('login.psychologist');
        }
        
        $psicologo = Psicologo::findOrFail($id);
        return view('psychologist.psicologos.edit', compact('psicologo'));
    }

    // Actualizar psicólogo en la base de datos (MODIFICAR)
    public function update(Request $request, $id)
    {
        if (!session('psicologo_id')) {
            return redirect()->route('login.psychologist');
        }
        
        $psicologo = Psicologo::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:100',
            'correo' => 'required|email|unique:psicologo,correo,' . $id . ',id_psicologo',
            'telefono' => 'nullable|string|max:30'
        ]);

        $psicologo->nombre = $request->nombre;
        $psicologo->correo = $request->correo;
        $psicologo->telefono = $request->telefono;
        $psicologo->disponible = $request->has('disponible');

        if ($request->filled('contrasena')) {
            $request->validate(['contrasena' => 'min:6']);
            $psicologo->contrasena = Hash::make($request->contrasena);
        }

        $psicologo->save();

        return redirect()->route('psicologos.index')->with('success', 'Psicólogo actualizado exitosamente.');
    }

    // Eliminar psicólogo de la base de datos (ELIMINAR)
    public function destroy($id)
    {
        if (!session('psicologo_id')) {
            return redirect()->route('login.psychologist');
        }
        
        $psicologo = Psicologo::findOrFail($id);
        $psicologo->delete();

        return redirect()->route('psicologos.index')->with('success', 'Psicólogo eliminado exitosamente.');
    }
}