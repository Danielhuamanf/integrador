<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si existe sesión
        if (!session()->has('usuario_id')) {
            return redirect('/login');
        }

        // Verificar rol admin
        if (session('usuario_rol') != 1) {
            return redirect('/home_cliente');
        }

        return $next($request);
    }
}