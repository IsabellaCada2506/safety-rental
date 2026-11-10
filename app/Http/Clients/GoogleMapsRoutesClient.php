<?php

/**
 * Author: Wendy Atehortua
 * Date: 2026-11-07
 * Description: HTTP client wrapping the Google Maps Routes API v2 to calculate driving routes.
 */

namespace App\Http\Clients;

use App\Models\Location;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class GoogleMapsRoutesClient
{
    public function calculate(
        array $originData,
        ?Location $location,
        string $locale
    ): array {
        if (
            $location === null
            || trim($location->getAddress()) === ''
            || trim($location->getCity()) === ''
        ) {
            return ['error' => 'missing_destination'];
        }

        if (($originData['origin_type'] ?? '') === 'location') {
            $latitude = $originData['latitude'] ?? null;
            $longitude = $originData['longitude'] ?? null;

            if (
                ! is_numeric($latitude)
                || ! is_numeric($longitude)
                || ! is_finite((float) $latitude)
                || ! is_finite((float) $longitude)
                || abs((float) $latitude) > 90
                || abs((float) $longitude) > 180
            ) {
                return ['error' => 'invalid_origin'];
            }

            $origin = [
                'location' => [
                    'latLng' => [
                        'latitude' => (float) $latitude,
                        'longitude' => (float) $longitude,
                    ],
                ],
            ];

            $originLabel = $latitude.','.$longitude;
        } else {
            $originLabel = trim(
                (string) ($originData['origin_address'] ?? '')
            );

            if ($originLabel === '') {
                return ['error' => 'invalid_origin'];
            }

            $origin = ['address' => $originLabel];
        }

        $destination = $location->getAddress()
            .', '.$location->getCity()
            .', Colombia';

        $key = (string) config('integrations.google_maps.key');

        if ($key === '') {
            return ['error' => 'unconfigured'];
        }

        try {
            $response = Http::acceptJson()
                ->connectTimeout(3)
                ->timeout(
                    (int) config('integrations.google_maps.timeout', 10)
                )
                ->withHeaders([
                    'X-Goog-Api-Key' => $key,
                    'X-Goog-FieldMask' => 'routes.distanceMeters,routes.duration,routes.legs.steps.navigationInstruction.instructions',
                ])
                ->post(
                    'https://routes.googleapis.com/directions/v2:computeRoutes',
                    [
                        'origin' => $origin,
                        'destination' => [
                            'address' => $destination,
                        ],
                        'travelMode' => 'DRIVE',
                        'routingPreference' => 'TRAFFIC_AWARE',
                        'computeAlternativeRoutes' => false,
                        'languageCode' => $locale === 'pt'
                            ? 'pt-BR'
                            : $locale,
                        'regionCode' => 'co',
                        'units' => 'METRIC',
                    ]
                );

            if ($response->status() === 429) {
                return ['error' => 'quota'];
            }

            if (! $response->successful()) {
                return ['error' => 'unavailable'];
            }

            $route = $response->json('routes.0');

            if (
                ! is_array($route)
                || ! is_numeric($route['distanceMeters'] ?? null)
                || (float) $route['distanceMeters'] < 0
                || ! is_string($route['duration'] ?? null)
                || ! preg_match(
                    '/^([0-9]+(?:\.[0-9]+)?)s$/',
                    $route['duration'],
                    $duration
                )
            ) {
                return ['error' => 'no_route'];
            }

            $instructions = [];
            $legs = $route['legs'] ?? [];

            if (! is_array($legs)) {
                return ['error' => 'no_route'];
            }

            foreach ($legs as $leg) {
                if (
                    ! is_array($leg)
                    || ! is_array($leg['steps'] ?? [])
                ) {
                    return ['error' => 'no_route'];
                }

                foreach (($leg['steps'] ?? []) as $step) {
                    $instruction = data_get(
                        $step,
                        'navigationInstruction.instructions'
                    );

                    if (
                        is_string($instruction)
                        && $instruction !== ''
                    ) {
                        $instructions[] = $instruction;
                    }
                }
            }

            return [
                'error' => null,
                'distanceKm' => round(
                    (float) $route['distanceMeters'] / 1000,
                    1
                ),
                'durationMinutes' => (int) ceil(
                    (float) $duration[1] / 60
                ),
                'instructions' => $instructions,
                'mapsUrl' => 'https://www.google.com/maps/dir/?'
                    .http_build_query([
                        'api' => 1,
                        'origin' => $originLabel,
                        'destination' => $destination,
                        'travelmode' => 'driving',
                    ]),
            ];
        } catch (ConnectionException) {
            return ['error' => 'connection'];
        }
    }
}
