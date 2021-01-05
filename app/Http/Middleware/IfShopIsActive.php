<?php

namespace App\Http\Middleware;

use Closure;

class IfShopIsActive
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
        if (is_null(auth_user()->shop) || auth_user()->shop->wizard) {
            return redirect()->route('admin.wizard.firststep.create');
        }

        return $next($request);
    }
}
