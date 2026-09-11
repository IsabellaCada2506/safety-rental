{{--
    Author: Isabella Cadavid Posada
    Date: 2026-09-06
    Description: Public welcome landing page view.
--}}

@extends('layouts.app')

@section('content')
    <section class="welcome-hero">
        <div class="road-line" aria-hidden="true"></div>

        <div class="container">
            <div class="welcome-hero-inner">
                <span class="logo-badge" aria-hidden="true">
                    <svg
                        viewBox="0 0 32 36"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M16 2 L29 7V17C29 25 23.5 31 16 34C8.5 31 3 25 3 17V7Z"
                            fill="currentColor"
                        />
                        <path
                            d="M9 20 L11.5 14.5C12 13.4 13 12.7 14.2 12.7H17.8C19 12.7 20 13.4 20.5 14.5L23 20"
                            stroke="var(--sr-gold)"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            fill="none"
                        />
                        <path
                            d="M8 20H24V23C24 23.6 23.6 24 23 24H21.5C20.9 24 20.5 23.6 20.5 23V22H11.5V23C11.5 23.6 11.1 24 10.5 24H9C8.4 24 8 23.6 8 23V20Z"
                            stroke="var(--sr-gold)"
                            stroke-width="1.8"
                            stroke-linejoin="round"
                            fill="none"
                        />
                    </svg>
                </span>

                <span class="welcome-eyebrow">
                    {{ __('authentication.vehicle_rental') }}
                </span>

                <h1 class="welcome-title display-font">
                    {{ __('authentication.application_name') }}
                </h1>

                <div
                    class="welcome-underline"
                    aria-hidden="true"
                ></div>

                <p class="welcome-subtitle">
                    {{ __('authentication.welcome_subtitle') }}
                </p>

                @guest
                    <div class="welcome-actions">
                        <a
                            class="btn-pill-solid"
                            href="{{ route('register') }}"
                        >
                            {{ __('authentication.create_account') }}
                        </a>

                        <a
                            class="btn-pill-ghost"
                            href="{{ route('login') }}"
                        >
                            {{ __('authentication.login') }}
                        </a>
                    </div>
                @endguest
            </div>
        </div>
    </section>

    <section class="feature-strip">
        <div class="container">
            <div class="feature-grid">
                <div class="feature-item">
                    <span class="feature-icon" aria-hidden="true">
                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M12 3 L20 6V11C20 16 16.5 19.5 12 21C7.5 19.5 4 16 4 11V6Z"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linejoin="round"
                            />
                            <path
                                d="M9 12L11 14L15.5 9.5"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                    </span>

                    <h3>
                        {{ __('authentication.safe_driving') }}
                    </h3>

                    <p>
                        {{ __('authentication.safe_driving_description') }}
                    </p>
                </div>

                <div class="feature-item">
                    <span class="feature-icon" aria-hidden="true">
                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M3 16 L5 9.5C5.4 8.3 6.5 7.5 7.7 7.5H16.3C17.5 7.5 18.6 8.3 19 9.5L21 16"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                            <path
                                d="M3 16H21V18.5C21 19.05 20.55 19.5 20 19.5H18C17.45 19.5 17 19.05 17 18.5V17H7V18.5C7 19.05 6.55 19.5 6 19.5H4C3.45 19.5 3 19.05 3 18.5V16Z"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linejoin="round"
                            />
                        </svg>
                    </span>

                    <h3>
                        {{ __('authentication.varied_fleet') }}
                    </h3>

                    <p>
                        {{ __('authentication.varied_fleet_description') }}
                    </p>
                </div>

                <div class="feature-item">
                    <span class="feature-icon" aria-hidden="true">
                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <rect
                                x="4"
                                y="5"
                                width="16"
                                height="15"
                                rx="2"
                                stroke="currentColor"
                                stroke-width="1.8"
                            />
                            <path
                                d="M4 10H20"
                                stroke="currentColor"
                                stroke-width="1.8"
                            />
                            <path
                                d="M8 3V6.5M16 3V6.5"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                            />
                        </svg>
                    </span>

                    <h3>
                        {{ __('authentication.quick_reservations') }}
                    </h3>

                    <p>
                        {{ __('authentication.quick_reservations_description') }}
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection