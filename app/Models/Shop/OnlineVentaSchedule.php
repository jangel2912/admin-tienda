<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Class Category
 * @package App\Models\Shop
 * @property-read integer $id
 * @property bool $sunday
 * @property bool $monday
 * @property bool $tuesday
 * @property bool $wednesday
 * @property bool $thursday
 * @property bool $friday
 * @property bool $saturday
 * @property Datetime $open_time
 * @property Datetime $close_time
 * @mixin \Eloquent
 */
class OnlineVentaSchedule extends Model
{
    /**
     * Nombre de la conexion
     *
     * @var string
     */
    protected $connection = 'mysql_shop';

    /**
     * Nombre de la tabla
     *
     * @var string
     */
    protected $table = 'online_venta_schedule';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function sale()
    {
        return $this->belongsTo(OnlineSale::class, 'online_venta_id');
    }

    /**
     * Get the pickup time.
     *
     * @return string
     */
    public function getPickUpAttribute()
    {
        $result = "";
        if(!empty($this->sale_date) && !empty($this->sale_time)){
            $saleDate = Carbon::createFromFormat('Y-m-d', $this->sale_date)->format("d/m/Y");
            $saleTime = Carbon::createFromFormat('H:i:s', $this->sale_time)->format("g:i A");
            $result = "{$saleDate} {$saleTime}";
        }

        return $result;
        
    }
}
