<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // If user is logged in but not admin, redirect to user dashboard
        if (Auth::check()) {
            return redirect('/user')->with('error', 'Anda tidak memiliki akses ke halaman Admin.');
        }

        // If not logged in, redirect to login
        return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
    }
}
