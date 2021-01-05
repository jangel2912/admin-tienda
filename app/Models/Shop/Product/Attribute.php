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
class Attribute extends Model
{
    /**
     * @var string
     */
    protected $connection = 'mysql_shop';

    /**
     * @var string
     */
    protected $table = 'producto_referencia_atributo';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reference()
    {
        return $this->belongsTo(Reference::class, 'producto_referencia_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details()
    {
        return $this->hasMany(Detail::class, 'producto_referencia_atributo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getDetailsStringAttribute()
    {
        $details = '';

        foreach ($this->details as $detail) {
            $details .= $detail->nombre_detalle . ',';
        }

        return $details;
    }
}
