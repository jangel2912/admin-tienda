<?php

namespace App\Http\Controllers\User\PaymentMethod;

use App\Models\Shop\PaymentMethod\EPayco;
use App\Modules\Facades\PaymentMethod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EPaycoController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $epayco = EPayco::first();

        return view('admin.settings.payments.epayco', compact('epayco'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'client_id' => 'required|alpha_num|max:100',
            'public_key' => 'required|alpha_num|max:100',
            'private_key' => 'required|alpha_num|max:100',
        ]);

        $epayco = EPayco::first();
        if (is_null($epayco)) {
            $epayco = new EPayco;
        }

        $epayco->client_id = $request->client_id;
        $epayco->public_key = $request->public_key;
        $epayco->private_key = $request->private_key;

        if (!is_null($request->active)) {
            PaymentMethod::disablePayment();
        }

        $epayco->active = (!is_null($request->active)) ? true : false;

        if ($epayco->save()) {
            return back()->with('success', 'Las credenciales se agregaron con éxito.');
        } else {
            return back()->with('error', message('error'));
        }
    }
}
