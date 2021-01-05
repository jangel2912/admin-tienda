<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Shop\OnlineSale;
use App\Models\Shop\OnlineSaleProd;
use App\Models\Shop\SaleGoal;
use App\Models\Shop\Visit;
use App\Models\Vendty\Business;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        validate_shipping();

        $nit = null;
    	$quantity = $this->soldItems();
        $sales = $this->sales();
        $orders = $this->orders();
        $goal = SaleGoal::first();
        $total = OnlineSale::where('fecha', date('Y-d-m'))->sum('sub_total');
        $goal = (!is_null($goal) && $goal->monto > 0) ? ($total / $goal->monto) * 100 : 0;
        $business = Business::where('id_db_config', auth_user()->db_config_id)->first();
        $visits = Visit::where('created_at', '>=', Carbon::now()
            ->subHours(12)
            ->format('Y-m-d H:i:s'))
            ->get()
            ->count();

        if (!is_null($business)) {
            $nit = $business->identificacion_empresa;
        }

    	return view('admin.dashboard', compact('quantity', 'goal', 'sales', 'orders', 'visits', 'nit'));
    }

    /**
     * @return array
     */
    public function chart()
    {
    	$sales = OnlineSale::where('fecha', '<=', date('Y-d-m'))->get();

        $amounts = collect([]);
        $dates = collect([]);
    	$data = $sales->map(function($row) use ($amounts, $dates) {
    		$amounts->push($row->sub_total);
            $dates->push($row->fecha->format('d/m'));
    	});

    	return [
            'amounts' => $amounts,
            'dates' => $dates
        ];
    }

    /**
     * @return mixed
     */
    private function soldItems()
    {
    	$start = date('Y-m-d 00:00:00');
    	$end = date('Y-m-d 23:59:59');

    	return OnlineSaleProd::whereBetween('created_at', [$start, $end])->get()->sum('cantidad');
    }

    /**
     * @return mixed
     */
    private function sales()
    {
        $start = date('Y-m-d 00:00:00');
        $end = date('Y-m-d 23:59:59');

        return OnlineSale::whereEstado(1)
            ->whereBetween('fecha', [$start, $end])
            ->get()
            ->count();
    }

    /**
     * @return mixed
     */
    private function orders()
    {
        return OnlineSale::where('estado', '<>', 1)
            ->get()
            ->count();
    }

    /**
     * @return mixed
     */
    public function updateData(Request $request)
    {
        $this->validate($request, [
            'nit' => 'required|numeric|digits_between:6,12',
        ]);

        $business = Business::where('id_db_config', auth_user()->db_config_id)->first();

        if (!is_null($business)) {
            $business->identificacion_empresa = $request->nit;
            $business->save();
        }

        return redirect()->route('admin.dashboard')->with('success', "Información de la empresa actualizada.");
    }
}
