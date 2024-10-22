<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class EnsureUserIsAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Periksa apakah user tidak login (guest)
        if (!Auth::check()) {
            // Tampilkan SweetAlert
            Alert::info('Login Required', 'Please login to submit infaq.');

            // Redirect ke halaman login
            return redirect()->route('login');
        }

        // Jika sudah login, lanjutkan request
        return $next($request);
    }
}
