<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->role === 'alumni' && $user->status !== 'aktif') {
            if (! $request->routeIs('verification.notice') && ! $request->routeIs('logout')) {
                return redirect()->route('verification.notice');
            }
        }

        return $next($request);
    }
}
