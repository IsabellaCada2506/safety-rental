{{--
    Author: Wendy Atehortua
    Author: Isabella Cadavid Posada
    Date: 2026-11-04
    Description: User vehicle detail with a large photograph, specifications and existing reservation access.
--}}

@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<section class="container catalog-page user-catalog">
    <a
        href="{{ route('catalog.index') }}"
        class="btn btn-outline-secondary btn-sm rounded-pill px-3 mb-4 d-inline-block text-decoration-none"
    >
        &larr; {{ __('general.btn_back') }}
    </a>

    <div class="uc-detail-grid">
        <div class="uc-detail-media">
            <x-responsive-image
                :src="$viewData['car']->getImage()"
                :alt="$viewData['car']->getCategory()?->getName() ?? __('general.image_alt')"
                class="uc-detail-image"
            />
        </div>

        <article class="uc-detail-panel">
            <span
                class="uc-detail-status {{ $viewData['car']->isActive() ? 'uc-status-active' : 'uc-status-inactive' }}"
            >
                {{ $viewData['car']->isActive() ? __('catalog.available') : __('catalog.status_deactivated') }}
            </span>

            <span class="uc-category">
                {{ $viewData['car']->getCategory()?->getType() ?? '—' }}
            </span>

            <h1 class="uc-detail-title">
                {{ $viewData['car']->getCategory()?->getName() ?? $viewData['car']->getPlate() }}
            </h1>

            <p class="uc-price uc-detail-price">
                ${{ number_format($viewData['car']->getPrice(), 0, app()->getLocale() === 'es' ? ',' : '.', app()->getLocale() === 'es' ? '.' : ',') }}

                <span>{{ __('catalog.per_day') }}</span>
            </p>

            <dl class="uc-specifications">
                <div>
                    <dt>{{ __('catalog.plate_label') }}</dt>
                    <dd>{{ $viewData['car']->getPlate() }}</dd>
                </div>

                <div>
                    <dt>{{ __('car.color') }}</dt>
                    <dd>{{ $viewData['car']->getColor() }}</dd>
                </div>

                <div>
                    <dt>{{ __('car.mileage') }}</dt>
                    <dd>
                        {{ number_format($viewData['car']->getMileage(), 0, app()->getLocale() === 'es' ? ',' : '.', app()->getLocale() === 'es' ? '.' : ',') }}
                        {{ __('catalog.km_unit') }}
                    </dd>
                </div>

                <div>
                    <dt>{{ __('catalog.passengers_label') }}</dt>
                    <dd>
                        {{ $viewData['car']->getCategory()?->getPassengerCapacity() ?? '—' }}
                    </dd>
                </div>

                <div>
                    <dt>{{ __('catalog.luggage_label') }}</dt>
                    <dd>
                        {{ $viewData['car']->getCategory()?->getLuggageCapacity() ?? '—' }}
                        {{ __('catalog.units') }}
                    </dd>
                </div>
            </dl>

            @if ($viewData['car']->getLocation())
                <div class="uc-location">
                    <span>{{ __('catalog.location_filter') }}</span>

                    <strong>
                        {{ $viewData['car']->getLocation()->getName() }}
                    </strong>

                    <span>
                        {{ $viewData['car']->getLocation()->getCity() }}
                    </span>
                </div>
            @endif

            @if ($viewData['car']->getDescription())
                <div class="uc-description">
                    <h2>{{ __('catalog.description_label') }}</h2>

                    <p>{{ $viewData['car']->getDescription() }}</p>
                </div>
            @endif

            <a class="btn btn-outline-primary mb-3" href="{{ route('pickupRoutes.index', ['id' => $viewData['car']->getId()]) }}">{{ __('integrations.pickup_route') }}</a>

            @if ($viewData['car']->isActive())
                <a
                    href="{{ route('reservations.create', ['car_id' => $viewData['car']->getId()]) }}"
                    class="uc-button uc-button-primary uc-card-link"
                >
                    {{ __('catalog.rent_now') }}
                    <span aria-hidden="true">→</span>
                </a>
            @else
                <button
                    type="button"
                    class="uc-button uc-button-primary uc-card-link"
                    disabled
                >
                    {{ __('catalog.status_deactivated') }}
                </button>
            @endif
        </article>
    </div>
</section>
@endsection