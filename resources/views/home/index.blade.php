{{--
    Author: Isabella Cadavid Posada
    Date: 2026-09-06
    Description: Customer home dashboard view.
--}}

@extends('layouts.app')

@section('content')
    <section class="dash-hero dash-hero-customer">
        <div class="road-line" aria-hidden="true"></div>

        <div class="container dash-hero-inner">
            <span class="dash-label">
                {{ __('authentication.customer_area') }}
            </span>

            <h1>
                {{ $viewData['title'] }}
            </h1>

            <p class="dash-hero-text">
                {{ __('authentication.customer_message') }}
            </p>

            <div class="dash-user">
                <span
                    class="dash-user-avatar"
                    aria-hidden="true"
                >
                    {{ strtoupper(substr($viewData['userName'], 0, 1)) }}
                </span>

                {{ $viewData['userName'] }}
            </div>
        </div>
    </section>

    <section class="fleet-section">
        <div class="container">
            <h2 class="fleet-heading">
                {{ __('authentication.available_fleet') }}
            </h2>

            <div class="fleet-grid">
                <article class="fleet-card">
                    <span class="fleet-badge">
                        {{ __('authentication.available') }}
                    </span>

                    <span class="fleet-icon" aria-hidden="true">
                        <svg
                            viewBox="0 0 64 32"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M6 22 L11 12 Q14 8 20 8 H40 Q46 8 49 12 L58 22 V25 Q58 27 56 27 H8 Q6 27 6 25 Z"
                                stroke="currentColor"
                                stroke-width="2"
                                fill="none"
                            />
                            <path
                                d="M16 12 L20 12 L18 19 H12 Z"
                                stroke="currentColor"
                                stroke-width="1.6"
                                fill="none"
                            />
                            <path
                                d="M24 12 H40 L43 19 H21 Z"
                                stroke="currentColor"
                                stroke-width="1.6"
                                fill="none"
                            />
                            <circle cx="18" cy="27" r="4" stroke="currentColor" stroke-width="2" />
                            <circle cx="46" cy="27" r="4" stroke="currentColor" stroke-width="2" />
                        </svg>
                    </span>

                    <h3>
                        {{ __('authentication.executive_sedan') }}
                    </h3>

                    <p>
                        {{ __('authentication.executive_sedan_description') }}
                    </p>
                </article>

                <article class="fleet-card">
                    <span class="fleet-badge">
                        {{ __('authentication.available') }}
                    </span>

                    <span class="fleet-icon" aria-hidden="true">
                        <svg
                            viewBox="0 0 64 32"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M4 22 L8 10 Q10 7 15 7 H45 Q50 7 52 10 L60 22 V26 Q60 28 58 28 H6 Q4 28 4 26 Z"
                                stroke="currentColor"
                                stroke-width="2"
                                fill="none"
                            />
                            <path
                                d="M12 10 H20 V17 H9 Z"
                                stroke="currentColor"
                                stroke-width="1.6"
                                fill="none"
                            />
                            <path
                                d="M23 10 H44 L48 17 H23 Z"
                                stroke="currentColor"
                                stroke-width="1.6"
                                fill="none"
                            />
                            <circle cx="17" cy="28" r="4.5" stroke="currentColor" stroke-width="2" />
                            <circle cx="47" cy="28" r="4.5" stroke="currentColor" stroke-width="2" />
                        </svg>
                    </span>

                    <h3>
                        {{ __('authentication.family_suv') }}
                    </h3>

                    <p>
                        {{ __('authentication.family_suv_description') }}
                    </p>
                </article>

                <article class="fleet-card">
                    <span class="fleet-badge">
                        {{ __('authentication.available') }}
                    </span>

                    <span class="fleet-icon" aria-hidden="true">
                        <svg
                            viewBox="0 0 64 32"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M4 24 L9 13 Q12 9 18 9 H36 L46 9 Q50 9 52 12 L60 24 V26 Q60 28 58 28 H6 Q4 28 4 26 Z"
                                stroke="currentColor"
                                stroke-width="2"
                                fill="none"
                            />
                            <path
                                d="M14 13 L18 13 L16 19 H10 Z"
                                stroke="currentColor"
                                stroke-width="1.6"
                                fill="none"
                            />
                            <path
                                d="M22 9 H36 V19 H22 Z"
                                stroke="currentColor"
                                stroke-width="1.6"
                                fill="none"
                            />
                            <circle cx="17" cy="28" r="4" stroke="currentColor" stroke-width="2" />
                            <circle cx="47" cy="28" r="4" stroke="currentColor" stroke-width="2" />
                        </svg>
                    </span>

                    <h3>
                        {{ __('authentication.pickup_truck') }}
                    </h3>

                    <p>
                        {{ __('authentication.pickup_truck_description') }}
                    </p>
                </article>

                <article class="fleet-card">
                    <span class="fleet-badge">
                        {{ __('authentication.available') }}
                    </span>

                    <span class="fleet-icon" aria-hidden="true">
                        <svg
                            viewBox="0 0 64 32"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M4 24 L14 15 Q18 11 26 11 H40 Q46 11 50 15 L60 21 V25 Q60 27 58 27 H6 Q4 27 4 25 Z"
                                stroke="currentColor"
                                stroke-width="2"
                                fill="none"
                            />
                            <path
                                d="M18 15 L27 11 L27 18 L15 20 Z"
                                stroke="currentColor"
                                stroke-width="1.6"
                                fill="none"
                            />
                            <circle cx="18" cy="27" r="4.5" stroke="currentColor" stroke-width="2" />
                            <circle cx="48" cy="27" r="4.5" stroke="currentColor" stroke-width="2" />
                        </svg>
                    </span>

                    <h3>
                        {{ __('authentication.sports_car') }}
                    </h3>

                    <p>
                        {{ __('authentication.sports_car_description') }}
                    </p>
                </article>
            </div>
        </div>
    </section>
@endsection