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
        if (!session('psicologo_id')) {
            return redirect()->route('login.psychologist')->withErrors([
                'error' => 'Debes iniciar sesión para acceder a esta página.'
            ]);
        }
        return $next($request);
    }
}