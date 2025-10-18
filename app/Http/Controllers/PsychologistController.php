<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Psicologo;

class PsychologistController extends Controller
{
    // Mostrar formulario de login
    public function showLoginForm()
    {
        return view('login-psychologist');
    }

    // Procesar login
    public function login(Request $request)
    {
        // Validar los campos
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Buscar psicólogo por correo
        $psicologo = Psicologo::where('correo', $request->email)->first();

        // Verificar si existe y la contraseña es correcta
        if ($psicologo && Hash::check($request->password, $psicologo->contrasena)) {
            // Guardar datos en sesión
            Session::put('psicologo_id', $psicologo->id_psicologo);
            Session::put('psicologo_nombre', $psicologo->nombre);
            
            // Redirigir al dashboard
            return redirect()->route('dashboard.psychologist');
        }

        // Si falla, redirigir con error
        return back()->withErrors([
            'email' => 'Las credenciales son incorrectas.'
        ])->withInput();
    }

    // Dashboard del psicólogo (protegido)
    public function index()
    {
        // Verificar si está autenticado
        if (!session('psicologo_id')) {
            return redirect()->route('login.psychologist');
        }
        
        return view('dashboard-psychologist');
    }

    // Cerrar sesión
    public function logout()
    {
        Session::forget(['psicologo_id', 'psicologo_nombre']);
        return redirect()->route('login.psychologist');
    }
}