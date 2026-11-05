{{--
    Author: Isabella Cadavid Posada
    Author: Alejandro Correa Marin
    Date: 2026-11-04
    Description: Administrator dashboard with management shortcuts and no vehicle carousel.
--}}

@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
    <section class="dash-hero dash-hero-admin">
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
                <article class="admin-card">
                    <h3>
                        {{ __('authentication.vehicles') }}
                    </h3>

                    <p>
                        {{ __('authentication.vehicles_description') }}
                    </p>

                    <div class="d-flex flex-wrap gap-2">
                        <a
                            href="{{ route('admin.car.index') }}"
                            class="btn btn-primary"
                        >
                            {{ __('car.heading_management') }}
                        </a>

                        <a
                            href="{{ route('admin.ranking.index') }}"
                            class="btn btn-outline-primary"
                        >
                            {{ __('ranking.manage_ranking') }}
                        </a>
                    </div>
                </article>

                <article class="admin-card">
                    <h3>
                        {{ __('authentication.reservations') }}
                    </h3>

                    <p>
                        {{ __('authentication.reservations_description') }}
                    </p>

                    <div class="d-flex flex-wrap gap-2">
                        <a
                            href="{{ route('admin.reservation.index') }}"
                            class="btn btn-primary"
                        >
                            {{ __('reservation.admin_title_index') }}
                        </a>

                        <a
                            href="{{ route('admin.metrics.index') }}"
                            class="btn btn-outline-primary"
                        >
                            {{ __('metrics.manage_metrics') }}
                        </a>
                    </div>
                </article>

                <article class="admin-card">
                    <h3>
                        {{ __('location.heading_management') }}
                    </h3>

                    <p>
                        {{ __('location.registered_locations') }}
                    </p>

                    <a
                        href="{{ route('admin.location.index') }}"
                        class="btn btn-primary"
                    >
                        {{ __('location.manage_locations') }}
                    </a>
                </article>

                <article class="admin-card">
                    <h3>
                        {{ __('authentication.users') }}
                    </h3>

                    <p>
                        {{ __('authentication.users_description') }}
                    </p>

                    <a
                        href="{{ route('admin.user.index') }}"
                        class="btn btn-primary"
                    >
                        {{ __('user.manage_users') }}
                    </a>
                </article>
            </div>
        </div>
    </section>
@endsection