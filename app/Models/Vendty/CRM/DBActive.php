<?php

namespace App\Models\Vendty\CRM;

use App\Models\Vendty\DBConfig;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DBActive
 * @package App\Models\Vendty\CRM
 * @property-read \App\Models\Vendty\DBConfig $dbConfig
 * @mixin \Eloquent
 */
class DBActive extends Model
{
    /**
     * @var string
     */
    protected $table = 'crm_db_activas';

    /**
     * @var null
     */
    protected $primaryKey = 'id_db';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = [
        'tienda_dominio', 'tienda_dominio_interno', 'tienda_estado'
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dbConfig()
    {
        return $this->belongsTo(DBConfig::class, 'id_db');
    }
}
