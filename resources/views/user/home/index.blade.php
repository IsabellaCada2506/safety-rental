{{--
    Author: Isabella Cadavid Posada
    Date: 2026-11-04
    Description: Informative user home with a full-width automatic image carousel and existing user routes.
--}}

@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<div class="user-home">
    <section class="user-banner" data-user-carousel data-interval="5000" data-fallback="{{ asset('images/car-placeholder.png') }}" data-pause-label="{{ __('user-home.pause') }}" data-play-label="{{ __('user-home.play') }}" data-status-template="{{ __('user-home.slide_status') }}" role="region" aria-label="{{ __('user-home.carousel_label') }}">
        <div class="user-banner-images">
            <img src="{{ asset('images/home/slide-1.jpg') }}" alt="{{ __('user-home.image_one') }}" class="user-banner-image" data-user-slide fetchpriority="high">
            <img src="{{ asset('images/home/slide-2.jpg') }}" alt="{{ __('user-home.image_two') }}" class="user-banner-image" data-user-slide hidden>
            <img src="{{ asset('images/home/slide-3.jpg') }}" alt="{{ __('user-home.image_three') }}" class="user-banner-image" data-user-slide hidden>
        </div>
        <div class="user-banner-shade" aria-hidden="true"></div>
        <div class="container user-banner-content">
            <div class="user-banner-copy">
                <span class="user-banner-eyebrow">{{ __('user-home.eyebrow') }}</span>
                <h1>{{ __('user-home.title') }}</h1>
                <p>{{ __('user-home.subtitle') }}</p>
                <a class="user-home-button user-home-button-white" href="{{ route('catalog.index') }}">{{ __('user-home.explore') }} <span aria-hidden="true">→</span></a>
            </div>
        </div>
        <button class="user-banner-arrow user-banner-previous" type="button" data-user-previous aria-label="{{ __('user-home.previous') }}"><span aria-hidden="true">‹</span></button>
        <button class="user-banner-arrow user-banner-next" type="button" data-user-next aria-label="{{ __('user-home.next') }}"><span aria-hidden="true">›</span></button>
        <div class="user-banner-controls">
            <div class="user-banner-dots">
                <button type="button" class="user-banner-dot" data-user-dot="0" aria-label="{{ __('user-home.go_to_slide', ['number' => 1]) }}" aria-pressed="true"></button>
                <button type="button" class="user-banner-dot" data-user-dot="1" aria-label="{{ __('user-home.go_to_slide', ['number' => 2]) }}" aria-pressed="false"></button>
                <button type="button" class="user-banner-dot" data-user-dot="2" aria-label="{{ __('user-home.go_to_slide', ['number' => 3]) }}" aria-pressed="false"></button>
            </div>
            <button type="button" class="user-banner-pause" data-user-toggle>{{ __('user-home.pause') }}</button>
            <span class="user-home-sr-only" data-user-status aria-live="off">{{ __('user-home.slide_status', ['current' => 1, 'total' => 3]) }}</span>
        </div>
    </section>

    <section class="container user-home-about">
        <div>
            <span class="user-home-eyebrow">{{ __('user-home.about_label') }}</span>
            <h2>{{ __('user-home.about_title') }}</h2>
        </div>
        <div>
            <p>{{ __('user-home.about_text') }}</p>
            <p>{{ __('user-home.about_goal') }}</p>
        </div>
    </section>

    <section class="container user-home-services">
        <header><span class="user-home-eyebrow">{{ __('user-home.services_label') }}</span><h2>{{ __('user-home.services_title') }}</h2></header>
        <div class="user-home-grid">
            <article class="user-home-card"><span class="user-home-step" aria-hidden="true">01</span><h3>{{ __('user-home.vehicles_title') }}</h3><p>{{ __('user-home.vehicles_text') }}</p><a href="{{ route('catalog.index') }}">{{ __('user-home.explore') }} <span aria-hidden="true">→</span></a></article>
            <article class="user-home-card"><span class="user-home-step" aria-hidden="true">02</span><h3>{{ __('user-home.locations_title') }}</h3><p>{{ __('user-home.locations_text') }}</p><a href="{{ route('locations.index') }}">{{ __('user-home.locations_link') }} <span aria-hidden="true">→</span></a></article>
            <article class="user-home-card"><span class="user-home-step" aria-hidden="true">03</span><h3>{{ __('user-home.reservations_title') }}</h3><p>{{ __('user-home.reservations_text') }}</p><a href="{{ route('reservations.index') }}">{{ __('user-home.reservations_link') }} <span aria-hidden="true">→</span></a></article>
        </div>
    </section>
</div>
@endsection

@push('scripts')
    <script
        src="{{ asset('js/user/homepage.js') }}?v=4"
        defer
    ></script>
@endpush