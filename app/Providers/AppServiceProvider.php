<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Service provider registering application services and dependency injection interfaces.
 */

namespace App\Providers;

use App\Interfaces\CarServiceInterface;
use App\Interfaces\CategoryServiceInterface;
use App\Interfaces\LocationReferenceCheckerInterface;
use App\Interfaces\LocationServiceInterface;
use App\Interfaces\ReservationCodeGeneratorInterface;
use App\Interfaces\ReservationPricingInterface;
use App\Interfaces\ReservationServiceInterface;
use App\Interfaces\UserServiceInterface;
use App\Services\CarService;
use App\Services\CategoryService;
use App\Services\LocationService;
use App\Services\ReservationService;
use App\Services\UserService;
use App\Utils\LocationReferenceChecker;
use App\Utils\ReservationCodeGenerator;
use App\Utils\ReservationPricingUtil;
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
        $this->app->bind(LocationReferenceCheckerInterface::class, LocationReferenceChecker::class);
        $this->app->bind(LocationServiceInterface::class, LocationService::class);
        $this->app->bind(ReservationCodeGeneratorInterface::class, ReservationCodeGenerator::class);
        $this->app->bind(ReservationPricingInterface::class, ReservationPricingUtil::class);
        $this->app->bind(ReservationServiceInterface::class, ReservationService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
