<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function showLoginForm()
    {
        return view('login-user');
    }

    public function login(Request $request)
    {
        // Validar campos
        $request->validate([
            'correo' => 'required|email',
            'contrasena' => 'required'
        ]);

        // Buscar usuario en la base de datos
        $usuario = Usuario::where('correo', $request->correo)->first();

        if (!$usuario) {
            return back()->with('error', 'El correo no está registrado.');
        }

        // Verificar contraseña
        if (!Hash::check($request->contrasena, $usuario->contrasena)) {
            return back()->with('error', 'Contraseña incorrecta.');
        }

        // Guardar datos en sesión
        session([
            'usuario_id' => $usuario->id_usuario,
            'tipo_usuario' => $usuario->tipo_usuario,
            'nombre_usuario' => $usuario->nombre
        ]);

        // Redirigir según tipo de usuario
        switch ($usuario->tipo_usuario) {
            case 'estudiante':
            case 'docente':
            case 'administrativo':
                return redirect()->route('dashboard.user');
            default:
                return redirect()->route('home');
        }
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('home');
    }
}
