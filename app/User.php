<?php

namespace App;

use App\Models\Shop\Permit;
use App\Models\Shop\UserStore;
use App\Models\Vendty\DBConfig;
use App\Models\Vendty\Shop;
use App\Models\Vendty\SocialNetwork;
use App\Notifications\AdminResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\User
 * @property-read integer $id
 * @property-read \App\Models\Vendty\Shop $shop
 * @property-read \App\Models\Vendty\DBConfig $dbConfig
 * @property-read \App\Models\Shop\UserStore $userStore
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPassword($token));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function shop()
    {
        return $this->hasOne(Shop::class, 'id_db', 'db_config_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function permits()
    {
        return $this->hasMany(Permit::class, 'id_rol', 'rol_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dbConfig()
    {
        return $this->belongsTo(DBConfig::class, 'db_config_id');
    }
}
