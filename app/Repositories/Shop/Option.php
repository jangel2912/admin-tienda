<?php

namespace App\Repositories\Shop;

use App\Models\Shop\Option as OptionModel;
use App\Repositories\Abstracts\Repository;
use Illuminate\Support\Facades\Cache;

/**
 * Class Option
 * @package App\Repositories\Shop
 */
class Option extends Repository
{
    /**
     * @var string
     */
    protected $table = 'options';

    /**
     * @param string $option
     * @return mixed
     */
    public function get(string $option)
    {
        return Cache::remember("{$this->key}.{$this->table}.{$option}", $this->time, function () use ($option) {
            $opt = OptionModel::where('nombre_opcion', $option)->first();

            if (!is_null($opt)) {
                return $opt->valor_opcion;
            }

            return null;
        });
    }

    /**
     * @param string $option
     * @param $value
     * @return bool
     */
    public function set(string $option, $value): bool
    {
        $optionModel = OptionModel::where('nombre_opcion', $option)->first();

        if (is_null($optionModel)) {
            $optionModel = new OptionModel;
            $optionModel->nombre_opcion = $option;
        }

        $optionModel->valor_opcion = $value;

        if ($optionModel->save()) {
            if (Cache::has("{$this->key}.{$this->table}.{$option}")) {
                return Cache::put("{$this->key}.{$this->table}.{$option}", $value);
            } else {
                return Cache::add("{$this->key}.{$this->table}.{$option}", $value, $this->time);
            }
        }

        return false;
    }
}
