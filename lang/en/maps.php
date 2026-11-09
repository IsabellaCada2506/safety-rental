<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-11-09
 * Description: English language strings for driving route estimates to rental branches.
 */

return [
    'title_show' => 'Route to branch - Safety Rental',
    'heading' => 'How to get to the branch',
    'subtitle' => 'Estimated driving distance and travel time from your current location.',
    'use_my_location' => 'Estimate route from my location',
    'locating' => 'Reading your current location...',
    'geolocation_denied' => 'Location access was denied. Enable location permissions and try again.',
    'geolocation_unavailable' => 'Your browser could not determine the current location.',
    'distance_label' => 'Distance',
    'duration_label' => 'Travel time',
    'distance_value' => ':value km',
    'duration_value' => ':value min',
    'origin_label' => 'Origin coordinates',
    'destination_label' => 'Pickup branch',
    'back_to_catalog' => 'Back to catalog',
    'error_missing_config' => 'The Google Maps route service is not configured. Ask the architect to set GOOGLE_MAPS_API_KEY.',
    'error_connection' => 'The route service could not be reached. Check the network connection and try again.',
    'error_timeout' => 'The route service took too long to respond. Try again in a few minutes.',
    'error_http' => 'The route service returned an HTTP error. The estimate is temporarily unavailable.',
    'error_empty' => 'The route service did not return a driving path for these coordinates.',
    'error_invalid' => 'The route service returned a response that could not be read.',
    'error_missing_destination' => 'This branch does not have map coordinates yet, so a route cannot be estimated.',
    'validation_location_required' => 'Select a pickup branch to estimate the route.',
    'validation_location_not_found' => 'The selected pickup branch was not found.',
    'validation_origin_required' => 'Your current location is required to estimate the route.',
    'validation_origin_invalid' => 'The origin coordinates are not valid.',
];
