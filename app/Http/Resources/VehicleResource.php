<?php

namespace App\Http\Resources;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var Car $car */
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
