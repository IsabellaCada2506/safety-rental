<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-11-03
 * Description: Controller for displaying a single active vehicle detail for external integrations.
 */

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\View\View;

class VehicleController extends Controller
{
    public function show(int $id): View
    {
        $car = Car::query()->with(['category', 'location'])->where('status', Car::STATUS_ACTIVE)->findOrFail($id);
        $viewData = ['title' => __('catalog.title_show'), 'car' => $car];

        return view('user.vehicle.show')->with('viewData', $viewData);
    }
}
