<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login-user'); // tu vista de inicio de sesión
    }

    public function login(Request $request)
    {
        // Validar datos
        $request->validate([
            'correo' => 'required|email',
            'contrasena' => 'required'
        ]);

        $correo = $request->correo;
        $contrasena = $request->contrasena;

        // Buscar en las tres tablas
        $usuario = DB::table('usuario')->where('correo', $correo)->first();
        $psicologo = DB::table('psicologo')->where('correo', $correo)->first();
        $admin = DB::table('administrador')->where('correo', $correo)->first();

        if ($usuario && Hash::check($contrasena, $usuario->contrasena)) {
            session(['rol' => 'usuario', 'id' => $usuario->id_usuario, 'nombre' => $usuario->nombre]);
            return redirect()->route('inicio.usuario');
        }

        if ($psicologo && Hash::check($contrasena, $psicologo->contrasena)) {
            session(['rol' => 'psicologo', 'id' => $psicologo->id_psicologo, 'nombre' => $psicologo->nombre]);
            return redirect()->route('inicio.psicologo');
        }

        if ($admin && Hash::check($contrasena, $admin->contrasena)) {
            session(['rol' => 'admin', 'id' => $admin->id_admin, 'nombre' => $admin->nombre]);
            return redirect()->route('administrador.dashboard');
        }

        // Si no se encontró ningún usuario válido
        return back()->withErrors(['login_error' => 'Correo o contraseña incorrectos']);
    }
}
