<?php

namespace App\Imports;

use App\Models\Shop\Category;
use App\Models\Shop\Product;
use App\Models\Shop\Product\Attribute;
use App\Models\Shop\Product\Detail;
use App\Models\Shop\Product\DetailProduct;
use App\Models\Shop\Product\Reference;
use App\Models\Shop\Stock\Current;
use App\Models\Shop\Tax;
use App\Modules\InventoryMovement;
use App\Repositories\Temp\ProductsImport as ProductsImportRepository;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsWithAttributesImport implements ToModel, WithHeadingRow
{
    /**
     * @var \Illuminate\Support\Collection
     */
    protected $products;

    /**
     * @var int
     */
    protected $warehouse = 0;

    /**
     * ProductsImport constructor.
     */
    public function __construct()
    {
        $this->products = collect();
        $this->warehouse = auth_user()->shop->id_almacen;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        try {
            $keys = array_keys($row);
            $row = array_values($row);
            $category_name = ($row[0] != 'NULL' && $row[0] != '' && $row[0] != ' ') ? trim($row[0]) : null;
            $subcategory_name = ($row[1] != 'NULL' && $row[1] != '' && $row[1] != ' ') ? trim($row[1]) : null;
            $sub_subcategory_name = ($row[2] != 'NULL' && $row[2] != '' && $row[2] != ' ') ? trim($row[2]) : null;
            $name = ($row[3] != 'NULL' && $row[3] != '' && $row[3] != ' ') ? trim($row[3]) : null;
            $description = ($row[4] != 'NULL' && $row[4] != '' && $row[4] != ' ') ? trim($row[4]) : null;
            $code = ($row[5] != 'NULL' && $row[5] != '' && $row[5] != ' ') ? trim($row[5]) : null;
            $buy_price = ($row[6] != 'NULL' && $row[6] != '' && $row[6] != ' ') ? floatval($row[6]) : 0;
            $sale_price = ($row[7] != 'NULL' && $row[7] != '' && $row[7] != ' ') ? floatval($row[7]) : 0;
            $sell_in_negative = ($row[8] === 'Si' || $row[8] === 'SI' || $row[8] === 'si');
            $quantity = ($row[9] != 'NULL' && $row[9] != '' && $row[9] != ' ') ? floatval($row[9]) : 0;
            $tax_percentage = ($row[10] != 'NULL' && $row[10] != '' && $row[10] != ' ') ? floatval($row[10]) : 0;
            $attribute_keys = [11 => 'COLOR', 12 => 'TALLA', 13 => 'MATERIAL'];
            $attributes = [];
            $details_name = '';

            for ($i = 11; $i <= 13; $i++) {
                if (array_key_exists($i, $row) && $row[$i] != 'NULL' && $row[$i] != '' && $row[$i] != ' ') {
                    if (array_key_exists($i, $keys) && $keys[$i] != 'NULL' && $keys[$i] != '' && $keys[$i] != ' ') {
                        $attributes[strtoupper(trim($keys[$i]))] = strtoupper(trim($row[$i]));
                    } else {
                        $attributes[$attribute_keys[$i]] = strtoupper(trim($row[$i]));
                    }
                }
            }

            if (!is_null($name) && !empty($attributes)) {
                $product_category = null;

                if (!is_null($category_name) && !is_null($subcategory_name) && !is_null($sub_subcategory_name)) {
                    $sub_subcategories = Category::with('father')->where([
                        'nombre' => $sub_subcategory_name,
                        ['padre', '<>', null]
                    ])->get();

                    foreach ($sub_subcategories as $value) {
                        if (
                            strtolower($value->father->nombre) === strtolower($subcategory_name)
                            && !is_null($value->father->father)
                            && strtolower($value->father->father->nombre) === strtolower($category_name)
                        ) {
                            $product_category = $value;
                        }
                    }

                    if (is_null($product_category)) {
                        $subcategory = null;

                        $subcategories = Category::with('father')->where([
                            'nombre' => $subcategory_name,
                            ['padre', '<>', null]
                        ])->get();

                        foreach ($subcategories as $value) {
                            if (strtolower($value->father->nombre) === strtolower($category_name)) {
                                $subcategory = $value;
                            }
                        }

                        if (is_null($subcategory)) {
                            $category = Category::where([
                                'nombre' => $category_name,
                                'padre' => null,
                            ])->first();

                            if (is_null($category)) {
                                $category = new Category;
                                $category->nombre = $category_name;
                                $category->save();
                            }

                            $subcategory = new Category;
                            $subcategory->nombre = $subcategory_name;
                            $subcategory->padre = $category->id;
                            $subcategory->save();
                        }

                        $sub_subcategory = new Category;
                        $sub_subcategory->nombre = $sub_subcategory_name;
                        $sub_subcategory->padre = $subcategory->id;
                        $sub_subcategory->save();

                        $product_category = $sub_subcategory;
                    }
                } else if (!is_null($category_name) && !is_null($subcategory_name)) {
                    $subcategories = Category::with('father')->where([
                        'nombre' => $subcategory_name,
                        ['padre', '<>', null]
                    ])->get();

                    foreach ($subcategories as $value) {
                        if (strtolower($value->father->nombre) === strtolower($category_name)) {
                            $product_category = $value;
                        }
                    }

                    if (is_null($product_category)) {
                        $category = Category::where([
                            'nombre' => $category_name,
                            'padre' => null,
                        ])->first();

                        if (is_null($category)) {
                            $category = new Category;
                            $category->nombre = $category_name;
                            $category->save();
                        }

                        $subcategory = new Category;
                        $subcategory->nombre = $subcategory_name;
                        $subcategory->padre = $category->id;
                        $subcategory->save();

                        $product_category = $subcategory;
                    }
                } else if (!is_null($category_name)) {
                    $category = Category::where([
                        'nombre' => $category_name,
                        'padre' => null,
                    ])->first();

                    if (is_null($category)) {
                        $category = new Category;
                        $category->nombre = $category_name;
                        $category->save();
                    }

                    $product_category = $category;
                } else {
                    $category = Category::first();

                    if (is_null($category)) {
                        $category = new Category;
                        $category->nombre = 'General';
                        $category->save();
                    }

                    $product_category = $category;
                }

                if (!is_null($product_category)) {
                    $reference = Reference::where('nombre', $name)->first();
                    $idDetails = [];

                    if (is_null($reference)) {
                        $reference = new Reference;
                        $reference->nombre = $name;
                        $reference->descripcion = $description;
                    }

                    if ($reference->save()) {
                        foreach ($attributes as $key => $value) {
                            $attribute = Attribute::where([
                                'nombre_atributo' => strtoupper($key),
                                'producto_referencia_id' => $reference->id,
                            ])->first();

                            if (is_null($attribute)) {
                                $attribute = new Attribute;
                                $attribute->nombre_atributo = strtoupper($key);
                                $attribute->producto_referencia_id = $reference->id;
                            }

                            if ($attribute->save()) {
                                $detail = Detail::where([
                                    'nombre_detalle' => strtoupper($value),
                                    'producto_referencia_atributo_id' => $attribute->id,
                                ])->first();

                                if (is_null($detail)) {
                                    $detail = new Detail;
                                    $detail->nombre_detalle = strtoupper($value);
                                    $detail->producto_referencia_atributo_id = $attribute->id;
                                }

                                if ($detail->save()) {
                                    array_push($idDetails, $detail->id);
                                    $details_name .= '/' . $detail->nombre_detalle;
                                }
                            }
                        }

                        if (!empty($idDetails) && $details_name !== '') {
                            $tax = Tax::where('porciento', $tax_percentage)->first();

                            if (is_null($tax)) {
                                $tax = new Tax;
                                $tax->nombre_impuesto = 'Impuesto (' . $tax_percentage . '%)';
                                $tax->porciento = $tax_percentage;
                            }

                            if ($tax->save()) {
                                $product = Product::where('nombre', $reference->nombre . $details_name)->first();

                                if (is_null($product)) {
                                    $product = new Product;
                                }

                                $product->category = $product_category->id;
                                $product->code = $code;
                                $product->name = $reference->nombre . $details_name;
                                $product->description = $description;
                                $product->buy_price = $buy_price;
                                $product->sale_price = $sale_price;
                                $product->sell_in_negative = $sell_in_negative;
                                $product->impuesto = $tax->id_impuesto;
                                $product->referencia_id = $reference->id;

                                if ($product->save()) {
                                    $curret_stock = new Current;
                                    $curret_stock->set_warehouse = $this->warehouse;
                                    $curret_stock->set_product = $product->id;
                                    $curret_stock->set_quantity = $quantity;

                                    if ($curret_stock->save()) {
                                        if ($quantity > 0) {
                                            $this->products->push([
                                                'id' => $product->id,
                                                'name' => $product->name,
                                                'buy_price' => $product->buy_price,
                                                'sale_price' => $product->sale_price,
                                                'quantity' => $quantity,
                                                'subtotal' => $product->buy_price * $quantity,
                                            ]);

                                            $movement = new InventoryMovement($this->products);
                                            $inventory = $movement->new($this->warehouse);
                                            $result = $movement->addItems($inventory);
                                            $this->products = collect([]);
                                        }
                                    }

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
                    }
                } else {
                    $import = new ProductsImportRepository;
                    $import->put($row);
                }

            } else {
                $import = new ProductsImportRepository;
                $import->put($row);
            }
        } catch (\Throwable $th) {
            $import = new ProductsImportRepository;
            $import->put($row);
        }
    }
}
