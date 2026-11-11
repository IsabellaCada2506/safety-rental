{{--
    Author: Wendy Atehortua
    Date: 2026-11-07
    Description: Driving route calculator to vehicle pickup headquarters using Google Maps.
--}}

@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<section class="integration-page">
    <header class="integration-hero">
        <span class="integration-tag">
            {{ $viewData['car']->getCategory()?->getName() }}
        </span>

        <h1>{{ __('integrations.pickup_route') }}</h1>

        <p>{{ __('pickup.origin_help') }}</p>
    </header>

    <div class="integration-grid">
        <article class="integration-card">
            <h2>{{ __('pickup.origin') }}</h2>

            <form
                id="pickup-route-form"
                method="POST"
                action="{{ route('pickupRoutes.calculate', ['id' => $viewData['car']->getId()]) }}"
            >
                @csrf

                <input
                    id="origin-type"
                    type="hidden"
                    name="origin_type"
                    value="address"
                >

                <input
                    id="origin-latitude"
                    type="hidden"
                    name="latitude"
                    value=""
                >

                <input
                    id="origin-longitude"
                    type="hidden"
                    name="longitude"
                    value=""
                >

                <label
                    for="origin-address"
                    class="integration-label"
                >
                    {{ __('pickup.origin') }}
                </label>

                <input
                    id="origin-address"
                    name="origin_address"
                    type="text"
                    maxlength="255"
                    class="integration-input"
                    value="{{ old('origin_address', $viewData['originData']['origin_address'] ?? '') }}"
                    placeholder="{{ __('pickup.origin_placeholder') }}"
                    required
                    aria-describedby="origin-help"
                >

                <p
                    id="origin-help"
                    class="integration-muted mt-2"
                >
                    {{ __('pickup.origin_help') }}
                </p>

                <div class="integration-actions">
                    <button
                        id="locate-origin"
                        type="button"
                        class="integration-button integration-button-secondary"
                        data-error="{{ __('integrations.geolocation_error') }}"
                        data-success="{{ __('pickup.current_location') }}"
                    >
                        {{ __('integrations.use_location') }}
                    </button>

                    <button
                        type="submit"
                        class="integration-button"
                    >
                        {{ __('integrations.calculate') }}
                        <span aria-hidden="true">→</span>
                    </button>
                </div>

                <p
                    id="geolocation-status"
                    class="integration-status"
                    role="status"
                    aria-live="polite"
                ></p>

                @if ($errors->any())
                    <div
                        class="integration-notice mt-3"
                        role="alert"
                    >
                        {{ __('pickup.invalid_origin') }}
                    </div>
                @endif
            </form>

            <hr class="my-4">

            <h2>{{ __('reservation.pickup_location') }}</h2>

            @if ($viewData['car']->getLocation())
                <p class="fw-bold mb-1">
                    {{ $viewData['car']->getLocation()->getName() }}
                </p>

                <p class="integration-muted">
                    {{ $viewData['car']->getLocation()->getAddress() }},
                    {{ $viewData['car']->getLocation()->getCity() }}
                </p>

                <a
                    class="integration-button integration-button-secondary"
                    href="https://www.google.com/maps/search/?api=1&query={{ urlencode($viewData['car']->getLocation()->getAddress().', '.$viewData['car']->getLocation()->getCity().', Colombia') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    {{ __('integrations.open_maps') }}
                    <span aria-hidden="true">↗</span>
                </a>
            @else
                <p class="integration-notice">
                    {{ __('pickup.missing_destination') }}
                </p>
            @endif
        </article>

        <div>
            <article class="integration-card">
                <h2>{{ __('integrations.recommended_route') }}</h2>

                @if ($viewData['result'] === null)
                    <p class="integration-notice">
                        {{ __('pickup.origin_help') }}
                    </p>
                @elseif ($viewData['result']['error'])
                    <div
                        class="integration-notice"
                        role="alert"
                    >
                        @if (
                            in_array(
                                $viewData['result']['error'],
                                ['missing_destination', 'invalid_origin'],
                                true
                            )
                        )
                            {{ __('pickup.'.$viewData['result']['error']) }}
                        @else
                            {{ __('integrations.'.$viewData['result']['error']) }}
                        @endif
                    </div>
                @else
                    <div class="integration-metrics">
                        <div class="integration-metric">
                            <span>
                                {{ __('integrations.distance') }}
                            </span>

                            <strong>
                                {{ number_format(
                                    $viewData['result']['distanceKm'],
                                    1,
                                    app()->getLocale() === 'es' ? ',' : '.',
                                    ''
                                ) }}
                                km
                            </strong>
                        </div>

                        <div class="integration-metric">
                            <span>
                                {{ __('integrations.duration') }}
                            </span>

                            <strong>
                                {{ $viewData['result']['durationMinutes'] }}
                                min
                            </strong>
                        </div>
                    </div>

                    <ol class="integration-directions">
                        @foreach ($viewData['result']['instructions'] as $instruction)
                            <li>{{ $instruction }}</li>
                        @endforeach
                    </ol>

                    <p class="integration-attribution">
                        {{ __('integrations.google_attribution') }}
                    </p>

                    <a
                        href="{{ $viewData['result']['mapsUrl'] }}"
                        class="integration-button integration-button-wide mt-3"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        {{ __('integrations.open_maps') }}
                        <span aria-hidden="true">↗</span>
                    </a>
                @endif
            </article>

            <div class="integration-actions">
                <a
                    href="{{ route('reservations.create', ['car_id' => $viewData['car']->getId()]) }}"
                    class="integration-button"
                >
                    {{ __('catalog.rent_now') }}
                </a>

                <a
                    href="{{ route('catalog.show', ['id' => $viewData['car']->getId()]) }}"
                    class="integration-button integration-button-secondary"
                >
                    {{ __('general.btn_back') }}
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script
    src="{{ asset('js/user/pickup-route.js') }}?v=3"
    defer
></script>
@endpush