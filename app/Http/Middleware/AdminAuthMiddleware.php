<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class AdminAuthMiddleware
{
    public function handle(Request $request, Closure $next): RedirectResponse|\Illuminate\Http\Response
    {
        $userId = session('auth_user_id');
        $userRole = strtolower(session('active_profile') ?? '');

        if (!$userId || $userRole !== 'admin') {
            return redirect()->route('login')->withErrors([
                'login' => 'Accès réservé aux administrateurs. Veuillez vous connecter.',
            ]);
        }

        return $next($request);
    }
}
