<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-11-09
 * Description: Spanish language strings for the preceding team fleet integration.
 */

return [
    'title_index' => 'Flota aliada - Safety Rental',
    'heading' => 'Vehículos aliados',
    'subtitle' => 'Vehículos publicados por el equipo aliado, cargados en vivo desde su API pública.',
    'nav' => 'Aliados',
    'available' => 'Disponible',
    'unavailable' => 'No disponible',
    'unknown_vehicle' => 'Vehículo aliado',
    'unknown_category' => 'Sin categoría',
    'view_details' => 'Ver detalle del aliado',
    'empty_title' => 'No hay vehículos aliados por ahora',
    'empty_body' => 'La API aliada respondió correctamente, pero no devolvió vehículos disponibles para alquilar.',
    'error_missing_config' => 'La URL de la API aliada no está configurada. Pide al arquitecto que defina PARTNER_API_URL.',
    'error_connection' => 'No fue posible conectar con el servicio aliado. Verifica la conexión e inténtalo de nuevo.',
    'error_timeout' => 'El servicio aliado tardó demasiado en responder. Inténtalo de nuevo en unos minutos.',
    'error_http' => 'El servicio aliado devolvió un error HTTP. El catálogo aliado no está disponible temporalmente.',
    'error_empty' => 'El servicio aliado no devolvió datos de vehículos.',
    'error_invalid' => 'El servicio aliado devolvió una respuesta que no se pudo interpretar como vehículos.',
];
