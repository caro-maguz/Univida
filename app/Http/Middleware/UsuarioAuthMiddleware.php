<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UsuarioAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Unificar clave de sesión: el controlador de login/registro usa 'id'
        if (!session('rol') || session('rol') !== 'usuario' || !session('id')) {
            return redirect()->route('login.user')->withErrors(['error' => 'Debes iniciar sesión como usuario']);
        }

        return $next($request);
    }
}