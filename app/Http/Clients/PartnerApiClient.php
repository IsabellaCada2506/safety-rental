<?php

/**
 * Author: Isabella Cadavid Posada
 * Date: 2026-11-07
 * Description: HTTP client fetching partner business listings from an external REST API.
 */

namespace App\Http\Clients;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class PartnerApiClient
{
    public function fetch(): array
    {
        $url = (string) config('integrations.partner.url');
        if (! filter_var($url, FILTER_VALIDATE_URL) || ! in_array(parse_url($url, PHP_URL_SCHEME), ['https', 'http'], true)) {
            return ['items' => [], 'error' => 'unconfigured'];
        }

        try {
            $response = Http::acceptJson()->connectTimeout(3)
                ->timeout((int) config('integrations.partner.timeout'))
                ->withOptions(['allow_redirects' => false])->get($url);
            if (! $response->successful()) {
                return ['items' => [], 'error' => 'unavailable'];
            }
            $payload = $response->json();
            $path = (string) config('integrations.partner.items_path');
            $items = $path === '' ? $payload : data_get($payload, $path);
            if (! is_array($items) || ! array_is_list($items)) {
                return ['items' => [], 'error' => 'invalid_response'];
            }
            if ($items === []) {
                return ['items' => [], 'error' => 'empty'];
            }
            foreach ($items as $item) {
                if (! is_array($item)) {
                    return ['items' => [], 'error' => 'invalid_response'];
                }
            }

            return ['items' => $items, 'error' => null];
        } catch (ConnectionException) {
            return ['items' => [], 'error' => 'connection'];
        }
    }
}
