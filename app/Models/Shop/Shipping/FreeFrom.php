<?php

namespace App\Models\Shop\Shipping;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FreeFrom
 * @package App\Models\Shop\Shipping
 * @property-read int $id
 * @property float $valor
 * @property string $minimo
 * @property string $activo
 * @mixin \Eloquent
 */
class FreeFrom extends Model
{
    /**
     * @var string
     */
    protected $connection = 'mysql_shop';

    /**
     * @var string
     */
    protected $table = 'envios_gratis_desde';

    /**
     * @var array
     */
    protected $fillable = [
        'valor', 'minimo', 'activo'
    ];
}
