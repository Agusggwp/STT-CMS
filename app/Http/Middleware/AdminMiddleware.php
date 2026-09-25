<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan masuk terlebih dahulu untuk mengakses dashboard admin.');
        }

        $user = auth()->user();

        if ($user->status !== 'active') {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Akun Anda dinonaktifkan. Silakan hubungi Super Admin.');
        }

        return $next($request);
    }
}
