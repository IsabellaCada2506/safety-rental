{{--
    Author: Isabella Ocampo
    Date: 2026-09-11
    Description: Admin detailed audit view for a specific reservation record.
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
            </div>

            <a href="{{ route('admin.reservation.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                &larr; {{ __('reservation.back_to_admin_list') }}
            </a>
        </header>

        @if (session('success'))
            <div class="alert alert-success admin-alert" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger admin-alert" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row g-4">
            {{-- Customer & Vehicle Summary --}}
            <div class="col-lg-8">
                {{-- Reservation Overview --}}
                <div class="card shadow-sm border-0 rounded-4 bg-white p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="fw-bold text-dark mb-0">{{ __('reservation.summary_heading') }}</h4>
                        <span class="badge {{ $viewData['reservation']->getStateBadgeClass() }} fs-6 px-3 py-2 rounded-pill">
                            {{ __('reservation.state_' . $viewData['reservation']->getState()) }}
                        </span>
                    </div>

                    <div class="row g-3 small mb-4">
                        <div class="col-sm-4">
                            <span class="text-muted d-block">{{ __('reservation.reservation_code') }}:</span>
                            <strong class="fs-6 text-dark">#{{ $viewData['reservation']->getCode() }}</strong>
                        </div>
                        <div class="col-sm-4">
                            <span class="text-muted d-block">{{ __('reservation.start_date') }}:</span>
                            <strong class="text-dark">{{ $viewData['reservation']->getStartDate()?->format('d/m/Y') }}</strong>
                        </div>
                        <div class="col-sm-4">
                            <span class="text-muted d-block">{{ __('reservation.end_date') }}:</span>
                            <strong class="text-dark">{{ $viewData['reservation']->getEndDate()?->format('d/m/Y') }}</strong>
                        </div>
                    </div>

                    <div class="bg-light p-3 rounded-4">
                        <div class="d-flex justify-content-between small text-muted mb-1">
                            <span>{{ __('reservation.daily_rate') }}:</span>
                            <span class="fw-semibold text-dark">${{ number_format($viewData['reservation']->getCar()?->getPrice() ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between small text-muted mb-2">
                            <span>{{ __('reservation.rental_days') }}:</span>
                            <span class="fw-semibold text-dark">{{ $viewData['reservation']->getDays() }} {{ __('reservation.days_unit') }}</span>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-dark">{{ __('reservation.total_price') }}:</span>
                            <span class="fw-bold text-primary fs-4">${{ number_format($viewData['reservation']->getTotalPrice(), 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Customer Information Card --}}
                <div class="card shadow-sm border-0 rounded-4 bg-white p-4 mb-4">
                    <h5 class="fw-bold text-dark mb-3">{{ __('reservation.customer_info') }}</h5>
                    <div class="row g-3 small">
                        <div class="col-sm-6">
                            <span class="text-muted d-block">{{ __('authentication.name') }}:</span>
                            <strong class="text-dark">{{ $viewData['reservation']->getUser()?->getName() }} {{ $viewData['reservation']->getUser()?->getLastName() }}</strong>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted d-block">{{ __('authentication.email') }}:</span>
                            <strong class="text-dark">{{ $viewData['reservation']->getUser()?->getEmail() }}</strong>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted d-block">{{ __('authentication.identification_number') }}:</span>
                            <span class="text-dark">{{ $viewData['reservation']->getUser()?->getIdentificationNumber() ?? 'N/A' }}</span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted d-block">{{ __('authentication.license_number') }}:</span>
                            <span class="text-dark">{{ $viewData['reservation']->getUser()?->getLicenseNumber() ?? 'N/A' }}</span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted d-block">{{ __('authentication.emergency_contact') }}:</span>
                            <span class="text-dark">{{ $viewData['reservation']->getUser()?->getEmergencyContact() ?? 'N/A' }}</span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted d-block">{{ __('authentication.address') }}:</span>
                            <span class="text-dark">{{ $viewData['reservation']->getUser()?->getAddress() ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Vehicle Information Card --}}
                <div class="card shadow-sm border-0 rounded-4 bg-white p-4">
                    <h5 class="fw-bold text-dark mb-3">{{ __('reservation.vehicle_info') }}</h5>
                    <div class="row g-3 small">
                        <div class="col-sm-6">
                            <span class="text-muted d-block">{{ __('car.plate') }}:</span>
                            <strong class="text-dark">{{ $viewData['reservation']->getCar()?->getPlate() }}</strong>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted d-block">{{ __('car.color') }}:</span>
                            <span class="text-dark">{{ ucfirst($viewData['reservation']->getCar()?->getColor() ?? '') }}</span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted d-block">{{ __('car.category') }}:</span>
                            <span class="text-dark">{{ optional($viewData['reservation']->getCar()?->getCategory())->getBrand() }} {{ optional($viewData['reservation']->getCar()?->getCategory())->getModel() }}</span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted d-block">{{ __('car.mileage') }}:</span>
                            <span class="text-dark">{{ number_format($viewData['reservation']->getCar()?->getMileage() ?? 0, 0, ',', '.') }} km</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Branch & Administrative Actions --}}
            <div class="col-lg-4">
                {{-- Branch Card --}}
                <div class="card shadow-sm border-0 rounded-4 bg-white p-4 mb-4">
                    <h5 class="fw-bold text-dark mb-3">{{ __('reservation.pickup_location') }}</h5>
                    <p class="mb-1 fw-semibold text-dark">{{ $viewData['reservation']->getLocation()?->getName() }}</p>
                    <p class="text-muted small mb-1">{{ $viewData['reservation']->getLocation()?->getAddress() }}, {{ $viewData['reservation']->getLocation()?->getCity() }}</p>
                    <p class="text-muted small mb-0">{{ $viewData['reservation']->getLocation()?->getTelephone() }}</p>
                </div>

                {{-- Actions Card --}}
                <div class="card shadow-sm border-0 rounded-4 bg-white p-4">
                    <h5 class="fw-bold text-dark mb-3">{{ __('reservation.actions') }}</h5>

                    <div class="d-grid gap-2">
                        @if ($viewData['reservation']->isPending())
                            <form action="{{ route('admin.reservation.confirm', ['id' => $viewData['reservation']->getId()]) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success w-100 py-2 rounded-pill fw-semibold shadow-sm">
                                    {{ __('reservation.confirm_reservation') }}
                                </button>
                            </form>
                        @endif

                        @if ($viewData['reservation']->isCancellable())
                            <form
                                action="{{ route('admin.reservation.cancel', ['id' => $viewData['reservation']->getId()]) }}"
                                method="POST"
                                onsubmit="return confirm('{{ __('reservation.cancellation_confirm') }}');"
                            >
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-outline-danger w-100 py-2 rounded-pill fw-semibold shadow-sm">
                                    {{ __('reservation.cancel_reservation') }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
