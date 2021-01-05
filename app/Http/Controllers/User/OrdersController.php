<?php

namespace App\Http\Controllers\User;

use App\Exports\OnlineSalesExport;
use App\Http\Controllers\Controller;
use App\Models\Shop\OnlineSale;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use DateTime;

class OrdersController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $initialDate =  $request->input('initial_date');
        $finalDate =  $request->input('final_date');

        if (($initialDate && $initialDate !== '') || ($finalDate && $finalDate !== '')) {
            $initialDate = new DateTime($initialDate);
            $initialDate = $initialDate->format('Y-m-d H:i:s');
            $finalDate = new DateTime($finalDate);
            $finalDate = $finalDate->format('Y-m-d H:i:s');
            $orders = OnlineSale::whereBetween('fecha', [$initialDate, $finalDate])
            ->paginate(30);
        } else {
            $orders = OnlineSale::orderByDesc('id')->paginate(5);
        }
    	return view('admin.orders', compact('orders'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function detailsSale(int $id)
    {
    	$order = OnlineSale::with(['onlineVentaProd', 'onlineVentaProd.onlineVentaAditions.adition.aditional', 'onlineVentaProd.onlineVentaModifications.modification','clients', 'clients.coupon', 'schedule'])->find($id);

    	return response()->json($order);
    }

    public function download(Request $request)
    {
        $initialDate =  $request->input('initial_date');
        $finalDate =  $request->input('final_date');

        return Excel::download(new OnlineSalesExport($initialDate, $finalDate), 'VentasOnline.xlsx');
    }
}
