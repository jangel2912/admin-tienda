<?php

namespace App\Models\Shop\Promotion;

use App\Setters\Promotion\Description as DescriptionSetAttributes;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Description
 * @package App\Models\Shop\Promotion
 * @property-read integer $id
 * @property integer $id_promocion
 * @property integer $producto_pos
 * @property integer $cantidad
 * @property integer $descuento
 * @property string $tipo
 * @property \App\Models\Shop\Promotion\Promotion $promotion
 * @mixin \Eloquent
 */
class Description extends Model
{
    use DescriptionSetAttributes;

    /**
     * @var string
     */
    protected $connection = 'mysql_shop';

    /**
     * @var string
     */
    protected $table = 'promociones_descripcion';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_promocion', 'producto_pos', 'cantidad', 'descuento', 'tipo'
    ];

    /**
     * @var array
     */
    protected $attributes = [
        'tipo' => 'mayor_costo'
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
}
