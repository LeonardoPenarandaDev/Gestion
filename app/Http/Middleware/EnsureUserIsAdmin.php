<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     * Permite acceso solo a administradores
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            // Redirigir según el rol del usuario
            if (auth()->user()->isTestigo()) {
                return redirect()->route('testigo.portal');
            }

            if (auth()->user()->isEditor()) {
                return redirect()->route('testigos.index');
            }

            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
