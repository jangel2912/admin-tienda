<?php

namespace App\Models\Shop\Shipping;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ByDestination
 * @package App\Models\Shop\Shipping
 * @property-read integer $id
 * @property string $origen
 * @property string $destino
 * @property float $valor
 * @property-read \Carbon\Carbon $created_at
 * @property-read \Carbon\Carbon $updated_at
 * @mixin \Eloquent
 */
class ByDestination extends Model
{
    /**
     * @var string
     */
    protected $connection = 'mysql_shop';

    /**
     * @var string
     */
    protected $table = 'envios_por_destino';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'origen', 'destino', 'valor'
    ];
}
