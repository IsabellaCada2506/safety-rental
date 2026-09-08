{{--
    Author: Isabella Cadavid Posada
    Contributor: Alejandro
    Date: 07/09/2026
    Description: Administrator dashboard view using the admin layout.
--}}

@extends('layouts.admin')

@section('content')
    <section class="dash-hero dash-hero-admin">
        <div class="road-line" aria-hidden="true"></div>

        <div class="container dash-hero-inner">
            <span class="dash-label dash-label-admin">
                {{ __('admin.administration_area') }}
            </span>

            <h1>
                {{ $viewData['title'] }}
            </h1>

            <p class="dash-hero-text">
                {{ __('admin.admin_message') }}
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
                {{ __('admin.management_panel') }}
            </h2>

            <div class="admin-grid">
                <div
                    id="admin-vehicles"
                    class="admin-card"
                >
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
                        {{ __('admin.vehicles') }}
                    </h3>

                    <p>
                        {{ __('admin.vehicles_description') }}
                    </p>

                    <span class="admin-soon">
                        {{ __('admin.coming_soon') }}
                    </span>
                </div>

                <div
                    id="admin-reservations"
                    class="admin-card"
                >
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
                        {{ __('admin.reservations') }}
                    </h3>

                    <p>
                        {{ __('admin.reservations_description') }}
                    </p>

                    <span class="admin-soon">
                        {{ __('admin.coming_soon') }}
                    </span>
                </div>

                <div
                    id="admin-locations"
                    class="admin-card"
                >
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
                        {{ __('admin.locations') }}
                    </h3>

                    <p>
                        {{ __('admin.locations_description') }}
                    </p>

                    <span class="admin-soon">
                        {{ __('admin.coming_soon') }}
                    </span>
                </div>

                <div
                    id="admin-metrics"
                    class="admin-card"
                >
                    <h3>
                        {{ __('admin.metrics') }}
                    </h3>

                    <p>
                        {{ __('admin.metrics_description') }}
                    </p>

                    <span class="admin-soon">
                        {{ __('admin.coming_soon') }}
                    </span>
                </div>
            </div>
        </div>
    </section>
@endsection