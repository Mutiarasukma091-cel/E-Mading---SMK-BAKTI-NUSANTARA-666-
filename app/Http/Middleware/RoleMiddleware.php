<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $userRole = auth()->user()->role;
        
        // Allow access based on role
        if (($role === 'admin' && $userRole === 'admin') ||
            ($role === 'teacher' && $userRole === 'guru') ||
            ($role === 'student' && $userRole === 'siswa')) {
            return $next($request);
        }

        // Redirect to appropriate dashboard if wrong role
        $dashboardRoute = match($userRole) {
            'admin' => 'admin.dashboard',
            'guru' => 'teacher.dashboard',
            'siswa' => 'student.dashboard',
            default => 'login'
        };
        
        return redirect()->route($dashboardRoute)->with('error', 'Akses ditolak untuk halaman ini');
    }
}