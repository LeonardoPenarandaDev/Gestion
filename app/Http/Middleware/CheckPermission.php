<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Check specific permissions
        switch ($permission) {
            case 'admin':
                if (!$user->isAdmin()) {
                    return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción.');
                }
                break;

            case 'delete':
                if (!$user->canDelete()) {
                    return redirect()->back()->with('error', 'No tienes permisos para eliminar registros.');
                }
                break;

            case 'manage-users':
                if (!$user->canManageUsers()) {
                    return redirect()->back()->with('error', 'No tienes permisos para gestionar usuarios.');
                }
                break;

            default:
                return redirect()->back()->with('error', 'Permiso no válido.');
        }

        return $next($request);
    }
}
