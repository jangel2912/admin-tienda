<?php

namespace App\Models\Vendty;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Template
 * @package App\Models\Vendty
 * @property-read \App\Models\Vendty\Shop $shop
 * @mixin \Eloquent
 */
class Template extends Model
{
    /**
     * [$table description]
     * @var string
     */
    protected $table = 'plantillas';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * Relación con la tienda
     * @return [type] [description]
     */
    public function shop()
    {
    	return $this->belongsTo(Shop::class, 'nombre', 'layout');
    }
}
