<?php

namespace App\Models\Vendty;

use App\Getters\DbConfig as GetDbConfigAttributes;
use App\Models\Vendty\CRM\DBActive;
use App\Models\Vendty\Views\License as ViewLicense;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Class DBConfig
 * @package App\Models\Vendty
 * @property-read integer $id
 * @property-read string $servidor
 * @property-read string $base_dato
 * @property-read string $usuario
 * @property-read string $clave
 * @property-read \App\User $user
 * @property-read \App\Models\Vendty\Shop $shop
 * @property-read \App\Models\Vendty\Licence $licence
 * @property-read \App\Models\Vendty\CRM\DBActive dbActive
 * @mixin \Eloquent
 */
class DBConfig extends Model
{
    use GetDbConfigAttributes;

    /**
     * @var string
     */
    protected $table = 'db_config';

	/**
     * @var array
     */
    protected $hidden = [
        'servidor', 'base_dato', 'usuario', 'clave'
    ];

    /**
     * @var boolean
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->hasOne(User::class, 'db_config_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function shop()
    {
        return $this->hasOne(Shop::class, 'id_db');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function license()
    {
        return $this->hasMany(Licence::class, 'id_db_config');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function viewLicenses()
    {
        return $this->hasMany(ViewLicense::class, 'id_db_config');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function dbActive()
    {
        return $this->hasOne(DBActive::class, 'id_db');
    }

    public function connect()
    {
        if (!$this->connected()) {
            DB::purge('mysql_shop');

            Config::set('database.connections.mysql_shop.host', $this->servidor);
            Config::set('database.connections.mysql_shop.database', $this->base_dato);
            Config::set('database.connections.mysql_shop.username', $this->usuario);
            Config::set('database.connections.mysql_shop.password', $this->clave);

            DB::reconnect('mysql_shop');

            Schema::connection('mysql_shop')->getConnection()->reconnect();
        }
    }

    /**
     * @return bool
     */
    private function connected()
    {
        $connection = Config::get('database.connections.mysql_shop');

        return $connection['username'] == $this->usuario &&
            $connection['password'] == $this->clave &&
            $connection['database'] == $this->base_dato;
    }
}
