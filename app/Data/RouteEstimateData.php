<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-11-09
 * Description: Data object holding a driving distance and duration estimate from Google Routes.
 */

namespace App\Data;

final class RouteEstimateData
{
    private bool $ok;

    private ?int $distanceMeters;

    private ?int $durationSeconds;

    private ?string $errorKey;

    public function __construct(bool $ok, ?int $distanceMeters, ?int $durationSeconds, ?string $errorKey)
    {
        $this->ok = $ok;
        $this->distanceMeters = $distanceMeters;
        $this->durationSeconds = $durationSeconds;
        $this->errorKey = $errorKey;
    }

    public function isOk(): bool
    {
        return $this->ok;
    }

    public function getDistanceMeters(): ?int
    {
        return $this->distanceMeters;
    }

    public function getDurationSeconds(): ?int
    {
        return $this->durationSeconds;
    }

    public function getErrorKey(): ?string
    {
        return $this->errorKey;
    }

    public function getDistanceKilometers(): string
    {
        if ($this->distanceMeters === null) {
            return '0';
        }

        return number_format($this->distanceMeters / 1000, 1, ',', '.');
    }

    public function getDurationMinutes(): int
    {
        if ($this->durationSeconds === null) {
            return 0;
        }

        return (int) ceil($this->durationSeconds / 60);
    }
}
