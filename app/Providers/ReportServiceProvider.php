<?php

/**
 * Author: Isabella Ocampo
 * Author: Wendy Atehortua
 * Date: 2026-11-10
 * Description: Service provider registering ReportGenerator interface binding and report dependencies.
 */

namespace App\Providers;

use App\Interfaces\ReportGenerator;
use App\Utils\ExcelReportGenerator;
use App\Utils\PdfReportGenerator;
use Barryvdh\DomPDF\PDF;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class ReportServiceProvider extends ServiceProvider
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
