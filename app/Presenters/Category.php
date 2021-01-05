<?php

namespace App\Presenters;

use App\Presenters\Abstracts\Presenter;
use Illuminate\Support\HtmlString;

/**
 * Class Category
 * @package App\Presenters
 */
class Category extends Presenter
{

    /**
     * @return HtmlString|string
     */
    public function subcategories()
    {
        if (count($this->model->subcategories) > 0) {
            return new HtmlString('<span class="label label-success">Si</span>');
        }

        return new HtmlString('<span class="label label-danger">No</span>');
    }

    /**
     * @return HtmlString|string
     */
    public function sub_subcategories()
    {
        $sub_subcategories = false;

        foreach ($this->model->subcategories as $subcategory) {
            if (count($subcategory->subcategories) > 0) {
                $sub_subcategories = true;
            }
        }

        if ($sub_subcategories) {
            return new HtmlString('<span class="label label-success">Si</span>');
        }

        return new HtmlString('<span class="label label-danger">No</span>');
    }
}
