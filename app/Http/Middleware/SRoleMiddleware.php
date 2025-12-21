<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SRoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (session('role') !== $role) {
            return redirect('/')
                ->with('login_error', 'Akses ditolak. Kamu bukan ' . $role);
        }

        return $next($request);
    }
}
