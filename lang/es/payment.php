<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-09-12
 * Description: Spanish localization strings for the simulated payments module.
 */

return [
    'title_create' => 'Pagar reserva #:code',
    'admin_title_index' => 'Gestión de pagos',
    'admin_title_show' => 'Detalle de pago #:code',
    'manage_payments' => 'Pagos',

    'heading' => 'Pago simulado',
    'subtitle' => 'Completa un pago de demostración con el total aprobado de la reserva.',
    'receipt_label' => 'Recibo de pago de alquiler',
    'not_an_invoice' => 'Este documento es un recibo de pago de alquiler, no una factura tributaria.',
    'download_receipt' => 'Descargar recibo',
    'currency' => 'COP',
    'receipt_not_paid' => 'El recibo de pago solo está disponible después de un pago exitoso.',

    'payment_code' => 'Código de pago',
    'transaction_code' => 'Referencia de transacción',
    'method' => 'Método de pago',
    'select_method' => 'Selecciona un método de pago',
    'method_credit_card' => 'Tarjeta de crédito',
    'method_debit_card' => 'Tarjeta de débito',
    'method_bank_transfer' => 'Transferencia bancaria',
    'method_pse_debit' => 'Débito PSE',
    'amount' => 'Monto',
    'approved_amount' => 'Monto aprobado',
    'date' => 'Fecha de pago',
    'status' => 'Estado',
    'reservation' => 'Reserva',
    'vehicle' => 'Vehículo',
    'customer' => 'Cliente',
    'actions' => 'Acciones',

    'status_completed' => 'Completado',
    'status_pending' => 'Pendiente',
    'status_failed' => 'Fallido',
    'status_refunded' => 'Reembolsado',

    'simulated_result' => 'Resultado de la simulación',
    'simulate_success' => 'Simular pago exitoso',
    'simulate_failure' => 'Simular pago fallido',
    'pay_now' => 'Pagar ahora',
    'submit_payment' => 'Procesar pago',
    'refund_payment' => 'Aplicar reembolso',
    'refund_confirm' => '¿Aplicar el reembolso aprobado a este pago completado?',
    'view_details' => 'Ver detalles',
    'back_to_reservation' => 'Volver a la reserva',
    'back_to_admin_list' => 'Volver a la lista de pagos',
    'no_payments' => 'No se encontraron registros de pago.',
    'unpaid' => 'Sin pagar',
    'paid' => 'Pagado',

    'completed_success' => 'El pago simulado se registró correctamente.',
    'failed_reported' => 'El pago simulado falló. La reserva no quedó marcada como pagada.',
    'refunded_success' => 'El reembolso se aplicó según la política aprobada.',
    'amount_mismatch' => 'El monto enviado no coincide con el total aprobado de la reserva.',
    'not_payable' => 'Esta reserva no puede recibir un nuevo pago exitoso.',
    'refund_not_allowed' => 'Solo un pago completado puede reembolsarse.',
];
