<?php

/**
 * Author: Wendy Atehortua
 * Date: 2026-09-11
 * Description: Controller for the car rental catalog, providing vehicle search, filtering, and detail views.
 */

namespace App\Http\Controllers;

use App\Http\Requests\FilterCarsRequest;
use App\Interfaces\CarServiceInterface;
use App\Interfaces\CategoryServiceInterface;
use App\Interfaces\LocationServiceInterface;
use Illuminate\View\View;

class CatalogController extends Controller
{
    private readonly CarServiceInterface $carService;

    private readonly CategoryServiceInterface $categoryService;

    private readonly LocationServiceInterface $locationService;

    public function __construct(
        CarServiceInterface $carService,
        CategoryServiceInterface $categoryService,
        LocationServiceInterface $locationService
    ) {
        $this->carService = $carService;
        $this->categoryService = $categoryService;
        $this->locationService = $locationService;
    }

    public function index(FilterCarsRequest $request): View
    {
        $filters = $request->validated();

        $viewData = [];
        $viewData['title'] = __('catalog.title_index');
        $viewData['cars'] = $this->carService->searchAndFilter($filters);
        $viewData['categories'] = $this->categoryService->getAll();
        $viewData['locations'] = $this->locationService->getAll();
        $viewData['filters'] = $filters;

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
