{{--
    Author: Wendy Atehortua
    Date: 2026-09-11
    Description: Vehicle catalog view with search and filter controls by keyword, category, branch location, and rental dates.
--}}

@extends('layouts.app')

@section('content')
<div class="container py-5 catalog-page">
    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="fw-bold text-dark">{{ __('catalog.title') }}</h1>
            <p class="text-muted">{{ __('catalog.subtitle') }}</p>
        </div>
    </div>

    {{-- Validation error messages --}}
    @if ($errors->any())
        <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4">
            <ul class="mb-0 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Filter and Search Bar --}}
    <div class="card shadow-sm border-0 rounded-4 p-4 mb-4 bg-white">
        <form method="GET" action="{{ route('catalog.index') }}" class="row g-3 align-items-end">
            {{-- Search input --}}
            <div class="col-12 col-lg-4">
                <label for="search" class="form-label fw-semibold text-muted small mb-1">{{ __('catalog.search_label') }}</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-0 text-muted"><i class="bi bi-search"></i></span>
                    <input
                        type="text"
                        name="search"
                        id="search"
                        class="form-control bg-light border-0 py-2"
                        placeholder="{{ __('catalog.search_placeholder') }}"
                        value="{{ $viewData['filters']['search'] ?? '' }}"
                    >
                </div>
            </div>

            {{-- Category filter --}}
            <div class="col-6 col-md-3 col-lg-2">
                <label for="category_id" class="form-label fw-semibold text-muted small mb-1">{{ __('catalog.category_filter') }}</label>
                <select name="category_id" id="category_id" class="form-select bg-light border-0 py-2">
                    <option value="">{{ __('catalog.all_categories') }}</option>
                    @foreach ($viewData['categories'] as $category)
                        <option
                            value="{{ $category->getId() }}"
                            {{ (isset($viewData['filters']['category_id']) && (int) $viewData['filters']['category_id'] === $category->getId()) ? 'selected' : '' }}
                        >
                            {{ $category->getName() }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Location filter --}}
            <div class="col-6 col-md-3 col-lg-2">
                <label for="location_id" class="form-label fw-semibold text-muted small mb-1">{{ __('catalog.location_filter') }}</label>
                <select name="location_id" id="location_id" class="form-select bg-light border-0 py-2">
                    <option value="">{{ __('catalog.all_locations') }}</option>
                    @foreach ($viewData['locations'] as $location)
                        <option
                            value="{{ $location->getId() }}"
                            {{ (isset($viewData['filters']['location_id']) && (int) $viewData['filters']['location_id'] === $location->getId()) ? 'selected' : '' }}
                        >
                            {{ $location->getName() }} ({{ $location->getCity() }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Pickup Date --}}
            <div class="col-6 col-md-3 col-lg-2">
                <label for="start_date" class="form-label fw-semibold text-muted small mb-1">{{ __('catalog.start_date') }}</label>
                <input
                    type="date"
                    name="start_date"
                    id="start_date"
                    class="form-control bg-light border-0 py-2 @error('start_date') is-invalid @enderror"
                    min="{{ \Carbon\Carbon::now()->toDateString() }}"
                    value="{{ $viewData['filters']['start_date'] ?? '' }}"
                >
            </div>

            {{-- Return Date --}}
            <div class="col-6 col-md-3 col-lg-2">
                <label for="end_date" class="form-label fw-semibold text-muted small mb-1">{{ __('catalog.end_date') }}</label>
                <input
                    type="date"
                    name="end_date"
                    id="end_date"
                    class="form-control bg-light border-0 py-2 @error('end_date') is-invalid @enderror"
                    min="{{ \Carbon\Carbon::now()->toDateString() }}"
                    value="{{ $viewData['filters']['end_date'] ?? '' }}"
                >
            </div>

            {{-- Footer actions --}}
            <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-2 pt-3 border-top mt-3">
                <div>
                    <span class="badge bg-light text-dark border rounded-pill px-3 py-2 fw-medium">
                        {{ __('catalog.results_count', ['count' => $viewData['cars']->count()]) }}
                    </span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    @if (! empty(array_filter($viewData['filters'])))
                        <a href="{{ route('catalog.index') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-medium">
                            <i class="bi bi-x-circle me-1"></i>{{ __('catalog.clear_filters') }}
                        </a>
                    @endif
                    <button type="submit" class="btn btn-dark rounded-pill px-4 py-2 fw-semibold shadow-sm">
                        <i class="bi bi-funnel me-1"></i>{{ __('catalog.filter_button') }}
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Cars Grid --}}
    <div class="row row-cols-1 row-cols-md-2 g-4">
        @forelse ($viewData['cars'] as $car)
            <div class="col">
                <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden bg-white">
                    <x-car-image
                        :image="$car->getImage()"
                        class="card-img-top object-fit-cover catalog-card-image"
                    />

                    <div class="card-body d-flex flex-column justify-content-between p-4">
                        <div>
                            {{-- Badges row --}}
                            <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-1">
                                <span class="text-muted small">
                                    {{ number_format($car->getMileage(), 0, ',', '.') }} {{ __('catalog.km_unit') }}
                                </span>
                                @if ($car->getLocation())
                                    <span class="badge bg-light text-dark border rounded-pill px-2 py-1 small">
                                        <i class="bi bi-geo-alt text-danger me-1"></i>{{ $car->getLocation()->getCity() }} - {{ $car->getLocation()->getName() }}
                                    </span>
                                @endif
                            </div>

                            <h3 class="card-title fw-bold text-dark fs-5 mb-2">
                                {{ optional($car->getCategory())->getBrand() }} {{ optional($car->getCategory())->getModel() }}
                            </h3>

                            <p class="text-dark fw-bold fs-4 mb-3">
                                ${{ number_format($car->getPrice(), 0, ',', '.') }}
                                <span class="fs-6 text-muted fw-normal">{{ __('catalog.per_day') }}</span>
                            </p>
                        </div>
                        <div>
                            <a href="{{ route('catalog.show', ['id' => $car->getId()]) }}" class="btn btn-dark w-100 fw-semibold rounded-pill py-2">
                                {{ __('catalog.view_details') }} &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="card border-0 rounded-4 shadow-sm p-5 bg-white mx-auto" style="max-width: 520px;">
                    <div class="mb-3 text-muted">
                        <i class="bi bi-search" style="font-size: 2.5rem;"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-2">{{ __('catalog.no_results_title') }}</h4>
                    <p class="text-muted small mb-4">{{ __('catalog.no_results_subtitle') }}</p>
                    <div>
                        <a href="{{ route('catalog.index') }}" class="btn btn-dark rounded-pill px-4 py-2 fw-semibold">
                            {{ __('catalog.clear_filters') }}
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
