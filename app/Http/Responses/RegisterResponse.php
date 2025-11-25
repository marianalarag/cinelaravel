<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use Illuminate\Support\Facades\Auth;

class RegisterResponse implements RegisterResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $user = Auth::user();

        // Asignar rol de cliente por defecto a nuevos usuarios
        if (!$user->hasRole('client')) {
            $user->assignRole('client');
        }

        // Redirigir al dashboard de cliente
        return redirect()->route('client.dashboard');
    }
}
