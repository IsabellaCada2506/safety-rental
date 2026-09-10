<?php

/**
 * Author: Wendy
 * Date: 09/09/2026
 * Description: Car model representing the rentable vehicles in inventory.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * CAR ATTRIBUTES
 * $this->attributes['id']              - int - contains the car primary key (id)
 * $this->attributes['plate']           - string - contains the vehicle license plate
 * $this->attributes['color']           - string - contains the car color
 * $this->attributes['soat']            - string - contains the SOAT insurance identifier
 * $this->attributes['price']           - int - contains the rental price per day
 * $this->attributes['transit_license'] - string - contains the transit license number
 * $this->attributes['description']     - string|null - contains additional notes or physical state
 * $this->attributes['kilometer']       - string - contains the current mileage
 * $this->attributes['image']           - string|null - contains the car photo URL or path
 * $this->attributes['is_active']       - bool - indicates if the car is available for rent
 * $this->attributes['created_at']      - string - contains the creation timestamp
 * $this->attributes['updated_at']      - string - contains the update timestamp
 */
class Car extends Model
{
    protected $fillable = [
        'plate',
        'color',
        'soat',
        'transit_license',
        'price',
        'mileage',
        'image',
        'description',
        'status',
    ];

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getPlate(): string
    {
        return $this->attributes['plate'];
    }

    public function setPlate(string $plate): void
    {
        $this->attributes['plate'] = $plate;
    }

    public function getColor(): string
    {
        return $this->attributes['color'];
    }

    public function setColor(string $color): void
    {
        $this->attributes['color'] = $color;
    }

    public function getSoat(): string
    {
        return $this->attributes['soat'];
    }

    public function setSoat(string $soat): void
    {
        $this->attributes['soat'] = $soat;
    }

    public function getTransitLicense(): string
    {
        return $this->attributes['transit_license'];
    }

    public function setTransitLicense(string $transitLicense): void
    {
        $this->attributes['transit_license'] = $transitLicense;
    }

    public function getPrice(): int
    {
        return $this->attributes['price_per_day'];
    }

    public function setPrice(int $price): void
    {
        $this->attributes['price_per_day'] = $price;
    }

    public function getMileage(): int
    {
        return $this->attributes['mileage'];
    }

    public function setMileage(int $mileage): void
    {
        $this->attributes['mileage'] = $mileage;
    }

    public function getImage(): ?string
    {
        return $this->attributes['image'] ?? null;
    }

    public function setImage(?string $image): void
    {
        $this->attributes['image'] = $image;
    }

    public function getDescription(): ?string
    {
        return $this->attributes['description'] ?? null;
    }

    public function setDescription(?string $description): void
    {
        $this->attributes['description'] = $description;
    }

    public function getStatus(): string
    {
        return $this->attributes['status'];
    }

    public function setStatus(string $status): void
    {
        $this->attributes['status'] = $status;
    }
}