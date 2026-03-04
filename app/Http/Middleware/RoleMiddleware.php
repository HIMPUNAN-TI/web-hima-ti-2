<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($user->role !== $role) {
            // Redirect to their own dashboard
            return $user->role === 'admin'
                ? redirect('/admin/dashboard')
                : redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman Admin.');;
        }

        return $next($request);
    }
}



