<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaiterCheck
{
    /**
     * Check if a waiter is authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('waiter')->check() && $request->path() != 'login') {
            return redirect()->route('waiterLogin');
        }

        if (Auth::guard('waiter')->check() && $request->path() == 'login') {
            return back();
        }

        return $next($request);
    }
}
