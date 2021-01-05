<?php

namespace App\Models\Shop\Product;

use App\Models\Shop\Product;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Attribute
 * @package App\Models\Shop\Stock
 * @property-read integer $id
 * @property-read integer $almacen_id
 * @property-read integer $producto_id
 * @property-read float $unidades
 * @property-read \App\Models\Shop\Product $product
 * @mixin \Eloquent
 */
class Modifications extends Model
{
    /**
     * @var string
     */
    protected $connection = 'mysql_shop';

    /**
     * @var string
     */
    protected $table = 'producto_modificacion';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_producto');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function onlineVentaModifications()
    {
        return $this->hasMany(OnlineVentaProductModification::class, 'producto_modificacion_id');
    }
}
