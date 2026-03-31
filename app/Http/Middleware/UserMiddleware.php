<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'user') {
            return $next($request);
        }

        // If admin tries to access user pages, redirect to admin dashboard
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect('/admin')->with('error', 'Admin tidak memiliki akses ke halaman User.');
        }

        // If not logged in, redirect to login
        return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
    }
}
