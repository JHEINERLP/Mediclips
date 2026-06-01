<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $allowed = collect($roles)->flatMap(fn ($r) => explode(',', $r))->all();

        if (! $request->user() || ! in_array($request->user()->rol, $allowed, true)) {
            abort(403, 'No tiene permiso para acceder a esta sección.');
        }

        return $next($request);
    }
}
