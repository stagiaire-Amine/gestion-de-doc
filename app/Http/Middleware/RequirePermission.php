<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RequirePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $permission
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // 1. Admin Bypass: Administrators have absolute access to everything.
        if ($user->is_admin) {
            return $next($request);
        }

        // 2. Granular Check: Check the user's JSON permission array.
        if (!$user->hasPermission($permission)) {
            abort(403, "Forbidden: You do not have the required permission ('{$permission}') to access this feature.");
        }

        return $next($request);
    }
}
