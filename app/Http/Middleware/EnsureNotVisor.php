<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureNotVisor
{
    /**
     * Bloquea a los usuarios con rol 'visor' para que solo puedan acceder al panel /visor.
     * Cualquier otra ruta protegida los redirige al visor.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->isVisor()) {
            return redirect()->route('visor');
        }

        return $next($request);
    }
}
