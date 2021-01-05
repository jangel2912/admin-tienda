<?php

namespace App\Modules;

use App\Models\Shop\Movement\Detail;
use App\Models\Shop\Movement\Inventory;
use App\Models\Shop\Stock\Daily;
use Illuminate\Support\Collection;

/**
 * Class InventoryMovement
 * @package App\Modules
 */
class InventoryMovement
{
    /**
     * @var Collection
     */
    protected $products;

    /**
     * InventoryMovement constructor.
     * @param Collection $products
     */
    public function __construct(Collection $products)
    {
        $this->products = $products;
    }

    /**
     * @param int $warehouse
     * @return Inventory|null
     */
    public function new(int $warehouse)
    {
        $total = $this->products->sum('subtotal');

        $inventory = new Inventory;
        $inventory->almacen_id = $warehouse;
        $inventory->total_inventario = $total;

        if ($inventory->save()) {
            return $inventory;
        }

        return null;
    }

    /**
     * @param Inventory $inventory
     * @return array
     */
    public function addItems(Inventory $inventory)
    {
        $saved = 0;
        $no_saved = 0;

        $this->products->each(function ($product) use ($inventory, &$saved, &$no_saved) {
            $detail = new Detail;
            $detail->id_inventario = $inventory->id;
            $detail->codigo_barra = '';
            $detail->cantidad = $product['quantity'];
            $detail->precio_compra = $product['buy_price'];
            $detail->existencias = 0;
            $detail->nombre = $product['name'];
            $detail->total_inventario = $product['buy_price'] * $product['quantity'];
            $detail->producto_id = $product['id'];

            if ($detail->save()) {

                $dailyStock = new Daily;
                $dailyStock->producto_id = $product['id'];
                $dailyStock->almacen_id = $inventory->almacen_id;
                $dailyStock->razon = 'E';
                $dailyStock->cod_documento = null;
                $dailyStock->unidad = $product['quantity'];
                $dailyStock->precio = $product['sale_price'];

                if ($dailyStock->save()) {
                    $saved++;
                }

            } else {
                $no_saved++;
            }
        });

        return compact('saved', 'no_saved');
    }
}
