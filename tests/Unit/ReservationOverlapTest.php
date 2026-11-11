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

class ReservationOverlapTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_overlapping_dates_are_detected(): void
    {
        $car = Car::factory()->create();

        $existing = Reservation::factory()
            ->for($car)
            ->state(function (): array {
                return [
                    'start_date' => Carbon::parse('2026-12-05')->toDateString(),
                    'end_date' => Carbon::parse('2026-12-10')->toDateString(),
                ];
            })
            ->create();

        $futureReservations = new Collection([$existing]);

        // New range overlaps on days 8-12.
        $newStart = Carbon::parse('2026-12-08');
        $newEnd = Carbon::parse('2026-12-12');

        $this->assertTrue(
            Reservation::datesOverlap($car, $newStart, $newEnd, $futureReservations)
        );
    }

    #[Test]
    public function test_non_overlapping_dates_are_not_detected(): void
    {
        $car = Car::factory()->create();

        $existing = Reservation::factory()
            ->for($car)
            ->state(function (): array {
                return [
                    'start_date' => Carbon::parse('2026-12-05')->toDateString(),
                    'end_date' => Carbon::parse('2026-12-10')->toDateString(),
                ];
            })
            ->create();

        $futureReservations = new Collection([$existing]);

        // New range is completely after the existing one.
        $newStart = Carbon::parse('2026-12-11');
        $newEnd = Carbon::parse('2026-12-15');

        $this->assertFalse(
            Reservation::datesOverlap($car, $newStart, $newEnd, $futureReservations)
        );
    }

    #[Test]
    public function test_empty_collection_does_not_overlap(): void
    {
        $car = Car::factory()->create();

        $newStart = Carbon::parse('2026-12-01');
        $newEnd = Carbon::parse('2026-12-05');

        $this->assertFalse(
            Reservation::datesOverlap($car, $newStart, $newEnd, new Collection)
        );
    }
}
