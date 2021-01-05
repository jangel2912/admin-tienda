<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Imports\ShippingByDestinationImport;
use App\Models\Shop\Shipping\ByDestination;
use App\Models\Shop\Shipping\FreeFrom;
use App\Models\Shop\Shipping\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $shipping = Shipping::all();
        $shippingAllBy = $shipping[1]->nombre == 'envios_todos_por' ? $shipping[1] : null;
        $shippingFreeFrom = FreeFrom::first();
        $shippingByDestination = ByDestination::all();

        return view('admin.settings.shipping', compact('shipping', 'shippingAllBy', 'shippingFreeFrom', 'shippingByDestination'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $shipping
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'shipping' => 'required|numeric|min:1|max:4',
            'valorAllBy' => 'nullable|required_if:shipping,2|numeric|min:0|digits_between:1,10',
            'valorFreeFrom' => 'nullable|required_if:shipping,3|numeric|min:0|digits_between:1,10',
            'minimoFreeFrom' => 'nullable|required_if:shipping,3|numeric|min:0|digits_between:1,10',
        ]);

        $shipping = Shipping::findOrFail($request->shipping);
        $shippingFreeFrom = FreeFrom::first();

        if (is_null($shippingFreeFrom)) {
            $shippingFreeFrom = new FreeFrom;
        }

        $shippingFreeFrom->valor = is_null($request->valorFreeFrom) ? 0 : $request->valorFreeFrom;
        $shippingFreeFrom->minimo = is_null($request->minimoFreeFrom) ? 0 : $request->minimoFreeFrom;
        $shippingFreeFrom->save();

        if ($shipping->id == 4 && ByDestination::count() <= 0) {
            return back()->withErrors([
                'byDestination' => 'Debe cargar al menos un origen y un destino en la configuración "Cobrar por Destinos"',
            ])->withInput();
        }

        if ($shipping->id !== 2) {
            $shippingAllBy = Shipping::find(2);
        } else {
            $shippingAllBy = $shipping;
        }

        $shippingAllBy->valor = is_null($request->valorAllBy) ? 0 : $request->valorAllBy;
        $shippingAllBy->save();
        $active = Shipping::where('activo', true);


        if ($active->update(['activo' => false])) {
            $shipping->activo = true;

            if ($shipping->save()) {
                return back()->with('success', 'Cobro por envíos actualizado correctamente');
            }
        }

        return back()->with('error', message('error'));
    }

    /**
     * Delete all destinations.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $shipping
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
            try {
                ByDestination::truncate();

                return back()->with('success', 'Los destinos se borraron con éxito.');
            } catch (Exception $e) {
                //
            }

            return back()->with('error', message('error'));
    }

    public function setShippingByDestination(Request $request)
    {
        if ($request->hasFile('excel')) {
            try {
                ByDestination::truncate();
                Excel::import(new ShippingByDestinationImport, $request->file('excel'));

                return back()->with('success', 'Los destinos se cargaron con éxito.');
            } catch (Exception $e) {
                //
            }
        }

        return back()->with('error', message('error'));
    }

    public function download()
    {
        return response()->download(storage_path('ciudades.xlsx'));
    }
}
