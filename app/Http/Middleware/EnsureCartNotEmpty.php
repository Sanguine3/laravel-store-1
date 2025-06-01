<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureCartNotEmpty
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (empty($request->session()->get('cart', []))) {
            return redirect()->route('cart.view');
        }

        return $next($request);
    }
} 