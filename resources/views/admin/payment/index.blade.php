{{--
    Author: Alejandro Correa Marin
    Author: Wendy Atehortua
    Date: 2026-09-13
    Description: Admin index listing reservation payments with method, reference, and status.
--}}

@inject('paymentService', 'App\Interfaces\PaymentServiceInterface')

@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<section class="admin-page">
    <div class="admin-page-shape admin-page-shape-left" aria-hidden="true"></div>
    <div class="admin-page-shape admin-page-shape-right" aria-hidden="true"></div>

    <div class="container admin-container">
        <header class="admin-header">
            <div>
                <span class="admin-eyebrow">
                    {{ __('car.admin_area') }}
                </span>
                <h1 class="admin-title">
                    {{ $viewData['title'] }}
                </h1>
            </div>

            <a href="{{ route('admin.dashboard.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                &larr; {{ __('authentication.dashboard') }}
            </a>
        </header>

        @if (session('success'))
            <div class="alert alert-success admin-alert" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if ($viewData['payments']->isEmpty())
            <div class="card shadow-sm border-0 rounded-4 text-center py-5 bg-white">
                <div class="card-body">
                    <p class="text-muted mb-0">{{ __('payment.no_payments') }}</p>
                </div>
            </div>
        @else
            <div class="admin-index-table-wrapper">
                <table class="admin-index-table">
                    <thead>
                        <tr>
                            <th>{{ __('payment.reservation') }}</th>
                            <th>{{ __('payment.customer') }}</th>
                            <th>{{ __('payment.amount') }}</th>
                            <th>{{ __('payment.method') }}</th>
                            <th>{{ __('payment.transaction_code') }}</th>
                            <th>{{ __('payment.status') }}</th>
                            <th class="text-end">{{ __('payment.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($viewData['payments'] as $payment)
                            <tr>
                                <td>
                                    <strong>#{{ $payment->getReservation()?->getCode() ?? '—' }}</strong>
                                </td>
                                <td>
                                    {{ $payment->getReservation()?->getUser()?->getName() }}
                                    {{ $payment->getReservation()?->getUser()?->getLastName() }}
                                </td>
                                <td>
                                    <strong>${{ number_format($payment->getAmount(), 0, ',', '.') }}</strong>
                                </td>
                                <td>{{ $paymentService->getMethodLabel($payment) }}</td>
                                <td>{{ $payment->getTransactionCode() }}</td>
                                <td>
                                    <span class="badge {{ $paymentService->getStatusBadgeClass($payment) }} px-2 py-1 rounded-pill">
                                        {{ __('payment.status_' . $payment->getStatus()) }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.payment.show', ['id' => $payment->getId()]) }}" class="btn btn-sm btn-outline-primary rounded-pill px-2 py-1">
                                        {{ __('payment.view_details') }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</section>
@endsection
