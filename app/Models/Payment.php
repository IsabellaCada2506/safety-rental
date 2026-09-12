<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Payment model representing rental transaction records.
 */

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\PaymentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property int $code
 * @property float $amount
 * @property string $method
 * @property int $transaction_code
 * @property string $status
 * @property Carbon|null $date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Reservation|null $reservation
 */
class Payment extends Model
{
    /** @use HasFactory<PaymentFactory> */
    use HasFactory;

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_PENDING = 'pending';

    public const STATUS_REFUNDED = 'refunded';

    public $timestamps = true;

    protected $guarded = [
        'id',
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

    public function reservation(): HasOne
    {
        return $this->hasOne(Reservation::class);
    }

    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }
}
