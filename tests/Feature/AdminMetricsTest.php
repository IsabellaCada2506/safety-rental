<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-09-12
 * Description: Feature tests covering administrator reservation and payment metrics.
 */

namespace Tests\Feature;

use App\Models\Car;
use App\Models\Location;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminMetricsTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private User $customer;

    private Car $car;

    private Location $location;

    private int $nextReservationCode = 51000000;

    private int $nextPaymentCode = 61000000;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->admin = User::query()->where('role', User::ROLE_ADMIN)->first();
        $this->customer = User::query()->where('email', 'customer@safetyrental.test')->first();
        $this->car = Car::first();
        $this->location = Location::first();

        Reservation::query()->delete();
        Payment::query()->delete();
    }

    private function createReservation(string $state, Carbon $startDate, Carbon $endDate): Reservation
    {
        $reservation = new Reservation;
        $reservation->setCode($this->nextReservationCode++);
        $reservation->setState($state);
        $reservation->setStartDate($startDate);
        $reservation->setEndDate($endDate);
        $reservation->setUserId($this->customer->getId());
        $reservation->setCarId($this->car->getId());
        $reservation->setLocationId($this->location->getId());
        $reservation->save();

        return $reservation;
    }

    private function createPayment(float $amount, string $status, Carbon $date): Payment
    {
        $payment = new Payment;
        $payment->setCode($this->nextPaymentCode++);
        $payment->setAmount($amount);
        $payment->setMethod(Payment::METHOD_CREDIT_CARD);
        $payment->setTransactionCode($this->nextPaymentCode++);
        $payment->setStatus($status);
        $payment->setDate($date);
        $payment->save();

        return $payment;
    }

    public function test_administrator_sees_reservation_counts_grouped_by_state(): void
    {
        $this->createReservation(Reservation::STATE_PENDING, Carbon::now()->addDays(2), Carbon::now()->addDays(4));
        $this->createReservation(Reservation::STATE_CONFIRMED, Carbon::now()->addDays(6), Carbon::now()->addDays(8));
        $this->createReservation(Reservation::STATE_CONFIRMED, Carbon::now()->addDays(10), Carbon::now()->addDays(12));
        $this->createReservation(Reservation::STATE_CANCELLED, Carbon::now()->addDays(14), Carbon::now()->addDays(16));
        $this->createReservation(Reservation::STATE_COMPLETED, Carbon::now()->subDays(10), Carbon::now()->subDays(8));

        $response = $this->actingAs($this->admin)->get(route('admin.metrics.index'));

        $response->assertOk();
        $response->assertSee(__('metrics.pending'));
        $response->assertSee(__('metrics.confirmed'));
        $response->assertSee(__('metrics.cancelled'));
        $response->assertSee(__('metrics.completed'));
        $response->assertSee('1');
        $response->assertSee('2');
    }

    public function test_successful_net_amount_excludes_failed_and_refunded_payments(): void
    {
        $this->createPayment(100000, Payment::STATUS_COMPLETED, Carbon::now());
        $this->createPayment(40000, Payment::STATUS_FAILED, Carbon::now());
        $this->createPayment(25000, Payment::STATUS_REFUNDED, Carbon::now());

        $response = $this->actingAs($this->admin)->get(route('admin.metrics.index'));

        $response->assertOk();
        $response->assertSee(number_format(100000, 0, ',', '.'));
        $response->assertSee(number_format(40000, 0, ',', '.'));
        $response->assertSee(number_format(25000, 0, ',', '.'));
        $response->assertDontSee(number_format(140000, 0, ',', '.'));
        $response->assertDontSee(number_format(75000, 0, ',', '.'));
    }

    public function test_date_range_filters_metrics(): void
    {
        $this->createReservation(Reservation::STATE_CONFIRMED, Carbon::parse('2026-01-10'), Carbon::parse('2026-01-12'));
        $this->createPayment(80000, Payment::STATUS_COMPLETED, Carbon::parse('2026-01-10'));
        $this->createReservation(Reservation::STATE_PENDING, Carbon::parse('2026-08-10'), Carbon::parse('2026-08-12'));
        $this->createPayment(150000, Payment::STATUS_COMPLETED, Carbon::parse('2026-08-10'));

        $emptyResponse = $this->actingAs($this->admin)->get(route('admin.metrics.index', [
            'start_date' => '2026-03-01',
            'end_date' => '2026-03-31',
        ]));
        $emptyResponse->assertOk();
        $emptyResponse->assertSee(__('metrics.empty'));
        $emptyResponse->assertSee('$0');

        $filteredResponse = $this->actingAs($this->admin)->get(route('admin.metrics.index', [
            'start_date' => '2026-08-01',
            'end_date' => '2026-08-31',
        ]));
        $filteredResponse->assertOk();
        $filteredResponse->assertSee(number_format(150000, 0, ',', '.'));
        $filteredResponse->assertDontSee(number_format(80000, 0, ',', '.'));
        $filteredResponse->assertDontSee(__('metrics.empty'));
    }

    public function test_customer_cannot_access_administrator_metrics(): void
    {
        $response = $this->actingAs($this->customer)->get(route('admin.metrics.index'));

        $response->assertForbidden();
    }
}
