<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-11-09
 * Description: HTTP helper that consumes the preceding team JSON fleet API and normalizes the response.
 */

namespace App\Helpers;

use App\Data\PartnerVehicleData;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

final class PartnerFleetHelper
{
    public const ERROR_MISSING_CONFIG = 'missing_config';

    public const ERROR_CONNECTION = 'connection';

    public const ERROR_TIMEOUT = 'timeout';

    public const ERROR_HTTP = 'http';

    public const ERROR_EMPTY = 'empty';

    public const ERROR_INVALID = 'invalid';

    private function __construct() {}

    public static function fetchAvailableVehicles(): array
    {
        $partnerApiUrl = config('services.partner.url');
        $partnerApiToken = config('services.partner.token');
        $timeoutSeconds = (int) config('services.partner.timeout', 8);

        if (! is_string($partnerApiUrl) || trim($partnerApiUrl) === '') {
            return [
                'ok' => false,
                'vehicles' => [],
                'errorKey' => self::ERROR_MISSING_CONFIG,
            ];
        }

        try {
            $pendingRequest = Http::timeout($timeoutSeconds)
                ->connectTimeout(min($timeoutSeconds, 5))
                ->acceptJson();

            if (is_string($partnerApiToken) && $partnerApiToken !== '') {
                $pendingRequest = $pendingRequest->withToken($partnerApiToken);
            }

            $response = $pendingRequest->get($partnerApiUrl);
        } catch (ConnectionException $exception) {
            $exceptionMessage = strtolower($exception->getMessage());
            $errorKey = str_contains($exceptionMessage, 'timeout') || str_contains($exceptionMessage, 'timed out')
                ? self::ERROR_TIMEOUT
                : self::ERROR_CONNECTION;

            return [
                'ok' => false,
                'vehicles' => [],
                'errorKey' => $errorKey,
            ];
        }

        if ($response->failed()) {
            return [
                'ok' => false,
                'vehicles' => [],
                'errorKey' => self::ERROR_HTTP,
            ];
        }

        $payload = $response->json();

        if (! is_array($payload)) {
            return [
                'ok' => false,
                'vehicles' => [],
                'errorKey' => self::ERROR_INVALID,
            ];
        }

        $items = self::extractItems($payload);
        $vehicles = [];

        foreach ($items as $item) {
            if (! is_array($item)) {
                continue;
            }

            $vehicles[] = self::mapVehicle($item);
        }

        if ($vehicles === []) {
            return [
                'ok' => true,
                'vehicles' => [],
                'errorKey' => self::ERROR_EMPTY,
            ];
        }

        return [
            'ok' => true,
            'vehicles' => $vehicles,
            'errorKey' => null,
        ];
    }

    private static function extractItems(array $payload): array
    {
        if (array_is_list($payload)) {
            return $payload;
        }

        $collectionKeys = ['vehicles', 'data', 'results', 'items'];

        foreach ($collectionKeys as $collectionKey) {
            if (isset($payload[$collectionKey]) && is_array($payload[$collectionKey])) {
                return $payload[$collectionKey];
            }
        }

        return [];
    }

    private static function mapVehicle(array $item): PartnerVehicleData
    {
        $availabilityValue = self::firstString($item, ['availability', 'disponibilidad', 'status', 'estado']);
        $availability = self::normalizeAvailability($availabilityValue, $item);

        $dailyRateValue = self::firstNumeric($item, ['daily_rate', 'dailyRate', 'price', 'tarifa_diaria', 'tarifa']);

        return new PartnerVehicleData(
            self::firstString($item, ['make', 'brand', 'marca']),
            self::firstString($item, ['model', 'modelo']),
            self::firstString($item, ['category', 'type', 'categoria', 'categoría']),
            self::firstString($item, ['location', 'sede', 'branch', 'ubicacion', 'ubicación']),
            $dailyRateValue,
            $availability,
            self::firstString($item, ['detail_url', 'detailUrl', 'url', 'link'])
        );
    }

    private static function normalizeAvailability(?string $availabilityValue, array $item): string
    {
        if (array_key_exists('available', $item) && is_bool($item['available'])) {
            return $item['available'] ? 'available' : 'unavailable';
        }

        if ($availabilityValue === null) {
            return 'available';
        }

        $normalizedValue = strtolower($availabilityValue);

        if (in_array($normalizedValue, ['unavailable', 'not_available', 'inactive', 'deactivated', 'no disponible'], true)) {
            return 'unavailable';
        }

        return 'available';
    }

    private static function firstString(array $item, array $keys): ?string
    {
        foreach ($keys as $key) {
            if (! array_key_exists($key, $item) || $item[$key] === null) {
                continue;
            }

            $value = trim((string) $item[$key]);

            if ($value !== '') {
                return $value;
            }
        }

        return null;
    }

    private static function firstNumeric(array $item, array $keys): ?int
    {
        foreach ($keys as $key) {
            if (! array_key_exists($key, $item) || ! is_numeric($item[$key])) {
                continue;
            }

            return (int) $item[$key];
        }

        return null;
    }
}
