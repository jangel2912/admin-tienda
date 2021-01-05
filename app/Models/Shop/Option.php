<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Option
 * @package App\Models\Shop
 * @property-read integer $id
 * @property string $nombre_opcion
 * @property string $valor_opcion
 * @mixin \Eloquent
 */
class Option extends Model
{
    /**
     * @var string
     */
    protected $connection = 'mysql_shop';

    /**
     * @var string
     */
    protected $table = 'opciones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre_opcion', 'valor_opcion'
    ];

    /**
     * @var bool
     */
    public $timestamps = false;
}
