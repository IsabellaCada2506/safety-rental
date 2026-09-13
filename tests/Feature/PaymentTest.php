<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-09-12
 * Description: Feature tests covering simulated payments, amount integrity, duplicates, and refunds.
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

class PaymentTest extends TestCase
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

        $this->customer = User::query()->where('email', 'customer@safetyrental.test')->first();
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
        $this->otherCustomer->setEmail('other-payment@safetyrental.test');
        $this->otherCustomer->setPassword('password');
        $this->otherCustomer->setEmailVerifiedAt(Carbon::now());
        $this->otherCustomer->save();
    }

    private function createPayableReservation(User $user): Reservation
    {
        $reservation = new Reservation;
        $reservation->setCode(random_int(20000000, 29999999));
        $reservation->setState(Reservation::STATE_PENDING);
        $reservation->setStartDate(Carbon::now()->addDays(25));
        $reservation->setEndDate(Carbon::now()->addDays(28));
        $reservation->setUserId($user->getId());
        $reservation->setCarId($this->car->getId());
        $reservation->setLocationId($this->location->getId());
        $reservation->save();

        return $reservation->fresh(['car.category', 'location', 'payment']);
    }

    public function test_customer_can_record_a_valid_simulated_payment(): void
    {
        $reservation = $this->createPayableReservation($this->customer);

        $response = $this->actingAs($this->customer)->post(route('payments.store', ['id' => $reservation->getId()]), [
            'method' => Payment::METHOD_CREDIT_CARD,
            'simulated_result' => Payment::SIMULATED_RESULT_SUCCESS,
        ]);

        $reservation->refresh();
        $payment = $reservation->getPayment();

        $this->assertNotNull($payment);
        $this->assertSame((float) $reservation->getTotalPrice(), $payment->getAmount());
        $this->assertSame(Payment::METHOD_CREDIT_CARD, $payment->getMethod());
        $this->assertNotNull($payment->getTransactionCode());
        $this->assertNotNull($payment->getDate());
        $this->assertTrue($payment->isCompleted());
        $this->assertSame($reservation->getId(), $payment->getReservationId());
        $response->assertRedirect(route('reservations.show', ['id' => $reservation->getId()]));
    }

    public function test_payment_is_associated_with_the_correct_reservation(): void
    {
        $reservation = $this->createPayableReservation($this->customer);

        $this->actingAs($this->customer)->post(route('payments.store', ['id' => $reservation->getId()]), [
            'method' => Payment::METHOD_DEBIT_CARD,
            'simulated_result' => Payment::SIMULATED_RESULT_SUCCESS,
        ]);

        $payment = Payment::query()->with('reservation')->where('reservation_id', $reservation->getId())->first();

        $this->assertNotNull($payment);
        $this->assertSame($reservation->getId(), $payment->getReservation()?->getId());
    }

    public function test_inconsistent_client_amount_is_rejected(): void
    {
        $reservation = $this->createPayableReservation($this->customer);

        $response = $this->actingAs($this->customer)->post(route('payments.store', ['id' => $reservation->getId()]), [
            'method' => Payment::METHOD_CREDIT_CARD,
            'simulated_result' => Payment::SIMULATED_RESULT_SUCCESS,
            'amount' => $reservation->getTotalPrice() + 50000,
        ]);

        $response->assertSessionHasErrors('error');
        $this->assertNull($reservation->fresh()->getPaymentId());
    }

    public function test_duplicate_successful_payment_is_rejected(): void
    {
        $reservation = $this->createPayableReservation($this->customer);

        $this->actingAs($this->customer)->post(route('payments.store', ['id' => $reservation->getId()]), [
            'method' => Payment::METHOD_CREDIT_CARD,
            'simulated_result' => Payment::SIMULATED_RESULT_SUCCESS,
        ]);

        $response = $this->actingAs($this->customer)->post(route('payments.store', ['id' => $reservation->getId()]), [
            'method' => Payment::METHOD_BANK_TRANSFER,
            'simulated_result' => Payment::SIMULATED_RESULT_SUCCESS,
        ]);

        $response->assertForbidden();
        $this->assertSame(1, Payment::query()->where('reservation_id', $reservation->getId())->where('status', Payment::STATUS_COMPLETED)->count());
    }

    public function test_failed_payment_is_recorded_without_marking_reservation_as_paid(): void
    {
        $reservation = $this->createPayableReservation($this->customer);

        $response = $this->actingAs($this->customer)->post(route('payments.store', ['id' => $reservation->getId()]), [
            'method' => Payment::METHOD_CREDIT_CARD,
            'simulated_result' => Payment::SIMULATED_RESULT_FAILURE,
        ]);

        $reservation->refresh();
        $failedPayment = Payment::query()->where('reservation_id', $reservation->getId())->first();

        $this->assertNotNull($failedPayment);
        $this->assertTrue($failedPayment->isFailed());
        $this->assertNull($reservation->getPaymentId());
        $this->assertFalse($reservation->hasSuccessfulPayment());
        $response->assertSessionHasErrors('error');
    }

    public function test_administrator_can_review_payment_records(): void
    {
        $reservation = $this->createPayableReservation($this->customer);

        $this->actingAs($this->customer)->post(route('payments.store', ['id' => $reservation->getId()]), [
            'method' => Payment::METHOD_PSE_DEBIT,
            'simulated_result' => Payment::SIMULATED_RESULT_SUCCESS,
        ]);

        $payment = Payment::query()->where('reservation_id', $reservation->getId())->first();

        $indexResponse = $this->actingAs($this->admin)->get(route('admin.payment.index'));
        $indexResponse->assertOk();
        $indexResponse->assertSee((string) $reservation->getCode());
        $indexResponse->assertSee((string) $payment->getTransactionCode());
        $indexResponse->assertSee(Payment::methodLabel(Payment::METHOD_PSE_DEBIT));

        $showResponse = $this->actingAs($this->admin)->get(route('admin.payment.show', ['id' => $payment->getId()]));
        $showResponse->assertOk();
        $showResponse->assertSee((string) $payment->getCode());
    }

    public function test_only_an_administrator_can_refund_a_completed_payment(): void
    {
        $reservation = $this->createPayableReservation($this->customer);

        $this->actingAs($this->customer)->post(route('payments.store', ['id' => $reservation->getId()]), [
            'method' => Payment::METHOD_CREDIT_CARD,
            'simulated_result' => Payment::SIMULATED_RESULT_SUCCESS,
        ]);

        $payment = Payment::query()->where('reservation_id', $reservation->getId())->first();

        $customerRefund = $this->actingAs($this->customer)->patch(route('admin.payment.refund', ['id' => $payment->getId()]));
        $customerRefund->assertForbidden();
        $this->assertTrue($payment->fresh()->isCompleted());

        $adminRefund = $this->actingAs($this->admin)->patch(route('admin.payment.refund', ['id' => $payment->getId()]));
        $adminRefund->assertRedirect(route('admin.payment.show', ['id' => $payment->getId()]));
        $this->assertTrue($payment->fresh()->isRefunded());
        $this->assertFalse($reservation->fresh(['payment'])->hasSuccessfulPayment());
    }

    public function test_customer_cannot_pay_another_customers_reservation(): void
    {
        $reservation = $this->createPayableReservation($this->customer);

        $response = $this->actingAs($this->otherCustomer)->post(route('payments.store', ['id' => $reservation->getId()]), [
            'method' => Payment::METHOD_CREDIT_CARD,
            'simulated_result' => Payment::SIMULATED_RESULT_SUCCESS,
        ]);

        $response->assertForbidden();
        $this->assertNull($reservation->fresh()->getPaymentId());
    }
}
