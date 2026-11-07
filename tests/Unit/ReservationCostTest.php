<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Car;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ReservationCostTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_single_day_reservation_cost(): void
    {
        $car = Car::factory()->create(['price' => 100000]);

        $reservation = Reservation::factory()
            ->for($car)
            ->state(function (): array {
                $start = Carbon::parse('2026-12-01');
                $end = Carbon::parse('2026-12-02');

                return [
                    'start_date' => $start->toDateString(),
                    'end_date' => $end->toDateString(),
                ];
            })
            ->create();

        $reservation->setCar($car);

        $this->assertSame(1, $reservation->getDays());
        $this->assertSame(100000, $reservation->getTotalPrice());
    }

    #[Test]
    public function test_multiple_day_reservation_cost(): void
    {
        $car = Car::factory()->create(['price' => 80000]);

        $reservation = Reservation::factory()
            ->for($car)
            ->state(function (): array {
                $start = Carbon::parse('2026-12-10');
                $end = Carbon::parse('2026-12-15');

                return [
                    'start_date' => $start->toDateString(),
                    'end_date' => $end->toDateString(),
                ];
            })
            ->create();

        $reservation->setCar($car);

        $this->assertSame(5, $reservation->getDays());
        $this->assertSame(400000, $reservation->getTotalPrice());
    }

    #[Test]
    public function test_same_date_returns_minimum_one_day(): void
    {
        $car = Car::factory()->create(['price' => 50000]);

        $reservation = Reservation::factory()
            ->for($car)
            ->state(function (): array {
                $date = Carbon::parse('2026-12-20');

                return [
                    'start_date' => $date->toDateString(),
                    'end_date' => $date->toDateString(),
                ];
            })
            ->create();

        $reservation->setCar($car);

        $this->assertSame(1, $reservation->getDays());
        $this->assertSame(50000, $reservation->getTotalPrice());
    }
}
