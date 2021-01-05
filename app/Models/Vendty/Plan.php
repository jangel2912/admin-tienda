<?php

namespace App\Models\Vendty;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Plan
 * @package App\Models\Vendty
 * @property-read \App\Models\Vendty\Licence $licence
 * @mixin \Eloquent
 */
class Plan extends Model
{
    /**
     * @var string
     */
    protected $table = 'crm_planes';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function license()
    {
    	return $this->belongsTo(Licence::class, 'planes_id');
    }
}
