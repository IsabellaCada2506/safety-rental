{{--
    Author: Isabella Ocampo
    Date: 2026-09-11
    Description: Customer view listing all physical rental locations and branches.
--}}

@extends('layouts.app')

@section('content')
<div class="container py-5 catalog-page">
    <div class="row mb-5 text-center">
        <div class="col-lg-8 mx-auto">
            <span class="badge bg-light text-dark border rounded-pill px-3 py-2 fw-semibold mb-3">
                <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ __('location.registered_locations') }}
            </span>
            <h1 class="fw-bold text-dark display-5 mb-3">{{ __('location.customer_title_index') }}</h1>
            <p class="text-muted fs-6 mb-0">{{ __('location.branches_subtitle') }}</p>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @forelse ($viewData['locations'] as $location)
            <div class="col">
                <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden bg-white p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="badge bg-dark-subtle text-dark rounded-pill px-3 py-1 fw-semibold">
                                <i class="bi bi-building me-1"></i>{{ $location->getCity() }}
                            </span>
                            <span class="badge bg-light text-muted border rounded-pill px-3 py-1 small">
                                {{ $location->cars_count ?? $location->getCars()->count() }} {{ __('location.cars_count') }}
                            </span>
                        </div>

                        <h3 class="fw-bold text-dark fs-5 mb-2">{{ $location->getName() }}</h3>
                        <p class="text-muted small mb-3">
                            <i class="bi bi-geo-alt text-danger me-1"></i>{{ $location->getAddress() }}
                        </p>

                        <div class="p-3 bg-light rounded-3 mb-4">
                            <p class="small text-muted mb-1">
                                <strong>{{ __('location.headquarters_label') }}:</strong>
                                <span class="text-dark">{{ $location->getHeadquarters() }}</span>
                            </p>
                            <p class="small text-muted mb-0">
                                <strong>{{ __('location.telephone_label') }}:</strong>
                                <span class="text-dark">{{ $location->getTelephone() }}</span>
                            </p>
                        </div>
                    </div>

                    <div>
                        <a
                            href="{{ route('locations.show', ['id' => $location->getId()]) }}"
                            class="btn btn-dark w-100 fw-semibold rounded-pill py-2 shadow-sm"
                        >
                            {{ __('location.explore_fleet') }} &rarr;
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted fs-5">{{ __('location.no_locations_found') }}</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
