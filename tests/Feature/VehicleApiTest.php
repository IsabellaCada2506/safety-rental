<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-11-09
 * Description: Feature tests for the public JSON catalog of available vehicles.
 */

namespace Tests\Feature;

use App\Models\Car;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VehicleApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_vehicles_endpoint_returns_available_cars_as_json(): void
    {
        $this->seed();

        $deactivatedCar = Car::factory()->create([
            'status' => Car::STATUS_DEACTIVATED,
            'category_id' => Category::query()->first()?->getId(),
            'location_id' => Location::query()->first()?->getId(),
        ]);

        $response = $this->getJson(route('api.vehicles.index'));

        $response->assertOk();
        $response->assertJsonStructure([
            'vehicles' => [
                '*' => [
                    'id',
                    'make',
                    'model',
                    'category',
                    'location',
                    'daily_rate',
                    'availability',
                    'detail_url',
                ],
            ],
        ]);

        $vehicleIds = [];
        foreach ($response->json('vehicles') as $vehicle) {
            $vehicleIds[] = $vehicle['id'];
            $this->assertSame('available', $vehicle['availability']);
            $this->assertNotEmpty($vehicle['detail_url']);
        }

        $this->assertNotContains($deactivatedCar->getId(), $vehicleIds);
        $this->assertNotEmpty($vehicleIds);
    }

    public function test_public_vehicle_detail_endpoint_returns_a_single_available_car(): void
    {
        $this->seed();

        $car = Car::query()
            ->with(['category', 'location'])
            ->where('status', Car::STATUS_ACTIVE)
            ->firstOrFail();

        $response = $this->getJson(route('api.vehicles.show', ['id' => $car->getId()]));

        $response->assertOk();
        $response->assertJsonPath('vehicle.id', $car->getId());
        $response->assertJsonPath('vehicle.make', $car->getCategory()?->getBrand());
        $response->assertJsonPath('vehicle.model', $car->getCategory()?->getModel());
        $response->assertJsonPath('vehicle.availability', 'available');
    }

    public function test_public_vehicle_detail_endpoint_returns_not_found_for_missing_cars(): void
    {
        $response = $this->getJson(route('api.vehicles.show', ['id' => 999999]));

        $response->assertNotFound();
    }
}
