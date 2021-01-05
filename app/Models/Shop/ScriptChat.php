<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ScriptChat
 * @package App\Models\Shop
 * @mixin \Eloquent
 */
class ScriptChat extends Model
{
    /**
     * @var string
     */
	protected $connection = 'mysql_shop';

    /**
     * @var string
     */
    protected $table = 'scriptchat';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'html', 'javascript'
    ];
}
