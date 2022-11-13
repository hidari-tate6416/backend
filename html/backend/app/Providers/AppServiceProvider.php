<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\AppService;
use App\Services\ItoService;
use App\Services\InsiderService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('AppService', AppService::class);
        $this->app->singleton('ItoService', ItoService::class);
        $this->app->singleton('InsiderService', InsiderService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
