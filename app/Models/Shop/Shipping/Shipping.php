<?php

namespace App\Models\Shop\Shipping;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Shipping
 * @package App\Models\Shop\Shipping
 * @property-read integer $id
 * @property string $nombre
 * @property float $valor
 * @property bool $activo
 * @property-read \Carbon\Carbon $created_at
 * @property-read \Carbon\Carbon $updated_at
 * @mixin \Eloquent
 */
class Shipping extends Model
{
    /**
     * @var string
     */
    protected $connection = 'mysql_shop';

    /**
     * @var string
     */
    protected $table = 'envios';

    /**
     * @var array
     */
    protected $fillable = [
        'nombre', 'valor', 'activo'
    ];
}
