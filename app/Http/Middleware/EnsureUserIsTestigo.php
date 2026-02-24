<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsTestigo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Debe iniciar sesión para acceder.');
        }

        $user = auth()->user();

        if (!$user->isTestigo()) {
            abort(403, 'No tiene permisos para acceder a esta sección.');
        }

        if (!$user->testigo) {
            abort(403, 'No tiene un registro de testigo asociado. Contacte al administrador.');
        }

        return $next($request);
    }
}
