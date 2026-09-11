<?php

/**
 * Author: Wendy Atehortua
 * Date: 2026-09-09
 * Description: Controller for the car rental catalog, listing active vehicles and showing individual details.
 */

namespace App\Http\Controllers;

use App\Services\Contracts\CarServiceInterface;
use Illuminate\View\View;

class CatalogController extends Controller
{
    private readonly CarServiceInterface $carService;

    public function __construct(CarServiceInterface $carService)
    {
        $this->carService = $carService;
    }

    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = __('catalog.title_index');
        $viewData['cars'] = $this->carService->getActiveCarsWithCategory();

        return view('catalog.index')->with('viewData', $viewData);
    }

    public function show(int $id): View
    {
        $car = $this->carService->findActiveWithCategoryOrFail($id);

        $viewData = [];
        $viewData['title'] = __('catalog.title_show');
        $viewData['car'] = $car;

        return view('catalog.show')->with('viewData', $viewData);
    }
}
