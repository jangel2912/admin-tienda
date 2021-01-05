<?php

namespace App\Presenters\Abstracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

/**
 * Class Presenter
 * @package App\Presenters
 */
abstract class Presenter
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * Presenter constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function status()
    {
        if ($this->model->activo) {
            return new HtmlString('<span class="label label-success">Activo</span>');
        }

        return new HtmlString('<span class="label label-danger">Inactivo</span>');
    }
}
