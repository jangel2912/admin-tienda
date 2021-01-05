<?php

namespace App\Presenters;

use App\Presenters\Abstracts\Presenter;
use Illuminate\Support\HtmlString;

/**
 * Class Product
 * @package App\Presenters
 */
class Product extends Presenter
{
    /**
     * @return string
     */
    public function price()
    {
        return amount_format($this->model->precio_venta);
    }

    /**
     * @return HtmlString|string
     */
    public function featured()
    {
        if ($this->model->destacado_tienda) {
            return new HtmlString('<span class="label label-success">Destacado</span>');
        }

        return '';
    }

    /**
     * @return HtmlString|string
     */
    public function sellWithoutStock()
    {
        if ($this->model->vendernegativo) {
            return new HtmlString('<span class="label label-success">Activado</span>');
        }

        return '';
    }

    /**
     * @return HtmlString|string
     */
    public function showStock()
    {
        if ($this->model->mostrar_stock) {
            return new HtmlString('<span class="label label-success">Activado</span>');
        }

        return '';
    }
}
