<?php

/**
 * Author: Wendy Atehortua
 * Date: 2026-09-11
 * Description: Admin controller for managing cars in the inventory with category and branch location associations.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCarRequest;
use App\Http\Requests\Admin\UpdateCarRequest;
use App\Interfaces\CarServiceInterface;
use App\Interfaces\CategoryServiceInterface;
use App\Interfaces\LocationServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CarController extends Controller
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

    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = __('car.title_index');
        $viewData['cars'] = $this->carService->getAll();

        return view('admin.car.index')->with('viewData', $viewData);
    }

    public function create(): View
    {
        $viewData = [];
        $viewData['title'] = __('car.title_create');
        $viewData['categories'] = $this->categoryService->getAll();
        $viewData['locations'] = $this->locationService->getAll();

        return view('admin.car.create')->with('viewData', $viewData);
    }

    public function store(StoreCarRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        $this->carService->createFromValidated($validatedData);

        return redirect()->route('admin.car.index')->with('success', __('car.created_success'));
    }

    public function edit(int $id): View
    {
        $car = $this->carService->findOrFail($id);

        $viewData = [];
        $viewData['title'] = __('car.title_edit');
        $viewData['car'] = $car;
        $viewData['categories'] = $this->categoryService->getAll();
        $viewData['locations'] = $this->locationService->getAll();

        return view('admin.car.edit')->with('viewData', $viewData);
    }

    public function update(UpdateCarRequest $request, int $id): RedirectResponse
    {
        $car = $this->carService->findOrFail($id);
        $validatedData = $request->validated();

        $this->carService->updateFromValidated($car, $validatedData);

        return redirect()->route('admin.car.index')->with('success', __('car.updated_success'));
    }

    public function deactivate(int $id): RedirectResponse
    {
        $car = $this->carService->findOrFail($id);

        $updatedCar = $this->carService->toggleStatus($car);

        $successMessage = $updatedCar->isActive()
            ? __('car.activated_success')
            : __('car.deactivated_success');

        return redirect()->route('admin.car.index')->with('success', $successMessage);
    }
}
