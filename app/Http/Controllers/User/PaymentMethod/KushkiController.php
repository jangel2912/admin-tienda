<?php

namespace App\Http\Controllers\User\PaymentMethod;

use App\Models\Shop\PaymentMethod\Kushki;
use App\Modules\Facades\PaymentMethod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KushkiController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $kushki = Kushki::first();

        return view('admin.settings.payments.kushki', compact('kushki'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'merchant_public_id' => 'required|alpha_dash|max:100',
            'merchant_private_id' => 'required|alpha_dash|max:100',
        ]);

        $kushki = Kushki::first();
        if (is_null($kushki)) {
            $kushki = new Kushki();
        }

        $kushki->merchant_public_id = $request->merchant_public_id;
        $kushki->merchant_private_id = $request->merchant_private_id;

        if (!is_null($request->active)) {
            PaymentMethod::disablePayment();
        }

        $kushki->active = (!is_null($request->active)) ? true : false;
        $kushki->kushki_environment = (!is_null($request->kushki_environment)) ? true : false;

        if ($kushki->save()) {
            return back()->with('success', 'Las credenciales se agregaron con éxito.');
        } else {
            return back()->with('error', message('error'));
        }
    }
}
