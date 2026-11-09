<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-11-09
 * Description: Data object representing a normalized vehicle record consumed from the preceding team API.
 */

namespace App\Data;

final class PartnerVehicleData
{
    private ?string $make;

    private ?string $model;

    private ?string $category;

    private ?string $location;

    private ?int $dailyRate;

    private string $availability;

    private ?string $detailUrl;

    public function __construct(
        ?string $make,
        ?string $model,
        ?string $category,
        ?string $location,
        ?int $dailyRate,
        string $availability,
        ?string $detailUrl
    ) {
        $this->make = $make;
        $this->model = $model;
        $this->category = $category;
        $this->location = $location;
        $this->dailyRate = $dailyRate;
        $this->availability = $availability;
        $this->detailUrl = $detailUrl;
    }

    public function getMake(): ?string
    {
        return $this->make;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function getDailyRate(): ?int
    {
        return $this->dailyRate;
    }

    public function getAvailability(): string
    {
        return $this->availability;
    }

    public function getDetailUrl(): ?string
    {
        return $this->detailUrl;
    }

    public function getDisplayName(): string
    {
        $parts = [];

        if ($this->make !== null && $this->make !== '') {
            $parts[] = $this->make;
        }

        if ($this->model !== null && $this->model !== '') {
            $parts[] = $this->model;
        }

        if ($parts === []) {
            return __('partner.unknown_vehicle');
        }

        return implode(' ', $parts);
    }

    public function isAvailable(): bool
    {
        return $this->availability === 'available';
    }
}
