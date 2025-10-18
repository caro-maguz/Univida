<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Administrador;
use App\Models\Psicologo;

class AdminController extends Controller
{
    // =====================
    // LOGIN Y SESIÓN
    // =====================

    public function showLoginForm()
    {
        return view('login-admin');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $administrador = Administrador::where('correo', $request->email)->first();

        if ($administrador && Hash::check($request->password, $administrador->contrasena)) {
            Session::put('admin_id', $administrador->id_admin);
            Session::put('admin_nombre', $administrador->nombre);

            return redirect()->route('administrador.dashboard');
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas'])->withInput();
    }

    public function logout()
    {
        Session::forget(['admin_id', 'admin_nombre']);
        return redirect()->route('login.admin');
    }

    public function dashboard()
    {
        if (!session('admin_id')) {
            return redirect()->route('login.admin');
        }

        $psicologos = Psicologo::all();
        return view('administrador.dashboard', compact('psicologos'));
    }

    // =====================
    // CRUD DE PSICÓLOGOS
    // =====================

    // Mostrar lista
    public function index()
    {
        $administradores = Psicologo::all();
        return view('administrador.index', compact('administradores'));
    }

    // Formulario de creación
    public function create()
    {
        return view('administrador.create');
    }

    // Guardar nuevo psicólogo
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'correo' => 'required|email|unique:psicologo,correo',
            'contrasena' => 'required|min:6',
        ]);

        Psicologo::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'contrasena' => Hash::make($request->contrasena),
        ]);

        return redirect()->route('administrador.index')->with('success', '✅ Psicólogo agregado correctamente.');
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $administrador = Psicologo::findOrFail($id);
        return view('administrador.edit', compact('administrador'));
    }

    // Actualizar datos
    public function update(Request $request, $id)
    {
        $administrador = Psicologo::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:100',
            'correo' => 'required|email|unique:psicologo,correo,' . $id . ',id_psicologo',
        ]);

        $administrador->nombre = $request->nombre;
        $administrador->correo = $request->correo;

        if ($request->filled('contrasena')) {
            $administrador->contrasena = Hash::make($request->contrasena);
        }

        $administrador->save();

        return redirect()->route('administrador.index')->with('success', '✅ Psicólogo actualizado exitosamente.');
    }

    // Eliminar psicólogo
    public function destroy($id)
    {
        $administrador = Psicologo::findOrFail($id);
        $administrador->delete();

        return redirect()->route('administrador.index')->with('success', '🗑️ Psicólogo eliminado correctamente.');
    }
}
