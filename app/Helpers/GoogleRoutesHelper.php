<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-11-09
 * Description: HTTP helper that estimates driving distance and duration through the Google Maps Routes API.
 */

namespace App\Helpers;

use App\Data\RouteEstimateData;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

final class GoogleRoutesHelper
{
    public const ERROR_MISSING_CONFIG = 'missing_config';

    public const ERROR_CONNECTION = 'connection';

    public const ERROR_TIMEOUT = 'timeout';

    public const ERROR_HTTP = 'http';

    public const ERROR_EMPTY = 'empty';

    public const ERROR_INVALID = 'invalid';

    private function __construct() {}

    public static function estimateDrivingRoute(
        float $originLatitude,
        float $originLongitude,
        float $destinationLatitude,
        float $destinationLongitude
    ): RouteEstimateData {
        $apiKey = config('services.google.maps_api_key');
        $routesUrl = config('services.google.routes_url');
        $timeoutSeconds = (int) config('services.google.timeout', 8);

        if (! is_string($apiKey) || trim($apiKey) === '' || ! is_string($routesUrl) || trim($routesUrl) === '') {
            return new RouteEstimateData(false, null, null, self::ERROR_MISSING_CONFIG);
        }

        try {
            $response = Http::timeout($timeoutSeconds)
                ->connectTimeout(min($timeoutSeconds, 5))
                ->acceptJson()
                ->withHeaders([
                    'X-Goog-Api-Key' => $apiKey,
                    'X-Goog-FieldMask' => 'routes.duration,routes.distanceMeters',
                ])
                ->post($routesUrl, [
                    'origin' => [
                        'location' => [
                            'latLng' => [
                                'latitude' => $originLatitude,
                                'longitude' => $originLongitude,
                            ],
                        ],
                    ],
                    'destination' => [
                        'location' => [
                            'latLng' => [
                                'latitude' => $destinationLatitude,
                                'longitude' => $destinationLongitude,
                            ],
                        ],
                    ],
                    'travelMode' => 'DRIVE',
                    'routingPreference' => 'TRAFFIC_AWARE',
                    'languageCode' => app()->getLocale() === 'es' ? 'es-CO' : 'en-US',
                    'units' => 'METRIC',
                ]);
        } catch (ConnectionException $exception) {
            $exceptionMessage = strtolower($exception->getMessage());
            $errorKey = str_contains($exceptionMessage, 'timeout') || str_contains($exceptionMessage, 'timed out')
                ? self::ERROR_TIMEOUT
                : self::ERROR_CONNECTION;

            return new RouteEstimateData(false, null, null, $errorKey);
        }

        if ($response->failed()) {
            return new RouteEstimateData(false, null, null, self::ERROR_HTTP);
        }

        $payload = $response->json();

        if (! is_array($payload) || ! isset($payload['routes']) || ! is_array($payload['routes']) || $payload['routes'] === []) {
            return new RouteEstimateData(false, null, null, self::ERROR_EMPTY);
        }

        $firstRoute = $payload['routes'][0];

        if (! is_array($firstRoute) || ! isset($firstRoute['distanceMeters'])) {
            return new RouteEstimateData(false, null, null, self::ERROR_INVALID);
        }

        $distanceMeters = (int) $firstRoute['distanceMeters'];
        $durationSeconds = self::parseDurationSeconds($firstRoute['duration'] ?? null);

        if ($distanceMeters <= 0 || $durationSeconds === null) {
            return new RouteEstimateData(false, null, null, self::ERROR_INVALID);
        }

        return new RouteEstimateData(true, $distanceMeters, $durationSeconds, null);
    }

    private static function parseDurationSeconds(mixed $duration): ?int
    {
        if (is_numeric($duration)) {
            return (int) $duration;
        }

        if (! is_string($duration) || $duration === '') {
            return null;
        }

        if (preg_match('/^([0-9]+)s$/', $duration, $matches) !== 1) {
            return null;
        }

        return (int) $matches[1];
    }
}
