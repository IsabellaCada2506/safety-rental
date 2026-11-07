<?php

/**
 * Author: Isabella Ocampo
 * Author: Alejandro Correa Marin
 * Date: 2026-09-12
 * Description: Service provider registering application services and dependency injection interfaces.
 */

namespace App\Providers;

use App\Interfaces\ReportGenerator;
use App\Reports\ExcelReportGenerator;
use App\Reports\PdfReportGenerator;
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

        $this->app->bind(ReportGenerator::class, function (Application $app): ReportGenerator {
            $format = strtolower((string) request()->query('format', 'pdf'));

            if ($format === 'excel' || $format === 'xlsx') {
                return $app->make(ExcelReportGenerator::class);
            }

            return $app->make(PdfReportGenerator::class);
        });
    }

    public function boot(): void {}
}
