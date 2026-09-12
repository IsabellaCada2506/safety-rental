{{--
    Author: Isabella Ocampo
    Date: 2026-09-11
    Description: Customer view showing contact information of a branch and the vehicles available for rent at that location.
--}}

@extends('layouts.app')

@section('content')
<div class="container py-5 catalog-page">
    {{-- Branch Overview Card --}}
    <div class="card shadow-sm border-0 rounded-4 p-4 p-md-5 mb-5 bg-white">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge bg-dark text-white rounded-pill px-3 py-1">
                        <i class="bi bi-building me-1"></i>{{ $viewData['location']->getCity() }}
                    </span>
                    <span class="badge bg-light text-muted border rounded-pill px-3 py-1">
                        {{ $viewData['location']->getHeadquarters() }}
                    </span>
                </div>
                <h1 class="fw-bold text-dark display-6 mb-3">{{ $viewData['location']->getName() }}</h1>
                <div class="row g-3 text-muted">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-geo-alt-fill text-danger fs-5 mt-1"></i>
                            <div>
                                <span class="d-block fw-semibold text-dark small">{{ __('location.address') }}</span>
                                <span class="small">{{ $viewData['location']->getAddress() }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-telephone-fill text-success fs-5 mt-1"></i>
                            <div>
                                <span class="d-block fw-semibold text-dark small">{{ __('location.telephone') }}</span>
                                <span class="small">{{ $viewData['location']->getTelephone() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('locations.index') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-medium">
                    &larr; {{ __('location.back_to_locations') }}
                </a>
            </div>
        </div>
    </div>

    {{-- Vehicles Available Heading --}}
    <div class="row mb-4 align-items-center">
        <div class="col-md-8">
            <h2 class="fw-bold text-dark fs-3 mb-1">{{ __('location.available_fleet_heading') }}</h2>
            <p class="text-muted small mb-0">{{ __('location.available_fleet_subtitle') }}</p>
        </div>
        <div class="col-md-4 text-md-end">
            <span class="badge bg-light text-dark border rounded-pill px-3 py-2 fw-semibold">
                {{ $viewData['location']->getCars()->count() }} {{ __('location.cars_count') }}
            </span>
        </div>
    </div>

    {{-- Vehicles Grid --}}
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @forelse ($viewData['location']->getCars() as $car)
            <div class="col">
                <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden bg-white">
                    <x-car-image
                        :image="$car->getImage()"
                        class="card-img-top object-fit-cover catalog-card-image"
                    />

                    <div class="card-body d-flex flex-column justify-content-between p-4">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted small">
                                    {{ number_format($car->getMileage(), 0, ',', '.') }} {{ __('catalog.km_unit') }}
                                </span>
                                <span class="badge bg-dark-subtle text-dark rounded-pill px-2 py-1 small">
                                    {{ optional($car->getCategory())->getType() }}
                                </span>
                            </div>

                            <h3 class="card-title fw-bold text-dark fs-5 mb-2">
                                {{ optional($car->getCategory())->getBrand() }} {{ optional($car->getCategory())->getModel() }}
                            </h3>

                            <p class="text-dark fw-bold fs-4 mb-3">
                                ${{ number_format($car->getPrice(), 0, ',', '.') }}
                                <span class="fs-6 text-muted fw-normal">{{ __('catalog.per_day') }}</span>
                            </p>
                        </div>

                        <div class="d-grid gap-2">
                            <a
                                href="{{ route('reservations.create', ['car_id' => $car->getId(), 'location_id' => $viewData['location']->getId()]) }}"
                                class="btn btn-dark fw-semibold rounded-pill py-2 shadow-sm"
                            >
                                {{ __('catalog.rent_now') }} &rarr;
                            </a>
                            <a
                                href="{{ route('catalog.show', ['id' => $car->getId()]) }}"
                                class="btn btn-outline-secondary rounded-pill py-2 small fw-medium"
                            >
                                {{ __('catalog.view_details') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="card border-0 rounded-4 shadow-sm p-5 bg-white mx-auto" style="max-width: 520px;">
                    <div class="mb-3 text-muted">
                        <i class="bi bi-car-front" style="font-size: 2.5rem;"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-2">{{ __('location.no_vehicles_at_location') }}</h4>
                    <p class="text-muted small mb-4">{{ __('location.branches_subtitle') }}</p>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('locations.index') }}" class="btn btn-dark rounded-pill px-4 py-2 fw-semibold">
                            {{ __('location.browse_other_branches') }}
                        </a>
                        <a href="{{ route('catalog.index') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-medium">
                            {{ __('catalog.title') }}
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
