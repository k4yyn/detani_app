<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        \Log::debug('Role Check', [
            'user_role' => auth()->user()->role,
            'required_roles' => $roles
        ]);

        if (!in_array(auth()->user()->role, $roles)) {
            abort(403, 'Akses ditolak untuk role ini');
        }

        return $next($request);
    }
}
