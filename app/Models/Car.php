<?php

/**
 * Author: Wendy Atehortua
 * Date: 2026-09-09
 * Description: Car model representing the rentable vehicles in inventory.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * CAR ATTRIBUTES
 * $this->attributes['id']              - int         - contains the car primary key (id)
 * $this->attributes['plate']           - string      - contains the vehicle license plate
 * $this->attributes['color']           - string      - contains the car color
 * $this->attributes['soat']            - string      - contains the SOAT insurance identifier
 * $this->attributes['price']           - int         - contains the rental price per day
 * $this->attributes['transit_license'] - string      - contains the transit license number
 * $this->attributes['description']     - string|null - contains additional notes or physical state
 * $this->attributes['mileage']         - int         - contains the current mileage in km
 * $this->attributes['image']           - string|null - contains the car photo URL or path
 * $this->attributes['status']          - string      - contains the car availability status
 * $this->attributes['category_id']     - int|null    - foreign key referencing the category
 * $this->attributes['created_at']      - string      - contains the creation timestamp
 * $this->attributes['updated_at']      - string      - contains the update timestamp
 *
 * RELATIONSHIPS
 * $this->category - Category|null - the classification category this car belongs to
 */
class Car extends Model
{
    public const STATUS_ACTIVE = 'Active';

    public const STATUS_DEACTIVATED = 'Deactivated';

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
        return (int) $this->attributes['price'];
    }

    public function setPrice(int $price): void
    {
        $this->attributes['price'] = $price;
    }

    public function getMileage(): int
    {
        return (int) $this->attributes['mileage'];
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

    public function isActive(): bool
    {
        return $this->getStatus() === self::STATUS_ACTIVE;
    }

    public function getCategoryId(): ?int
    {
        return isset($this->attributes['category_id']) ? (int) $this->attributes['category_id'] : null;
    }

    public function setCategoryId(?int $categoryId): void
    {
        $this->attributes['category_id'] = $categoryId;
    }

    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    public function getUpdatedAt(): string
    {
        return $this->attributes['updated_at'];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getCategory(): ?Category
    {
        return $this->getRelation('category');
    }

    public function setCategory(?Category $category): void
    {
        $this->setRelation('category', $category);
    }
}
