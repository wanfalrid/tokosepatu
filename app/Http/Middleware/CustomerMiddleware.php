<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('customer')->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            
            return redirect()->route('auth.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
