<?php

/**
 * Author: Alejandro
 * Date: 07/09/2026
 * Description: Reserve model, represents a vehicle rental reservation.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $code
 * @property int $user_id
 * @property int $car_id
 * @property int $location_id
 * @property int $state_id
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property string $total_amount
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Reserve extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'code',
        'user_id',
        'car_id',
        'location_id',
        'state_id',
        'start_date',
        'end_date',
        'total_amount',
    ];

    protected $guarded = [
        'id',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'total_amount' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Reserve $reserve): void {
            if ($reserve->getCode() === '') {
                $reserve->setCode(self::generateCode());
            }

            $reserve->setTotalAmount($reserve->calculateRentalCost());
        });
    }

    public static function generateCode(): string
    {
        return 'SR-'.Carbon::now()->format('Ymd').'-'.strtoupper(bin2hex(random_bytes(3)));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return (string) $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(int $userId): void
    {
        $this->user_id = $userId;
    }

    public function getCarId(): int
    {
        return $this->car_id;
    }

    public function setCarId(int $carId): void
    {
        $this->car_id = $carId;
    }

    public function getLocationId(): int
    {
        return $this->location_id;
    }

    public function setLocationId(int $locationId): void
    {
        $this->location_id = $locationId;
    }

    public function getStateId(): int
    {
        return $this->state_id;
    }

    public function setStateId(int $stateId): void
    {
        $this->state_id = $stateId;
    }

    public function getStartDate(): ?Carbon
    {
        return $this->start_date;
    }

    public function setStartDate(Carbon $startDate): void
    {
        $this->start_date = $startDate;
    }

    public function getEndDate(): ?Carbon
    {
        return $this->end_date;
    }

    public function setEndDate(Carbon $endDate): void
    {
        $this->end_date = $endDate;
    }

    public function getTotalAmount(): string
    {
        return (string) $this->total_amount;
    }

    public function setTotalAmount(string $totalAmount): void
    {
        $this->total_amount = $totalAmount;
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
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user()->associate($user);
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(Car $car): void
    {
        $this->car()->associate($car);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(Location $location): void
    {
        $this->location()->associate($location);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function getState(): ?State
    {
        return $this->state;
    }

    public function setState(State $state): void
    {
        $this->state()->associate($state);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function getPayment(): ?Payment
    {
        return $this->payment;
    }

    public function setPayment(Payment $payment): void
    {
        $this->payment()->save($payment);
    }

    public function getDurationInDays(): int
    {
        $startDate = $this->getStartDate();
        $endDate = $this->getEndDate();

        if (! $startDate instanceof Carbon || ! $endDate instanceof Carbon) {
            return 0;
        }

        $days = $startDate->copy()->startOfDay()->diffInDays($endDate->copy()->startOfDay());

        return max(1, (int) $days);
    }

    public function calculateRentalCost(): string
    {
        $car = $this->getCar();

        if (! $car instanceof Car && $this->car_id) {
            $car = Car::query()->find($this->car_id);
        }

        $dailyRate = $car instanceof Car ? $car->getDailyRate() : '0.00';
        $total = (float) $dailyRate * $this->getDurationInDays();

        return number_format($total, 2, '.', '');
    }

    public function overlapsPeriod(Carbon $startDate, Carbon $endDate): bool
    {
        $currentStart = $this->getStartDate();
        $currentEnd = $this->getEndDate();

        if (! $currentStart instanceof Carbon || ! $currentEnd instanceof Carbon) {
            return false;
        }

        return $currentStart->lte($endDate) && $currentEnd->gte($startDate);
    }

    public function isCancellable(): bool
    {
        $state = $this->getState();

        if (! $state instanceof State) {
            return false;
        }

        return ! $state->isCancelled() && ! $state->isCompleted();
    }

    public function belongsToUser(User $user): bool
    {
        return $this->getUserId() === $user->getId();
    }
}
