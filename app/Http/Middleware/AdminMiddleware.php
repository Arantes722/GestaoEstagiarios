<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || strtolower(auth()->user()->tipo_utilizador) !== 'administrador') {
            abort(403, 'Acesso negado.');
        }

        return $next($request);
    }
}
