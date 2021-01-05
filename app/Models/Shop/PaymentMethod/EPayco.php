<?php

namespace App\Models\Shop\PaymentMethod;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EPayco
 * @package App\Models\Shop\PaymentMethod
 * @property-read integer $id
 * @property string $client_id
 * @property string $public_key
 * @property string $private_key
 * @property bool $active
 * @property-read \Carbon\Carbon $created_at
 * @property-read \Carbon\Carbon $updated_at
 * @mixin \Eloquent
 */
class EPayco extends Model
{
    /**
     * @var string
     */
    protected $connection = 'mysql_shop';

    /**
     * @var string
     */
    protected $table = 'epayco_credentials';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id', 'public_key', 'private_key', 'active'
    ];
}
