<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Location model representing physical branches where vehicles can be picked up and returned.
 */

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\LocationFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $headquarters
 * @property string $telephone
 * @property string $city
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Collection<int, Reservation> $reservations
 * @property Collection<int, Car> $cars
 */
class Location extends Model
{
    /** @use HasFactory<LocationFactory> */
    use HasFactory;

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

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }

    public function getCars(): Collection
    {
        return $this->cars;
    }
}
