<?php

namespace App\Http\Controllers\User;

use App\Exports\CustomersExport;
use App\Http\Controllers\Controller;
use App\Models\Shop\Customer;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CustomersController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
    	$customers = Customer::where('onlineTienda', true)->paginate(8);
    	return view('admin.customer', compact('customers'));
    }

    public function download()
    {
        return Excel::download(new CustomersExport, 'Clientes.xlsx');
    }
}
