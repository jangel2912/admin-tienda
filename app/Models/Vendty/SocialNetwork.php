<?php

namespace App\Models\Vendty;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SocialNetwork
 * @package App\Models\Vendty
 * @property-read \App\User $user
 * @mixin \Eloquent
 */
class SocialNetwork extends Model
{
    /**
     * [$table description]
     * @var string
     */
    protected $table = 'redes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_user', 'drible', 'facebook', 'google', 'instagram', 'linkedin', 'twitter', 'youtube', 'pinterest'
    ];

    /**
     * Deshabilitamos los campos created_at y updated_at
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Relación con el usuario
     * @return [type] [description]
     */
    public function user()
    {
    	return $this->belongsTo(User::class, 'id_user');
    }
}
