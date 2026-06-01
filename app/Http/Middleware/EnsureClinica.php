<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureClinica
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->clinica_id) {
            abort(403, 'No tiene una clínica asociada.');
        }

        return $next($request);
    }
}
