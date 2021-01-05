<?php

namespace App\Http\Middleware;

use Closure;

class IfShopIsNotActive
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
        if (auth_user()->shop && !auth_user()->shop->wizard) {
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}
