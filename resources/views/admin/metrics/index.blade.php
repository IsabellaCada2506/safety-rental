{{--
    Author: Alejandro Correa Marin
    Date: 2026-09-12
    Description: Admin metrics view for reservation counts by state and payment totals.
--}}

@extends('layouts.app')

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
                <p class="admin-subtitle">
                    {{ __('metrics.subtitle') }}
                </p>
            </div>

            <a href="{{ route('admin.dashboard.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                &larr; {{ __('authentication.dashboard') }}
            </a>
        </header>

        @if ($errors->any())
            <div class="alert alert-danger admin-alert" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="GET" action="{{ route('admin.metrics.index') }}" class="card shadow-sm border-0 rounded-4 bg-white p-4 mb-4">
            @csrf
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="start_date" class="form-label fw-semibold">{{ __('metrics.start_date') }}</label>
                    <input
                        type="date"
                        id="start_date"
                        name="start_date"
                        class="form-control"
                        value="{{ $viewData['startDate'] }}"
                    >
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label fw-semibold">{{ __('metrics.end_date') }}</label>
                    <input
                        type="date"
                        id="end_date"
                        name="end_date"
                        class="form-control"
                        value="{{ $viewData['endDate'] }}"
                    >
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-dark rounded-pill fw-semibold px-4">
                        {{ __('metrics.apply_filter') }}
                    </button>
                    <a href="{{ route('admin.metrics.index') }}" class="btn btn-outline-secondary rounded-pill fw-semibold px-4">
                        {{ __('metrics.clear_filter') }}
                    </a>
                </div>
            </div>
        </form>

        @if (! $viewData['hasActivity'])
            <div class="alert alert-light border rounded-4 mb-4" role="status">
                {{ __('metrics.empty') }}
            </div>
        @endif

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 rounded-4 bg-white p-4 h-100">
                    <h2 class="fw-bold fs-5 text-dark mb-3">{{ __('metrics.reservations') }}</h2>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span>{{ __('metrics.pending') }}</span>
                        <strong>{{ $viewData['reservationCounts']['pending'] }}</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span>{{ __('metrics.confirmed') }}</span>
                        <strong>{{ $viewData['reservationCounts']['confirmed'] }}</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span>{{ __('metrics.cancelled') }}</span>
                        <strong>{{ $viewData['reservationCounts']['cancelled'] }}</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span>{{ __('metrics.completed') }}</span>
                        <strong>{{ $viewData['reservationCounts']['completed'] }}</strong>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow-sm border-0 rounded-4 bg-white p-4 h-100">
                    <h2 class="fw-bold fs-5 text-dark mb-3">{{ __('metrics.payments') }}</h2>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span>{{ __('metrics.completed_amount') }}</span>
                        <strong>${{ number_format($viewData['completedAmount'], 0, ',', '.') }} {{ __('metrics.currency') }}</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span>{{ __('metrics.failed_amount') }}</span>
                        <strong>${{ number_format($viewData['failedAmount'], 0, ',', '.') }} {{ __('metrics.currency') }}</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span>{{ __('metrics.refunded_amount') }}</span>
                        <strong>${{ number_format($viewData['refundedAmount'], 0, ',', '.') }} {{ __('metrics.currency') }}</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span>{{ __('metrics.net_successful_amount') }}</span>
                        <strong>${{ number_format($viewData['netSuccessfulAmount'], 0, ',', '.') }} {{ __('metrics.currency') }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
