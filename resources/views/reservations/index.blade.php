{{--
    Author: Isabella Ocampo
    Date: 2026-09-11
    Description: View listing authenticated customer's reservations.
--}}

@extends('layouts.app')

@section('content')
<div class="container py-5 catalog-page">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold fs-3 text-dark mb-1">{{ $viewData['title'] }}</h1>
            <p class="text-muted small mb-0">{{ __('reservation.summary_heading') }}</p>
        </div>
        <a href="{{ route('catalog.index') }}" class="btn btn-outline-dark fw-semibold px-3 py-2 rounded-pill shadow-sm">
            &larr; {{ __('catalog.title') }}
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger rounded-4 shadow-sm" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($viewData['reservations']->isEmpty())
        <div class="card shadow-sm border-0 rounded-4 text-center py-5 bg-white">
            <div class="card-body">
                <div class="mb-3">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#6c757d" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </div>
                <h5 class="fw-semibold text-dark">{{ __('reservation.no_reservations') }}</h5>
                <p class="text-muted small mb-4">{{ __('catalog.subtitle') }}</p>
                <a href="{{ route('catalog.index') }}" class="btn btn-dark fw-semibold px-4 py-2 rounded-pill shadow-sm text-decoration-none">
                    {{ __('catalog.title') }} &rarr;
                </a>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach ($viewData['reservations'] as $reservation)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden bg-white d-flex flex-column">
                        <div class="position-relative">
                            <x-car-image
                                :image="$reservation->getCar()?->getImage()"
                                class="card-img-top object-fit-cover"
                                style="height: 190px;"
                            />
                            <span class="badge {{ $reservation->getStateBadgeClass() }} position-absolute top-0 end-0 m-3 px-3 py-2 rounded-pill shadow-sm">
                                {{ __('reservation.state_' . $reservation->getState()) }}
                            </span>
                        </div>

                        <div class="card-body p-4 d-flex flex-column justify-content-between flex-grow-1">
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-muted small fw-semibold">#{{ $reservation->getCode() }}</span>
                                    <span class="text-muted small">{{ $reservation->getLocation()?->getName() }}</span>
                                </div>

                                <h5 class="fw-bold text-dark mb-2">
                                    {{ optional($reservation->getCar()?->getCategory())->getBrand() }} {{ optional($reservation->getCar()?->getCategory())->getModel() }}
                                </h5>

                                <p class="small text-muted mb-3">
                                    {{ __('catalog.plate_label') }}: <strong class="text-dark">{{ $reservation->getCar()?->getPlate() }}</strong>
                                </p>

                                <div class="bg-light p-3 rounded-3 mb-3">
                                    <div class="d-flex justify-content-between small text-muted mb-1">
                                        <span>{{ __('reservation.start_date') }}:</span>
                                        <span class="fw-semibold text-dark">{{ $reservation->getStartDate()?->format('Y-m-d') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between small text-muted mb-1">
                                        <span>{{ __('reservation.end_date') }}:</span>
                                        <span class="fw-semibold text-dark">{{ $reservation->getEndDate()?->format('Y-m-d') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between small text-muted">
                                        <span>{{ __('reservation.rental_days') }}:</span>
                                        <span class="fw-semibold text-dark">{{ $reservation->getDays() }} {{ __('reservation.days_unit') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-2 border-top d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-muted small d-block">{{ __('reservation.total_price') }}</span>
                                    <span class="fw-bold text-dark fs-5">${{ number_format($reservation->getTotalPrice(), 0, ',', '.') }}</span>
                                </div>
                                <a href="{{ route('reservations.show', ['id' => $reservation->getId()]) }}" class="btn btn-outline-primary btn-sm rounded-pill fw-semibold px-3">
                                    {{ __('reservation.view_details') }} &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
