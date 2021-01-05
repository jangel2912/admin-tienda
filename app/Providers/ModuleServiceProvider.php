<?php

namespace App\Providers;

use App\Models\Shop\Promotion\Promotion as PromotionModel;
use App\Modules\Promotion\Promotion;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('module.promotion', function () {
            $promotion = new PromotionModel;
            return new Promotion($promotion);
        });
    }
}
