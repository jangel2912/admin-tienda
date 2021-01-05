<?php

namespace App\Models\Shop\Promotion;

use App\Presenters\Promotion as PromotionPresenter;
use App\QueryScopes\Shop\Promotion as PromotionScope;
use App\Setters\Promotion as PromotionSetAttributes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Promotion
 * @package App\Models\Shop\Promotion
 * @property-read int $id
 * @property string $nombre,
 * @property string $tipo,
 * @property string $fecha_inicial,
 * @property string $fecha_final,
 * @property string $hora_inicio,
 * @property string $hora_fin,
 * @property string $dias,
 * @property bool $activo,
 * @property bool $shop
 * @property \Illuminate\Support\Collection $days
 * @property-read Carbon $start_in
 * @property-read Carbon $ends_in
 * @mixin \Eloquent
 */
class Promotion extends Model
{
    use PromotionSetAttributes;

    /**
     * @var string
     */
    protected $connection = 'mysql_shop';

    /**
     * @var string
     */
    protected $table = 'promociones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'tipo', 'fecha_inicial', 'fecha_final', 'hora_inicio', 'hora_fin', 'dias', 'activo', 'shop'
    ];

    /**
     * Valores por defecto en los siguientes campos
     *
     * @var array
     */
    protected $attributes = [
        'tipo' => 'progresivo',
        'shop' => true
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new PromotionScope);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getDaysAttribute()
    {
        $array = collect(explode(',', $this->dias));
        $days = collect([]);

        $array->each(function ($day) use (&$days) {
            $days->push((int) $day);
        });

        return $days;
    }

    /**
     * @return Carbon
     */
    public function getStartInAttribute(): Carbon
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', "{$this->fecha_inicial} {$this->hora_inicio}");
    }

    /**
     * @return Carbon
     */
    public function getEndsInAttribute(): Carbon
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', "{$this->fecha_final} {$this->hora_fin}");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function warehouse()
    {
        return $this->hasOne(Warehouse::class, 'id_promocion', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'id_promocion');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function descriptions()
    {
        return $this->hasMany(Description::class, 'id_promocion');
    }

    /**
     * @return PromotionPresenter
     */
    public function present(): PromotionPresenter
    {
        return new PromotionPresenter($this);
    }
}
