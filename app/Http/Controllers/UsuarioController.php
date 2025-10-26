<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}