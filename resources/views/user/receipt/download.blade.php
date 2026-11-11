{{--
    Author: Alejandro Correa Marin
    Date: 2026-09-12
    Description: Rental payment receipt content rendered into a downloadable PDF.
--}}

@extends('layouts.app')

@section('title', $viewData['title'])

@push('styles')
    <link
        rel="stylesheet"
        href="{{ public_path('css/user/receipt.css') }}"
    >
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
            <td>${{ number_format($viewData['amount'], 0, app()->getLocale() === 'es' ? ',' : '.', app()->getLocale() === 'es' ? '.' : ',') }}</td>
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
