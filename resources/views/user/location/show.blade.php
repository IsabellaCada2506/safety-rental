{{--
    Author: Isabella Ocampo
    Author: Isabella Cadavid Posada
    Date: 2026-11-04
    Description: User branch details with contact information and available vehicle cards.
--}}

@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<section class="container catalog-page locations-page">
    <a
        href="{{ route('locations.index') }}"
        class="btn btn-outline-secondary btn-sm rounded-pill px-3 mb-4 d-inline-block text-decoration-none"
    >
        &larr; {{ __('general.btn_back') }}
    </a>

    <article class="locations-detail">
        <header class="locations-detail-header">
            <div>
                <span class="locations-eyebrow">
                    {{ $viewData['location']->getCity() }}
                </span>

                <h1>{{ $viewData['location']->getName() }}</h1>

                <p>{{ $viewData['location']->getHeadquarters() }}</p>
            </div>

            <span class="locations-count">
                {{ $viewData['location']->getCars()->count() }}
                {{ __('location.cars_count') }}
            </span>
        </header>

        <dl class="locations-detail-contact">
            <div>
                <dt>{{ __('location.address') }}</dt>
                <dd>{{ $viewData['location']->getAddress() }}</dd>
            </div>

            <div>
                <dt>{{ __('location.telephone_label') }}</dt>
                <dd>{{ $viewData['location']->getTelephone() }}</dd>
            </div>
        </dl>
    </article>

    <header class="locations-fleet-heading">
        <h2>{{ __('location.available_fleet_heading') }}</h2>
        <p>{{ __('location.available_fleet_subtitle') }}</p>
    </header>

    <div class="locations-grid">
        @forelse ($viewData['location']->getCars() as $car)
            <article class="locations-card">
                <div class="locations-vehicle-media">
                    <x-car-image
                        :image="$car->getImage()"
                        :alt="$car->getCategory()?->getName() ?? __('car.image_alt')"
                        class="locations-vehicle-image"
                        loading="lazy"
                    />

                    <span class="locations-vehicle-category">
                        {{ $car->getCategory()?->getType() ?? '—' }}
                    </span>
                </div>

                <div class="locations-card-body">
                    <h3 class="locations-vehicle-title">
                        {{ $car->getCategory()?->getName() ?? $car->getPlate() }}
                    </h3>

                    <p class="locations-price">
                        ${{ number_format($car->getPrice(), 0, app()->getLocale() === 'es' ? ',' : '.', app()->getLocale() === 'es' ? '.' : ',') }}

                        <span>{{ __('catalog.per_day') }}</span>
                    </p>

                    <dl class="locations-vehicle-facts">
                        <div>
                            <dt>{{ __('catalog.plate_label') }}</dt>
                            <dd>{{ $car->getPlate() }}</dd>
                        </div>

                        <div>
                            <dt>{{ __('car.mileage') }}</dt>
                            <dd>
                                {{ number_format($car->getMileage(), 0, app()->getLocale() === 'es' ? ',' : '.', app()->getLocale() === 'es' ? '.' : ',') }}
                                {{ __('catalog.km_unit') }}
                            </dd>
                        </div>

                        <div>
                            <dt>{{ __('car.color') }}</dt>
                            <dd>{{ $car->getColor() }}</dd>
                        </div>

                        <div>
                            <dt>{{ __('catalog.passengers_label') }}</dt>
                            <dd>
                                {{ $car->getCategory()?->getPassengerCapacity() ?? '—' }}
                            </dd>
                        </div>
                    </dl>

                    <div class="locations-vehicle-actions">
                        <a
                            href="{{ route('reservations.create', [
                                'car_id' => $car->getId(),
                                'location_id' => $viewData['location']->getId(),
                            ]) }}"
                            class="locations-button locations-button-primary"
                        >
                            {{ __('catalog.rent_now') }}
                            <span aria-hidden="true">→</span>
                        </a>

                        <a
                            href="{{ route('catalog.show', ['id' => $car->getId()]) }}"
                            class="locations-button locations-button-secondary"
                        >
                            {{ __('catalog.view_details') }}
                        </a>
                    </div>
                </div>
            </article>
        @empty
            <div class="locations-empty" role="status">
                <h3>{{ __('location.no_vehicles_at_location') }}</h3>

                <p>{{ __('location.branches_subtitle') }}</p>

                <div class="locations-empty-actions">
                    <a
                        href="{{ route('locations.index') }}"
                        class="locations-button locations-button-primary"
                    >
                        {{ __('location.browse_other_branches') }}
                    </a>

                    <a
                        href="{{ route('catalog.index') }}"
                        class="locations-button locations-button-secondary"
                    >
                        {{ __('catalog.title') }}
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</section>
@endsection