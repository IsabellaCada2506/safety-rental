<?php

namespace App\Http\Controllers\User;

use App\Http\Clients\GoogleMapsRoutesClient;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\CalculatePickupRouteRequest;
use App\Models\Car;
use Illuminate\View\View;

class PickupRouteController extends Controller
{
    public function index(int $id): View
    {
        $car = Car::query()
            ->with(['category', 'location'])
            ->where('status', Car::STATUS_ACTIVE)
            ->findOrFail($id);

        $viewData = [
            'title' => __('integrations.pickup_route'),
            'car' => $car,
            'result' => null,
            'originData' => [],
        ];

        return view('user.pickupRoute.index')
            ->with('viewData', $viewData);
    }

    public function calculate(
        CalculatePickupRouteRequest $request,
        int $id,
        GoogleMapsRoutesClient $googleMapsRoutesClient
    ): View {
        $car = Car::query()
            ->with(['category', 'location'])
            ->where('status', Car::STATUS_ACTIVE)
            ->findOrFail($id);

        $originData = $request->validated();

        $viewData = [
            'title' => __('integrations.pickup_route'),
            'car' => $car,
            'originData' => $originData,
            'result' => $googleMapsRoutesClient->calculate(
                $originData,
                $car->getLocation(),
                app()->getLocale()
            ),
        ];

        return view('user.pickupRoute.index')
            ->with('viewData', $viewData);
    }
}