<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (session('role') !== $role) {
            return redirect('/')->with('login_error', "Kamu harus login sebagai {$role} dulu.");
        }

        return $next($request);
    }
}
