<?php

/**
 * Author: Isabella Ocampo
 * Author: Alejandro Correa Marin
 * Date: 2026-09-12
 * Description: Service provider registering application services and dependency injection interfaces.
 */

namespace App\Providers;

use Barryvdh\DomPDF\PDF;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PDF::class, function (Application $app): PDF {
            return $app->make('dompdf.wrapper');
        });
    }

    public function boot(): void {}
}
