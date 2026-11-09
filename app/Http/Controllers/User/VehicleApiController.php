<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-11-09
 * Description: Public JSON API controller exposing available vehicles for consumption by other teams.
 */

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\JsonResponse;

class VehicleApiController extends Controller
{
    public function index(): JsonResponse
    {
        $cars = Car::listAvailableForPublicApi();
        $vehicles = [];

        foreach ($cars as $car) {
            $vehicles[] = $car->toPublicApiArray();
        }

        return response()->json([
            'vehicles' => $vehicles,
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $car = Car::query()
            ->with(['category', 'location'])
            ->where('status', Car::STATUS_ACTIVE)
            ->find($id);

        if ($car === null) {
            return response()->json([
                'message' => 'Vehicle not found.',
            ], 404);
        }

        return response()->json([
            'vehicle' => $car->toPublicApiArray(),
        ]);
    }
}
