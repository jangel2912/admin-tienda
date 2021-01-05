<?php

namespace App\Http\Controllers\User\Wizard;

use App\Http\Controllers\Controller;
use App\Models\Shop\PaymentMethod\EPayco;
use App\Models\Shop\PaymentMethod\MercadoPago;
use App\Models\Shop\PaymentMethod\OpenPay;
use App\Models\Shop\PaymentMethod\PayPal;
use App\Models\Shop\PaymentMethod\PayU;
use App\Models\Shop\PaymentMethod\Wompi;
use App\Models\Vendty\Licence;
use Illuminate\Http\Request;

class ThirdStepController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $shop = auth_user()->dbConfig->shop;

        return view('admin.wizard.thirdstep', compact('shop'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'seo_description' => 'nullable|string|max:250',
        ]);

        $shop = auth_user()->dbConfig->shop;
        $shop->seo_description = $request->seo_description;

        if ($shop->save()) {
            return redirect()->route('admin.wizard.fourthstep.create');
        } else {
            return back()->with('error', message('error'));
        }
    }
}
