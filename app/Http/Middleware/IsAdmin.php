<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        if (!$user) {
            abort(403, 'Unauthorized action.');
        }

        if (!$user->is_admin) {
            abort(403, 'Administrative privileges required.');
        }

        return $next($request);
    }
}
