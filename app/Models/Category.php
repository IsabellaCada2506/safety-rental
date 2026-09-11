<?php

/**
 * Author: Wendy Atehortua
 * Date: 2026-09-10
 * Description: Category model representing a classification group for rentable vehicles.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * CATEGORY ATTRIBUTES
 * $this->attributes['id']                  - int           - contains the category primary key (id)
 * $this->attributes['model']               - string        - contains the category model name
 * $this->attributes['brand']               - string        - contains the category brand name
 * $this->attributes['type']                - string        - contains the category vehicle type
 * $this->attributes['passenger_capacity']  - int           - contains the passenger capacity
 * $this->attributes['luggage_capacity']    - int           - contains the luggage capacity
 * $this->attributes['created_at']          - string|null   - contains the creation timestamp
 * $this->attributes['updated_at']          - string|null   - contains the update timestamp
 *
 * RELATIONSHIPS
 * $this->cars - Car[] - the cars belonging to this category
 */

class Category extends Model
{
    public $timestamps = true;

    protected $guarded = [
        'id',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getModel(): string
    {
        return $this->attributes['model'];
    }

    public function setModel(string $model): void
    {
        $this->attributes['model'] = $model;
    }

    public function getBrand(): string
    {
        return $this->attributes['brand'];
    }

    public function setBrand(string $brand): void
    {
        $this->attributes['brand'] = $brand;
    }

    public function getType(): string
    {
        return $this->attributes['type'];
    }

    public function setType(string $type): void
    {
        $this->attributes['type'] = $type;
    }

    public function getPassengerCapacity(): int
    {
        return (int) $this->attributes['passenger_capacity'];
    }

    public function setPassengerCapacity(int $passengerCapacity): void
    {
        $this->attributes['passenger_capacity'] = $passengerCapacity;
    }

    public function getLuggageCapacity(): int
    {
        return (int) $this->attributes['luggage_capacity'];
    }

    public function setLuggageCapacity(int $luggageCapacity): void
    {
        $this->attributes['luggage_capacity'] = $luggageCapacity;
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

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }

    public function getCars(): Collection
    {
        return $this->getRelation('cars');
    }

    public function setCars(Collection $cars): void
    {
        $this->setRelation('cars', $cars);
    }

    public function getCarsCount(): int
    {
        return (int) ($this->attributes['cars_count'] ?? $this->cars()->count());
    }
}
