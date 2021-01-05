<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\Product\CreateRequest;
use App\Http\Requests\Product\CreateWithAttributesRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Http\Requests\Product\UpdateWithAttributesRequest;
use App\Http\Resources\Product as ProductResource;
use App\Imports\ProductsImport;
use App\Imports\ProductsWithAttributesImport;
use App\Models\Shop\Category;
use App\Models\Shop\Product;
use App\Models\Shop\Product\Attribute;
use App\Models\Shop\Product\Detail;
use App\Models\Shop\Product\DetailProduct;
use App\Models\Shop\Product\Reference;
use App\Models\Shop\Stock\Current;
use App\Models\Shop\Tax;
use App\Models\Shop\Warehouse;
use App\Modules\InventoryMovement;
use App\Repositories\Temp\ProductsImport as ProductsImportRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search =  $request->input('search_text');

        if ($search && $search !== ''){
            $products = Product::where('nombre', 'like', '%' . $search . '%')
                ->with(['currentStock', 'category'])
                    ->groupBy(\DB::raw('ifnull(referencia_id,CONCAT(nombre,\'_\',codigo))'))
                        ->paginate(5)
                            ->appends(Input::except('page'));;
        } else {
            $products =
                Product::with(['currentStock', 'category'])
                    ->groupBy(\DB::raw('ifnull(referencia_id,CONCAT(nombre,\'_\',codigo))'))
                        ->paginate(5);
        }

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::where([['tienda', true], ['activo', true]])->get();
        $taxes = Tax::all();

        return view('admin.products.create', compact('categories', 'taxes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createWithAttributes()
    {
        $categories = Category::where([['tienda', true], ['activo', true]])->get();

        return view('admin.products.create-with-attributes', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateRequest $request)
    {
        $product = new Product;
        $product->code = $request->code;
        $product->name = $request->name;
        $product->impuesto = $request->tax;
        $product->category = $request->category;
        $product->description = $request->description;
        $product->long_description = $request->long_description;
        $product->featured = (!is_null($request->featured)) ? true : false;
        $product->sell_in_negative = (!is_null($request->sell_without_stock)) ? true : false;
        $product->show_stock = (!is_null($request->show_stock)) ? true : false;
        $product->buy_price = $request->buy_price;
        $product->sale_price = $request->sale_price;

        if ($product->save()) {
            for ($i = 0; $i <= 5; $i++) {
                $image = $i > 0 ? 'imagen' . $i : 'imagen';

                if ($request->file($image) != null) {
                    $product_name = sanitize_file_name ($product->id . ' ' . $product->name . ' ' . $image);

                    if ($request->file($image)->storeAs(auth_user()->dbConfig->base_dato . '/imagenes_productos', $product_name . '.' . $request->file($image)->extension(), 'uploads')) {
                        $product->$image = $product_name . '.' . $request->file($image)->extension();
                    }

                    $storage = Storage::disk('s3')->put(
                        auth_user()->dbConfig->base_dato . '/imagenes_productos/'.$product->$image,
                        file_get_contents($request->file($image)->getRealPath())
                    );
                }
            }

            if ($product->save()) {
                $warehouses = Warehouse::all();
                $current_warehouse = auth_user()->shop->id_almacen;

                foreach ($warehouses as $warehouse) {
                    $quantity = $warehouse->id === $current_warehouse ? $request->quantity : 0;
                    $curret_stock = new Current;
                    $curret_stock->set_warehouse = $warehouse->id;
                    $curret_stock->set_product = $product->id;
                    $curret_stock->set_quantity = $quantity;
                    $curret_stock->save();
                }

                if ($request->quantity > 0) {
                    $products = collect();
                    $products->push([
                        'id' => $product->id,
                        'name' => $product->name,
                        'buy_price' => $product->buy_price,
                        'sale_price' => $product->sale_price,
                        'quantity' => $request->quantity,
                        'subtotal' => $product->buy_price * $request->quantity,
                    ]);
                    $movement = new InventoryMovement($products);
                    $inventory = $movement->new($current_warehouse);
                    $result = $movement->addItems($inventory);
                }

                return redirect()->route('admin.products.index')->with('success', 'El producto se agrego con éxito.');
            }
        }

        return back()->with('danger', 'Ha ocurrido un error.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateWithAttributesRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeWithAttributes(CreateWithAttributesRequest $request)
    {
        $products = $request->input('products');

        if (!is_null($products) && !empty($products)) {
            $reference = new Reference;
            $reference->nombre = $request->name;
            $reference->descripcion = $request->description;
            $reference->descripcion_larga = $request->long_description;

            if ($reference->save()) {
                $attributes = $request->input('attributes');
                $buy_prices = $request->input('buy_prices');
                $codes = $request->input('codes');
                $details = $request->input('details');
                $quantities = $request->input('quantities');
                $sale_prices = $request->input('sale_prices');
                $storedDetails = [];

                for ($i = 0; $i <= 5; $i++) {
                    $image = $i > 0 ? 'imagen' . $i : 'imagen';

                    if ($request->file($image) != null) {
                        $reference_name = sanitize_file_name ($reference->id . ' ' . $reference->nombre . ' ' . $image);

                        if ($request->file($image)->storeAs(auth_user()->dbConfig->base_dato . '/imagenes_productos', $reference_name . '.' . $request->file($image)->extension(), 'uploads')) {
                            $reference->$image = $reference_name . '.' . $request->file($image)->extension();
                        }
                    }
                }

                $reference->save();

                foreach ($attributes as $key => $value) {
                    if (array_key_exists($key, $details) && !is_null($details[$key])) {
                        $attribute = new Attribute;
                        $attribute->nombre_atributo = mb_strtoupper($value, 'UTF-8');
                        $attribute->producto_referencia_id = $reference->id;

                        if ($attribute->save()) {
                            foreach (explode(',', $details[$key]) as $value) {
                                $detail = new Detail;
                                $detail->nombre_detalle = mb_strtoupper($value, 'UTF-8');
                                $detail->producto_referencia_atributo_id = $attribute->id;
                                if ($detail->save()) {
                                    $storedDetails[$detail->nombre_detalle] = $detail->id;
                                }
                            }
                        }
                    }
                }

                $first = true;
                $tax = Tax::find($request->tax);

                if (is_null($tax)) {
                    $tax = Tax::where([
                        'porciento' => 0,
                    ])->first();

                    if (is_null($tax)) {
                        $tax = new Tax;
                        $tax->nombre_impuesto = 'IVA (0%)';
                        $tax->porciento = 0;
                        $tax->save();
                    }
                }

                foreach ($products as $key => $value) {
                    $productDetails = explode('/', mb_strtoupper($value, 'UTF-8'));
                    $findDetails = true;
                    $idDetails = [];

                    foreach ($productDetails as $detail) {
                        if (array_key_exists($detail, $storedDetails)) {
                            array_push($idDetails, $storedDetails[$detail]);
                        } else {
                            $findDetails = false;
                        }
                    }

                    if ($findDetails && count($idDetails) > 0) {
                        $featured = ($first && !is_null($request->featured)) ? true : false;
                        $code = array_key_exists($key, $codes) ? $codes[$key] : null;
                        $quantity = array_key_exists($key, $quantities) && !is_null($quantities[$key]) ? $quantities[$key] : 0;
                        $buy_price = array_key_exists($key, $buy_prices) && !is_null($buy_prices[$key]) ? $buy_prices[$key] : 0;
                        $sale_price = array_key_exists($key, $sale_prices) && !is_null($sale_prices[$key]) ? $sale_prices[$key] : 0;
                        $product = new Product;
                        $product->code = $code;
                        $product->name = $reference->nombre . '/' . mb_strtoupper($value, 'UTF-8');
                        $product->category = $request->category;
                        $product->description = $request->description;
                        $product->long_description = $request->long_description;
                        $product->impuesto = $tax->id_impuesto;
                        $product->featured = $featured;
                        $product->sell_in_negative = (!is_null($request->sell_without_stock)) ? true : false;
                        $product->show_stock = (!is_null($request->show_stock)) ? true : false;
                        $product->buy_price = $buy_price;                        $product->sale_price = $sale_price;
                        $product->referencia_id = $reference->id;

                        if ($product->save()) {
                            $warehouses = Warehouse::all();
                            $current_warehouse = auth_user()->shop->id_almacen;

                            foreach ($warehouses as $warehouse) {
                                $warehouse_quantity = $warehouse->id === $current_warehouse ? $quantity : 0;
                                $curret_stock = new Current;
                                $curret_stock->set_warehouse = $warehouse->id;
                                $curret_stock->set_product = $product->id;
                                $curret_stock->set_quantity = $warehouse_quantity;
                                $curret_stock->save();
                            }

                            if ($quantity > 0) {
                                $productCollection = collect();
                                $productCollection->push([
                                    'id' => $product->id,
                                    'name' => $product->name,
                                    'buy_price' => $product->buy_price,
                                    'sale_price' => $product->sale_price,
                                    'quantity' => $quantity,
                                    'subtotal' => $product->buy_price * $quantity,
                                ]);
                                $movement = new InventoryMovement($productCollection);
                                $inventory = $movement->new($current_warehouse);
                                $result = $movement->addItems($inventory);
                            }

                            $first = false;
                            $detailProduct = new DetailProduct;
                            $detailProduct->producto_id = $product->id;

                            for ($i = 0; $i < count($idDetails); $i++) {
                                if ($i < 10) {
                                    $detailId = 'producto_referencia_atributo_detalle' . ($i + 1) . '_id';
                                    $detailProduct->$detailId = $idDetails[$i];
                                }
                            }

                            $detailProduct->save();
                        }
                    }
                }

                return redirect()->route('admin.products.index')->with('success', 'El producto se agrego con éxito.');
            }
        }

        return back()->with('danger', 'Ha ocurrido un error.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shop\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {
        $product = Product::find($product);

        if (!is_null($product)) {
            $product->tienda = false;

            if ($product->save()) {
                return redirect()->route('admin.products.index')->with('success', 'El producto se ha retirado con exito.');
            }
        }

        return redirect()->route('admin.products.index')->with('danger', 'Ha ocurrido un error retirando el producto.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $product)
    {
        $categories = Category::all();
        $product = Product::findOrFail($product);
        $taxes = Tax::all();

        return view('admin.products.edit', compact('categories', 'product', 'taxes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editWithAttributes(int $product)
    {
        $product = Product::findOrFail($product);
        $tax = Tax::find($product->impuesto);

        if (is_null($tax)) {
            $tax = Tax::where([
                'porciento' => 0,
            ])->first();

            if (is_null($tax)) {
                $tax = new Tax;
                $tax->nombre_impuesto = 'IVA (0%)';
                $tax->porciento = 0;
                $tax->save();
            }
        }

        return view('admin.products.edit-with-attributes', compact('product', 'tax'));
    }

    /**
     * @param int $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, int $product)
    {

        if (is_null($request->reference)) {
            $product = Product::find($product);
            $product->code = $request->code;
            $product->name = $request->name;
            $product->impuesto = $request->tax;
            $product->category = $request->category;
            $product->description = $request->description;
            $product->long_description = $request->long_description;
            $product->featured = (!is_null($request->featured)) ? true : false;
            $product->sell_in_negative = (!is_null($request->sell_without_stock)) ? true : false;
            $product->show_stock = (!is_null($request->show_stock)) ? true : false;
            $product->buy_price = $request->buy_price;
            $product->sale_price = $request->sale_price;

            if ($product->save()) {
                for ($i = 0; $i <= 5; $i++) {
                    $image = $i > 0 ? 'imagen' . $i : 'imagen';

                    if ($request->file($image) != null) {
                        $product_name = sanitize_file_name ($product->id . ' ' . $product->name . ' ' . $image);

                        if ($product->$image) {
                            $routeProduct = 'public/uploads/' . auth_user()->dbConfig->base_dato . '/imagenes_productos/' . $product->$image;
                            Storage::delete($routeProduct);
                        }

                        if ($request->file($image)->storeAs(auth_user()->dbConfig->base_dato . '/imagenes_productos', $product_name . '.' . $request->file($image)->extension(), 'uploads')) {
                            $product->$image = $product_name . '.' . $request->file($image)->extension();
                        }

                        $storage = Storage::disk('s3')->put(
                            auth_user()->dbConfig->base_dato . '/imagenes_productos/'.$product->$image,
                            file_get_contents($request->file($image)->getRealPath())
                        );
                    }
                }

                $product->save();
                $curret_stock = Current::where('producto_id', $product->id)->first();
                $warehouse = auth_user()->shop->id_almacen;

                if (is_null($curret_stock)) {
                    $curret_stock = new Current;
                    $curret_stock->set_warehouse = $warehouse;
                    $curret_stock->set_product = $product->id;
                }

                $curret_stock->set_quantity = $request->quantity;

                if ($curret_stock->save()) {
                    $products = collect();
                    $products->push([
                        'id' => $product->id,
                        'name' => $product->name,
                        'buy_price' => $product->buy_price,
                        'sale_price' => $product->sale_price,
                        'quantity' => $request->quantity,
                        'subtotal' => $product->buy_price * $request->quantity,
                    ]);

                    $movement = new InventoryMovement($products);
                    $inventory = $movement->new($warehouse);
                    $result = $movement->addItems($inventory);

                    return redirect()->route('admin.products.index')->with('success', 'El producto se actualizó con éxito.');
                }
            }
        } else {
            $products = array_map('get_mb_strtolower_utf8', $request->input('products'));

            if (!is_null($products) && !empty($products)) {
                $reference = Reference::find($request->reference);
                $oldReferenceName = $reference->nombre;

                if (!is_null($reference)) {
                    $reference->nombre = $request->name;
                    $reference->descripcion = $request->description;
                    $reference->descripcion_larga = $request->long_description;
                    $reference->imagenes = !!$request->images;

                    if ($reference->save()) {
                        $attributes = array_map('get_mb_strtolower_utf8', $request->input('attributes'));
                        $buy_prices = $request->input('buy_prices');
                        $codes = $request->input('codes');
                        $details = $request->input('details');
                        $quantities = $request->input('quantities');
                        $sale_prices = $request->input('sale_prices');
                        $storedDetails = [];

                        for ($i = 0; $i <= 5; $i++) {
                            $image = $i > 0 ? 'imagen' . $i : 'imagen';

                            if ($request->file($image) != null) {
                                $reference_name = sanitize_file_name ($reference->id . ' ' . $reference->nombre . ' ' . $image);
                                if ($reference->$image) {
                                    $routeReference = 'public/uploads/' . auth_user()->dbConfig->base_dato . '/imagenes_productos/' . $reference->$image;
                                    Storage::delete($routeReference);
                                }

                                if ($request->file($image)->storeAs(auth_user()->dbConfig->base_dato . '/imagenes_productos', $reference_name . '.' . $request->file($image)->extension(), 'uploads')) {
                                    $reference->$image = $reference_name . '.' . $request->file($image)->extension();
                                }

                                $storage = Storage::disk('s3')->put(
                                    auth_user()->dbConfig->base_dato . '/imagenes_productos/'.$reference->$image,
                                    file_get_contents($request->file($image)->getRealPath())
                                );


                            }
                        }

                        $reference->save();

                        foreach ($reference->attributes as $attribute) {
                            $key = array_search(strtolower($attribute->nombre_atributo), $attributes);

                            if ($key !== FALSE && (!array_key_exists($key, $details) || is_null($details[$key]))) {
                                $attribute->delete();
                            }
                        }

                        foreach ($attributes as $key => $value) {
                            if (array_key_exists($key, $details) && !is_null($details[$key])) {
                                $attribute = Attribute::where([
                                    'nombre_atributo' => mb_strtoupper($value, 'UTF-8'),
                                    'producto_referencia_id' => $reference->id,
                                ])->first();

                                if (is_null($attribute)) {
                                    $attribute = new Attribute;
                                    $attribute->nombre_atributo = mb_strtoupper($value, 'UTF-8');
                                    $attribute->producto_referencia_id = $reference->id;
                                }

                                if ($attribute->save()) {
                                    $attribute_details = array_map('get_mb_strtolower_utf8', explode(',', $details[$key]));

                                    foreach ($attribute->details as $detail) {
                                        if (!in_array(mb_strtolower($detail->nombre_detalle, 'UTF-8'), $attribute_details)) {
                                            $detail->delete();
                                        }
                                    }

                                    foreach ($attribute_details as $value) {
                                        $detail = Detail::where([
                                            'nombre_detalle' => mb_strtoupper($value, 'UTF-8'),
                                            'producto_referencia_atributo_id' => $attribute->id,
                                        ])->first();

                                        if (is_null($detail)) {
                                            $detail = new Detail;
                                            $detail->nombre_detalle = mb_strtoupper($value, 'UTF-8');
                                            $detail->producto_referencia_atributo_id = $attribute->id;
                                        }

                                        if ($detail->save()) {
                                            $storedDetails[mb_strtoupper($detail->nombre_detalle, 'UTF-8')] = $detail->id;
                                        }
                                    }
                                }
                            }
                        }

                        $first = true;
                        $savedProducts = Product::withoutGlobalScopes()->where([
                            'referencia_id' => $reference->id,
                        ])->get();
                        $tax = Tax::find($request->tax);

                        if (is_null($tax)) {
                            $tax = Tax::where([
                                'porciento' => 0,
                            ])->first();

                            if (is_null($tax)) {
                                $tax = new Tax;
                                $tax->nombre_impuesto = 'IVA (0%)';
                                $tax->porciento = 0;
                                $tax->save();
                            }
                        }

                        foreach ($savedProducts as $product) {
                            $product->name = str_replace($oldReferenceName . '/', $reference->nombre . '/', $product->nombre);
                            $product->category = $request->category;
                            $product->description = $request->description;
                            $product->impuesto = $tax->id_impuesto;
                            $product->long_description = $request->long_description;
                            $product->featured = false;
                            $product->sell_in_negative = (!is_null($request->sell_without_stock)) ? true : false;
                            $product->show_stock = (!is_null($request->show_stock)) ? true : false;
                            $product->activo = true;
                            $product->tienda = true;
                            $product->save();

                            if (!in_array(strtolower($product->attributes), $products)) {
                                if ($product->detailProduct) {
                                    $product->detailProduct->delete();
                                }

                                $product->activo = 0;
                                $product->tienda = 0;
                                $product->save();
                            } else {
                                $productDetails = explode('/', mb_strtoupper($product->attributes, 'UTF-8'));
                                $findDetails = true;
                                $idDetails = [];

                                foreach ($productDetails as $detail) {
                                    if (array_key_exists($detail, $storedDetails)) {
                                        array_push($idDetails, $storedDetails[$detail]);
                                    } else {
                                        $findDetails = false;
                                    }
                                }

                                if (!$findDetails || count($idDetails) <= 0) {
                                    if ($product->detailProduct) {
                                        $product->detailProduct->delete();
                                    }

                                    $product->activo = 0;
                                    $product->tienda = 0;
                                    $product->save();
                                }
                            }
                        }

                        foreach ($products as $key => $value) {
                            $productDetails = explode('/', mb_strtoupper($value, 'UTF-8'));
                            $findDetails = true;
                            $idDetails = [];

                            foreach ($productDetails as $detail) {
                                if (array_key_exists($detail, $storedDetails)) {
                                    array_push($idDetails, $storedDetails[$detail]);
                                } else {
                                    $findDetails = false;
                                }
                            }

                            if ($findDetails && count($idDetails) > 0) {
                                $change_stock = true;
                                $featured = ($first && !is_null($request->featured)) ? true : false;
                                $code = array_key_exists($key, $codes) ? $codes[$key] : null;
                                $quantity = array_key_exists($key, $quantities) && !is_null($quantities[$key]) ? $quantities[$key] : 0;
                                $buy_price = array_key_exists($key, $buy_prices) && !is_null($buy_prices[$key]) ? $buy_prices[$key] : 0;
                                $sale_price = array_key_exists($key, $sale_prices) && !is_null($sale_prices[$key]) ? $sale_prices[$key] : 0;
                                $percentage = $tax->porciento;
                                $price = round($sale_price / (1 + ($percentage / 100)), 2);
                                $product = Product::where([
                                    'nombre' => $reference->nombre . '/' . mb_strtoupper($value, 'UTF-8'),
                                    'referencia_id' => $reference->id,
                                ])->first();

                                if (is_null($product)) {
                                    $product = new Product;
                                    $product->name = $reference->nombre . '/' . mb_strtoupper($value, 'UTF-8');
                                    $product->referencia_id = $reference->id;
                                }

                                $product->code = $code;
                                $product->category = $request->category;
                                $product->impuesto = $tax->id_impuesto;
                                $product->description = $request->description;
                                $product->long_description = $request->long_description;
                                $product->featured = $featured;
                                $product->sell_in_negative = (!is_null($request->sell_without_stock)) ? true : false;
                                $product->show_stock = (!is_null($request->show_stock)) ? true : false;
                                $product->buy_price = $buy_price;
                                $product->sale_price = $price;

                                if ($product->save()) {
                                    $warehouse = auth_user()->shop->id_almacen;
                                    $curret_stock = Current::where([
                                        'almacen_id' => $warehouse,
                                        'producto_id' => $product->id,
                                    ])->first();

                                    if (is_null($curret_stock)) {
                                        $curret_stock = new Current;
                                        $curret_stock->set_warehouse = $warehouse;
                                        $curret_stock->set_product = $product->id;
                                    } else {
                                        $change_stock = $curret_stock->unidades != $quantity;
                                    }

                                    $curret_stock->set_quantity = $quantity;

                                    if ($curret_stock->save()) {
                                        if ($change_stock && $quantity > 0) {
                                            $productCollection = collect();
                                            $productCollection->push([
                                                'id' => $product->id,
                                                'name' => $product->name,
                                                'buy_price' => $product->buy_price,
                                                'sale_price' => $product->sale_price,
                                                'quantity' => $quantity,
                                                'subtotal' => $product->buy_price * $quantity,
                                            ]);

                                            $movement = new InventoryMovement($productCollection);
                                            $inventory = $movement->new($warehouse);
                                            $result = $movement->addItems($inventory);
                                        }

                                        $first = false;
                                        $detailProduct = DetailProduct::where([
                                            'producto_id' => $product->id,
                                        ])->first();

                                        if (is_null($detailProduct)) {
                                            $detailProduct = new DetailProduct;
                                            $detailProduct->producto_id = $product->id;

                                            for ($i = 0; $i < count($idDetails); $i++) {
                                                if ($i < 10) {
                                                    $detailId = 'producto_referencia_atributo_detalle' . ($i + 1) . '_id';
                                                    $detailProduct->$detailId = $idDetails[$i];
                                                }
                                            }

                                        }

                                        $detailProduct->save();
                                    }
                                }
                            }
                        }

                        return redirect()->route('admin.products.index')->with('success', 'El producto se agrego con éxito.');
                    }
                }
            }
        }

        return back()->with('danger', 'Ha ocurrido un error.');
    }

    /**
     * @param int $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateWithAttributes(UpdateWithAttributesRequest $request, int $product)
    {
        $product = Product::findOrFail($product);

        for ($i = 0; $i <= 5; $i++) {
            $image = $i > 0 ? 'imagen' . $i : 'imagen';

            if ($request->file($image) != null) {
                $product_name = sanitize_file_name ($product->id . ' ' . $product->name . ' ' . $image);

                if ($product->$image) {
                    $routeProduct = 'public/uploads/' . auth_user()->dbConfig->base_dato . '/imagenes_productos/' . $product->$image;
                    Storage::delete($routeProduct);
                }

                if ($request->file($image)->storeAs(auth_user()->dbConfig->base_dato . '/imagenes_productos', $product_name . '.' . $request->file($image)->extension(), 'uploads')) {
                    $product->$image = $product_name . '.' . $request->file($image)->extension();
                }
            }
        }

        if ($product->save()) {
            return back()->with('success', 'El producto se actualizó con éxito.');
        }

        return back()->with('danger', 'Ha ocurrido un error.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shop\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    /**
     * @param int $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function featured(int $product)
    {
        $featured = Product::where('destacado_tienda', true)->count();
        $product = Product::findOrFail($product);

        if ($product->destacado_tienda) {
            $product->featured = false;
        } else {
            if ($featured >= 10) {
                return back()->with('danger', 'Solo puede seleccionar 10 productos como destacados.');
            }

            $product->featured = true;
        }

        if ($product->save()) {
            return back();
        }

        return back()->with('danger', 'No se pudo asignar el producto como destacado.');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sellAllWithoutStock()
    {
        $products = Product::where('tienda', true)->get();
        $count = 0;
        $products->each(function (Product $product) use (&$count) {
            $product->sell_in_negative = true;

            if ($product->save()) {
                $count++;
            }
        });

        return back()->with('success', "Se actualizaron {$count} productos de {$products->count()}.");
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sellAllOnlyWithStock()
    {
        $products = Product::where('tienda', true)->get();
        $count = 0;
        $products->each(function (Product $product) use (&$count) {
            $product->sell_in_negative = false;

            if ($product->save()) {
                $count++;
            }
        });

        return back()->with('success', "Se actualizaron {$count} productos de {$products->count()}.");
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function showStockOfAllProducts()
    {
        $products = Product::where('tienda', true)->get();
        $count = 0;
        $products->each(function (Product $product) use (&$count) {
            $product->show_stock = true;

            if ($product->save()) {
                $count++;
            }
        });

        return back()->with('success', "Se actualizaron {$count} productos de {$products->count()}.");
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function hideStockOfAllProducts()
    {
        $products = Product::where('tienda', true)->get();
        $count = 0;
        $products->each(function (Product $product) use (&$count) {
            $product->show_stock = false;

            if ($product->save()) {
                $count++;
            }
        });

        return back()->with('success', "Se actualizaron {$count} productos de {$products->count()}.");
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function uploadFromExcel()
    {
        return view('admin.products.upload-excel');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function validateExcel(Request $request)
    {
        $this->validate($request, [
            'excel' => 'required|mimes:xlsx|max:30',
        ]);

        if ($request->hasFile('excel')) {
            try {
                if (is_null($request->input('product_with_attributes'))) {
                    Excel::import(new ProductsImport, $request->file('excel'));
                } else {
                    Excel::import(new ProductsWithAttributesImport, $request->file('excel'));
                }

                $import = new ProductsImportRepository;
                $products = $import->get();
                $import->clear();
                $categories = Category::all();

                if (!is_null($products)) {
                    return back()->with(compact('products', 'categories'))->with('warning', 'Los productos del archivo Excel se cargaron con exito al sistema. Pero hubieron algunos errores.');
                }

                return redirect()->route('admin.products.index')->with('success', 'Los productos del archivo Excel se cargaron con exito al sistema.');
            } catch (\Exception $e) {
                return back()->withErrors('Error al intentar cargar el archivo. ' . $e->getMessage());
            }
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createUploadFromExcel(Request $request)
    {
        if ($request->hasFile('excel')) {
            Excel::import(new ProductsImport, $request->file('excel'));

            return redirect()->route('admin.products.index')
                ->with('success', 'Los productos del archivo Excel se cargaron con exito al sistema.');
        }
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function ajaxGetProducts()
    {
        return ProductResource::collection(Product::all());
    }

    /**
     * @param Request $request
     * @return Boolean
     */
    public function deleteImage(Request $request)
    {
        $image = $request->image;
        $is_reference = filter_var($request->is_reference, FILTER_VALIDATE_BOOLEAN);
        $product_id = $request->product_id;
        $product = Product::find($product_id);

        if (!is_null($product)) {
            $valueImage = $is_reference && !is_null($product->reference) ? $product->reference->$image : $product->$image;
            $reference = $is_reference && !is_null($product->reference) ? $product->reference : $product;
            $prefix = substr($valueImage, 0, 11);
            $db = $prefix === 'vendty2_db_' ? '' : Config::get('database.connections.mysql_shop.database');
            $routeImage = "public/uploads/{$db}/imagenes_productos/" . $valueImage;

            //File::exists(public_path("uploads/{$db}/imagenes_productos/{$image}"))
            if (File::exists($routeImage)) {
                Storage::delete($routeImage);
            }

            $reference->$image = null;

            return response()->json(['status' => $reference->save()]);
        }

        return response()->json(['status' => false]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function check(Request $request)
    {
        $products = collect([]);
        $reference = Reference::find($request->reference_id);

        if (!is_null($reference)) {
            foreach ($request->products as $key => $product) {
                $products->push(Product::withoutGlobalScopes()->with('currentStock')->where([
                    'referencia_id' => $reference->id,
                    'nombre' => $reference->nombre . '/' . $product,
                ])->first());
            }
        }

        return $products->toJson();
    }

    public function download()
    {
        return response()->download(storage_path('productos.xlsx'));
    }

    public function downloadWithAttributes()
    {
        return response()->download(storage_path('productos_con_atributos.xlsx'));
    }
}
