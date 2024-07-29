<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // No redirigir si el usuario está intentando acceder a la página de inicio
        if ($request->is('/')) {
            return null;
        }

        return $request->expectsJson() ? null : route('home');
    }
}
