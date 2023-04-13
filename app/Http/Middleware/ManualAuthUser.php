<?php

namespace App\Http\Middleware;

use Closure;

class ManualAuthUser
{
    public function handle($request, Closure $next)
    {
        if (!auth()->check()) {
            auth()->loginUsingId(1);
        }

        return $next($request);
    }
}
