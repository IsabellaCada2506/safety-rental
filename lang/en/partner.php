<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-11-09
 * Description: English language strings for the preceding team fleet integration.
 */

return [
    'title_index' => 'Partner Fleet - Safety Rental',
    'heading' => 'Partner vehicles',
    'subtitle' => 'Vehicles currently published by our allied rental team, loaded live from their public API.',
    'nav' => 'Partners',
    'available' => 'Available',
    'unavailable' => 'Unavailable',
    'unknown_vehicle' => 'Partner vehicle',
    'unknown_category' => 'Unspecified',
    'view_details' => 'View partner details',
    'empty_title' => 'No partner vehicles right now',
    'empty_body' => 'The allied API responded successfully, but it did not return vehicles available for rent.',
    'error_missing_config' => 'The partner API URL is not configured. Ask the architect to set PARTNER_API_URL.',
    'error_connection' => 'The partner service could not be reached. Check the network connection and try again.',
    'error_timeout' => 'The partner service took too long to respond. Try again in a few minutes.',
    'error_http' => 'The partner service returned an HTTP error. The allied catalog is temporarily unavailable.',
    'error_empty' => 'The partner service did not return vehicle data.',
    'error_invalid' => 'The partner service returned a response that could not be read as vehicle data.',
];
