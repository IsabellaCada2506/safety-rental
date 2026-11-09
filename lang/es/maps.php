<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-11-09
 * Description: Spanish language strings for driving route estimates to rental branches.
 */

return [
    'title_show' => 'Ruta a la sede - Safety Rental',
    'heading' => 'Cómo llegar a la sede',
    'subtitle' => 'Distancia y tiempo estimado de manejo desde tu ubicación actual.',
    'use_my_location' => 'Estimar ruta desde mi ubicación',
    'locating' => 'Leyendo tu ubicación actual...',
    'geolocation_denied' => 'Se denegó el acceso a la ubicación. Activa los permisos e inténtalo de nuevo.',
    'geolocation_unavailable' => 'El navegador no pudo determinar tu ubicación actual.',
    'distance_label' => 'Distancia',
    'duration_label' => 'Tiempo de viaje',
    'distance_value' => ':value km',
    'duration_value' => ':value min',
    'origin_label' => 'Coordenadas de origen',
    'destination_label' => 'Sede de recogida',
    'back_to_catalog' => 'Volver al catálogo',
    'error_missing_config' => 'El servicio de rutas de Google Maps no está configurado. Pide al arquitecto que defina GOOGLE_MAPS_API_KEY.',
    'error_connection' => 'No fue posible conectar con el servicio de rutas. Verifica la conexión e inténtalo de nuevo.',
    'error_timeout' => 'El servicio de rutas tardó demasiado en responder. Inténtalo de nuevo en unos minutos.',
    'error_http' => 'El servicio de rutas devolvió un error HTTP. La estimación no está disponible temporalmente.',
    'error_empty' => 'El servicio de rutas no devolvió un trayecto para estas coordenadas.',
    'error_invalid' => 'El servicio de rutas devolvió una respuesta que no se pudo interpretar.',
    'error_missing_destination' => 'Esta sede aún no tiene coordenadas, por lo que no se puede estimar la ruta.',
    'validation_location_required' => 'Selecciona una sede de recogida para estimar la ruta.',
    'validation_location_not_found' => 'No se encontró la sede de recogida seleccionada.',
    'validation_origin_required' => 'Tu ubicación actual es necesaria para estimar la ruta.',
    'validation_origin_invalid' => 'Las coordenadas de origen no son válidas.',
];
