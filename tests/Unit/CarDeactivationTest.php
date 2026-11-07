<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Car;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CarDeactivationTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_cannot_deactivate_with_pending_future_reservation(): void
    {
        $car = Car::factory()->create();

        $pending = Reservation::factory()
            ->for($car)
            ->state(function (): array {
                return [
                    'state' => Reservation::STATE_PENDING,
                    'start_date' => Carbon::parse('2026-12-10')->toDateString(),
                    'end_date' => Carbon::parse('2026-12-15')->toDateString(),
                ];
            })
            ->create();

        $futureReservations = new Collection([$pending]);

        $this->assertFalse($car->canBeDeactivated($futureReservations));
    }

    #[Test]
    public function test_cannot_deactivate_with_confirmed_future_reservation(): void
    {
        $car = Car::factory()->create();

        $confirmed = Reservation::factory()
            ->for($car)
            ->confirmed()
            ->state(function (): array {
                return [
                    'start_date' => Carbon::parse('2026-12-20')->toDateString(),
                    'end_date' => Carbon::parse('2026-12-25')->toDateString(),
                ];
            })
            ->create();

        $futureReservations = new Collection([$confirmed]);

        $this->assertFalse($car->canBeDeactivated($futureReservations));
    }

    #[Test]
    public function test_can_deactivate_with_no_future_reservations(): void
    {
        $car = Car::factory()->create();

        $this->assertTrue($car->canBeDeactivated(new Collection));
    }

    #[Test]
    public function test_can_deactivate_when_only_cancelled_reservations_exist(): void
    {
        $car = Car::factory()->create();

        $cancelled = Reservation::factory()
            ->for($car)
            ->cancelled()
            ->state(function (): array {
                return [
                    'start_date' => Carbon::parse('2026-12-10')->toDateString(),
                    'end_date' => Carbon::parse('2026-12-15')->toDateString(),
                ];
            })
            ->create();

        $futureReservations = new Collection([$cancelled]);

        $this->assertTrue($car->canBeDeactivated($futureReservations));
    }
}
