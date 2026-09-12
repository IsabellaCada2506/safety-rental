<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-09-12
 * Description: Feature tests covering the administrator top three most rented cars ranking.
 */

namespace Tests\Feature;

use App\Models\Car;
use App\Models\Location;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarRankingTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private User $customer;

    private Location $location;

    private int $nextCode = 41000000;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->admin = User::query()->where('role', User::ROLE_ADMIN)->first();
        $this->customer = User::query()->where('email', 'customer@safetyrental.test')->first();
        $this->location = Location::first();

        Reservation::query()->delete();
    }

    private function createReservation(Car $car, string $state, Carbon $startDate, Carbon $endDate): Reservation
    {
        $reservation = new Reservation;
        $reservation->setCode($this->nextCode++);
        $reservation->setState($state);
        $reservation->setStartDate($startDate);
        $reservation->setEndDate($endDate);
        $reservation->setUserId($this->customer->getId());
        $reservation->setCarId($car->getId());
        $reservation->setLocationId($this->location->getId());
        $reservation->save();

        return $reservation;
    }

    public function test_administrator_sees_cars_ordered_by_qualifying_reservations(): void
    {
        $cars = Car::query()->orderBy('id')->get();
        $firstCar = $cars->get(0);
        $secondCar = $cars->get(1);
        $thirdCar = $cars->get(2);

        $this->createReservation($firstCar, Reservation::STATE_CONFIRMED, Carbon::now()->addDays(2), Carbon::now()->addDays(4));
        $this->createReservation($firstCar, Reservation::STATE_COMPLETED, Carbon::now()->addDays(10), Carbon::now()->addDays(12));
        $this->createReservation($firstCar, Reservation::STATE_PENDING, Carbon::now()->addDays(20), Carbon::now()->addDays(22));
        $this->createReservation($secondCar, Reservation::STATE_CONFIRMED, Carbon::now()->addDays(3), Carbon::now()->addDays(5));
        $this->createReservation($secondCar, Reservation::STATE_CONFIRMED, Carbon::now()->addDays(14), Carbon::now()->addDays(16));
        $this->createReservation($thirdCar, Reservation::STATE_PENDING, Carbon::now()->addDays(6), Carbon::now()->addDays(8));

        $response = $this->actingAs($this->admin)->get(route('admin.ranking.index'));

        $response->assertOk();
        $response->assertSee($firstCar->getPlate());
        $response->assertSee($secondCar->getPlate());
        $response->assertSee($thirdCar->getPlate());
        $this->assertTrue(strpos($response->getContent(), $firstCar->getPlate()) < strpos($response->getContent(), $secondCar->getPlate()));
        $this->assertTrue(strpos($response->getContent(), $secondCar->getPlate()) < strpos($response->getContent(), $thirdCar->getPlate()));
    }

    public function test_ranking_shows_only_the_top_three_cars(): void
    {
        $cars = Car::query()->orderBy('id')->take(4)->get();

        foreach ($cars as $index => $car) {
            $count = 4 - $index;
            for ($i = 0; $i < $count; $i++) {
                $this->createReservation(
                    $car,
                    Reservation::STATE_CONFIRMED,
                    Carbon::now()->addDays(30 + ($index * 10) + $i),
                    Carbon::now()->addDays(32 + ($index * 10) + $i)
                );
            }
        }

        $response = $this->actingAs($this->admin)->get(route('admin.ranking.index'));

        $response->assertOk();
        $response->assertSee($cars->get(0)->getPlate());
        $response->assertSee($cars->get(1)->getPlate());
        $response->assertSee($cars->get(2)->getPlate());
        $response->assertDontSee($cars->get(3)->getPlate());
    }

    public function test_cancelled_reservations_do_not_increase_the_rental_count(): void
    {
        $cars = Car::query()->orderBy('id')->take(2)->get();
        $popularCar = $cars->get(0);
        $otherCar = $cars->get(1);

        $this->createReservation($popularCar, Reservation::STATE_CANCELLED, Carbon::now()->addDays(2), Carbon::now()->addDays(4));
        $this->createReservation($popularCar, Reservation::STATE_CANCELLED, Carbon::now()->addDays(8), Carbon::now()->addDays(10));
        $this->createReservation($otherCar, Reservation::STATE_CONFIRMED, Carbon::now()->addDays(3), Carbon::now()->addDays(5));

        $response = $this->actingAs($this->admin)->get(route('admin.ranking.index'));

        $response->assertOk();
        $response->assertSee($otherCar->getPlate());
        $response->assertDontSee($popularCar->getPlate());
    }

    public function test_date_range_filters_qualifying_reservations(): void
    {
        $car = Car::query()->orderBy('id')->first();

        $this->createReservation(
            $car,
            Reservation::STATE_CONFIRMED,
            Carbon::parse('2026-01-10'),
            Carbon::parse('2026-01-12')
        );
        $this->createReservation(
            $car,
            Reservation::STATE_CONFIRMED,
            Carbon::parse('2026-08-10'),
            Carbon::parse('2026-08-12')
        );

        $emptyResponse = $this->actingAs($this->admin)->get(route('admin.ranking.index', [
            'start_date' => '2026-03-01',
            'end_date' => '2026-03-31',
        ]));
        $emptyResponse->assertOk();
        $emptyResponse->assertSee(__('ranking.empty'));

        $filteredResponse = $this->actingAs($this->admin)->get(route('admin.ranking.index', [
            'start_date' => '2026-08-01',
            'end_date' => '2026-08-31',
        ]));
        $filteredResponse->assertOk();
        $filteredResponse->assertSee($car->getPlate());
        $filteredResponse->assertDontSee(__('ranking.empty'));
    }

    public function test_ties_are_ordered_by_plate_then_id(): void
    {
        $cars = Car::query()->orderBy('plate')->take(2)->get();
        $firstPlateCar = $cars->get(0);
        $secondPlateCar = $cars->get(1);

        $this->createReservation($firstPlateCar, Reservation::STATE_CONFIRMED, Carbon::now()->addDays(2), Carbon::now()->addDays(4));
        $this->createReservation($secondPlateCar, Reservation::STATE_CONFIRMED, Carbon::now()->addDays(6), Carbon::now()->addDays(8));

        $response = $this->actingAs($this->admin)->get(route('admin.ranking.index'));

        $response->assertOk();
        $this->assertTrue(strpos($response->getContent(), $firstPlateCar->getPlate()) < strpos($response->getContent(), $secondPlateCar->getPlate()));
    }

    public function test_empty_ranking_shows_an_empty_state_message(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.ranking.index'));

        $response->assertOk();
        $response->assertSee(__('ranking.empty'));
    }

    public function test_customer_cannot_access_the_car_ranking(): void
    {
        $response = $this->actingAs($this->customer)->get(route('admin.ranking.index'));

        $response->assertForbidden();
    }
}
