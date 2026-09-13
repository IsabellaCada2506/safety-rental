<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-09-12
 * Description: Feature tests covering paid reservation receipt PDF generation and authorization.
 */

namespace Tests\Feature;

use App\Interfaces\PaymentServiceInterface;
use App\Interfaces\ReservationServiceInterface;
use App\Models\Car;
use App\Models\Location;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReceiptTest extends TestCase
{
    use RefreshDatabase;

    private User $customer;

    private User $otherCustomer;

    private Car $car;

    private Location $location;

    private PaymentServiceInterface $paymentService;

    private ReservationServiceInterface $reservationService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->paymentService = app(PaymentServiceInterface::class);
        $this->reservationService = app(ReservationServiceInterface::class);

        $this->customer = User::query()->where('email', 'customer@safetyrental.test')->first();
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
        $this->otherCustomer->setEmail('other-receipt@safetyrental.test');
        $this->otherCustomer->setPassword('password');
        $this->otherCustomer->setEmailVerifiedAt(Carbon::now());
        $this->otherCustomer->save();
    }

    private function createReservation(User $user): Reservation
    {
        $reservation = new Reservation;
        $reservation->setCode(random_int(30000000, 39999999));
        $reservation->setState(Reservation::STATE_PENDING);
        $reservation->setStartDate(Carbon::now()->addDays(25));
        $reservation->setEndDate(Carbon::now()->addDays(28));
        $reservation->setUserId($user->getId());
        $reservation->setCarId($this->car->getId());
        $reservation->setLocationId($this->location->getId());
        $reservation->save();

        return $reservation->fresh(['car.category', 'location', 'payment']);
    }

    public function test_customer_can_download_a_pdf_receipt_for_a_paid_reservation(): void
    {
        $reservation = $this->createReservation($this->customer);

        $this->actingAs($this->customer)->post(route('payments.store', ['id' => $reservation->getId()]), [
            'method' => Payment::METHOD_CREDIT_CARD,
            'simulated_result' => Payment::SIMULATED_RESULT_SUCCESS,
        ]);

        $reservation = $reservation->fresh(['car.category', 'payment']);
        $payment = $reservation->getPayment();

        $response = $this->actingAs($this->customer)->get(route('receipts.download', ['id' => $reservation->getId()]));

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
        $this->assertStringContainsString('%PDF', $response->getContent());
        $this->assertStringContainsString((string) $reservation->getCode(), $response->headers->get('content-disposition'));

        $viewData = [];
        $viewData['title'] = __('payment.receipt_label');
        $viewData['documentName'] = __('payment.receipt_label');
        $viewData['disclaimer'] = __('payment.not_an_invoice');
        $viewData['reservationCode'] = $reservation->getCode();
        $viewData['vehicleName'] = trim(optional($reservation->getCar()?->getCategory())->getBrand().' '.optional($reservation->getCar()?->getCategory())->getModel());
        $viewData['vehiclePlate'] = $reservation->getCar()?->getPlate() ?? '';
        $viewData['startDate'] = $reservation->getStartDate()?->format('d/m/Y') ?? '';
        $viewData['endDate'] = $reservation->getEndDate()?->format('d/m/Y') ?? '';
        $viewData['amount'] = $payment?->getAmount() ?? 0.0;
        $viewData['currency'] = __('payment.currency');
        $viewData['transactionCode'] = $payment?->getTransactionCode();
        $viewData['paymentStatus'] = __('payment.status_'.$payment->getStatus());
        $viewData['paymentMethod'] = $payment ? $this->paymentService->getMethodLabel($payment) : '';
        $viewData['paymentDate'] = $payment?->getDate()?->format('d/m/Y') ?? '';
        $viewData['isPrintableDocument'] = true;

        $html = view('receipt.download', ['viewData' => $viewData])->render();

        $this->assertStringContainsString(__('payment.receipt_label'), $html);
        $this->assertStringContainsString(__('payment.not_an_invoice'), $html);
        $this->assertStringContainsString((string) $reservation->getCode(), $html);
        $this->assertStringContainsString((string) $payment->getTransactionCode(), $html);
        $this->assertStringContainsString(__('payment.currency'), $html);
        $this->assertStringContainsString(__('payment.status_completed'), $html);
    }

    public function test_customer_cannot_download_another_customers_receipt(): void
    {
        $reservation = $this->createReservation($this->customer);

        $this->actingAs($this->customer)->post(route('payments.store', ['id' => $reservation->getId()]), [
            'method' => Payment::METHOD_CREDIT_CARD,
            'simulated_result' => Payment::SIMULATED_RESULT_SUCCESS,
        ]);

        $response = $this->actingAs($this->otherCustomer)->get(route('receipts.download', ['id' => $reservation->getId()]));

        $response->assertForbidden();
    }

    public function test_unpaid_reservation_does_not_produce_a_paid_receipt(): void
    {
        $reservation = $this->createReservation($this->customer);

        $response = $this->actingAs($this->customer)->get(route('receipts.download', ['id' => $reservation->getId()]));

        $response->assertRedirect(route('reservations.show', ['id' => $reservation->getId()]));
        $response->assertSessionHasErrors('error');
        $this->assertFalse($this->reservationService->hasSuccessfulPayment($reservation->fresh(['payment'])));
    }
}
