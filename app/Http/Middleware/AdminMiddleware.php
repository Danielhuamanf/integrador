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

<<<<<<< HEAD
<<<<<<< HEAD
        // Verificar rol admin
        if (session('usuario_rol') != 1) {
=======
        // Verificar rol admin (1) o agente (2)
        if (!in_array(session('usuario_rol'), [1, 2])) {
>>>>>>> dev
=======
        // Verificar rol admin (1) o agente (2)
        if (!in_array(session('usuario_rol'), [1, 2])) {
>>>>>>> charles
            return redirect('/login');
        }

        return $next($request);
    }
}