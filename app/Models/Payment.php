<?php

/**
 * Author: Alejandro
 * Date: 07/09/2026
 * Description: Payment model, represents a simulated payment for a reservation.
 *
 * Coordination stub for TASK-10 inverse relation. TASK-09 owns the full Payment domain.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $reserve_id
 * @property string $amount
 * @property string $status
 * @property string|null $reference
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Payment extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';

    public const STATUS_SUCCESS = 'success';

    public const STATUS_FAILED = 'failed';

    public const STATUS_REFUNDED = 'refunded';

    public $timestamps = true;

    protected $fillable = [
        'reserve_id',
        'amount',
        'status',
        'reference',
    ];

    protected $guarded = [
        'id',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReserveId(): int
    {
        return $this->reserve_id;
    }

    public function setReserveId(int $reserveId): void
    {
        $this->reserve_id = $reserveId;
    }

    public function getAmount(): string
    {
        return (string) $this->amount;
    }

    public function setAmount(string $amount): void
    {
        $this->amount = $amount;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): void
    {
        $this->reference = $reference;
    }

    public function getCreatedAt(): ?Carbon
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?Carbon
    {
        return $this->updated_at;
    }

    public function reserve(): BelongsTo
    {
        return $this->belongsTo(Reserve::class);
    }

    public function getReserve(): ?Reserve
    {
        return $this->reserve;
    }

    public function setReserve(Reserve $reserve): void
    {
        $this->reserve()->associate($reserve);
    }

    public function isSuccessful(): bool
    {
        return $this->getStatus() === self::STATUS_SUCCESS;
    }
}
