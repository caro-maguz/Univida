<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login-user'); // tu vista de inicio de sesión
    }

    // Cerrar sesión
     public function logoutPsicologo()
    {
        Session::forget(['rol', 'id', 'nombre']);
        return redirect()->route('login.user');
    }

    public function logoutAdmin()
    {
    Session::forget(['rol', 'id', 'nombre']);
    return redirect()->route('login.user');
    }
    public function logoutUsuario()
    {
    Session::forget(['rol', 'id', 'nombre']);
    return redirect()->route('login.user');
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

        // Validar correo institucional usando función de BD
        $esInstitucional = DB::selectOne('SELECT validar_correo_institucional(?) as valido', [$correo]);
        if (!$esInstitucional->valido) {
            return back()->withErrors(['login_error' => 'Debes usar un correo institucional @uniautonoma.edu.co']);
        }

        // Verificar si el correo ya está registrado usando función de BD
        $correoExiste = DB::selectOne('SELECT correo_ya_registrado(?) as existe', [$correo]);
        if (!$correoExiste->existe) {
            return back()->withErrors(['login_error' => 'El correo no está registrado']);
        }

        // Buscar en las tres tablas
        $usuario = DB::table('usuario')->where('correo', $correo)->first();
        $psicologo = DB::table('psicologo')->where('correo', $correo)->first();
        $admin = DB::table('administrador')->where('correo', $correo)->first();

        if ($usuario && Hash::check($contrasena, $usuario->contrasena)) {
            session([
                'rol' => 'usuario', 
                'id' => $usuario->id_usuario,
                'usuario_id' => $usuario->id_usuario,
                'nombre' => $usuario->nombre
            ]);
            return redirect()->route('dashboard.user');
        }

        if ($psicologo && Hash::check($contrasena, $psicologo->contrasena)) {
            session([
                'rol' => 'psicologo', 
                'id' => $psicologo->id_psicologo, 
                'psicologo_id' => $psicologo->id_psicologo,
                'nombre' => $psicologo->nombre
            ]);
            return redirect()->route('dashboard.psychologist');
        }

        if ($admin && Hash::check($contrasena, $admin->contrasena)) {
            session([
                'rol' => 'admin', 
                'id' => $admin->id_admin,
                'admin_id' => $admin->id_admin,
                'nombre' => $admin->nombre
            ]);
            return redirect()->route('administrador.dashboard');
        }

        // Si no se encontró ningún usuario válido
        return back()->withErrors(['login_error' => 'Correo o contraseña incorrectos']);
    }
}
