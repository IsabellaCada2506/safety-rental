<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-09-12
 * Description: Admin controller for reservation and payment operational metrics.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FilterAdminMetricsRequest;
use App\Interfaces\AdminMetricsServiceInterface;
use Illuminate\View\View;

class MetricsController extends Controller
{
    private readonly AdminMetricsServiceInterface $adminMetricsService;

    public function __construct(AdminMetricsServiceInterface $adminMetricsService)
    {
        $this->adminMetricsService = $adminMetricsService;
    }

    public function index(FilterAdminMetricsRequest $request): View
    {
        $validatedData = $request->validated();
        $startDate = $validatedData['start_date'] ?? null;
        $endDate = $validatedData['end_date'] ?? null;
        $metrics = $this->adminMetricsService->getMetrics($startDate, $endDate);

        $viewData = [];
        $viewData['title'] = __('metrics.admin_title');
        $viewData['reservationCounts'] = $metrics['reservationCounts'];
        $viewData['completedAmount'] = $metrics['completedAmount'];
        $viewData['failedAmount'] = $metrics['failedAmount'];
        $viewData['refundedAmount'] = $metrics['refundedAmount'];
        $viewData['netSuccessfulAmount'] = $metrics['netSuccessfulAmount'];
        $viewData['hasActivity'] = $metrics['hasActivity'];
        $viewData['startDate'] = $startDate;
        $viewData['endDate'] = $endDate;

        return view('admin.metrics.index')->with('viewData', $viewData);
    }
}
