{{--
    Author: Alejandro Correa Marin
    Date: 2026-11-09
    Description: Form that sends the customer geolocation to estimate driving time to a rental branch.
--}}

@props(['location'])

@if ($location->hasCoordinates())
    <form
        method="GET"
        action="{{ route('route-estimates.show') }}"
        class="route-estimate-form mt-3"
        data-denied="{{ __('maps.geolocation_denied') }}"
        data-unavailable="{{ __('maps.geolocation_unavailable') }}"
        data-locating="{{ __('maps.locating') }}"
    >
        <input
            type="hidden"
            name="location_id"
            value="{{ $location->getId() }}"
        >
        <input
            type="hidden"
            name="origin_latitude"
            class="route-estimate-latitude"
        >
        <input
            type="hidden"
            name="origin_longitude"
            class="route-estimate-longitude"
        >
        <button
            type="button"
            class="btn btn-outline-dark rounded-pill py-2 fw-medium route-estimate-button"
        >
            {{ __('maps.use_my_location') }}
        </button>
        <p class="small text-muted mt-2 mb-0 route-estimate-status d-none"></p>
    </form>
@else
    <p class="small text-muted mt-3 mb-0">
        {{ __('maps.error_missing_destination') }}
    </p>
@endif

@once
    @push('scripts')
        <script src="{{ asset('js/route-estimate.js') }}"></script>
    @endpush
@endonce
