<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-09-12
 * Description: Admin controller for displaying the top three most rented cars.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FilterCarRankingRequest;
use App\Interfaces\CarRankingServiceInterface;
use Illuminate\View\View;

class CarRankingController extends Controller
{
    private readonly CarRankingServiceInterface $carRankingService;

    public function __construct(CarRankingServiceInterface $carRankingService)
    {
        $this->carRankingService = $carRankingService;
    }

    public function index(FilterCarRankingRequest $request): View
    {
        $validatedData = $request->validated();
        $startDate = $validatedData['start_date'] ?? null;
        $endDate = $validatedData['end_date'] ?? null;

        $viewData = [];
        $viewData['title'] = __('ranking.admin_title');
        $viewData['rankings'] = $this->carRankingService->getTopCars($startDate, $endDate);
        $viewData['startDate'] = $startDate;
        $viewData['endDate'] = $endDate;

        return view('admin.carranking.index')->with('viewData', $viewData);
    }
}
