<?php

namespace App\Http\Controllers\User\PaymentMethod;

use App\Models\Shop\PaymentMethod\OpenPay;
use App\Modules\Facades\PaymentMethod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OpenPayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $openpay = OpenPay::first();

        return view('admin.settings.payments.openpay', compact('openpay'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'client_id' => 'required|alpha_num|max:100',
            'public_key' => 'required|alpha_num|max:100',
            'private_key' => 'required|alpha_num|max:100',
        ]);

        $openpay = OpenPay::first();
        if (is_null($openpay)) {
            $openpay = new OpenPay;
        }

        $openpay->client_id = $request->client_id;
        $openpay->public_key = $request->public_key;
        $openpay->private_key = $request->private_key;

        if (!is_null($request->active)) {
            PaymentMethod::disablePayment();
        }

        $openpay->active = (!is_null($request->active)) ? true : false;

        if ($openpay->save()) {
            return back()->with('success', 'Las credenciales se agregaron con éxito.');
        } else {
            return back()->with('error', message('error'));
        }
    }
}
