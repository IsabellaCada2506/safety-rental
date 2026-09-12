<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Feature test suite covering reservation creation, validation, ownership, and management.
 */

namespace Tests\Feature;

use App\Models\Car;
use App\Models\Location;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationTest extends TestCase
{
    use RefreshDatabase;

    private User $customer;

    private User $otherCustomer;

    private User $admin;

    private Car $car;

    private Location $location;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->customer = User::query()->where('role', User::ROLE_CUSTOMER)->first();
        $this->admin = User::query()->where('role', User::ROLE_ADMIN)->first();
        $this->car = Car::first();
        $this->location = Location::first();

        $this->otherCustomer = new User;
        $this->otherCustomer->setRole(User::ROLE_CUSTOMER);
        $this->otherCustomer->setName('Other');
        $this->otherCustomer->setLastName('Customer');
        $this->otherCustomer->setBirthDate(Carbon::parse('1995-05-05'));
        $this->otherCustomer->setAddress('Other Address');
        $this->otherCustomer->setLicenseNumber(98765432);
        $this->otherCustomer->setEmergencyContact(3111111111);
        $this->otherCustomer->setIdentificationNumber(9876543210);
        $this->otherCustomer->setEmergencyContactName('Emergency');
        $this->otherCustomer->setEmergencyContactLastName('Contact');
        $this->otherCustomer->setEps('Sura');
        $this->otherCustomer->setEmail('other@safetyrental.test');
        $this->otherCustomer->setPassword('password');
        $this->otherCustomer->setEmailVerifiedAt(Carbon::now());
        $this->otherCustomer->save();
    }

    /** AC 1: Valid Reservation */
    public function test_customer_can_create_valid_reservation(): void
    {
        // Delete seeded reservations for this car to guarantee availability
        Reservation::where('car_id', $this->car->getId())->delete();

        $startDate = Carbon::now()->addDays(20)->toDateString();
        $endDate = Carbon::now()->addDays(23)->toDateString();

        $response = $this->actingAs($this->customer)->post(route('reservations.store'), [
            'car_id' => $this->car->getId(),
            'location_id' => $this->location->getId(),
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        $reservation = Reservation::where('user_id', $this->customer->getId())
            ->where('car_id', $this->car->getId())
            ->where('start_date', $startDate)
            ->first();

        $this->assertNotNull($reservation);
        $this->assertNotNull($reservation->getCode());
        $this->assertSame(Reservation::STATE_PENDING, $reservation->getState());
        $this->assertSame($this->location->getId(), $reservation->getLocationId());

        $response->assertRedirect(route('reservations.show', ['id' => $reservation->getId()]));
    }

    /** AC 2: Invalid Dates (Past Date & End Date <= Start Date) */
    public function test_reservation_with_past_date_is_rejected(): void
    {
        $pastDate = Carbon::now()->subDays(2)->toDateString();
        $endDate = Carbon::now()->addDays(2)->toDateString();

        $response = $this->actingAs($this->customer)->post(route('reservations.store'), [
            'car_id' => $this->car->getId(),
            'location_id' => $this->location->getId(),
            'start_date' => $pastDate,
            'end_date' => $endDate,
        ]);

        $response->assertSessionHasErrors('start_date');
    }

    public function test_reservation_with_end_date_before_start_date_is_rejected(): void
    {
        $startDate = Carbon::now()->addDays(5)->toDateString();
        $endDate = Carbon::now()->addDays(4)->toDateString();

        $response = $this->actingAs($this->customer)->post(route('reservations.store'), [
            'car_id' => $this->car->getId(),
            'location_id' => $this->location->getId(),
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        $response->assertSessionHasErrors('end_date');
    }

    /** AC 3: Unavailable Car Overlap Check */
    public function test_overlapping_reservation_is_rejected(): void
    {
        Reservation::where('car_id', $this->car->getId())->delete();

        $start = Carbon::now()->addDays(15);
        $end = Carbon::now()->addDays(20);

        // Blocking reservation
        $blocking = new Reservation;
        $blocking->setCode(99991111);
        $blocking->setState(Reservation::STATE_CONFIRMED);
        $blocking->setStartDate($start);
        $blocking->setEndDate($end);
        $blocking->setUserId($this->otherCustomer->getId());
        $blocking->setCarId($this->car->getId());
        $blocking->setLocationId($this->location->getId());
        $blocking->save();

        // Conflicting request (overlapping dates)
        $conflictingStart = Carbon::now()->addDays(17)->toDateString();
        $conflictingEnd = Carbon::now()->addDays(22)->toDateString();

        $response = $this->actingAs($this->customer)->post(route('reservations.store'), [
            'car_id' => $this->car->getId(),
            'location_id' => $this->location->getId(),
            'start_date' => $conflictingStart,
            'end_date' => $conflictingEnd,
        ]);

        $response->assertSessionHasErrors('conflict');
    }

    /** AC 4: Rental Total Calculation */
    public function test_rental_total_calculation(): void
    {
        $start = Carbon::now()->addDays(30);
        $end = Carbon::now()->addDays(33); // 3 days

        $res = new Reservation;
        $res->setCode(99992222);
        $res->setState(Reservation::STATE_PENDING);
        $res->setStartDate($start);
        $res->setEndDate($end);
        $res->setUserId($this->customer->getId());
        $res->setCarId($this->car->getId());
        $res->setLocationId($this->location->getId());
        $res->save();

        $this->assertSame(3, $res->getDays());
        $this->assertSame(3 * $this->car->getPrice(), $res->getTotalPrice());
    }

    /** AC 5: Reservation Ownership Access Control */
    public function test_customer_cannot_view_another_customers_reservation(): void
    {
        $reservation = new Reservation;
        $reservation->setCode(99993333);
        $reservation->setState(Reservation::STATE_PENDING);
        $reservation->setStartDate(Carbon::now()->addDays(40));
        $reservation->setEndDate(Carbon::now()->addDays(42));
        $reservation->setUserId($this->customer->getId());
        $reservation->setCarId($this->car->getId());
        $reservation->setLocationId($this->location->getId());
        $reservation->save();

        // Other customer tries to view
        $response = $this->actingAs($this->otherCustomer)->get(route('reservations.show', ['id' => $reservation->getId()]));
        $response->assertForbidden();

        // Owner customer can view
        $responseOwner = $this->actingAs($this->customer)->get(route('reservations.show', ['id' => $reservation->getId()]));
        $responseOwner->assertOk();
    }

    /** AC 6: Customer Cancellation */
    public function test_customer_can_cancel_their_reservation(): void
    {
        $reservation = new Reservation;
        $reservation->setCode(99994444);
        $reservation->setState(Reservation::STATE_PENDING);
        $reservation->setStartDate(Carbon::now()->addDays(45));
        $reservation->setEndDate(Carbon::now()->addDays(48));
        $reservation->setUserId($this->customer->getId());
        $reservation->setCarId($this->car->getId());
        $reservation->setLocationId($this->location->getId());
        $reservation->save();

        $response = $this->actingAs($this->customer)->patch(route('reservations.cancel', ['id' => $reservation->getId()]));

        $response->assertRedirect(route('reservations.show', ['id' => $reservation->getId()]));
        $this->assertSame(Reservation::STATE_CANCELLED, $reservation->fresh()->getState());
    }

    /** AC 7 & 8: Administrator Management */
    public function test_administrator_can_view_and_confirm_reservation(): void
    {
        $reservation = new Reservation;
        $reservation->setCode(99995555);
        $reservation->setState(Reservation::STATE_PENDING);
        $reservation->setStartDate(Carbon::now()->addDays(50));
        $reservation->setEndDate(Carbon::now()->addDays(52));
        $reservation->setUserId($this->customer->getId());
        $reservation->setCarId($this->car->getId());
        $reservation->setLocationId($this->location->getId());
        $reservation->save();

        // Admin lists reservations
        $responseIndex = $this->actingAs($this->admin)->get(route('admin.reservation.index'));
        $responseIndex->assertOk();

        // Admin confirms reservation
        $responseConfirm = $this->actingAs($this->admin)->patch(route('admin.reservation.confirm', ['id' => $reservation->getId()]));
        $responseConfirm->assertRedirect(route('admin.reservation.show', ['id' => $reservation->getId()]));

        $this->assertSame(Reservation::STATE_CONFIRMED, $reservation->fresh()->getState());
    }
}
