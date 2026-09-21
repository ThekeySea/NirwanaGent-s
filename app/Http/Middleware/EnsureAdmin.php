<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        // Jangan percaya role dari client. Cek dari session auth server-side.
        if ($user->role !== 'admin') {
            abort(403, 'Halaman ini hanya untuk admin.');
        }

        return $next($request);
    }
}
