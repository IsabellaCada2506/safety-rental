<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-09-12
 * Description: English localization strings for the simulated payments module.
 */

return [
    'title_create' => 'Pay reservation #:code',
    'admin_title_index' => 'Payment management',
    'admin_title_show' => 'Payment detail #:code',
    'manage_payments' => 'Payments',

    'heading' => 'Simulated payment',
    'subtitle' => 'Complete a demonstration payment using the approved reservation total.',
    'receipt_label' => 'Rental payment receipt',
    'not_an_invoice' => 'This document is a rental payment receipt, not a tax invoice.',
    'download_receipt' => 'Download receipt',
    'currency' => 'COP',
    'receipt_not_paid' => 'A paid receipt is available only after a successful payment.',

    'payment_code' => 'Payment code',
    'transaction_code' => 'Transaction reference',
    'method' => 'Payment method',
    'select_method' => 'Select a payment method',
    'method_credit_card' => 'Credit card',
    'method_debit_card' => 'Debit card',
    'method_bank_transfer' => 'Bank transfer',
    'method_pse_debit' => 'PSE debit',
    'amount' => 'Amount',
    'approved_amount' => 'Approved amount',
    'date' => 'Payment date',
    'status' => 'Status',
    'reservation' => 'Reservation',
    'vehicle' => 'Vehicle',
    'customer' => 'Customer',
    'actions' => 'Actions',

    'status_completed' => 'Completed',
    'status_pending' => 'Pending',
    'status_failed' => 'Failed',
    'status_refunded' => 'Refunded',

    'simulated_result' => 'Simulation result',
    'simulate_success' => 'Simulate successful payment',
    'simulate_failure' => 'Simulate failed payment',
    'pay_now' => 'Pay now',
    'submit_payment' => 'Process payment',
    'refund_payment' => 'Apply refund',
    'refund_confirm' => 'Apply the approved refund to this completed payment?',
    'view_details' => 'View details',
    'back_to_reservation' => 'Back to reservation',
    'back_to_admin_list' => 'Back to payment list',
    'no_payments' => 'No payment records found.',
    'unpaid' => 'Unpaid',
    'paid' => 'Paid',

    'completed_success' => 'The simulated payment was recorded successfully.',
    'failed_reported' => 'The simulated payment failed. The reservation was not marked as paid.',
    'refunded_success' => 'The refund was applied according to the approved policy.',
    'amount_mismatch' => 'The submitted amount does not match the approved reservation total.',
    'not_payable' => 'This reservation cannot receive a new successful payment.',
    'refund_not_allowed' => 'Only a completed payment can be refunded.',
];
