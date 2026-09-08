<?php

/**
 * Author: Alejandro
 * Date: 07/09/2026
 * Description: State model, represents a reservation lifecycle status.
 *
 * Coordination stub for TASK-10 foreign keys. TASK-08 owns the full State domain.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class State extends Model
{
    use HasFactory;

    public const NAME_PENDING = 'pending';

    public const NAME_CONFIRMED = 'confirmed';

    public const NAME_CANCELLED = 'cancelled';

    public const NAME_COMPLETED = 'completed';

    public $timestamps = true;

    protected $fillable = [
        'name',
    ];

    protected $guarded = [
        'id',
    ];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCreatedAt(): ?Carbon
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?Carbon
    {
        return $this->updated_at;
    }

    public function reserves(): HasMany
    {
        return $this->hasMany(Reserve::class);
    }

    public function getReserves(): Collection
    {
        return $this->reserves;
    }

    public function isCancelled(): bool
    {
        return $this->getName() === self::NAME_CANCELLED;
    }

    public function isCompleted(): bool
    {
        return $this->getName() === self::NAME_COMPLETED;
    }
}
