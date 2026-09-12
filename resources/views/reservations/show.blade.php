{{--
    Author: Isabella Ocampo
    Date: 2026-09-11
    Description: Reservation details view for customers with cancellation action.
--}}

@extends('layouts.app')

@section('content')
<div class="container py-5 catalog-page">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="fw-bold fs-3 text-dark mb-1">{{ $viewData['title'] }}</h1>
                    <p class="text-muted small mb-0">{{ __('reservation.summary_heading') }}</p>
                </div>
                <a href="{{ route('reservations.index') }}" class="btn btn-outline-dark btn-sm rounded-pill px-3">
                    &larr; {{ __('reservation.back_to_list') }}
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger rounded-4 shadow-sm mb-4" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card shadow-sm border-0 rounded-4 overflow-hidden bg-white mb-4">
                {{-- Card Header with Code and Status --}}
                <div class="card-header bg-light border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted small d-block">{{ __('reservation.reservation_code') }}</span>
                        <strong class="fs-5 text-dark">#{{ $viewData['reservation']->getCode() }}</strong>
                    </div>
                    <span class="badge {{ $viewData['reservation']->getStateBadgeClass() }} fs-6 px-3 py-2 rounded-pill">
                        {{ __('reservation.state_' . $viewData['reservation']->getState()) }}
                    </span>
                </div>

                <div class="card-body p-4">
                    <div class="row g-4">
                        {{-- Vehicle Thumbnail & Info --}}
                        <div class="col-md-5">
                            <x-car-image
                                :image="$viewData['reservation']->getCar()?->getImage()"
                                class="img-fluid rounded-4 object-fit-cover w-100 mb-3"
                                style="max-height: 200px;"
                            />
                            <h5 class="fw-bold text-dark mb-1">
                                {{ optional($viewData['reservation']->getCar()?->getCategory())->getBrand() }} {{ optional($viewData['reservation']->getCar()?->getCategory())->getModel() }}
                            </h5>
                            <p class="text-muted small mb-0">
                                {{ optional($viewData['reservation']->getCar()?->getCategory())->getType() }} | {{ ucfirst($viewData['reservation']->getCar()?->getColor() ?? '') }}<br>
                                {{ __('catalog.plate_label') }}: <strong>{{ $viewData['reservation']->getCar()?->getPlate() }}</strong>
                            </p>
                        </div>

                        {{-- Details Column --}}
                        <div class="col-md-7">
                            <div class="bg-light p-3 rounded-4 mb-3">
                                <h6 class="fw-bold text-dark mb-3">{{ __('reservation.pickup_location') }}</h6>
                                <p class="mb-1 fw-semibold text-dark">{{ $viewData['reservation']->getLocation()?->getName() }}</p>
                                <p class="text-muted small mb-1">{{ $viewData['reservation']->getLocation()?->getAddress() }}, {{ $viewData['reservation']->getLocation()?->getCity() }}</p>
                                <p class="text-muted small mb-0">{{ $viewData['reservation']->getLocation()?->getTelephone() }}</p>
                            </div>

                            <div class="bg-light p-3 rounded-4 mb-3">
                                <h6 class="fw-bold text-dark mb-3">{{ __('reservation.dates') }}</h6>
                                <div class="row g-2 small">
                                    <div class="col-6">
                                        <span class="text-muted d-block">{{ __('reservation.start_date') }}</span>
                                        <span class="fw-bold text-dark">{{ $viewData['reservation']->getStartDate()?->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-muted d-block">{{ __('reservation.end_date') }}</span>
                                        <span class="fw-bold text-dark">{{ $viewData['reservation']->getEndDate()?->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="p-3 border rounded-4">
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
                    </div>
                </div>

                {{-- Card Footer with Actions --}}
                @if ($viewData['reservation']->isCancellable())
                    <div class="card-footer bg-white border-top py-3 px-4 d-flex justify-content-end align-items-center">
                        <form
                            action="{{ route('reservations.cancel', ['id' => $viewData['reservation']->getId()]) }}"
                            method="POST"
                            onsubmit="return confirm('{{ __('reservation.cancellation_confirm') }}');"
                            class="m-0"
                        >
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-4 fw-semibold shadow-sm">
                                {{ __('reservation.cancel_reservation') }}
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
