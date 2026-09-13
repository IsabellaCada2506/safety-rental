<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Feature test suite covering car search, category, location, and date availability filters.
 */

namespace Tests\Feature;

use App\Models\Car;
use App\Models\Category;
use App\Models\Location;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarSearchFilterTest extends TestCase
{
    use RefreshDatabase;

    private User $customer;

    private Location $medellinLocation;

    private Location $rionegroLocation;

    private Category $suvCategory;

    private Category $sedanCategory;

    private Car $suvCar;

    private Car $sedanCar;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->customer = User::query()->where('role', User::ROLE_CUSTOMER)->first();
        $this->medellinLocation = Location::query()->where('city', 'Medellín')->first();
        $this->rionegroLocation = Location::query()->where('city', 'Rionegro')->first() ?? $this->medellinLocation;

        $this->suvCategory = Category::query()->where('type', 'SUV')->first() ?? Category::first();
        $this->sedanCategory = Category::query()->where('type', 'Sedan')->first() ?? Category::all()->last();

        $this->suvCar = Car::query()->where('category_id', $this->suvCategory->getId())->first();
        if ($this->suvCar) {
            $this->suvCar->setLocationId($this->medellinLocation->getId());
            $this->suvCar->save();
        }

        $this->sedanCar = Car::query()->where('category_id', $this->sedanCategory->getId())->first();
        if ($this->sedanCar) {
            $this->sedanCar->setLocationId($this->rionegroLocation->getId());
            $this->sedanCar->save();
        }
    }

    public function test_can_filter_cars_by_category(): void
    {
        $response = $this->actingAs($this->customer)->get(route('catalog.index', [
            'category_id' => $this->suvCategory->getId(),
        ]));

        $response->assertStatus(200);
        $viewData = $response->viewData('viewData');
        $this->assertNotEmpty($viewData['cars']);

        foreach ($viewData['cars'] as $car) {
            $this->assertSame($this->suvCategory->getId(), $car->getCategoryId());
        }
    }

    public function test_can_filter_cars_by_category_and_location(): void
    {
        $response = $this->actingAs($this->customer)->get(route('catalog.index', [
            'category_id' => $this->suvCategory->getId(),
            'location_id' => $this->medellinLocation->getId(),
        ]));

        $response->assertStatus(200);
        $viewData = $response->viewData('viewData');

        foreach ($viewData['cars'] as $car) {
            $this->assertSame($this->suvCategory->getId(), $car->getCategoryId());
            $this->assertSame($this->medellinLocation->getId(), $car->getLocationId());
        }
    }

    public function test_can_search_cars_by_text_query(): void
    {
        $plate = $this->suvCar->getPlate();

        $response = $this->actingAs($this->customer)->get(route('catalog.index', [
            'search' => $plate,
        ]));

        $response->assertStatus(200);
        $viewData = $response->viewData('viewData');
        $this->assertTrue($viewData['cars']->contains('id', $this->suvCar->getId()));
    }

    public function test_excludes_cars_with_overlapping_pending_or_confirmed_reservations(): void
    {
        $startDate = Carbon::now()->addDays(30)->toDateString();
        $endDate = Carbon::now()->addDays(35)->toDateString();

        // Create confirmed reservation on SUV car
        $reservation = new Reservation;
        $reservation->setCode(99881122);
        $reservation->setState(Reservation::STATE_CONFIRMED);
        $reservation->setStartDate($startDate);
        $reservation->setEndDate($endDate);
        $reservation->setUserId($this->customer->getId());
        $reservation->setCarId($this->suvCar->getId());
        $reservation->setLocationId($this->medellinLocation->getId());
        $reservation->save();

        // Search within overlapping dates
        $response = $this->actingAs($this->customer)->get(route('catalog.index', [
            'start_date' => Carbon::now()->addDays(32)->toDateString(),
            'end_date' => Carbon::now()->addDays(34)->toDateString(),
        ]));

        $response->assertStatus(200);
        $viewData = $response->viewData('viewData');
        $this->assertFalse(
            $viewData['cars']->contains('id', $this->suvCar->getId()),
            'Car with overlapping confirmed reservation must be excluded.'
        );
    }

    public function test_includes_cars_when_reservation_is_cancelled(): void
    {
        $startDate = Carbon::now()->addDays(40)->toDateString();
        $endDate = Carbon::now()->addDays(45)->toDateString();

        // Create cancelled reservation on Sedan car
        $reservation = new Reservation;
        $reservation->setCode(99881133);
        $reservation->setState(Reservation::STATE_CANCELLED);
        $reservation->setStartDate($startDate);
        $reservation->setEndDate($endDate);
        $reservation->setUserId($this->customer->getId());
        $reservation->setCarId($this->sedanCar->getId());
        $reservation->setLocationId($this->rionegroLocation->getId());
        $reservation->save();

        // Search within same dates
        $response = $this->actingAs($this->customer)->get(route('catalog.index', [
            'start_date' => Carbon::now()->addDays(41)->toDateString(),
            'end_date' => Carbon::now()->addDays(43)->toDateString(),
            'category_id' => $this->sedanCategory->getId(),
        ]));

        $response->assertStatus(200);
        $viewData = $response->viewData('viewData');
        $this->assertTrue(
            $viewData['cars']->contains('id', $this->sedanCar->getId()),
            'Car with cancelled reservation must be included.'
        );
    }

    public function test_returns_empty_state_when_no_cars_match(): void
    {
        $response = $this->actingAs($this->customer)->get(route('catalog.index', [
            'search' => 'NONEXISTENT_VEHICLE_QUERY_12345XYZ',
        ]));

        $response->assertStatus(200);
        $viewData = $response->viewData('viewData');
        $this->assertCount(0, $viewData['cars']);
        $response->assertSee(__('catalog.no_results_title'));
    }

    public function test_validates_end_date_must_be_after_start_date(): void
    {
        $response = $this->actingAs($this->customer)->get(route('catalog.index', [
            'start_date' => Carbon::now()->addDays(10)->toDateString(),
            'end_date' => Carbon::now()->addDays(5)->toDateString(),
        ]));

        $response->assertSessionHasErrors(['end_date']);
    }
}
