<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\Promotion\CreateRequest;
use App\Models\Shop\Promotion\Description;
use App\Models\Shop\Promotion\Product;
use App\Http\Resources\Product as ProductResource;
use App\Models\Shop\Promotion\Promotion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $promotions = Promotion::where('shop', true)->get()->reverse();

        return view('admin.promotions.index', compact('promotions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $promotion = Promotion::where([
            'activo' => true,
            'shop' => true
        ])->first();

        return view('admin.promotions.create', compact('promotion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $days = collect(explode(",", $request->days));
        $promotion = new Promotion;
        $promotion->name = $request->name;
        $promotion->initial_date = $request->initial_date;
        $promotion->final_date = $request->final_date;
        $promotion->initial_time = $request->initial_time;
        $promotion->final_time = $request->final_time;
        $promotion->days = $days;
        $promotion->active = true;

        if ($promotion->save()) {
            foreach ($request->qty as $key => $qty) {
                $description = new Description;
                $description->promotion = $promotion;
                $description->rule_index = $key;
                $description->qty = $qty;
                $description->discount = $request->percent[$key];
                $description->save();
            }

            $products = explode(",", $request->products);
            foreach ($products as $product) {
                $productPromotionModel = new Product;
                $productPromotionModel->id_promocion = $promotion->id;
                $productPromotionModel->id_producto = $product;
                $productPromotionModel->save();
            }

            return redirect()->route('admin.promotions.index')->with('success', 'La promoción se ha creado con éxito.');
        }
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
        $promotion = Promotion::find($id);
        // var_dump($promotion->days); die;

        return view('admin.promotions.edit',  compact('promotion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $promotion = Promotion::find($id);

        if (!is_null($promotion)) {
            $days = collect(explode(",", $request->days));
            $promotion->name = $request->name;
            $promotion->initial_date = $request->initial_date;
            $promotion->final_date = $request->final_date;
            $promotion->initial_time = $request->initial_time;
            $promotion->final_time = $request->final_time;
            $promotion->days = $days;

            if ($promotion->save()) {
                $promotion->products()->delete();
                $promotion->descriptions()->delete();

                foreach ($request->qty as $key => $qty) {
                    $description = new Description;
                    $description->promotion = $promotion;
                    $description->rule_index = $key;
                    $description->qty = $qty;
                    $description->discount = $request->percent[$key];
                    $description->save();
                }

                $products = explode(",", $request->products);

                foreach ($products as $product) {
                    $productPromotionModel = new Product;
                    $productPromotionModel->id_promocion = $promotion->id;
                    $productPromotionModel->id_producto = $product;
                    $productPromotionModel->save();
                }

                return redirect()->route('admin.promotions.index')->with('success', 'La promoción se ha editado con éxito.');
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
        //
    }

    /**
     * @param Promotion $promotion
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activate($id)
    {
        $promotion = Promotion::find($id);

        if (!is_null($promotion)) {
            Promotion::where([
                'activo' => true,
                'shop' => true
            ])->update(['activo' => false]);

            $promotion->activo = true;

            if ($promotion->save()) {
                return redirect()->route('admin.promotions.index')->with('success', 'La promoción se ha activado exitosamente.');
            }
        }

        return back()->with('danger', 'Ha ocurrido un error, por favor, intentelo de nuevo o comuniquese con el administrador del sistema.');
    }

    /**
     * @param Promotion $promotion
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deactivate($id)
    {
        $promotion = Promotion::find($id);

        if (!is_null($promotion)) {
            $promotion->activo = false;

            if ($promotion->save()) {
                return redirect()->route('admin.promotions.index')->with('success', 'La promoción se ha desactivado exitosamente.');
            }
        }

        return back()->with('danger', 'Ha ocurrido un error, por favor, intentelo de nuevo o comuniquese con el administrador del sistema.');
    }

    /**
     * @param Promotion $promotion
     * @return \Illuminate\Http\ProductResource
     */
    public function ajaxGetProducts($id)
    {
        $promotion = Promotion::find($id);

        if (!is_null($promotion)) {
            return ProductResource::collection($promotion->products);
        }

        return response()->json([]);
    }

    /**
     * @param Promotion $promotion
     * @return \Illuminate\Http\ProductResource
     */
    public function ajaxGetDescriptions($id)
    {
        $promotion = Promotion::find($id);

        if (!is_null($promotion)) {
            return $promotion->descriptions;
        }

        return response()->json([]);
    }
}
