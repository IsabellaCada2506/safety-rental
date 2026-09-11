<?php

namespace App\Providers;

use App\Services\CarService;
use App\Services\CategoryService;
use App\Services\Contracts\CarServiceInterface;
use App\Services\Contracts\CategoryServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CarServiceInterface::class, CarService::class);
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
