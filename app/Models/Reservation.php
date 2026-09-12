<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Reservation model representing a car rental booking between a customer and a vehicle.
 */

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\ReservationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $code
 * @property string $state
 * @property Carbon|null $start_date
 * @property Carbon|null $end_date
 * @property int $user_id
 * @property int $car_id
 * @property int $location_id
 * @property int|null $payment_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property User|null $user
 * @property Car|null $car
 * @property Location|null $location
 * @property Payment|null $payment
 */
class Reservation extends Model
{
    /** @use HasFactory<ReservationFactory> */
    use HasFactory;

    public const STATE_PENDING = 'pending';

    public const STATE_CONFIRMED = 'confirmed';

    public const STATE_CANCELLED = 'cancelled';

    public const STATE_COMPLETED = 'completed';

    public $timestamps = true;

    protected $guarded = [
        'id',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function getId(): int
    {
        return (int) $this->attributes['id'];
    }

    public function getCode(): int
    {
        return (int) $this->attributes['code'];
    }

    public function setCode(int $code): void
    {
        $this->attributes['code'] = $code;
    }

    public function getState(): string
    {
        return $this->attributes['state'];
    }

    public function setState(string $state): void
    {
        $this->attributes['state'] = $state;
    }

    public function getStartDate(): ?Carbon
    {
        return isset($this->attributes['start_date'])
            ? Carbon::parse($this->attributes['start_date'])
            : null;
    }

    public function setStartDate(Carbon|string $startDate): void
    {
        $this->attributes['start_date'] = $startDate instanceof Carbon
            ? $startDate->toDateString()
            : $startDate;
    }

    public function getEndDate(): ?Carbon
    {
        return isset($this->attributes['end_date'])
            ? Carbon::parse($this->attributes['end_date'])
            : null;
    }

    public function setEndDate(Carbon|string $endDate): void
    {
        $this->attributes['end_date'] = $endDate instanceof Carbon
            ? $endDate->toDateString()
            : $endDate;
    }

    public function getUserId(): int
    {
        return (int) $this->attributes['user_id'];
    }

    public function setUserId(int $userId): void
    {
        $this->attributes['user_id'] = $userId;
    }

    public function getCarId(): int
    {
        return (int) $this->attributes['car_id'];
    }

    public function setCarId(int $carId): void
    {
        $this->attributes['car_id'] = $carId;
    }

    public function getLocationId(): int
    {
        return (int) $this->attributes['location_id'];
    }

    public function setLocationId(int $locationId): void
    {
        $this->attributes['location_id'] = $locationId;
    }

    public function getPaymentId(): ?int
    {
        return isset($this->attributes['payment_id'])
            ? (int) $this->attributes['payment_id']
            : null;
    }

    public function setPaymentId(?int $paymentId): void
    {
        $this->attributes['payment_id'] = $paymentId;
    }

    public function getCreatedAt(): ?Carbon
    {
        return isset($this->attributes['created_at'])
            ? Carbon::parse($this->attributes['created_at'])
            : null;
    }

    public function getUpdatedAt(): ?Carbon
    {
        return isset($this->attributes['updated_at'])
            ? Carbon::parse($this->attributes['updated_at'])
            : null;
    }

    public function isPending(): bool
    {
        return $this->getState() === self::STATE_PENDING;
    }

    public function isConfirmed(): bool
    {
        return $this->getState() === self::STATE_CONFIRMED;
    }

    public function isCancelled(): bool
    {
        return $this->getState() === self::STATE_CANCELLED;
    }

    public function isCompleted(): bool
    {
        return $this->getState() === self::STATE_COMPLETED;
    }

    public function isCancellable(): bool
    {
        return in_array($this->getState(), [self::STATE_PENDING, self::STATE_CONFIRMED], true);
    }

    public function getStateBadgeClass(): string
    {
        return match ($this->getState()) {
            self::STATE_CONFIRMED => 'bg-success text-white',
            self::STATE_CANCELLED => 'bg-danger text-white',
            self::STATE_COMPLETED => 'bg-secondary text-white',
            default => 'bg-warning text-dark',
        };
    }

    public function getDays(): int
    {
        $start = $this->getStartDate();
        $end = $this->getEndDate();

        if (! $start || ! $end) {
            return 1;
        }

        return max(1, (int) $start->diffInDays($end));
    }

    public function getTotalPrice(): int
    {
        $car = $this->getCar();
        $carPrice = $car ? $car->getPrice() : 0;

        return $this->getDays() * $carPrice;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function getPayment(): ?Payment
    {
        return $this->payment;
    }
}
