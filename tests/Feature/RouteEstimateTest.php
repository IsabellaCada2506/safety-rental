<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-11-09
 * Description: Feature tests for Google Maps Routes driving estimates to rental branches.
 */

namespace Tests\Feature;

use App\Models\Car;
use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class RouteEstimateTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_route_estimate_shows_distance_and_duration_from_google_routes(): void
    {
        config([
            'services.google.maps_api_key' => 'test-maps-key',
            'services.google.routes_url' => 'https://routes.googleapis.com/directions/v2:computeRoutes',
        ]);

        Http::fake([
            'https://routes.googleapis.com/directions/v2:computeRoutes' => Http::response([
                'routes' => [
                    [
                        'distanceMeters' => 18500,
                        'duration' => '1620s',
                    ],
                ],
            ], 200),
        ]);

        $location = Location::query()->firstOrFail();

        $response = $this->actingAs($this->customer())->get(route('route-estimates.show', [
            'location_id' => $location->getId(),
            'origin_latitude' => 6.2442,
            'origin_longitude' => -75.5812,
        ]));

        $response->assertOk();
        $response->assertSee($location->getName());
        $response->assertSee(__('maps.distance_value', ['value' => '18,5']));
        $response->assertSee(__('maps.duration_value', ['value' => 27]));
        $response->assertDontSee('test-maps-key');
        Http::assertSentCount(1);
    }

    public function test_route_estimate_shows_a_translated_message_when_the_api_key_is_missing(): void
    {
        config(['services.google.maps_api_key' => '']);

        $location = Location::query()->firstOrFail();

        $response = $this->actingAs($this->customer())->get(route('route-estimates.show', [
            'location_id' => $location->getId(),
            'origin_latitude' => 6.2442,
            'origin_longitude' => -75.5812,
        ]));

        $response->assertOk();
        $response->assertSee(__('maps.error_missing_config'));
        Http::assertNothingSent();
    }

    public function test_route_estimate_shows_a_translated_message_when_google_times_out(): void
    {
        config([
            'services.google.maps_api_key' => 'test-maps-key',
            'services.google.routes_url' => 'https://routes.googleapis.com/directions/v2:computeRoutes',
        ]);

        Http::fake(function (): never {
            throw new ConnectionException('cURL error 28: Operation timed out');
        });

        $location = Location::query()->firstOrFail();

        $response = $this->actingAs($this->customer())->get(route('route-estimates.show', [
            'location_id' => $location->getId(),
            'origin_latitude' => 6.2442,
            'origin_longitude' => -75.5812,
        ]));

        $response->assertOk();
        $response->assertSee(__('maps.error_timeout'));
    }

    public function test_catalog_detail_does_not_expose_the_google_maps_api_key(): void
    {
        config(['services.google.maps_api_key' => 'secret-frontend-key']);

        $carId = Car::query()->where('status', Car::STATUS_ACTIVE)->value('id');

        $response = $this->actingAs($this->customer())->get(route('catalog.show', ['id' => $carId]));

        $response->assertOk();
        $response->assertDontSee('secret-frontend-key');
        $response->assertDontSee('GOOGLE_MAPS_API_KEY');
    }

    private function customer(): User
    {
        return User::query()->where('role', User::ROLE_CUSTOMER)->firstOrFail();
    }
}
