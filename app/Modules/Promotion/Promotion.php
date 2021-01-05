<?php

namespace App\Modules\Promotion;

use App\Models\Shop\Promotion\Description;
use App\Models\Shop\Promotion\Product;
use App\Models\Shop\Promotion\Promotion as PromotionModel;
use App\Models\Shop\Promotion\Warehouse;
use Illuminate\Support\Collection;

/**
 * Class Promotion
 * @package App\Modules\Promotion
 */
class Promotion
{
    /**
     * @var PromotionModel
     */
    protected $promotion;

    /**
     * Promotion constructor.
     * @param PromotionModel $promotion
     */
    public function __construct(PromotionModel $promotion)
    {
        $this->promotion = $promotion;
    }

    /**
     * @param array $request
     * @return PromotionModel|null
     */
    public function create(array $request)
    {
        $this->promotion->nombre = $request['name'];
        $this->promotion->dias = collect($request['days'])->implode(',');
        $this->promotion->fecha_inicial = $request['start_date'];
        $this->promotion->hora_inicio = $request['start_time'];
        $this->promotion->fecha_final = $request['final_date'];
        $this->promotion->hora_fin = $request['final_time'];
        $this->promotion->activo = true;

        if ($this->promotion->save()) {
            $this->addWarehouse();
            $this->addProducts(collect($request['products']), $this->promotion->id);
            $this->addRules(collect($request['rules']), $this->promotion->id);

            return $this->promotion;
        }

        return null;
    }

    /**
     * @return Warehouse|null
     */
    private function addWarehouse()
    {
        $warehouse = new Warehouse;
        $warehouse->id_promocion = $this->promotion->id;

        if ($warehouse->save()) {
            return $warehouse;
        }

        return null;
    }

    /**
     * @param Collection $products
     * @param int $promotion
     * @return Collection
     */
    private function addProducts(Collection $products, int $promotion)
    {
        $savedProducts = collect([]);

        $products->each(function ($product) use ($promotion, $savedProducts) {
            $productPromotionModel = new Product;
            $productPromotionModel->id_promocion = $promotion;
            $productPromotionModel->id_producto = $product['id'];

            if ($productPromotionModel->save()) {
                $savedProducts->push($productPromotionModel);
            }
        });

        return $savedProducts;
    }

    /**
     * @param Collection $rules
     * @param int $promotion
     * @return Collection
     */
    private function addRules(Collection $rules, int $promotion)
    {
        $savedRules = collect([]);

        $rules->each(function ($rule, $key) use ($promotion, $savedRules) {
            $descriptionModel = new Description;
            $descriptionModel->id_promocion = $promotion;
            $descriptionModel->item = $key;
            $descriptionModel->qty = $rule['qty'];
            $descriptionModel->discount_percent = $rule['percent'];

            if ($descriptionModel->save()) {
                $savedRules->push($descriptionModel);
            }
        });

        return $savedRules;
    }
}
