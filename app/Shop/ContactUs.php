<?php

namespace App\Shop;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ContactUs
 * @package App\Shop
 * @mixin \Eloquent
 */
class ContactUs extends Model
{
    /**
     * @var string
     */
    protected $connection = 'mysql_shop';

    /**
     * @var string
     */
    protected $table = 'tienda_contactanos';

    /**
     * @var array
     */
    protected $fillable = [
        'google_maps', 'address', 'phone', 'email', 'whatsapp_default_message'
    ];
}
