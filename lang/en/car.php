<?php

/**
 * Author: Wendy
 * Date: 09/09/2026
 * Description: English language strings for the car management module.
 */

return [
    'title_index' => 'Car Management - Safety Rental Admin',
    'title_create' => 'Register Car - Safety Rental Admin',
    'title_edit' => 'Edit Car - Safety Rental Admin',

    'heading_management' => 'Vehicle Inventory Management',
    'registered_vehicles' => 'Registered Vehicles',
    'register_new_car' => 'Register New Vehicle',
    'edit_vehicle' => 'Edit Vehicle: :plate',

    'manage_cars' => 'Manage Cars',

    // Table Headers
    'id' => 'ID',
    'plate' => 'Plate',
    'color' => 'Color',
    'soat' => 'SOAT',
    'price_per_day' => 'Price / Day',
    'mileage' => 'Mileage',
    'status' => 'Status',
    'actions' => 'Actions',

    // Badges & Status
    'status_active' => 'Active',
    'status_deactivated' => 'Deactivated',

    // Form Labels
    'plate_label' => 'License Plate',
    'color_label' => 'Color',
    'soat_label' => 'SOAT Code',
    'transit_license_label' => 'Transit License ID',
    'price_label' => 'Rental Price per Day ($)',
    'mileage_label' => 'Current Mileage (km)',
    'image_label' => 'Image URL',
    'description_label' => 'Description / Observations',

    // Placeholders
    'plate_placeholder' => 'e.g. ABC-123 or ABC123',
    'color_placeholder' => 'e.g. Metallic Blue',
    'soat_placeholder' => 'SOAT Insurance identifier',
    'transit_license_placeholder' => 'Transit Certificate #',
    'mileage_placeholder' => 'e.g. 35000',
    'image_placeholder' => 'https://example.com/car.jpg',
    'description_placeholder' => 'Transmission, features or physical state details',

    // Buttons
    'btn_create' => 'Register New Car',
    'btn_save' => 'Save Vehicle',
    'btn_edit' => 'Edit',
    'btn_update' => 'Update Vehicle',
    'btn_cancel' => 'Cancel',
    'btn_deactivate' => 'Deactivate',
    'btn_activate' => 'Activate',

    // Messages and Alerts
    'no_cars_found' => 'No cars found in inventory. Click "+ Register New Car" to add one.',
    'created_success' => 'Car created successfully.',
    'updated_success' => 'Car updated successfully.',
    'deactivated_success' => 'Car deactivated successfully.',
    'activated_success' => 'Car activated successfully.',
    'btn_deactivate' => 'Deactivate',
    'btn_activate' => 'Activate',
    'btn_edit' => 'Edit',
    'confirm_status_change' => 'Are you sure you want to change the car status?',
    'deactivate_error_reservations' => 'Cannot deactivate car with active reservations.',

    // Validation
    'plate_regex_error' => 'The plate format is invalid for Colombia. It must be 3 letters followed by 3 numbers (e.g., ABC-123 or ABC123).',
    'price_min_error' => 'The rental price per day must be at least $50,000 COP.',
];
