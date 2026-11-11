<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ReservationStateTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_new_reservation_is_pending_and_cancellable(): void
    {
        $reservation = Reservation::factory()->create();

        $this->assertSame(Reservation::STATE_PENDING, $reservation->getState());
        $this->assertTrue($reservation->isPending());
        $this->assertTrue($reservation->isCancellable());
        $this->assertFalse($reservation->isConfirmed());
        $this->assertFalse($reservation->isCancelled());
        $this->assertFalse($reservation->isCompleted());
    }

    #[Test]
    public function test_confirmed_reservation_is_cancellable(): void
    {
        $reservation = Reservation::factory()->confirmed()->create();

        $this->assertSame(Reservation::STATE_CONFIRMED, $reservation->getState());
        $this->assertTrue($reservation->isConfirmed());
        $this->assertTrue($reservation->isCancellable());
        $this->assertFalse($reservation->isPending());
    }

    #[Test]
    public function test_cancelled_reservation_is_not_cancellable(): void
    {
        $reservation = Reservation::factory()->cancelled()->create();

        $this->assertSame(Reservation::STATE_CANCELLED, $reservation->getState());
        $this->assertTrue($reservation->isCancelled());
        $this->assertFalse($reservation->isCancellable());
        $this->assertFalse($reservation->isPayable());
    }

    #[Test]
    public function test_state_can_be_changed_via_setter_and_reflected_by_getters(): void
    {
        $reservation = Reservation::factory()->create();

        $this->assertTrue($reservation->isPending());

        $reservation->setState(Reservation::STATE_CONFIRMED);
        $this->assertTrue($reservation->isConfirmed());
        $this->assertSame(Reservation::STATE_CONFIRMED, $reservation->getState());

        $reservation->setState(Reservation::STATE_CANCELLED);
        $reservation->setCancellationReason('Personal reasons');
        $this->assertTrue($reservation->isCancelled());
        $this->assertSame('Personal reasons', $reservation->getCancellationReason());
        $this->assertFalse($reservation->isCancellable());
    }
}
