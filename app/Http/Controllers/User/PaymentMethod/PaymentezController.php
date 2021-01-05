<?php

namespace App\Http\Controllers\User\PaymentMethod;

use App\Models\Shop\PaymentMethod\Paymentez;
use App\Modules\Facades\PaymentMethod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentezController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $paymentez = Paymentez::first();
        $environments = [
            'prod' => 'Producción',
            'stg' => 'Stage',
            'local' => 'Local'
        ];
        
        return view('admin.settings.payments.paymentez', compact('paymentez', 'environments'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'paymentez_app_code_client' => 'required|alpha_dash|max:100',
            'paymentez_app_key_client' => 'required|alpha_dash|max:100',
            'paymentez_app_code_server' => 'required|alpha_dash|max:100',
            'paymentez_app_key_server' => 'required|alpha_dash|max:100',
        ]);

        $paymentez = Paymentez::first();
        if (is_null($paymentez)) {
            $paymentez = new Paymentez();
        }

        $paymentez->paymentez_app_code_client = $request->paymentez_app_code_client;
        $paymentez->paymentez_app_key_client = $request->paymentez_app_key_client;
        $paymentez->paymentez_app_code_server = $request->paymentez_app_code_server;
        $paymentez->paymentez_app_key_server = $request->paymentez_app_key_server;

        if (!is_null($request->active)) {
            PaymentMethod::disablePayment();
        }

        $paymentez->active = (!is_null($request->active)) ? true : false;
        $paymentez->paymentez_environment = $request->paymentez_environment;

        if ($paymentez->save()) {
            return back()->with('success', 'Las credenciales se agregaron con éxito.');
        } else {
            return back()->with('error', message('error'));
        }
    }
}
