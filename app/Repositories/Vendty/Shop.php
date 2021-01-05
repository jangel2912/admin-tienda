<?php

namespace App\Repositories\Vendty;

use App\Models\Vendty\Shop as ShopModel;
use App\Repositories\Abstracts\Repository;
use Illuminate\Support\Facades\Cache;

/**
 * Class Shop
 * @package App\Repositories\Vendty
 */
class Shop extends Repository
{
    /**
     * @var string
     */
    protected $table = 'tienda';

    /**
     * @return ShopModel
     */
    public function get()
    {
        return Cache::remember("{$this->key}.{$this->table}", $this->time, function () {
            return auth_user()->shop;
        });
    }

    /**
     * @param array $data
     * @return bool
     */
    public function update(array $data)
    {
        $shop = auth_user()->shop;

        foreach ($data as $attribute => $value) {
            $shop->$attribute = $value;
        }

        if ($shop->save()) {
            return Cache::put("{$this->key}.{$this->table}", $shop, $this->time);
        }

        return false;
    }
}
