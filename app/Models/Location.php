<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Location model representing physical branches where vehicles can be picked up and returned.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * LOCATION ATTRIBUTES
 * $this->attributes['id']           - int         - contains the location primary key (id)
 * $this->attributes['name']         - string      - contains the branch name
 * $this->attributes['address']      - string      - contains the branch physical address
 * $this->attributes['headquarters'] - string      - contains the headquarters identifier
 * $this->attributes['telephone']    - string      - contains the contact telephone number
 * $this->attributes['city']         - string      - contains the city where the branch is located
 * $this->attributes['created_at']   - string|null - contains the creation timestamp
 * $this->attributes['updated_at']   - string|null - contains the update timestamp
 *
 * RELATIONSHIPS
 * $this->reservations - Collection<int, Reservation> - the reservations associated with this location
 * $this->cars - Collection<int, Car> - the cars stationed at this location
 */
class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'headquarters',
        'telephone',
        'city',
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
        return (int) $this->attributes['id'];
    }

    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function setName(string $name): void
    {
        $this->attributes['name'] = $name;
    }

    public function getAddress(): string
    {
        return $this->attributes['address'];
    }

    public function setAddress(string $address): void
    {
        $this->attributes['address'] = $address;
    }

    public function getHeadquarters(): string
    {
        return $this->attributes['headquarters'];
    }

    public function setHeadquarters(string $headquarters): void
    {
        $this->attributes['headquarters'] = $headquarters;
    }

    public function getTelephone(): string
    {
        return $this->attributes['telephone'];
    }

    public function setTelephone(string $telephone): void
    {
        $this->attributes['telephone'] = $telephone;
    }

    public function getCity(): string
    {
        return $this->attributes['city'];
    }

    public function setCity(string $city): void
    {
        $this->attributes['city'] = $city;
    }

    public function getCreatedAt(): ?Carbon
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?Carbon
    {
        return $this->updated_at;
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function getReservations(): Collection
    {
        return $this->relationLoaded('reservations') ? $this->getRelation('reservations') : new Collection;
    }

    public function setReservations(Collection $reservations): void
    {
        $this->setRelation('reservations', $reservations);
    }

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }

    public function getCars(): Collection
    {
        return $this->relationLoaded('cars') ? $this->getRelation('cars') : new Collection;
    }

    public function setCars(Collection $cars): void
    {
        $this->setRelation('cars', $cars);
    }

    public function getCarsCount(): int
    {
        return (int) ($this->attributes['cars_count'] ?? 0);
    }

    public function getReservationsCount(): int
    {
        return (int) ($this->attributes['reservations_count'] ?? 0);
    }
}
