<?php

namespace App\Http\Controllers\User\Wizard;

use App\Database\Tables;
use App\Http\Requests\Wizard\SetFirstStepRequest;
use App\Models\Shop\Category;
use App\Models\Shop\Warehouse;
use App\Models\Vendty\Shop;
use App\Http\Controllers\Controller;
use App\Repositories\Shop\Option;

class FirstStepController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        if (Category::count() == 0) {
            $category = new Category;
            $category->nombre = "General";
            $category->save();
        }

        $warehouses = Warehouse::where('bodega', false)->get();
        $countries = collect(include resource_path('countries/all.php'));
        $currencies = collect(include resource_path('currencies/all.php'));
        $shop = Shop::where('id_db', auth_user()->db_config_id)->first();

        return view('admin.wizard.firststep', compact('shop', 'countries', 'currencies', 'warehouses'));
    }

    /**
     * @param SetFirstStepRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SetFirstStepRequest $request)
    {
        $dominio_local = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $request->dominio_local));
        $shop = Shop::where('id_db', auth_user()->db_config_id)->first();

        if (is_null($shop)) {
            $shop = new Shop;
            $shop->id_user = auth_user()->id;
            $shop->id_db = auth_user()->db_config_id;
            $shop->description = 'Tienda';
        }

        $shop->id_almacen = $request->warehouse;
        $shop->dominio_local = $dominio_local;
        $shop->shopname = $request->shopname;

        if ($shop->save()) {
            $option = new Option;
            $option->set('tipo_moneda', $request->currency);
            $option->set('moneda_empresa', $request->currency);
            auth_user()->pais = $request->country;
            auth_user()->save();

            return redirect()->route('admin.wizard.secondstep.create');
        } else {
            return back()->with('error', message('error'));
        }
    }
}
