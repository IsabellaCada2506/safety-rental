<?php

/**
 * Author: Wendy Atehortua
 * Date: 2026-11-06
 * Description: Contract for generating and streaming confirmed reservations reports in different formats.
 */

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\Response;

interface ReportGenerator
{
    /**
     * Generate and return an HTTP response with the reservations report.
     *
     * @param  array<string, mixed>  $metadata
     */
    public function generate(Collection $reservations, array $metadata = []): Response;
}
