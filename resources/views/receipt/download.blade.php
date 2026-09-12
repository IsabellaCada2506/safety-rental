{{--
    Author: Alejandro Correa Marin
    Date: 2026-09-12
    Description: Rental payment receipt content rendered into a downloadable PDF.
--}}

@extends('layouts.app')

@push('styles')
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #111827;
            font-size: 13px;
            margin: 32px;
        }

        h1 {
            font-size: 22px;
            margin-bottom: 4px;
        }

        .disclaimer {
            margin: 0 0 24px;
            color: #6b7280;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            text-align: left;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        th {
            width: 40%;
            color: #6b7280;
            font-weight: 600;
        }
    </style>
@endpush

@section('content')
    <h1>{{ $viewData['documentName'] }}</h1>
    <p class="disclaimer">{{ $viewData['disclaimer'] }}</p>

    <table>
        <tr>
            <th>{{ __('reservation.reservation_code') }}</th>
            <td>#{{ $viewData['reservationCode'] }}</td>
        </tr>
        <tr>
            <th>{{ __('payment.vehicle') }}</th>
            <td>{{ $viewData['vehicleName'] }} ({{ $viewData['vehiclePlate'] }})</td>
        </tr>
        <tr>
            <th>{{ __('reservation.start_date') }}</th>
            <td>{{ $viewData['startDate'] }}</td>
        </tr>
        <tr>
            <th>{{ __('reservation.end_date') }}</th>
            <td>{{ $viewData['endDate'] }}</td>
        </tr>
        <tr>
            <th>{{ __('payment.amount') }}</th>
            <td>${{ number_format($viewData['amount'], 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>{{ __('payment.currency') }}</th>
            <td>{{ $viewData['currency'] }}</td>
        </tr>
        <tr>
            <th>{{ __('payment.transaction_code') }}</th>
            <td>{{ $viewData['transactionCode'] }}</td>
        </tr>
        <tr>
            <th>{{ __('payment.status') }}</th>
            <td>{{ $viewData['paymentStatus'] }}</td>
        </tr>
        <tr>
            <th>{{ __('payment.method') }}</th>
            <td>{{ $viewData['paymentMethod'] }}</td>
        </tr>
        <tr>
            <th>{{ __('payment.date') }}</th>
            <td>{{ $viewData['paymentDate'] }}</td>
        </tr>
    </table>
@endsection
