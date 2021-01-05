<?php

namespace App\Http\Controllers\User\PaymentMethod;

use App\Models\Shop\PaymentMethod\MercadoPago;
use App\Modules\Facades\PaymentMethod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MercadoPagoController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $mercadopago = MercadoPago::first();
        $countries = [
            "ar" => "Argentina",
            "br" => "Brasil",
            "cl" => "Chile",
            "co" => "Colombia",
            "mx" => "México",
            //"mx" => "Peru",
            "uy" => "Uruguay"
        ];
        return view('admin.settings.payments.mercadopago', compact('mercadopago', 'countries'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'public_key' => 'required|alpha_dash|max:100',
            'access_token' => 'required|alpha_dash|max:100',
        ]);

        $mercadopago = MercadoPago::first();
        if (is_null($mercadopago)) {
            $mercadopago = new MercadoPago;
        }

        $mercadopago->public_key = $request->public_key;
        $mercadopago->access_token = $request->access_token;
        $mercadopago->mercadopago_country = $request->mercadopago_country;

        if (!is_null($request->active)) {
            PaymentMethod::disablePayment();
        }

        $mercadopago->active = (!is_null($request->active)) ? true : false;

        if ($mercadopago->save()) {
            return back()->with('success', 'Las credenciales se agregaron con éxito.');
        } else {
            return back()->with('error', message('error'));
        }
    }
}
