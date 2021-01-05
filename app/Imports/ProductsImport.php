<?php

namespace App\Imports;

use App\Models\Shop\Category;
use App\Models\Shop\Product;
use App\Models\Shop\Stock\Current;
use App\Models\Shop\Tax;
use App\Modules\InventoryMovement;
use App\Repositories\Temp\ProductsImport as ProductsImportRepository;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
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
        $row = array_values($row);
        $category_name = ($row[0] != 'NULL' && $row[0] != '') ? trim($row[0]) : null;
        $subcategory_name = ($row[1] != 'NULL' && $row[1] != '') ? trim($row[1]) : null;
        $sub_subcategory_name = ($row[2] != 'NULL' && $row[2] != '') ? trim($row[2]) : null;
        $name = ($row[3] != 'NULL' && $row[3] != '') ? trim($row[3]) : null;
        $description = ($row[4] != 'NULL' && $row[4] != '') ? trim($row[4]) : null;
        $code = ($row[5] != 'NULL' && $row[5] != '') ? trim($row[5]) : null;
        $buy_price = ($row[6] != 'NULL' && $row[6] != '') ? floatval($row[6]) : 0;
        $sale_price = ($row[7] != 'NULL' && $row[7] != '') ? floatval($row[7]) : 0;
        $sell_in_negative = ($row[8] === 'Si' || $row[8] === 'SI' || $row[8] === 'si');
        $quantity = ($row[9] != 'NULL' && $row[9] != '') ? floatval($row[9]) : 0;
        $tax_percentage = ($row[10] != 'NULL' && $row[10] != '') ? floatval($row[10]) : 0;

        if (!is_null($name)) {
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
                $tax = Tax::where('porciento', $tax_percentage)->first();

                if (is_null($tax)) {
                    $tax = new Tax;
                    $tax->nombre_impuesto = 'Impuesto (' . $tax_percentage . '%)';
                    $tax->porciento = $tax_percentage;
                    $tax->save();
                }

                $product = Product::where('nombre', $name)->first();

                if (is_null($product)) {
                    $product = new Product;
                }

                $product->category = $product_category->id;
                $product->code = $code;
                $product->name = $name;
                $product->description = $description;
                $product->buy_price = $buy_price;
                $product->sale_price = $sale_price;
                $product->sell_in_negative = $sell_in_negative;
                $product->impuesto = $tax->id_impuesto;

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
                }
            } else {
                $import = new ProductsImportRepository;
                $import->put($row);
            }

        } else {
            $import = new ProductsImportRepository;
            $import->put($row);
        }
    }
}
