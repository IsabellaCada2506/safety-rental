<?php

/**
 * Author: Alejandro
 * Date: 07/09/2026
 * Description: Location model, represents a rental branch used by reservations.
 *
 * Coordination stub for TASK-10 foreign keys. TASK-11 owns the full Location domain.
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
 * @property string|null $city
 * @property string|null $address
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Location extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'name',
        'city',
        'address',
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

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): void
    {
        $this->address = $address;
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
}
