<?php

namespace App\Http\Controllers\User\PaymentMethod;

use App\Models\Shop\PaymentMethod\PayPal;
use App\Modules\Facades\PaymentMethod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PayPalController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $paypal = PayPal::first();

        return view('admin.settings.payments.paypal', compact('paypal'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'client_id' => 'required|max:100',
            'secret_id' => 'required|max:100',
        ]);

        $paypal = PayPal::first();
        if (is_null($paypal)) {
            $paypal = new PayPal;
        }

        $paypal->client_id = $request->client_id;
        $paypal->secret_id = $request->secret_id;

        if (!is_null($request->active)) {
            PaymentMethod::disablePayment();
        }

        $paypal->active = (!is_null($request->active)) ? true : false;

        if ($paypal->save()) {
            return back()->with('success', 'Las credenciales se agregaron con éxito.');
        } else {
            return back()->with('error', message('error'));
        }
    }
}
