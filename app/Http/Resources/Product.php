<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Product
 * @package App\Http\Resources
 * @property-read integer $id
 * @property-read string $nombre
 * @property-read string $descripcion
 * @property-read string $descripcion_larga
 * @property-read boolean $destacado_tienda
 */
class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $product = !is_null($this->product) ? $this->product : $this;

        return [
            'id' => $product->id,
            'name' => $product->nombre,
        ];
    }
}
