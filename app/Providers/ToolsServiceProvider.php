<?php

namespace App\Providers;

use App\Tools\Domain;
use Illuminate\Support\ServiceProvider;
use App\Tools\Password;

class ToolsServiceProvider extends ServiceProvider
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
        $this->app->singleton('tool.domain', function () {
            return new Domain;
        });

        $this->app->singleton('tools.password', function () {
            return new Password;
        });
    }
}
