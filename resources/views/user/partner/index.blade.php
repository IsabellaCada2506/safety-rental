{{--
    Author: Alejandro Correa Marin
    Date: 2026-11-09
    Description: Customer view listing vehicles consumed from the preceding team public API.
--}}

@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<div class="container py-5 catalog-page">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="fw-bold text-dark">{{ __('partner.heading') }}</h1>
            <p class="text-muted">{{ __('partner.subtitle') }}</p>
        </div>
    </div>

    @if (! $viewData['isAvailable'])
        <div class="alert alert-warning border-0 rounded-4 shadow-sm mb-4" role="alert">
            {{ __('partner.error_'.$viewData['errorKey']) }}
        </div>
    @elseif ($viewData['errorKey'] === 'empty')
        <div class="card border-0 rounded-4 shadow-sm p-5 bg-white text-center">
            <h2 class="fw-bold text-dark fs-4 mb-2">{{ __('partner.empty_title') }}</h2>
            <p class="text-muted mb-0">{{ __('partner.empty_body') }}</p>
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($viewData['vehicles'] as $partnerVehicle)
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden bg-white">
                        <div class="card-body d-flex flex-column justify-content-between p-4">
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-light text-dark border rounded-pill px-2 py-1 small">
                                        {{ $partnerVehicle->getCategory() ?? __('partner.unknown_category') }}
                                    </span>
                                    <span class="small {{ $partnerVehicle->isAvailable() ? 'text-success' : 'text-danger' }}">
                                        {{ $partnerVehicle->isAvailable() ? __('partner.available') : __('partner.unavailable') }}
                                    </span>
                                </div>

                                <h2 class="card-title fw-bold text-dark fs-5 mb-2">
                                    {{ $partnerVehicle->getDisplayName() }}
                                </h2>

                                @if ($partnerVehicle->getLocation())
                                    <p class="text-muted small mb-3">
                                        {{ $partnerVehicle->getLocation() }}
                                    </p>
                                @endif

                                @if ($partnerVehicle->getDailyRate() !== null)
                                    <p class="text-dark fw-bold fs-4 mb-3">
                                        ${{ number_format($partnerVehicle->getDailyRate(), 0, ',', '.') }}
                                        <span class="fs-6 text-muted fw-normal">{{ __('catalog.per_day') }}</span>
                                    </p>
                                @endif
                            </div>

                            @if ($partnerVehicle->getDetailUrl())
                                <a
                                    href="{{ $partnerVehicle->getDetailUrl() }}"
                                    class="btn btn-outline-secondary rounded-pill py-2 small fw-medium"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >
                                    {{ __('partner.view_details') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
