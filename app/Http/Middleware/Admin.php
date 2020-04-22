<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->email == config('admin.email') && Auth::user()->is_admin == 1) {
            return $next($request);
        }

        if ($request->wantsJson() || $request->expectsJson()) {
            return response()->json([
                'message' => 'Admin required',
            ], 422);
        }

        return redirect()->back();
    }
}
