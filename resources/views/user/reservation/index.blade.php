{{--
    Author: Isabella Ocampo
    Author: Wendy Atehortua
    Author: Isabella Cadavid Posada
    Date: 2026-11-04
    Description: Customer reservation cards with vehicle images, rental information and status.
--}}

@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<div class="container user-reservations">
    <header class="user-reservations-heading">
        <div>
            <span class="user-reservations-eyebrow">
                {{ __('reservation.summary_heading') }}
            </span>

            <h1>{{ $viewData['title'] }}</h1>
        </div>

        <a
            href="{{ route('catalog.index') }}"
            class="user-reservations-back"
        >
            <span aria-hidden="true">&larr;</span>
            {{ __('catalog.title') }}
        </a>
    </header>

    @if (session('success'))
        <div
            class="alert alert-success user-reservations-alert"
            role="status"
        >
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div
            class="alert alert-danger user-reservations-alert"
            role="alert"
        >
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="user-reservations-grid">
        @forelse ($viewData['reservations'] as $reservation)
            <article class="user-reservation-card">
                <header class="user-reservation-header">
                    <div class="user-reservation-reference">
                        <span>{{ __('reservation.reservation_code') }}</span>

                        <h2>#{{ $reservation->getCode() }}</h2>
                    </div>

                    <span
                        class="user-reservation-status"
                        data-state="{{ $reservation->getState() }}"
                    >
                        <span aria-hidden="true"></span>
                        {{ __('reservation.state_' . $reservation->getState()) }}
                    </span>
                </header>

                <div class="user-reservation-image">
                    <x-car-image
                        :image="$reservation->getCar()?->getImage()"
                        class="user-reservation-photo"
                    />
                </div>

                <div class="user-reservation-body">
                    <div class="user-reservation-vehicle">
                        <h3>
                            {{ optional($reservation->getCar()?->getCategory())->getBrand() }}
                            {{ optional($reservation->getCar()?->getCategory())->getModel() }}
                        </h3>

                        <span class="user-reservation-plate">
                            {{ __('catalog.plate_label') }}:
                            <strong>
                                {{ $reservation->getCar()?->getPlate() }}
                            </strong>
                        </span>
                    </div>

                    <div class="user-reservation-location">
                        <svg
                            width="20"
                            height="20"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.7"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            aria-hidden="true"
                        >
                            <path d="M20 10C20 16 12 22 12 22S4 16 4 10a8 8 0 1 1 16 0Z"/>
                            <circle cx="12" cy="10" r="2.5"/>
                        </svg>

                        <div>
                            <span>{{ __('reservation.pickup_location') }}</span>
                            <strong>
                                {{ $reservation->getLocation()?->getName() }}
                            </strong>
                        </div>
                    </div>

                    <dl class="user-reservation-dates">
                        <div>
                            <dt>{{ __('reservation.start_date') }}</dt>
                            <dd>
                                {{ $reservation->getStartDate()?->format('d/m/Y') }}
                            </dd>
                        </div>

                        <div>
                            <dt>{{ __('reservation.end_date') }}</dt>
                            <dd>
                                {{ $reservation->getEndDate()?->format('d/m/Y') }}
                            </dd>
                        </div>

                        <div class="user-reservation-duration">
                            <dt>{{ __('reservation.rental_days') }}</dt>
                            <dd>
                                {{ $reservation->getDays() }}
                                {{ __('reservation.days_unit') }}
                            </dd>
                        </div>
                    </dl>

                    <footer class="user-reservation-footer">
                        <div class="user-reservation-total">
                            <span>{{ __('reservation.total_price') }}</span>

                            <strong>
                                ${{ number_format($reservation->getTotalPrice(), 0, app()->getLocale() === 'es' ? ',' : '.', app()->getLocale() === 'es' ? '.' : ',') }}
                            </strong>
                        </div>

                        <a
                            href="{{ route('reservations.show', ['id' => $reservation->getId()]) }}"
                            class="user-reservation-details"
                        >
                            {{ __('reservation.view_details') }}
                            <span aria-hidden="true">&rarr;</span>
                        </a>
                    </footer>
                </div>
            </article>
        @empty
            <section class="user-reservations-empty">
                <span class="user-reservations-empty-icon" aria-hidden="true">
                    <svg
                        width="32"
                        height="32"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.6"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <rect x="3" y="4" width="18" height="17" rx="3"/>
                        <path d="M16 2v4M8 2v4M3 10h18"/>
                        <path d="M8 15h3M8 18h6"/>
                    </svg>
                </span>

                <h2>{{ __('reservation.no_reservations') }}</h2>

                <p>{{ __('catalog.subtitle') }}</p>

                <a
                    href="{{ route('catalog.index') }}"
                    class="user-reservation-details"
                >
                    {{ __('catalog.title') }}
                    <span aria-hidden="true">&rarr;</span>
                </a>
            </section>
        @endforelse
    </div>
</div>
@endsection