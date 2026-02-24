<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordReset
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->must_change_password) {
            // Allow them to visit the reset page or logout
            if (!$request->routeIs('password.force_reset', 'password.force_reset.store', 'logout')) {
                return redirect()->route('password.force_reset');
            }
        }

        return $next($request);
    }
}
