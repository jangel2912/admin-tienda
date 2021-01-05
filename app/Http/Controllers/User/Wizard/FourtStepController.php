<?php

namespace App\Http\Controllers\User\Wizard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FourtStepController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.wizard.fourthstep');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        auth_user()->dbConfig->shop->wizard = 0;
        auth_user()->dbConfig->shop->activo = 1;

        if (auth_user()->dbConfig->shop->save()) {
            return redirect()->route('admin.dashboard');
        } else {
            return back()->with('error', message('error'));
        }
    }
}
