<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        $user = $request->user();

        // if ($user) {
        //     if ($user->role === "admin") {
        //         return redirect('/pengajar/dashboard');
        //     } elseif ($user->role === "pengajar") {
        //         return redirect('/pengajar/dashboard');
        //     }
        // }
        return $next($request);
    }
}
