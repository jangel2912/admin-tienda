<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class Tenant
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
        $user = auth_user();

        if (!is_null($user)) {
            $user->dbConfig->connect();

            if ($user->is_admin === 't' || $user->permits->keyBy('id_permiso')->keys()->contains(1039)) {
                return $next($request);
            }
        }

        Auth::logout();

        return redirect(route('login'))->with('danger', '¡No tiene permiso para ingresar a la Tienda Virtual! Por favor contacte con el administrador.')->withInput();
    }
}
