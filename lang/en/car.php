<?php

/**
 * Author: Wendy Atehortua
 * Date: 2026-09-11
 * Description: English language strings for the car management module.
 */

return [
    'title_index' => 'Car Management - Safety Rental Admin',
    'title_create' => 'Register Car - Safety Rental Admin',
    'title_edit' => 'Edit Car - Safety Rental Admin',

    'admin_area' => 'Admin Area',
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
    'price' => 'Price / Day',
    'mileage' => 'Mileage',
    'status' => 'Status',
    'branch' => 'Branch',
    'actions' => 'Actions',

    // Badges & Status
    'status_active' => 'Active',
    'status_deactivated' => 'Desactivated',

    // Form Labels
    'plate_label' => 'License Plate',
    'color_label' => 'Color',
    'soat_label' => 'SOAT Code',
    'transit_license_label' => 'Transit License ID',
    'price_label' => 'Rental Price per Day ($)',
    'mileage_label' => 'Current Mileage (km)',
    'image_label' => 'Image URL',
    'description_label' => 'Description / Observations',
    'category_label' => 'Category',
    'category_placeholder' => 'Select a category',
    'location_label' => 'Branch Location',
    'location_placeholder' => 'Select a branch location',
    'image_alt' => 'Car image',

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
    'btn_deactivate' => 'Desactivate',
    'btn_activate' => 'Activate',

    // Placeholders (continued)
    'price_placeholder' => 'e.g. 80000',

    // Messages and Alerts
    'no_cars_found' => 'No cars found in inventory. Click "+ Register New Car" to add one.',
    'created_success' => 'Car created successfully.',
    'updated_success' => 'Car updated successfully.',
    'deactivated_success' => 'Car desactivated successfully.',
    'activated_success' => 'Car activated successfully.',
    'confirm_status_change' => 'Are you sure you want to change the car status?',
    'deactivate_error_reservations' => 'Cannot desactivate car with active reservations.',

    // Validation
    'plate_regex_error' => 'The plate format is invalid for Colombia. It must be 3 letters followed by 3 numbers (e.g., ABC-123 or ABC123).',
    'price_min_error' => 'The rental price per day must be at least $50,000 COP.',
];
