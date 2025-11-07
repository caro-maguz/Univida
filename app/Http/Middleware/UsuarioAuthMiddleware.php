<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UsuarioAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('rol') || session('rol') !== 'usuario') {
            return redirect()->route('login.user')->withErrors(['error' => 'Debes iniciar sesión como usuario']);
        }

        return $next($request);
    }
}