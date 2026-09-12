{{--
    Author: Wendy Atehortua
    Date: 2026-09-11
    Description: Detail view for a single active vehicle in the rental catalog, including reservation flow.
--}}

@extends('layouts.app')

@section('content')
<div class="container py-5 catalog-page">
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden bg-light">
                <x-car-image
                    :image="$viewData['car']->getImage()"
                    class="img-fluid w-100 object-fit-cover catalog-detail-image"
                />
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4 p-4 h-100 d-flex flex-column justify-content-between bg-white">
                <div>
                    <p class="text-muted small mb-2">
                        {{ number_format($viewData['car']->getMileage(), 0, ',', '.') }} {{ __('catalog.km_unit') }}
                        <span class="float-end fw-semibold {{ $viewData['car']->isActive() ? 'text-success' : 'text-danger' }}">
                            {{ $viewData['car']->isActive() ? __('catalog.available') : __('catalog.status_deactivated') }}
                        </span>
                    </p>

                    <h2 class="fw-bold text-dark fs-4 mb-2">
                        {{ optional($viewData['car']->getCategory())->getBrand() }} {{ optional($viewData['car']->getCategory())->getModel() }}
                    </h2>

                    <p class="text-muted small mb-3">
                        <span class="fw-semibold text-dark">{{ ucfirst($viewData['car']->getColor()) }}</span> |
                        <span>{{ optional($viewData['car']->getCategory())->getType() }}</span> |
                        <span>{{ __('catalog.plate_label') }}: <strong>{{ $viewData['car']->getPlate() }}</strong></span>
                    </p>

                    <div class="mb-3 p-3 bg-light rounded-3">
                        @if($viewData['car']->getLocation())
                            <p class="small mb-1"><strong>{{ __('catalog.location_filter') }}:</strong> {{ $viewData['car']->getLocation()->getName() }} ({{ $viewData['car']->getLocation()->getCity() }})</p>
                        @endif
                        <p class="small mb-1"><strong>{{ __('catalog.passengers_label') }}:</strong> {{ optional($viewData['car']->getCategory())->getPassengerCapacity() }}</p>
                        <p class="small mb-1"><strong>{{ __('catalog.luggage_label') }}:</strong> {{ optional($viewData['car']->getCategory())->getLuggageCapacity() }} {{ __('catalog.units') }}</p>
                        @if($viewData['car']->getDescription())
                            <p class="small mb-0"><strong>{{ __('catalog.description_label') }}:</strong> {{ $viewData['car']->getDescription() }}</p>
                        @endif
                    </div>

                    <div class="mb-4">
                        <h3 class="text-dark fw-bold display-6 d-flex align-items-baseline gap-2">
                            ${{ number_format($viewData['car']->getPrice(), 0, ',', '.') }}
                            <span class="fs-6 text-muted fw-normal">{{ __('catalog.per_day') }}</span>
                        </h3>
                    </div>

                    <div class="d-grid gap-2 mb-4">
                        @if ($viewData['car']->isActive())
                            <a
                                href="{{ route('reservations.create', ['car_id' => $viewData['car']->getId()]) }}"
                                class="btn btn-dark fw-semibold py-2 rounded-pill shadow-sm text-center text-decoration-none"
                            >
                                {{ __('catalog.rent_now') }} &rarr;
                            </a>
                        @else
                            <button class="btn btn-secondary fw-semibold py-2 rounded-pill shadow-sm" disabled>
                                {{ __('catalog.status_deactivated') }}
                            </button>
                        @endif
                    </div>
                </div>

                <div class="pt-3 border-top text-center">
                    <a href="{{ route('catalog.index') }}" class="text-decoration-none text-muted small fw-semibold">
                        &larr; {{ __('catalog.back') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
