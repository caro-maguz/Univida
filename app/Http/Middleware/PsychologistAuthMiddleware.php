<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PsychologistAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        \Log::info('Verificando autenticación de psicólogo:', [
            'psicologo_id' => session('psicologo_id'),
            'session' => session()->all(),
            'route' => $request->route()->getName()
        ]);

        if (!session('psicologo_id')) {
            \Log::warning('Acceso denegado: No hay sesión de psicólogo');
            return redirect()->route('login.user')->withErrors([
                'error' => 'Debes iniciar sesión como psicólogo para acceder a esta página.'
            ]);
        }
        return $next($request);
    }
}