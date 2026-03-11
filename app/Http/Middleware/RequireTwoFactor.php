<?php
// app/Http/Middleware/RequireTwoFactor.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequireTwoFactor
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Если пользователь авторизован и у него включена 2FA, но не подтверждена
        if ($user && $user->two_factor_enabled && !$user->hasValidTwoFactorSession()) {
            // Если это не AJAX запрос и не страница подтверждения
            if (!$request->ajax() && !$request->routeIs('two-factor.*')) {
                Auth::logout();
                return redirect()->route('login')
                    ->with('error', 'Требуется повторная авторизация с двухфакторной аутентификацией');
            }
        }

        return $next($request);
    }
}