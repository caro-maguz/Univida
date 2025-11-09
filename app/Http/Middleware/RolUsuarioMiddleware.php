<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RolUsuarioMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('rol') || session('rol') !== 'usuario') {
            return redirect()->route('login.user');
        }

        return $next($request);
    }
}
