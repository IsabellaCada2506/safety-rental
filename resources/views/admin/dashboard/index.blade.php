{{--
    Author: Isabella Cadavid Posada
    Date: 2026-09-06
    Description: Admin dashboard view.
--}}

@extends('layouts.app')

@section('content')
    <section class="dash-hero dash-hero-admin">
        <div class="road-line" aria-hidden="true"></div>

        <div class="container dash-hero-inner">
            <span class="dash-label dash-label-admin">
                {{ __('authentication.administration_area') }}
            </span>

            <h1>
                {{ $viewData['title'] }}
            </h1>

            <p class="dash-hero-text">
                {{ __('authentication.admin_message') }}
            </p>

            <div class="dash-user">
                <span
                    class="dash-user-avatar dash-user-avatar-admin"
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
                {{ __('authentication.management_panel') }}
            </h2>

            <div class="admin-grid">
                {{-- Vehicles Management Card --}}
                <div class="admin-card">
                    <span class="admin-icon" aria-hidden="true">
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
                            <circle
                                cx="18"
                                cy="27"
                                r="4"
                                stroke="currentColor"
                                stroke-width="2"
                            />
                            <circle
                                cx="46"
                                cy="27"
                                r="4"
                                stroke="currentColor"
                                stroke-width="2"
                            />
                        </svg>
                    </span>

                    <h3>
                        {{ __('authentication.vehicles') }}
                    </h3>

                    <p>
                        {{ __('authentication.vehicles_description') }}
                    </p>

                    <a href="{{ route('admin.car.index') }}" class="badge rounded-pill text-dark text-decoration-none px-3 py-2 fw-bold shadow-sm d-inline-flex align-items-center admin-card-link">
                        <span class="me-1"></span> {{ __('car.heading_management') }}
                    </a>
                </div>

                {{-- Reservations Card --}}
                <div class="admin-card">
                    <span class="admin-icon" aria-hidden="true">
                        <svg
                            viewBox="0 0 32 32"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <rect
                                x="6"
                                y="8"
                                width="20"
                                height="18"
                                rx="2"
                                stroke="currentColor"
                                stroke-width="2"
                            />
                            <path
                                d="M6 13H26"
                                stroke="currentColor"
                                stroke-width="2"
                            />
                            <path
                                d="M11 5V10M21 5V10"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                            />
                        </svg>
                    </span>

                    <h3>
                        {{ __('authentication.reservations') }}
                    </h3>

                    <p>
                        {{ __('authentication.reservations_description') }}
                    </p>

                    <span class="admin-soon">
                        {{ __('authentication.coming_soon') }}
                    </span>
                </div>

                {{-- Users Card --}}
                <div class="admin-card">
                    <span class="admin-icon" aria-hidden="true">
                        <svg
                            viewBox="0 0 32 32"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <circle
                                cx="16"
                                cy="12"
                                r="5"
                                stroke="currentColor"
                                stroke-width="2"
                            />
                            <path
                                d="M6 26C6 20.5 10.5 17 16 17C21.5 17 26 20.5 26 26"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                            />
                        </svg>
                    </span>

                    <h3>
                        {{ __('authentication.users') }}
                    </h3>

                    <p>
                        {{ __('authentication.users_description') }}
                    </p>

                    <span class="admin-soon">
                        {{ __('authentication.coming_soon') }}
                    </span>
                </div>
            </div>
        </div>
    </section>
@endsection