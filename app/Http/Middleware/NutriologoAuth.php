<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NutriologoAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('nutriologo_id')) {
            return redirect()
                ->route('login')
                ->with('error', 'Debes iniciar sesión para acceder al panel.');
        }

        return $next($request);
    }
}