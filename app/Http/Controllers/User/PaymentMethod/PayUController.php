<?php

namespace App\Http\Controllers\User\PaymentMethod;

use App\Models\Shop\PaymentMethod\PayU;
use App\Modules\Facades\PaymentMethod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PayUController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $payu = PayU::first();

        return view('admin.settings.payments.payu', compact('payu'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'merchant_id' => 'required|alpha_num|max:100',
            'account_id' => 'required|alpha_num|max:100',
            'api_key' => 'required|alpha_num|max:100',
        ]);

        $payu = PayU::first();
        if (is_null($payu)) {
            $payu = new PayU;
        }

        $payu->merchant_id = $request->merchant_id;
        $payu->account_id = $request->account_id;
        $payu->api_key = $request->api_key;

        if (!is_null($request->active)) {
            PaymentMethod::disablePayment();
        }

        $payu->active = (!is_null($request->active)) ? true : false;
        $payu->payu_test_mode = (!is_null($request->payu_test_mode)) ? true : false;
        

        if ($payu->save()) {
            return back()->with('success', 'Las credenciales se agregaron con éxito.');
        } else {
            return back()->with('error', message('error'));
        }
    }
}
