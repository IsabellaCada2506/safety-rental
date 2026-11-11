<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-11-04
 * Description: API resource transformer for the Car model exposed through the public vehicle feed.
 */

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $car = $this->resource;

        return [
            'id' => $car->getId(),
            'make' => $car->getCategory()?->getBrand(),
            'model' => $car->getCategory()?->getModel(),
            'category' => $car->getCategory()?->getType(),
            'location' => [
                'name' => $car->getLocation()?->getName(),
                'city' => $car->getLocation()?->getCity(),
                'address' => $car->getLocation()?->getAddress(),
            ],
            'daily_rate' => $car->getPrice(),
            'currency' => 'COP',
            'availability' => true,
            'detail_url' => route('vehicles.show', ['id' => $car->getId()]),
        ];
    }
}
