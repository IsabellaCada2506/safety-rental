<?php

/**
 * Author: Isabella Ocampo
 * Author: Alejandro Correa Marin
 * Date: 2026-09-12
 * Description: Payment model representing rental transaction records.
 */

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\PaymentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * PAYMENT ATTRIBUTES
 * $this->attributes['id']                - int           - contains the payment primary key
 * $this->attributes['reservation_id']    - int|null      - contains the related reservation id
 * $this->attributes['code']              - int           - contains the unique payment code
 * $this->attributes['amount']            - float         - contains the approved payment amount
 * $this->attributes['method']            - string        - contains the payment method
 * $this->attributes['transaction_code']  - int           - contains the transaction reference
 * $this->attributes['status']            - string        - contains the payment status
 * $this->attributes['date']              - string|null   - contains the payment date
 * $this->attributes['created_at']        - string|null   - contains the creation timestamp
 * $this->attributes['updated_at']        - string|null   - contains the update timestamp
 *
 * RELATIONSHIPS
 * $this->reservation - Reservation|null - the reservation linked to this payment
 */
class Payment extends Model
{
    /** @use HasFactory<PaymentFactory> */
    use HasFactory;

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_PENDING = 'pending';

    public const STATUS_REFUNDED = 'refunded';

    public const STATUS_FAILED = 'failed';

    public const METHOD_CREDIT_CARD = 'Credit Card';

    public const METHOD_DEBIT_CARD = 'Debit Card';

    public const METHOD_BANK_TRANSFER = 'Bank Transfer';

    public const METHOD_PSE_DEBIT = 'PSE Debit';

    public const SIMULATED_RESULT_SUCCESS = 'success';

    public const SIMULATED_RESULT_FAILURE = 'failure';

    public $timestamps = true;

    protected $fillable = [
        'reservation_id',
        'code',
        'amount',
        'method',
        'transaction_code',
        'status',
        'date',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'float',
            'date' => 'date',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function getId(): int
    {
        return (int) $this->attributes['id'];
    }

    public function getReservationId(): ?int
    {
        return isset($this->attributes['reservation_id'])
            ? (int) $this->attributes['reservation_id']
            : null;
    }

    public function setReservationId(?int $reservationId): void
    {
        $this->attributes['reservation_id'] = $reservationId;
    }

    public function getCode(): int
    {
        return (int) $this->attributes['code'];
    }

    public function setCode(int $code): void
    {
        $this->attributes['code'] = $code;
    }

    public function getAmount(): float
    {
        return (float) $this->attributes['amount'];
    }

    public function setAmount(float $amount): void
    {
        $this->attributes['amount'] = $amount;
    }

    public function getMethod(): string
    {
        return $this->attributes['method'];
    }

    public function setMethod(string $method): void
    {
        $this->attributes['method'] = $method;
    }

    public function getTransactionCode(): int
    {
        return (int) $this->attributes['transaction_code'];
    }

    public function setTransactionCode(int $transactionCode): void
    {
        $this->attributes['transaction_code'] = $transactionCode;
    }

    public function getStatus(): string
    {
        return $this->attributes['status'];
    }

    public function setStatus(string $status): void
    {
        $this->attributes['status'] = $status;
    }

    public function getDate(): ?Carbon
    {
        return isset($this->attributes['date'])
            ? Carbon::parse($this->attributes['date'])
            : null;
    }

    public function setDate(Carbon|string $date): void
    {
        $this->attributes['date'] = $date instanceof Carbon ? $date->toDateString() : $date;
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

    public function isCompleted(): bool
    {
        return $this->getStatus() === self::STATUS_COMPLETED;
    }

    public function isFailed(): bool
    {
        return $this->getStatus() === self::STATUS_FAILED;
    }

    public function isRefunded(): bool
    {
        return $this->getStatus() === self::STATUS_REFUNDED;
    }

    public function getStatusBadgeClass(): string
    {
        return match ($this->getStatus()) {
            self::STATUS_COMPLETED => 'bg-success text-white',
            self::STATUS_FAILED => 'bg-danger text-white',
            self::STATUS_REFUNDED => 'bg-secondary text-white',
            default => 'bg-warning text-dark',
        };
    }

    /**
     * @return list<string>
     */
    public static function availableMethods(): array
    {
        return [
            self::METHOD_CREDIT_CARD,
            self::METHOD_DEBIT_CARD,
            self::METHOD_BANK_TRANSFER,
            self::METHOD_PSE_DEBIT,
        ];
    }

    public static function methodLabel(string $method): string
    {
        return match ($method) {
            self::METHOD_CREDIT_CARD => __('payment.method_credit_card'),
            self::METHOD_DEBIT_CARD => __('payment.method_debit_card'),
            self::METHOD_BANK_TRANSFER => __('payment.method_bank_transfer'),
            self::METHOD_PSE_DEBIT => __('payment.method_pse_debit'),
            default => $method,
        };
    }

    public function getMethodLabel(): string
    {
        return self::methodLabel($this->getMethod());
    }

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }

    public function getReservation(): ?Reservation
    {
        return $this->relationLoaded('reservation') ? $this->getRelation('reservation') : null;
    }

    public function setReservation(?Reservation $reservation): void
    {
        $this->setRelation('reservation', $reservation);
    }
}
