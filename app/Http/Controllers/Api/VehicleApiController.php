<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VehicleResource;
use App\Models\Car;
use Illuminate\Http\JsonResponse;

class VehicleApiController extends Controller
{
    public function index(): JsonResponse
    {
        $cars = Car::availableForPublicFeed();

        return response()->json([
            'data' => VehicleResource::collection($cars)->resolve(),
            'availability_basis' => 'today',
        ]);
    }
}
