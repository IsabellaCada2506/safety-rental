<?php

/**
 * Author: Isabella Ocampo
 * Author: Alejandro Correa Marin
 * Author: Wendy Atehortua
 * Date: 2026-09-13
 * Description: Reservation model representing a car rental booking between a customer and a vehicle.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * RESERVATION ATTRIBUTES
 * $this->attributes['id']           - int         - contains the reservation primary key
 * $this->attributes['code']         - int         - contains the unique reservation code
 * $this->attributes['state']        - string      - contains the reservation state
 * $this->attributes['start_date']   - string|null - contains the rental start date
 * $this->attributes['end_date']     - string|null - contains the rental end date
 * $this->attributes['user_id']      - int         - contains the customer user id
 * $this->attributes['car_id']       - int         - contains the rented car id
 * $this->attributes['location_id']  - int         - contains the pickup location id
 * $this->attributes['payment_id']   - int|null    - contains the successful payment id
 * $this->attributes['created_at']   - string|null - contains the creation timestamp
 * $this->attributes['updated_at']   - string|null - contains the update timestamp
 *
 * RELATIONSHIPS
 * $this->user - User|null - the customer who created the reservation
 * $this->car - Car|null - the rented vehicle
 * $this->location - Location|null - the pickup location
 * $this->payment - Payment|null - the successful payment
 * $this->payments - Collection<int, Payment> - all payment attempts for this reservation
 */
class Reservation extends Model
{
    use HasFactory;

    public const STATE_PENDING = 'pending';

    public const STATE_CONFIRMED = 'confirmed';

    public const STATE_CANCELLED = 'cancelled';

    public const STATE_COMPLETED = 'completed';

    protected $fillable = [
        'code',
        'state',
        'start_date',
        'end_date',
        'user_id',
        'car_id',
        'location_id',
        'payment_id',
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
        return $this->start_date;
    }

    public function setStartDate(Carbon|string $startDate): void
    {
        $this->attributes['start_date'] = $startDate instanceof Carbon
            ? $startDate->toDateString()
            : $startDate;
    }

    public function getEndDate(): ?Carbon
    {
        return $this->end_date;
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
        return $this->created_at;
    }

    public function getUpdatedAt(): ?Carbon
    {
        return $this->updated_at;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getUser(): ?User
    {
        return $this->relationLoaded('user') ? $this->getRelation('user') : null;
    }

    public function setUser(?User $user): void
    {
        $this->setRelation('user', $user);
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function getCar(): ?Car
    {
        return $this->relationLoaded('car') ? $this->getRelation('car') : null;
    }

    public function setCar(?Car $car): void
    {
        $this->setRelation('car', $car);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function getLocation(): ?Location
    {
        return $this->relationLoaded('location') ? $this->getRelation('location') : null;
    }

    public function setLocation(?Location $location): void
    {
        $this->setRelation('location', $location);
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function getPayment(): ?Payment
    {
        return $this->relationLoaded('payment') ? $this->getRelation('payment') : null;
    }

    public function setPayment(?Payment $payment): void
    {
        $this->setRelation('payment', $payment);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function getPayments(): Collection
    {
        return $this->relationLoaded('payments') ? $this->getRelation('payments') : new Collection;
    }

    public function setPayments(Collection $payments): void
    {
        $this->setRelation('payments', $payments);
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

    public function hasSuccessfulPayment(): bool
    {
        $payment = $this->getPayment();

        return $payment !== null && $payment->getStatus() === Payment::STATUS_COMPLETED;
    }

    public function isPayable(): bool
    {
        return ! $this->isCancelled()
            && ! $this->isCompleted()
            && ! $this->hasSuccessfulPayment();
    }
}
