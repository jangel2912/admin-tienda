<?php

namespace App\Repositories\Temp;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * Class ProductsImport
 * @package App\Repositories\Temp
 */
class ProductsImport
{
    /**
     * @var string
     */
    protected $key = 'temp.products.import';

    /**
     * @var int
     */
    protected $time = 300;

    /**
     * @param array $product
     * @return bool
     */
    public function put(array $product): bool
    {
        $products = collect([]);

        if (Cache::has($this->key)) {
            $products = Cache::get($this->key);
        }

        $products->push($product);

        return Cache::put($this->key, $products, $this->time);
    }

    /**
     * @return Collection|null
     */
    public function get()
    {
        return Cache::get($this->key);
    }

    /**
     * @return bool
     */
    public function clear(): bool
    {
        return Cache::forget($this->key);
    }
}
