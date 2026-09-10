<?php

/**
 * Author: Wendy
 * Date: 09/09/2026
 * Description: Spanish language strings for the car management module.
 */

return [
    'title_index' => 'Gestión de Coches - Admin Safety Rental',
    'title_create' => 'Registrar Coche - Admin Safety Rental',
    'title_edit' => 'Editar Coche - Admin Safety Rental',

    'heading_management' => 'Gestión del Inventario de Vehículos',
    'registered_vehicles' => 'Vehículos Registrados',
    'register_new_car' => 'Registrar Nuevo Vehículo',
    'edit_vehicle' => 'Editar Vehículo: :plate',

    'manage_cars' => 'Gestionar Coches',

    'id' => 'ID',
    'plate' => 'Placa',
    'color' => 'Color',
    'soat' => 'SOAT',
    'price_per_day' => 'Precio / Día',
    'mileage' => 'Kilometraje',
    'status' => 'Estado',
    'actions' => 'Acciones',

    'status_active' => 'Activo',
    'status_deactivated' => 'Desactivado',

    'plate_label' => 'Placa de Vehículo',
    'color_label' => 'Color',
    'soat_label' => 'Código SOAT',
    'transit_license_label' => 'Licencia de Tránsito',
    'price_label' => 'Precio de Alquiler por Día ($)',
    'mileage_label' => 'Kilometraje Actual (km)',
    'image_label' => 'URL de Imagen',
    'description_label' => 'Descripción / Observaciones',

    'plate_placeholder' => 'Ej: ABC-123 o ABC123',
    'color_placeholder' => 'Ej: Azul Metálico',
    'soat_placeholder' => 'Identificador de póliza SOAT',
    'transit_license_placeholder' => 'N° de Certificado de Tránsito',
    'mileage_placeholder' => 'Ej: 35000',
    'image_placeholder' => 'https://ejemplo.com/carro.jpg',
    'description_placeholder' => 'Transmisión, características o estado físico',

    'btn_create' => '+ Registrar Nuevo Coche',
    'btn_save' => 'Guardar Vehículo',
    'btn_edit' => 'Editar',
    'btn_update' => 'Actualizar Vehículo',
    'btn_cancel' => 'Cancelar',
    'btn_deactivate' => 'Desactivar',
    'btn_activate' => 'Activar',

    'no_cars_found' => 'No se encontraron coches en el inventario. Haz clic en "+ Registrar Nuevo Coche" para agregar uno.',
    'confirm_status_change' => '¿Confirmas el cambio de estado del coche?',
    'created_success' => 'Coche registrado con éxito en el inventario.',
    'updated_success' => 'Detalles del coche actualizados con éxito.',
    'activated_success' => 'Coche activado con éxito.',
    'deactivated_success' => 'Coche retirado de forma segura del inventario de alquiler.',
    'deactivate_error_reservations' => 'No se puede desactivar el coche: actualmente está vinculado a reservas activas o futuras.',

    'plate_regex_error' => 'El formato de placa no es válido para Colombia. Debe tener 3 letras seguidas de 3 números (ej. ABC-123 o ABC123).',
    'price_min_error' => 'El precio de alquiler por día debe ser de al menos $50.000 COP.',
];