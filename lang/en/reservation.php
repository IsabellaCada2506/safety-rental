<?php

/**
 * English localization strings for the Reservations module.
 */

return [
    'title_my_reservations' => 'My Reservations',
    'title_create' => 'Create Reservation',
    'title_show' => 'Reservation Detail #:code',
    'admin_title_index' => 'Reservation Management',
    'admin_title_show' => 'Reservation Audit #:code',

    'state_pending' => 'Pending',
    'state_confirmed' => 'Confirmed',
    'state_cancelled' => 'Cancelled',
    'state_completed' => 'Completed',

    'reservation_code' => 'Reservation Code',
    'code' => 'Code',
    'status' => 'Status',
    'dates' => 'Rental Dates',
    'start_date' => 'Start Date',
    'end_date' => 'End Date',
    'pickup_location' => 'Pickup / Return Branch',
    'select_location' => 'Select a branch',
    'vehicle' => 'Vehicle',
    'customer' => 'Customer',
    'daily_rate' => 'Daily Rate',
    'rental_days' => 'Rental Days',
    'total_price' => 'Estimated Total',
    'days_unit' => 'day(s)',
    'actions' => 'Actions',

    'confirm_booking' => 'Confirm & Reserve',
    'cancel_reservation' => 'Cancel Reservation',
    'confirm_reservation' => 'Confirm Reservation',
    'view_details' => 'View Details',
    'back_to_list' => 'Back to my reservations',
    'back_to_admin_list' => 'Back to administrative list',
    'filter_all' => 'All',
    'no_reservations' => 'No reservations found.',
    'cancellation_confirm' => 'Are you sure you want to cancel this reservation? This will make the vehicle available for other users.',

    'created_success' => 'Your reservation has been created successfully! Current state: Pending.',
    'confirmed_success' => 'The reservation has been confirmed successfully.',
    'cancelled_success' => 'The reservation has been cancelled successfully.',

    'car_unavailable' => 'The selected vehicle is not available for the requested date range due to an overlapping reservation.',
    'start_date_past_error' => 'The start date cannot be prior to today.',
    'end_date_order_error' => 'The end date must be after the start date.',
    'car_not_found' => 'The selected car is not valid.',
    'location_not_found' => 'The selected location is not valid.',
    'cancellation_not_allowed' => 'This reservation can no longer be cancelled.',
    'transition_not_allowed' => 'The requested status transition is not allowed.',

    'summary_heading' => 'Rental Summary',
    'customer_info' => 'Customer Information',
    'vehicle_info' => 'Vehicle Information',
];
