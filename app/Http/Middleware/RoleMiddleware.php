<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
{
    // 1. Cek apakah user sudah login?
    if (! $request->user()) {
        return redirect('/login');
    }

    // 2. Cek apakah user_type SESUAI dengan role yang diminta?
    // Kita bandingkan user_type di database dengan $role yang kita set di route
    if ($request->user()->user_type !== $role) {
        // Jika tidak sesuai, lempar error 403 (Forbidden)
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }

    // 3. Jika lolos, silakan lanjut
    return $next($request);
}
}
