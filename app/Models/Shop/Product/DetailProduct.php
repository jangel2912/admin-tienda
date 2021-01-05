<?php

namespace App\Models\Shop\Product;

use App\Models\Shop\Product;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DetailProduct
 * @package App\Models\Shop\Stock
 * @property-read integer $id
 * @property-read integer $almacen_id
 * @property-read integer $producto_id
 * @property-read float $unidades
 * @property-read \App\Models\Shop\Product $product
 * @mixin \Eloquent
 */
class DetailProduct extends Model
{
    /**
     * @var string
     */
    protected $connection = 'mysql_shop';

    /**
     * @var string
     */
    protected $table = 'producto_referencia_atributo_detalle_producto';

    /**
     * @var bool
     */
    public $timestamps = false;
}
