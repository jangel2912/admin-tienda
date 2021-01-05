<?php

namespace App\Http\Controllers\User\PaymentMethod;

use App\Models\Shop\PaymentMethod\Cash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CashController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $cash = Cash::first();

        return view('admin.settings.payments.cash', compact('cash'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $cash = Cash::first();
        if (is_null($cash)) {
            $cash = new Cash;
        }

        $cash->active = (!is_null($request->active)) ? true : false;

        if ($cash->save()) {
            return back()->with('success', 'La forma de pago "efectivo" se modificó con éxito.');
        } else {
            return back()->with('error', message('error'));
        }
    }
}
