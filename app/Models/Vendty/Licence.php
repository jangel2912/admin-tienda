<?php

namespace App\Models\Vendty;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Licence
 * @package App\Models\Vendty
 * @property-read \App\Models\Vendty\DBConfig $dbConfig
 * @property-read \App\Models\Vendty\Plan $plan
 * @mixin \Eloquent
 */
class Licence extends Model
{
    /**
     * @var string
     */
    protected $table = 'crm_licencias_empresa';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dbConfig()
    {
    	return $this->belongsTo(DBConfig::class, 'id_db_config');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function plan()
    {
    	return $this->hasMany(Plan::class, 'id', 'planes_id');
    }
}
