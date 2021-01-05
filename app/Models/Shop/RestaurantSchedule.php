<?php

namespace App\Models\Shop;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

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
class RestaurantSchedule extends Model
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
    protected $table = 'restaurant_schedule';

    /**
     * @var array
     */
    protected $attributes = [
        'sunday' => true,
        'monday' => true, 
        'tuesday' => true, 
        'wednesday' => true, 
        'thursday'=> true, 
        'friday'=> true, 
        'saturday' => true
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'open_time', 'close_time'
    ];

    protected $casts = [
        'sunday' => 'boolean',
        'monday' => 'boolean', 
        'tuesday' => 'boolean', 
        'wednesday' => 'boolean', 
        'thursday'=> 'boolean', 
        'friday'=> 'boolean', 
        'saturday' => 'boolean'
    ];

    /**
     * Get the pickup time.
     *
     * @return string
     */
    public function getPickUpAttribute()
    {
        $result = "";
        if(!empty($this->open_time) && !empty($this->close_time)){
            $openTime = Carbon::createFromFormat('H:i:s', $this->open_time)->format("g:i A");
            $closeTime = Carbon::createFromFormat('H:i:s', $this->close_time)->format("g:i A");
            $result = "{$openTime} - {$closeTime}";
        }

        return $result;
        
    }

    /**
     * Get the open days.
     *
     * @return string
     */
    public function getOpenDaysAttribute()
    {
        $result = "";
        if($this->sunday == 1){
            $result = "Domingo";
        }	
        if($this->monday == 1){
            $result .= empty($result) ? "Lunes" : " - Lunes";
        }	
        if($this->tuesday == 1){
            $result .= empty($result) ? "Martes" : " - Martes";
        }	
        if($this->wednesday == 1){
            $result .= empty($result) ? "Miércoles" : " - Miércoles";
        }	
        if($this->thursday == 1){
            $result .= empty($result) ? "Jueves" : " - Jueves";
        }	
        if($this->friday == 1){
            $result .= empty($result) ? "Viernes" : " - Viernes";
        }	
        if($this->saturday == 1){
            $result .= empty($result) ? "Sábado" : " - Sábado";
        }	
        return $result;
    }


}
