{{--
    Author: Isabella Ocampo
    Author: Isabella Cadavid Posada
    Date: 2026-11-04
    Description: User location cards with branch information, contact details and fleet access.
--}}

@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<section class="container catalog-page locations-page">
    <header class="locations-heading">
        <span class="locations-eyebrow">
            {{ __('location.registered_locations') }}
        </span>

        <h1>{{ __('general.nav_locations') }}</h1>

        <p>{{ __('location.branches_subtitle') }}</p>
    </header>

    <div class="locations-grid">
        @forelse ($viewData['locations'] as $location)
            <article class="locations-card">
                <header class="locations-card-banner">
                    <div class="locations-city">
                        <span class="locations-marker" aria-hidden="true">
                            ⌖
                        </span>

                        <span>{{ $location->getCity() }}</span>
                    </div>

                    <span class="locations-count">
                        {{ $location->getCarsCount() }}
                        {{ __('location.cars_count') }}
                    </span>
                </header>

                <div class="locations-card-body">
                    <span class="locations-unit">
                        {{ $location->getHeadquarters() }}
                    </span>

                    <h2>{{ $location->getName() }}</h2>

                    <dl class="locations-contact">
                        <div>
                            <dt>{{ __('location.address') }}</dt>
                            <dd>{{ $location->getAddress() }}</dd>
                        </div>

                        <div>
                            <dt>{{ __('location.telephone_label') }}</dt>
                            <dd>{{ $location->getTelephone() }}</dd>
                        </div>
                    </dl>

                    <a
                        href="{{ route('locations.show', ['id' => $location->getId()]) }}"
                        class="locations-button locations-button-primary locations-card-link"
                    >
                        {{ __('location.explore_fleet') }}
                        <span aria-hidden="true">→</span>
                    </a>
                </div>
            </article>
        @empty
            <div class="locations-empty" role="status">
                <p>{{ __('location.no_locations_found') }}</p>
            </div>
        @endforelse
    </div>
</section>
@endsection