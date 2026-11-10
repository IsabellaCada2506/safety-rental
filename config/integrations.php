<?php

return [
    'partner' => [
        'url' => env('PARTNER_API_URL', ''),
        'items_path' => env('PARTNER_API_ITEMS_PATH', 'data'),
        'timeout' => 8,
    ],
    'google_maps' => [
        'key' => env('GOOGLE_MAPS_API_KEY', ''),
        'timeout' => 10,
    ],
];
