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
            'correo' => [
                'required',
                'email',
                'unique:usuario,correo',
                'regex:/@uniautonoma\.edu\.co$/i'
            ],
            'password' => 'required|string|min:6',
        ], [
            'alias.required' => 'El alias es obligatorio.',
            'alias.min' => 'El alias debe tener al menos 3 caracteres.',
            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'Debe proporcionar un correo válido.',
            'correo.unique' => 'Este correo ya está registrado. Por favor usa otro correo.',
            'correo.regex' => 'Debes usar un correo institucional (@uniautonoma.edu.co).',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
        ]);

        try {
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

            return redirect()->route('dashboard.user');
            
        } catch (\Illuminate\Database\QueryException $e) {
            // Capturar errores de base de datos (triggers, constraints, etc.)
            $errorMessage = $e->getMessage();
            
            // Error de correo duplicado
            if ($e->getCode() == 23000 || strpos($errorMessage, 'Duplicate entry') !== false) {
                return back()->withInput()->withErrors([
                    'correo' => 'Este correo ya está registrado. Por favor usa otro correo.'
                ]);
            }
            
            // Error del trigger de validación de correo institucional
            if (strpos($errorMessage, 'institucional') !== false || strpos($errorMessage, 'uniautonoma') !== false) {
                return back()->withInput()->withErrors([
                    'correo' => 'Debes usar un correo institucional (@uniautonoma.edu.co).'
                ]);
            }
            
            // Otros errores de base de datos
            return back()->withInput()->withErrors([
                'error' => 'Error al crear el usuario. Por favor intenta nuevamente.'
            ]);
        } catch (\Exception $e) {
            // Cualquier otro error
            return back()->withInput()->withErrors([
                'error' => 'Ocurrió un error inesperado. Por favor intenta nuevamente.'
            ]);
        }
    }
}