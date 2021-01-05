<?php

namespace App\Http\Controllers\User\PaymentMethod;

use App\Models\Shop\PaymentMethod\Wompi;
use App\Modules\Facades\PaymentMethod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WompiController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $wompi = Wompi::first();

        return view('admin.settings.payments.wompi', compact('wompi'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'public_key' => 'required|alpha_dash|max:100',
            'private_key' => 'required|alpha_dash|max:100',
        ]);

        $wompi = Wompi::first();

        if (is_null($wompi)) {
            $wompi = new Wompi;
        }

        $wompi->public_key = $request->public_key;
        $wompi->private_key = $request->private_key;

        if (!is_null($request->active)) {
            PaymentMethod::disablePayment();
        }

        $wompi->active = (!is_null($request->active)) ? true : false;

        if ($wompi->save()) {
            return back()->with('success', 'Las credenciales se agregaron con éxito.');
        } else {
            return back()->with('error', message('error'));
        }
    }
}
