<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Debug información
        Log::info('CheckRole Middleware ejecutándose', [
            'user_email' => $request->user()?->email,
            'user_id' => $request->user()?->id,
            'required_role' => $role,
            'user_roles' => $request->user()?->getRoleNames()->toArray(),
            'has_role' => $request->user()?->hasRole($role) ? 'SÍ' : 'NO'
        ]);

        if (!$request->user()) {
            Log::warning('Usuario no autenticado');
            abort(403, 'No autenticado.');
        }

        if (!$request->user()->hasRole($role)) {
            Log::warning('Usuario no tiene el rol requerido', [
                'user_has_roles' => $request->user()->getRoleNames()->toArray(),
                'required_role' => $role
            ]);
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        Log::info('Acceso permitido');
        return $next($request);
    }
}
