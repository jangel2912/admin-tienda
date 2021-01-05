<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\Coupons\CreateRequest;
use App\Http\Resources\Product as ProductResource;
use App\Models\Shop\Coupon\Coupon;
use App\Models\Shop\Coupon\CouponProduct;
use App\Models\Shop\Coupon\CategoryCoupon;
use App\Models\Shop\Product;
use App\Models\Shop\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $coupons = Coupon::get()->reverse();
        return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $coupon = new Coupon();
        $coupon->importe = 0;
        $coupon->gasto_minimo = 0;
        $coupon->gasto_maximo = 0;
        $coupon->limites_uso = 0;
        $coupon->limites_uso_usuario = 0;
        $coupon->incluir_productos = 0;
        $coupon->incluir_categorias = 0;
        $products = Product::where(['tienda' => true])->groupBy(\DB::raw('ifnull(referencia_id,nombre)'))->orderBy('nombre', 'asc')->get();
        $categories = Category::where([['tienda', true], ['activo', true]])->get();

        return view('admin.coupons.create', compact('coupon', 'products', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateRequest $request)
    {
        $cupon = new Coupon();
        $cupon->nombre = $request->nombre;
        $cupon->descripcion = $request->descripcion;
        $cupon->tipo = $request->tipo;
        $cupon->importe = $request->importe;
        $cupon->gasto_minimo = $request->gasto_minimo;
        $cupon->gasto_maximo = $request->gasto_maximo;
        $cupon->fecha_caducidad = $request->fecha_caducidad;
        $cupon->correos_electronicos = $request->correos_electronicos;
        $cupon->limites_uso = $request->limites_uso;
        $cupon->limites_uso_usuario = $request->limites_uso_usuario;
        $cupon->uso_individual = (!is_null($request->uso_individual)) ? true : false;
        $cupon->incluir_productos = (!is_null($request->incluir_productos)) ? true : false;
        $cupon->incluir_categorias = (!is_null($request->incluir_categorias)) ? true : false;

        if($cupon->save()){
            //Save include products
            if(isset($request->productos) && !empty($request->productos) && (!is_null($request->incluir_productos))){
                foreach ($request->productos as $producto) {
                    $couponProduct = new CouponProduct();
                    $couponProduct->producto_id = $producto;
                    $couponProduct->cupon_id = $cupon->id;
                    $couponProduct->tipo = "incluido";
                    $couponProduct->save();
                }
            }

            //Save exclude products
            if(isset($request->productos_excluidos) && !empty($request->productos_excluidos)){
                foreach ($request->productos_excluidos as $producto) {
                    $couponProduct = new CouponProduct();
                    $couponProduct->producto_id = $producto;
                    $couponProduct->cupon_id = $cupon->id;
                    $couponProduct->tipo = "no_incluido";
                    $couponProduct->save();
                }
            }

            //Save include categories
            if(isset($request->categorias) && !empty($request->categorias) && (!is_null($request->incluir_categorias))){
                foreach ($request->categorias as $categoria) {
                    $categoryCoupon = new CategoryCoupon();
                    $categoryCoupon->categoria_id = $categoria;
                    $categoryCoupon->cupon_id = $cupon->id;
                    $categoryCoupon->tipo = "incluido";
                    $categoryCoupon->save();
                }
            }

            //Save exclude categories
            if(isset($request->categorias_excluidas) && !empty($request->categorias_excluidas)){
                foreach ($request->categorias_excluidas as $categoria) {
                    $categoryCoupon = new CategoryCoupon();
                    $categoryCoupon->categoria_id = $categoria;
                    $categoryCoupon->cupon_id = $cupon->id;
                    $categoryCoupon->tipo = "no_incluido";
                    $categoryCoupon->save();
                }
            }

            return redirect()->route('admin.coupons.index')->with('success', 'El cupón se agregó con éxito.');
        }

        return back()->with('danger', 'Ha ocurrido un error.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, int $promotion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coupon = Coupon::find($id);
        $products = Product::where(['tienda' => true])->groupBy(\DB::raw('ifnull(referencia_id,nombre)'))->orderBy('nombre', 'asc')->get();
        $categories = Category::where([['tienda', true], ['activo', true]])->get();
        
        return view('admin.coupons.edit',  compact('coupon', 'products', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateRequest $request, $id)
    {
        $cupon = Coupon::find($id);

        if (!is_null($cupon)) {
            $cupon->nombre = $request->nombre;
            $cupon->descripcion = $request->descripcion;
            $cupon->tipo = $request->tipo;
            $cupon->importe = $request->importe;
            $cupon->gasto_minimo = $request->gasto_minimo;
            $cupon->gasto_maximo = $request->gasto_maximo;
            $cupon->fecha_caducidad = $request->fecha_caducidad;
            $cupon->correos_electronicos = $request->correos_electronicos;
            $cupon->limites_uso = $request->limites_uso;
            $cupon->limites_uso_usuario = $request->limites_uso_usuario;
            $cupon->uso_individual = (!is_null($request->uso_individual)) ? true : false;
            $cupon->incluir_productos = (!is_null($request->incluir_productos)) ? true : false;
            $cupon->incluir_categorias = (!is_null($request->incluir_categorias)) ? true : false;

            if($cupon->save()){
                $cupon->products()->delete();
                if(isset($request->productos) && !empty($request->productos)){
                    foreach ($request->productos as $producto) {
                        $couponProduct = new CouponProduct();
                        $couponProduct->producto_id = $producto;
                        $couponProduct->cupon_id = $cupon->id;
                        $couponProduct->tipo = "incluido";
                        $couponProduct->save();
                    }
                }
    
                //Save exclude products
                if(isset($request->productos_excluidos) && !empty($request->productos_excluidos)){
                    foreach ($request->productos_excluidos as $producto) {
                        $couponProduct = new CouponProduct();
                        $couponProduct->producto_id = $producto;
                        $couponProduct->cupon_id = $cupon->id;
                        $couponProduct->tipo = "no_incluido";
                        $couponProduct->save();
                    }
                }
    
                $cupon->categories()->delete();
                //Save include categories
                if(isset($request->categorias) && !empty($request->categorias)){
                    foreach ($request->categorias as $categoria) {
                        $categoryCoupon = new CategoryCoupon();
                        $categoryCoupon->categoria_id = $categoria;
                        $categoryCoupon->cupon_id = $cupon->id;
                        $categoryCoupon->tipo = "incluido";
                        $categoryCoupon->save();
                    }
                }
    
                //Save exclude categories
                if(isset($request->categorias_excluidas) && !empty($request->categorias_excluidas)){
                    foreach ($request->categorias_excluidas as $categoria) {
                        $categoryCoupon = new CategoryCoupon();
                        $categoryCoupon->categoria_id = $categoria;
                        $categoryCoupon->cupon_id = $cupon->id;
                        $categoryCoupon->tipo = "no_incluido";
                        $categoryCoupon->save();
                    }
                }
                
                return redirect()->route('admin.coupons.index')->with('success', 'El cupón se ha editado con éxito.');
            }

        }

        return back()->with('danger', 'Ha ocurrido un error.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coupon = Coupon::where(["id" => $id])->first();
        if(!is_null($coupon)){
            //TODO: Here validate is coupon was used in Sales con cancel de delete
            //return back()->withErrors(['El cupón ' . $coupon->nombre . ' no se puede eliminar porque tiene pedidos asociados.']);

            $coupon->delete();
            return redirect()->route('admin.coupons.index')->with('success', "El cupón {$coupon->nombre} se eliminó con éxito.");
        }
        return redirect()->route('admin.coupons.index')->with('danger', 'Ha ocurrido un error.');
    }
}
