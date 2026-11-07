{{--
    Author: Wendy Atehortua
    Date: 2026-11-06
    Description: PDF template for complete reservations administrative report with executive summary and cancellation ranking.
--}}

@extends('layouts.app')

@section('title', $viewData['title'])

@push('styles')
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #1f2937;
            font-size: 10px;
            line-height: 1.35;
        }

        .report-header {
            border-bottom: 2px solid #2563eb;
            padding-bottom: 10px;
            margin-bottom: 14px;
        }

        .report-title {
            font-size: 18px;
            font-weight: bold;
            color: #1e3a8a;
            margin: 0 0 4px 0;
        }

        .report-meta {
            font-size: 9px;
            color: #6b7280;
            margin: 0;
        }

        .summary-cards {
            width: 100%;
            margin-bottom: 14px;
        }

        .summary-cards td {
            width: 25%;
            padding: 6px 8px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            text-align: center;
        }

        .summary-value {
            font-size: 14px;
            font-weight: bold;
            color: #0f172a;
        }

        .summary-label {
            font-size: 8.5px;
            text-transform: uppercase;
            color: #64748b;
        }

        .section-heading {
            font-size: 12px;
            font-weight: bold;
            color: #1e3a8a;
            margin: 12px 0 6px 0;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 3px;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
            margin-bottom: 12px;
        }

        .report-table th {
            background-color: #f1f5f9;
            color: #334155;
            font-weight: 600;
            text-align: left;
            padding: 6px 5px;
            border-bottom: 1px solid #cbd5e1;
            font-size: 9px;
            text-transform: uppercase;
        }

        .report-table td {
            padding: 5px 5px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 9px;
        }

        .report-table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .badge {
            display: inline-block;
            padding: 2px 5px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 8px;
            text-transform: uppercase;
        }

        .badge-confirmed {
            background-color: #dcfce7;
            color: #15803d;
        }

        .badge-pending {
            background-color: #fef9c3;
            color: #854d0e;
        }

        .badge-cancelled {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        .badge-completed {
            background-color: #e0e7ff;
            color: #4338ca;
        }
    </style>
@endpush

@section('content')
    <div class="report-header">
        <h1 class="report-title">{{ $viewData['title'] }}</h1>
        <p class="report-meta">
            {{ __('reservation.generated_at') }}: {{ $viewData['generatedAt'] }}
        </p>
    </div>

    <table class="summary-cards">
        <tr>
            <td>
                <div class="summary-value">{{ $viewData['totalReservations'] }}</div>
                <div class="summary-label">{{ __('reservation.total_reservations') }}</div>
            </td>
            <td>
                <div class="summary-value" style="color: #15803d;">{{ $viewData['confirmedCount'] }}</div>
                <div class="summary-label">{{ __('reservation.state_confirmed') }}</div>
            </td>
            <td>
                <div class="summary-value" style="color: #854d0e;">{{ $viewData['pendingCount'] }}</div>
                <div class="summary-label">{{ __('reservation.state_pending') }}</div>
            </td>
            <td>
                <div class="summary-value" style="color: #b91c1c;">{{ $viewData['cancelledCount'] }}</div>
                <div class="summary-label">{{ __('reservation.state_cancelled') }}</div>
            </td>
        </tr>
    </table>

    @if ($viewData['cancellationRanking']->isNotEmpty())
        <div class="section-heading">{{ __('reservation.cancellation_ranking_title') }}</div>
        <table class="report-table" style="width: 60%;">
            <thead>
                <tr>
                    <th>{{ __('reservation.cancellation_reason_label') }}</th>
                    <th style="width: 90px; text-align: right;">{{ __('reservation.cancellation_count') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($viewData['cancellationRanking'] as $reason => $count)
                    <tr>
                        <td>{{ $reason }}</td>
                        <td style="text-align: right; font-weight: bold;">{{ $count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="section-heading">{{ __('reservation.reservations_list_title') }}</div>
    <table class="report-table">
        <thead>
            <tr>
                <th>{{ __('reservation.code') }}</th>
                <th>{{ __('reservation.customer') }}</th>
                <th>{{ __('reservation.vehicle') }}</th>
                <th>{{ __('reservation.car_license_plate') }}</th>
                <th>{{ __('reservation.pickup_location') }}</th>
                <th>{{ __('reservation.start_date') }}</th>
                <th>{{ __('reservation.end_date') }}</th>
                <th>{{ __('reservation.status') }}</th>
                <th>{{ __('reservation.cancellation_reason_label') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($viewData['reservations'] as $reservation)
                @php
                    $car = $reservation->getCar();
                    $category = $car?->getCategory();
                    $user = $reservation->getUser();
                    $location = $reservation->getLocation();
                    $state = $reservation->getState();
                @endphp
                <tr>
                    <td>#{{ $reservation->getCode() }}</td>
                    <td>{{ $user ? $user->getName() : 'N/A' }}</td>
                    <td>{{ $category ? trim($category->getBrand().' '.$category->getModel()) : 'N/A' }}</td>
                    <td>{{ $car ? $car->getPlate() : 'N/A' }}</td>
                    <td>{{ $location ? $location->getName() : 'N/A' }}</td>
                    <td>{{ $reservation->getStartDate() ? $reservation->getStartDate()->format('d/m/Y') : 'N/A' }}</td>
                    <td>{{ $reservation->getEndDate() ? $reservation->getEndDate()->format('d/m/Y') : 'N/A' }}</td>
                    <td>
                        @if ($state === \App\Models\Reservation::STATE_CONFIRMED)
                            <span class="badge badge-confirmed">{{ __('reservation.state_confirmed') }}</span>
                        @elseif ($state === \App\Models\Reservation::STATE_PENDING)
                            <span class="badge badge-pending">{{ __('reservation.state_pending') }}</span>
                        @elseif ($state === \App\Models\Reservation::STATE_CANCELLED)
                            <span class="badge badge-cancelled">{{ __('reservation.state_cancelled') }}</span>
                        @else
                            <span class="badge badge-completed">{{ __('reservation.state_completed') }}</span>
                        @endif
                    </td>
                    <td>{{ $reservation->getCancellationReason() ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center; padding: 12px; color: #6b7280;">
                        {{ __('reservation.no_reservations') }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
