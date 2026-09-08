<?php

/**
 * Author: Alejandro
 * Date: 07/09/2026
 * Description: Car model, represents a rentable vehicle referenced by reservations.
 *
 * Coordination stub for TASK-10 foreign keys. TASK-09 owns the full Car domain.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $plate
 * @property string|null $brand
 * @property string|null $model_name
 * @property string $daily_rate
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Car extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'plate',
        'brand',
        'model_name',
        'daily_rate',
    ];

    protected $guarded = [
        'id',
    ];

    protected function casts(): array
    {
        return [
            'daily_rate' => 'decimal:2',
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlate(): string
    {
        return $this->plate;
    }

    public function setPlate(string $plate): void
    {
        $this->plate = $plate;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(?string $brand): void
    {
        $this->brand = $brand;
    }

    public function getModelName(): ?string
    {
        return $this->model_name;
    }

    public function setModelName(?string $modelName): void
    {
        $this->model_name = $modelName;
    }

    public function getDailyRate(): string
    {
        return (string) $this->daily_rate;
    }

    public function setDailyRate(string $dailyRate): void
    {
        $this->daily_rate = $dailyRate;
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
