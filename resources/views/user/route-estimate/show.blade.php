{{--
    Author: Alejandro Correa Marin
    Date: 2026-11-09
    Description: Customer view showing the estimated driving distance and duration to a rental branch.
--}}

@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<div class="container py-5 catalog-page">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4 p-4 p-md-5 bg-white">
                <h1 class="fw-bold text-dark fs-3 mb-2">{{ __('maps.heading') }}</h1>
                <p class="text-muted mb-4">{{ __('maps.subtitle') }}</p>

                <p class="mb-2">
                    <strong>{{ __('maps.destination_label') }}:</strong>
                    {{ $viewData['location']->getName() }} ({{ $viewData['location']->getCity() }})
                </p>
                <p class="text-muted small mb-4">
                    {{ $viewData['location']->getAddress() }}
                </p>

                @if ($viewData['errorKey'])
                    <div class="alert alert-warning border-0 rounded-4" role="alert">
                        {{ __('maps.error_'.$viewData['errorKey']) }}
                    </div>
                @elseif ($viewData['routeEstimate'] && $viewData['routeEstimate']->isOk())
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3">
                                <span class="d-block text-muted small">{{ __('maps.distance_label') }}</span>
                                <span class="fw-bold fs-4 text-dark">
                                    {{ __('maps.distance_value', ['value' => $viewData['routeEstimate']->getDistanceKilometers()]) }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3">
                                <span class="d-block text-muted small">{{ __('maps.duration_label') }}</span>
                                <span class="fw-bold fs-4 text-dark">
                                    {{ __('maps.duration_value', ['value' => $viewData['routeEstimate']->getDurationMinutes()]) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endif

                <p class="small text-muted">
                    {{ __('maps.origin_label') }}:
                    {{ $viewData['originLatitude'] }}, {{ $viewData['originLongitude'] }}
                </p>

                <a
                    href="{{ route('locations.show', ['id' => $viewData['location']->getId()]) }}"
                    class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-medium"
                >
                    &larr; {{ __('location.back_to_locations') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
