<?php

/**
 * Author: Wendy
 * Date: 09/09/2026
 * Description: Admin controller for managing cars in the inventory.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCarRequest;
use App\Http\Requests\Admin\UpdateCarRequest;
use App\Models\Car;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class CarController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = __('car.title_index');
        $viewData['cars'] = Car::all();

        return view('admin.car.index')->with('viewData', $viewData);
    }

    public function create(): View
    {
        $viewData = [];
        $viewData['title'] = __('car.title_create');

        return view('admin.car.create')->with('viewData', $viewData);
    }

    public function store(StoreCarRequest $request): RedirectResponse
    {
        $car = new Car();
        $car->setPlate((string) $request->input('plate'));
        $car->setColor((string) $request->input('color'));
        $car->setSoat((string) $request->input('soat'));
        $car->setTransitLicense((string) $request->input('transit_license'));
        $car->setPrice((int) $request->input('price'));
        $car->setMileage((int) $request->input('mileage'));
        $car->setImage((string) $request->input('image'));
        $car->setDescription((string) $request->input('description'));
        $car->setStatus('Active');
        $car->save();

        return redirect()->route('admin.car.index')->with('success', __('car.created_success'));
    }

    public function edit(int $id): View
    {
        $car = Car::findOrFail($id);

        $viewData = [];
        $viewData['car'] = $car;

        return view('admin.car.edit')->with('viewData', $viewData);
    }

    public function update(UpdateCarRequest $request, int $id): RedirectResponse
    {
        $car = Car::findOrFail($id);
        $car->setPlate((string) $request->input('plate'));
        $car->setColor((string) $request->input('color'));
        $car->setSoat((string) $request->input('soat'));
        $car->setPrice((int) $request->input('price'));
        $car->setTransitLicense((string) $request->input('transit_license'));
        $car->setDescription((string) $request->input('description'));
        $car->setMileage((int) $request->input('mileage'));
        $car->setImage((string) $request->input('image'));
        $car->save();

        return redirect()->route('admin.car.index')->with('success', __('car.updated_success'));
    }

    public function deactivate(int $id): RedirectResponse
    {
        $car = Car::findOrFail($id);

        if ($car->getStatus() === 'Active') {
            if (Schema::hasTable('reservations') || Schema::hasTable('reserves')) {
                $tableName = Schema::hasTable('reservations') ? 'reservations' : 'reserves';
                $hasActiveReservations = DB::table($tableName)
                    ->where('car_id', $car->getId())
                    ->where('end_date', '>=', now()->toDateString())
                    ->exists();

                if ($hasActiveReservations) {
                    return back()->with('error', __('car.deactivate_error_reservations'));
                }
            }

            $car->setStatus('Deactivated');
            $car->save();

            return redirect()->route('admin.car.index')->with('success', __('car.deactivated_success'));
        } else {
            $car->setStatus('Active');
            $car->save();

            return redirect()->route('admin.car.index')->with('success', __('car.activated_success'));
        }
    }

    public function delete(int $id): RedirectResponse
    {
        $car = Car::findOrFail($id);
        $car->delete();

        return redirect()->route('admin.car.index');
    }
}