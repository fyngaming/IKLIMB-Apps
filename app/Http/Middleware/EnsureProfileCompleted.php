<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileCompleted
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->role === 'alumni' && $user->is_first_login) {
            if (! $request->routeIs('onboarding.*') && ! $request->routeIs('logout')) {
                return redirect()->route('onboarding.index')
                    ->with('info', 'Selamat datang di IKLIMB Apps! Silakan lengkapi biodata dan atur password Anda terlebih dahulu.');
            }
        }

        return $next($request);
    }
}
