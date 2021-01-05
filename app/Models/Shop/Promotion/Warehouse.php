<?php

namespace App\Models\Shop\Promotion;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Warehouse
 * @package App\Models\Shop\Promotion
 * @property-read integer $id
 * @property-write integer id_promocion
 * @property-read \App\Models\Shop\Promotion\Promotion $promotion
 * @mixin \Eloquent
 */
class Warehouse extends Model
{
    /**
     * @var string
     */
    protected $connection = 'mysql_shop';

    /**
     * @var string
     */
    protected $table = 'promociones_almacenes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_promocion', 'id_almacen'
    ];

    /**
     * Valores por defecto en los siguientes campos
     *
     * @var array
     */
    protected $attributes = [
        'id_almacen' => null
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * Promotion constructor.
     */
    function __construct()
    {
        parent::__construct();
        $this->attributes['id_almacen'] = auth()->user()->shop->id_almacen;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'id_promocion', 'id');
    }
}
