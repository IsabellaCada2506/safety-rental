<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-09-12
 * Description: Contract for administrator reservation and payment metrics.
 */

namespace App\Interfaces;

interface AdminMetricsServiceInterface
{
    /**
     * @return array{
     *     reservationCounts: array<string, int>,
     *     completedAmount: float,
     *     failedAmount: float,
     *     refundedAmount: float,
     *     netSuccessfulAmount: float,
     *     hasActivity: bool
     * }
     */
    public function getMetrics(?string $startDate = null, ?string $endDate = null): array;
}
