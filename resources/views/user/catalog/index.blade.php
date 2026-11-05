{{--
    Author: Wendy Atehortua
    Author: Isabella Cadavid Posada
    Date: 2026-11-04
    Description: User vehicle catalog with responsive cards and existing search filters.
--}}

@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<section class="container catalog-page user-catalog">
    <header class="uc-heading">
        <h1>{{ __('catalog.title') }}</h1>
        <p>{{ __('catalog.subtitle') }}</p>
    </header>

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        method="GET"
        action="{{ route('catalog.index') }}"
        class="uc-filter-panel"
    >
        @csrf

        <div class="uc-filter-grid">
            <div class="uc-field uc-search-field">
                <label for="search" class="form-label">
                    {{ __('catalog.search_label') }}
                </label>

                <input
                    type="text"
                    name="search"
                    id="search"
                    class="form-control @error('search') is-invalid @enderror"
                    placeholder="{{ __('catalog.search_placeholder') }}"
                    value="{{ old('search', $viewData['filters']['search'] ?? '') }}"
                    @error('search') aria-invalid="true" aria-describedby="search-error" @enderror
                >
                @error('search')
                    <div id="search-error" class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="uc-field">
                <label for="category_id" class="form-label">
                    {{ __('catalog.category_filter') }}
                </label>

                <select
                    name="category_id"
                    id="category_id"
                    class="form-select @error('category_id') is-invalid @enderror"
                    @error('category_id') aria-invalid="true" aria-describedby="category_id-error" @enderror
                >
                    <option value="">
                        {{ __('catalog.all_categories') }}
                    </option>

                    @foreach ($viewData['categories'] as $category)
                        <option
                            value="{{ $category->getId() }}"
                            @selected(
                                (int) old('category_id', $viewData['filters']['category_id'] ?? '')
                                === $category->getId()
                            )
                        >
                            {{ $category->getName() }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div id="category_id-error" class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="uc-field">
                <label for="location_id" class="form-label">
                    {{ __('catalog.location_filter') }}
                </label>

                <select
                    name="location_id"
                    id="location_id"
                    class="form-select @error('location_id') is-invalid @enderror"
                    @error('location_id') aria-invalid="true" aria-describedby="location_id-error" @enderror
                >
                    <option value="">
                        {{ __('catalog.all_locations') }}
                    </option>

                    @foreach ($viewData['locations'] as $location)
                        <option
                            value="{{ $location->getId() }}"
                            @selected(
                                (int) old('location_id', $viewData['filters']['location_id'] ?? '')
                                === $location->getId()
                            )
                        >
                            {{ $location->getName() }}
                            ({{ $location->getCity() }})
                        </option>
                    @endforeach
                </select>
                @error('location_id')
                    <div id="location_id-error" class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="uc-field">
                <label for="start_date" class="form-label">
                    {{ __('catalog.start_date') }}
                </label>

                <input
                    type="date"
                    name="start_date"
                    id="start_date"
                    class="form-control @error('start_date') is-invalid @enderror"
                    min="{{ $viewData['today'] ?? now()->toDateString() }}"
                    value="{{ old('start_date', $viewData['filters']['start_date'] ?? '') }}"
                    @error('start_date')
                        aria-invalid="true"
                        aria-describedby="start-date-error"
                    @enderror
                >

                @error('start_date')
                    <div id="start-date-error" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="uc-field">
                <label for="end_date" class="form-label">
                    {{ __('catalog.end_date') }}
                </label>

                <input
                    type="date"
                    name="end_date"
                    id="end_date"
                    class="form-control @error('end_date') is-invalid @enderror"
                    min="{{ $viewData['today'] ?? now()->toDateString() }}"
                    value="{{ old('end_date', $viewData['filters']['end_date'] ?? '') }}"
                    @error('end_date')
                        aria-invalid="true"
                        aria-describedby="end-date-error"
                    @enderror
                >

                @error('end_date')
                    <div id="end-date-error" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="uc-filter-footer">
            <span class="uc-result-count">
                {{ __('catalog.results_count', ['count' => $viewData['cars']->count()]) }}
            </span>

            <div class="uc-actions">
                @if (! empty(array_filter($viewData['filters'])))
                    <a
                        href="{{ route('catalog.index') }}"
                        class="uc-button uc-button-secondary"
                    >
                        {{ __('catalog.clear_filters') }}
                    </a>
                @endif

                <button
                    type="submit"
                    class="uc-button uc-button-primary"
                >
                    {{ __('catalog.filter_button') }}
                </button>
            </div>
        </div>
    </form>

    <div class="uc-grid">
        @forelse ($viewData['cars'] as $car)
            <article class="uc-card">
                <div class="uc-card-media">
                    <x-car-image
                        :image="$car->getImage()"
                        :alt="$car->getCategory()?->getName() ?? __('car.image_alt')"
                        class="uc-car-image"
                        loading="lazy"
                    />

                    <span
                        class="uc-status {{ $car->isActive() ? 'uc-status-active' : 'uc-status-inactive' }}"
                    >
                        {{ $car->isActive() ? __('catalog.available') : __('catalog.status_deactivated') }}
                    </span>
                </div>

                <div class="uc-card-body">
                    <span class="uc-category">
                        {{ $car->getCategory()?->getType() ?? '—' }}
                    </span>

                    <h2 class="uc-card-title">
                        {{ $car->getCategory()?->getName() ?? $car->getPlate() }}
                    </h2>

                    <p class="uc-price">
                        ${{ number_format($car->getPrice(), 0, app()->getLocale() === 'es' ? ',' : '.', app()->getLocale() === 'es' ? '.' : ',') }}

                        <span>{{ __('catalog.per_day') }}</span>
                    </p>

                    <dl class="uc-specifications">
                        <div>
                            <dt>{{ __('catalog.plate_label') }}</dt>
                            <dd>{{ $car->getPlate() }}</dd>
                        </div>

                        <div>
                            <dt>{{ __('car.color') }}</dt>
                            <dd>{{ $car->getColor() }}</dd>
                        </div>

                        <div>
                            <dt>{{ __('car.mileage') }}</dt>
                            <dd>
                                {{ number_format($car->getMileage(), 0, app()->getLocale() === 'es' ? ',' : '.', app()->getLocale() === 'es' ? '.' : ',') }}
                                {{ __('catalog.km_unit') }}
                            </dd>
                        </div>

                        <div>
                            <dt>{{ __('catalog.passengers_label') }}</dt>
                            <dd>
                                {{ $car->getCategory()?->getPassengerCapacity() ?? '—' }}
                            </dd>
                        </div>
                    </dl>

                    <div class="uc-location">
                        <span>{{ __('catalog.location_filter') }}</span>

                        <strong>
                            {{ $car->getLocation()?->getName() ?? '—' }}
                        </strong>

                        @if ($car->getLocation())
                            <span>
                                {{ $car->getLocation()->getCity() }}
                            </span>
                        @endif
                    </div>

                    <a
                        href="{{ route('catalog.show', ['id' => $car->getId()]) }}"
                        class="uc-button uc-button-primary uc-card-link"
                    >
                        {{ __('catalog.view_details') }}
                        <span aria-hidden="true">→</span>
                    </a>
                </div>
            </article>
        @empty
            <div class="uc-empty" role="status">
                <h2>{{ __('catalog.no_results_title') }}</h2>

                <p>{{ __('catalog.no_results_subtitle') }}</p>

                <a
                    href="{{ route('catalog.index') }}"
                    class="uc-button uc-button-primary"
                >
                    {{ __('catalog.clear_filters') }}
                </a>
            </div>
        @endforelse
    </div>
</section>
@endsection