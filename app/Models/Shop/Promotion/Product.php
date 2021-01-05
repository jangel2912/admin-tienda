<?php

namespace App\Models\Shop\Promotion;

use App\Models\Shop\Product as ProductModel;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * @package App\Models\Shop\Promotion
 * @property-read integer $id
 * @property-write integer $id_promocion
 * @property-write integer $id_producto
 * @property-read \App\Models\Shop\Promotion\Promotion $promotion
 * @property-read \App\Models\Shop\Product $product
 * @mixin \Eloquent
 */
class Product extends Model
{
    /**
     * @var string
     */
    protected $connection = 'mysql_shop';

    /**
     * @var string
     */
    protected $table = 'promociones_productos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_promocion', 'id_producto'
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'id_promocion', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'id_producto', 'id');
    }
}
