<?php

/**
 * Author: Wendy Atehortua
 * Date: 2026-09-13
 * Description: Admin controller for managing cars in the inventory with category and branch location associations.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCarRequest;
use App\Http\Requests\Admin\UpdateCarRequest;
use App\Models\Car;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CarController extends Controller
{
    public function index(): View
    {
        $cars = Car::query()->with(['category', 'location'])
            ->orderBy('id', 'desc')
            ->get();

        $viewData = [];
        $viewData['title'] = __('car.title_index');
        $viewData['cars'] = $cars;

        return view('admin.car.index')->with('viewData', $viewData);
    }

    public function create(): View
    {
        $viewData = [];
        $viewData['title'] = __('car.title_create');
        $viewData['categories'] = Category::query()->orderBy('brand')->orderBy('model')->get();
        $viewData['locations'] = Location::query()->orderBy('name')->get();

        return view('admin.car.create')->with('viewData', $viewData);
    }

    public function store(StoreCarRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        $car = new Car;
        $car->setPlate((string) $validatedData['plate']);
        $car->setColor((string) $validatedData['color']);
        if (isset($validatedData['soat'])) {
            $car->setSoat((string) $validatedData['soat']);
        }
        if (isset($validatedData['transit_license'])) {
            $car->setTransitLicense((string) $validatedData['transit_license']);
        }
        $car->setPrice((int) $validatedData['price']);
        $car->setMileage((int) $validatedData['mileage']);
        $car->setImage($validatedData['image'] ?? null);
        $car->setDescription($validatedData['description'] ?? null);
        $car->setStatus(Car::STATUS_ACTIVE);
        $car->setCategoryId((int) $validatedData['category_id']);
        if (isset($validatedData['location_id'])) {
            $car->setLocationId((int) $validatedData['location_id']);
        }
        $car->save();

        return redirect()->route('admin.car.index')->with('success', __('car.created_success'));
    }

    public function edit(int $id): View
    {
        $car = Car::query()->with(['category', 'location'])->findOrFail($id);

        $viewData = [];
        $viewData['title'] = __('car.title_edit');
        $viewData['car'] = $car;
        $viewData['categories'] = Category::query()->orderBy('brand')->orderBy('model')->get();
        $viewData['locations'] = Location::query()->orderBy('name')->get();

        return view('admin.car.edit')->with('viewData', $viewData);
    }

    public function update(UpdateCarRequest $request, int $id): RedirectResponse
    {
        $car = Car::query()->findOrFail($id);
        $validatedData = $request->validated();

        $car->setPlate((string) $validatedData['plate']);
        $car->setColor((string) $validatedData['color']);
        if (isset($validatedData['soat'])) {
            $car->setSoat((string) $validatedData['soat']);
        }
        if (isset($validatedData['transit_license'])) {
            $car->setTransitLicense((string) $validatedData['transit_license']);
        }
        $car->setPrice((int) $validatedData['price']);
        $car->setMileage((int) $validatedData['mileage']);
        $car->setImage($validatedData['image'] ?? null);
        $car->setDescription($validatedData['description'] ?? null);
        $car->setCategoryId((int) $validatedData['category_id']);
        if (isset($validatedData['location_id'])) {
            $car->setLocationId((int) $validatedData['location_id']);
        }
        $car->save();

        return redirect()->route('admin.car.index')->with('success', __('car.updated_success'));
    }

    public function deactivate(int $id): RedirectResponse
    {
        $car = Car::query()->findOrFail($id);
        $car->setStatus($car->isActive() ? Car::STATUS_DEACTIVATED : Car::STATUS_ACTIVE);
        $car->save();

        return redirect()->route('admin.car.index')->with('success', __('car.status_updated_success'));
    }
}
