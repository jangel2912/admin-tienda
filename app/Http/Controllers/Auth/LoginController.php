<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Database\Tables;
use App\Http\Controllers\Controller;
use App\Tools\Facades\Password;
use Carbon\Carbon;
use Hesto\MultiAuth\Traits\LogsoutGuard;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers, LogsoutGuard {
        LogsoutGuard::logout insteadof AuthenticatesUsers;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin.guest', ['except' => 'logout']);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!is_null($user)) {
            if (Password::validate($user, $request->password)) {
                $config = $user->dbConfig;
                $licenses = $config->all_licenses;
                $warehouse_id = $user->shop->id_almacen;
                $is_licensed = false;

                foreach ($licenses as $license) {
                    if (
                        $license->id_almacen === $warehouse_id &&
                        $license->fecha_vencimiento > Carbon::now()
                    ) {
                        $is_licensed = true;
                        break;
                    }
                }

                if (!$is_licensed) {
                    if ($config->is_demo) {
                        return back()->with('warning', 'TU SUSCRIPCIÓN GRATUITA A EXPIRADO<p>Por favor contacta con uno de nuestros asesores <a href="mailto:asesor@vendty.com?Subject=Compra%20de%20licencia%20Tienda%20Vendty">asesor@vendty.com</a> <p>')->withInput();
                    } else {
                        return back()->with('warning', 'SUSCRIPCIÓN VENCIDA<p>Por favor contacta con uno de nuestros asesores <a href="mailto:asesor@vendty.com?Subject=Compra%20de%20licencia%20Tienda%20Vendty">asesor@vendty.com</a> <p>')->withInput();
                    }
                }

                Auth::guard('admin')->login($user);
                (new Tables($user))->runAll();

                return redirect('/admin/dashboard');
            }
        }

        return back()->with('danger', '¡El usuario o la clave son incorrectos!')->withInput();
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }
}
