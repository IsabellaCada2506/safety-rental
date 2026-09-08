<?php

/**
 * Author: Alejandro
 * Date: 07/09/2026
 * Description: Feature tests for the Reserve model, relations and business methods.
 */

namespace Tests\Feature;

use App\Models\Car;
use App\Models\Location;
use App\Models\Payment;
use App\Models\Reserve;
use App\Models\State;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ReserveModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_reserve_persists_with_required_relationships(): void
    {
        $customer = User::factory()->create();
        $car = Car::factory()->create([
            'daily_rate' => '100.00',
        ]);
        $location = Location::factory()->create();
        $state = State::factory()->pending()->create();

        $reserve = new Reserve;
        $reserve->setUser($customer);
        $reserve->setCar($car);
        $reserve->setLocation($location);
        $reserve->setState($state);
        $reserve->setStartDate(Carbon::parse('2026-09-10'));
        $reserve->setEndDate(Carbon::parse('2026-09-13'));
        $reserve->save();

        $this->assertDatabaseHas('reserves', [
            'id' => $reserve->getId(),
            'user_id' => $customer->getId(),
            'car_id' => $car->getId(),
            'location_id' => $location->getId(),
            'state_id' => $state->getId(),
        ]);
        $this->assertNotSame('', $reserve->getCode());
        $this->assertSame('300.00', $reserve->getTotalAmount());
    }

    public function test_reserve_exposes_eloquent_relationships_on_both_sides(): void
    {
        $reserve = new Reserve;
        $user = new User;
        $car = new Car;
        $location = new Location;
        $state = new State;
        $payment = new Payment;

        $this->assertInstanceOf(BelongsTo::class, $reserve->user());
        $this->assertInstanceOf(BelongsTo::class, $reserve->car());
        $this->assertInstanceOf(BelongsTo::class, $reserve->location());
        $this->assertInstanceOf(BelongsTo::class, $reserve->state());
        $this->assertInstanceOf(HasOne::class, $reserve->payment());
        $this->assertInstanceOf(HasMany::class, $user->reserves());
        $this->assertInstanceOf(HasMany::class, $car->reserves());
        $this->assertInstanceOf(HasMany::class, $location->reserves());
        $this->assertInstanceOf(HasMany::class, $state->reserves());
        $this->assertInstanceOf(BelongsTo::class, $payment->reserve());
    }

    public function test_reserve_payment_uses_one_to_one_cardinality(): void
    {
        $reserve = $this->makeReserve();

        $payment = new Payment;
        $payment->setAmount($reserve->getTotalAmount());
        $payment->setStatus(Payment::STATUS_SUCCESS);
        $payment->setReference('PAY-001');
        $reserve->setPayment($payment);

        $storedPayment = $reserve->fresh()?->getPayment();

        $this->assertInstanceOf(Payment::class, $storedPayment);
        $this->assertTrue($storedPayment->isSuccessful());
        $this->assertSame($reserve->getId(), $storedPayment->getReserve()?->getId());
    }

    public function test_rental_cost_uses_daily_rate_and_day_count(): void
    {
        $reserve = $this->makeReserve(
            dailyRate: '80.50',
            startDate: '2026-09-01',
            endDate: '2026-09-04',
        );

        $this->assertSame(3, $reserve->getDurationInDays());
        $this->assertSame('241.50', $reserve->calculateRentalCost());
    }

    public function test_overlapping_period_and_cancellation_rules(): void
    {
        $reserve = $this->makeReserve(
            startDate: '2026-09-10',
            endDate: '2026-09-12',
        );

        $this->assertTrue($reserve->overlapsPeriod(
            Carbon::parse('2026-09-11'),
            Carbon::parse('2026-09-15'),
        ));
        $this->assertFalse($reserve->overlapsPeriod(
            Carbon::parse('2026-09-13'),
            Carbon::parse('2026-09-16'),
        ));
        $this->assertTrue($reserve->isCancellable());

        $cancelled = State::factory()->cancelled()->create();
        $reserve->setState($cancelled);
        $reserve->save();

        $this->assertFalse($reserve->fresh()?->isCancellable());
    }

    public function test_combined_migrations_create_referenced_tables_before_foreign_keys(): void
    {
        $this->assertTrue(Schema::hasTable('users'));
        $this->assertTrue(Schema::hasTable('states'));
        $this->assertTrue(Schema::hasTable('locations'));
        $this->assertTrue(Schema::hasTable('cars'));
        $this->assertTrue(Schema::hasTable('reserves'));
        $this->assertTrue(Schema::hasTable('payments'));
    }

    private function makeReserve(
        string $dailyRate = '100.00',
        string $startDate = '2026-09-10',
        string $endDate = '2026-09-13',
    ): Reserve {
        $customer = User::factory()->create();
        $car = Car::factory()->create([
            'daily_rate' => $dailyRate,
        ]);
        $location = Location::factory()->create();
        $state = State::query()->first() ?? State::factory()->pending()->create();

        $reserve = new Reserve;
        $reserve->setUser($customer);
        $reserve->setCar($car);
        $reserve->setLocation($location);
        $reserve->setState($state);
        $reserve->setStartDate(Carbon::parse($startDate));
        $reserve->setEndDate(Carbon::parse($endDate));
        $reserve->save();

        return $reserve->fresh(['car', 'state', 'user', 'location']) ?? $reserve;
    }
}
