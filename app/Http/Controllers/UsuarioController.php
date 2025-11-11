<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    public function inicio()
    {
        // Verifica si el usuario ha iniciado sesión
        if (!session('rol') || session('rol') !== 'usuario') {
            return redirect()->route('login.user');
        }

        return view('dashboard-user'); 
    }

    /**
     * Procesar el registro de un nuevo usuario.
     */
    public function store(Request $request)
    {
        $request->validate([
            'alias' => 'required|string|min:3',
            'correo' => 'required|email|unique:usuario,correo',
            'password' => 'required|string|min:6',
        ]);

        // Crear el usuario
        $usuario = Usuario::create([
            'nombre' => $request->alias,
            'correo' => $request->correo,
            'contrasena' => Hash::make($request->password),
            'telefono' => null,
            'tipo_usuario' => 'usuario',
            'anonimo' => 0,
        ]);

        // Iniciar sesión en la aplicación
        session(['rol' => 'usuario', 'id' => $usuario->id_usuario, 'nombre' => $usuario->nombre]);

        return redirect()->route('inicio.usuario');
    }
}