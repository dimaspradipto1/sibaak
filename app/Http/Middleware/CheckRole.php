<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if (Auth::user()->is_admin || Auth::user()->is_operator || Auth::user()->is_mahasiswa || Auth::user()->is_tata_usaha) {
        //     return $next($request);
        // }
        // return $next($request);

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (
            Auth::user()->is_admin ||
            Auth::user()->is_operator ||
            Auth::user()->is_mahasiswa ||
            Auth::user()->is_tata_usaha
        ) {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}
