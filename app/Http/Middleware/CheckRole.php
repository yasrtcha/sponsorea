<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // 1. Jika user belum login sama sekali, kembalikan ke halaman login
        if (!Auth::check()) {
            return redirect('login');
        }

        // 2. Cek apakah role user yang sedang login ada di dalam daftar role yang diizinkan
        if (in_array(Auth::user()->role, $roles)) {
            return $next($request); // Jika cocok, silakan masuk ke halaman
        }

        // 3. Jika role tidak cocok, tolak aksesnya!
        abort(403, 'Akses Ditolak. Anda tidak memiliki izin untuk membuka halaman ini.');
    }
}