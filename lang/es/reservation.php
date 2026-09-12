<?php

/**
 * Spanish localization strings for the Reservations module.
 */

return [
    'title_my_reservations' => 'Mis Reservas',
    'title_create' => 'Crear Reserva',
    'title_show' => 'Detalle de Reserva #:code',
    'admin_title_index' => 'Gestión de Reservas',
    'admin_title_show' => 'Auditoría de Reserva #:code',

    'state_pending' => 'Pendiente',
    'state_confirmed' => 'Confirmada',
    'state_cancelled' => 'Cancelada',
    'state_completed' => 'Finalizada',

    'reservation_code' => 'Código de Reserva',
    'code' => 'Código',
    'status' => 'Estado',
    'dates' => 'Fechas de Reserva',
    'start_date' => 'Fecha de Inicio',
    'end_date' => 'Fecha de Finalización',
    'pickup_location' => 'Sede de Entrega / Recogida',
    'select_location' => 'Selecciona una sede',
    'vehicle' => 'Vehículo',
    'customer' => 'Cliente',
    'daily_rate' => 'Tarifa Diaria',
    'rental_days' => 'Días de Alquiler',
    'total_price' => 'Total Estimado',
    'days_unit' => 'día(s)',
    'actions' => 'Acciones',

    'confirm_booking' => 'Confirmar y Reservar',
    'cancel_reservation' => 'Cancelar Reserva',
    'confirm_reservation' => 'Confirmar Reserva',
    'view_details' => 'Ver Detalle',
    'back_to_list' => 'Volver a mis reservas',
    'back_to_admin_list' => 'Volver al listado administrativo',
    'filter_all' => 'Todas',
    'no_reservations' => 'No se encontraron reservas registradas.',
    'cancellation_confirm' => '¿Estás seguro de que deseas cancelar esta reserva? Esta acción liberará el vehículo para otros usuarios.',

    'created_success' => '¡Tu reserva ha sido creada exitosamente! Estado actual: Pendiente.',
    'confirmed_success' => 'La reserva ha sido confirmada satisfactoriamente.',
    'cancelled_success' => 'La reserva ha sido cancelada exitosamente.',

    'car_unavailable' => 'El vehículo seleccionado no se encuentra disponible para el rango de fechas solicitado debido a un solapamiento con otra reserva.',
    'start_date_past_error' => 'La fecha de inicio no puede ser anterior al día de hoy.',
    'end_date_order_error' => 'La fecha final debe ser posterior a la fecha de inicio.',
    'car_not_found' => 'El vehículo seleccionado no es válido.',
    'location_not_found' => 'La sede seleccionada no es válida.',
    'cancellation_not_allowed' => 'Esta reserva ya no puede ser cancelada.',
    'transition_not_allowed' => 'La transición de estado solicitada no está permitida.',

    'summary_heading' => 'Resumen del Alquiler',
    'customer_info' => 'Información del Cliente',
    'vehicle_info' => 'Información del Vehículo',
];
