{{--
    Author: Isabella Cadavid Posada
    Date: 2026-09-06
    Description: Customer profile view displaying personal, driving, and emergency contact information.
--}}

@extends('layouts.app')

@section('content')
    <section class="profile-page">
        <div
            class="profile-background-shape profile-background-shape-left"
            aria-hidden="true"
        ></div>

        <div
            class="profile-background-shape profile-background-shape-right"
            aria-hidden="true"
        ></div>

        <div class="container profile-container">
            <header class="profile-topbar">
                <div>
                    <span class="profile-eyebrow">
                        {{ __('authentication.customer_area') }}
                    </span>

                    <h1>
                        {{ $viewData['title'] }}
                    </h1>

                    <p>
                        {{ __('authentication.profile_description') }}
                    </p>
                </div>

                <a
                    class="profile-edit-button"
                    href="{{ route('profile.edit') }}"
                >
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        aria-hidden="true"
                    >
                        <path
                            d="M13.5 6.5L17.5 10.5M4 20L8.2 19.2L19 8.4C20.1 7.3 20.1 5.5 19 4.4C17.9 3.3 16.1 3.3 15 4.4L4.2 15.2L4 20Z"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>

                    {{ __('authentication.edit_profile') }}
                </a>
            </header>

            @if (session('status'))
                <div
                    class="alert alert-success profile-alert"
                    role="alert"
                >
                    {{ session('status') }}
                </div>
            @endif

            <div class="profile-layout">
                <aside class="profile-summary-card">
                    <div class="profile-avatar">
                        {{ strtoupper(substr($viewData['user']->getName(), 0, 1)) }}
                        {{ strtoupper(substr($viewData['user']->getLastName() ?? '', 0, 1)) }}
                    </div>

                    <h2>
                        {{ $viewData['user']->getName() }}
                        {{ $viewData['user']->getLastName() }}
                    </h2>

                    <p class="profile-email">
                        {{ $viewData['user']->getEmail() }}
                    </p>

                    <span class="profile-status">
                        <span aria-hidden="true"></span>

                        {{ __('authentication.active_account') }}
                    </span>

                    <div class="profile-summary-divider"></div>

                    <div class="profile-summary-detail">
                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            aria-hidden="true"
                        >
                            <rect
                                x="3"
                                y="5"
                                width="18"
                                height="16"
                                rx="2"
                                stroke="currentColor"
                                stroke-width="1.8"
                            />

                            <path
                                d="M3 10H21M8 3V7M16 3V7"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                            />
                        </svg>

                        <div>
                            <span>
                                {{ __('authentication.member_since') }}
                            </span>

                            <strong>
                                {{ $viewData['user']->getCreatedAt()?->format('F Y') }}
                            </strong>
                        </div>
                    </div>

                    <div class="profile-security-note">
                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            aria-hidden="true"
                        >
                            <rect
                                x="5"
                                y="10"
                                width="14"
                                height="11"
                                rx="2"
                                stroke="currentColor"
                                stroke-width="1.8"
                            />

                            <path
                                d="M8 10V7C8 4.8 9.8 3 12 3C14.2 3 16 4.8 16 7V10"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                            />
                        </svg>

                        <div>
                            <strong>
                                {{ __('authentication.account_protected') }}
                            </strong>

                            <span>
                                {{ __('authentication.account_protected_description') }}
                            </span>
                        </div>
                    </div>
                </aside>

                <div class="profile-sections">
                    <article class="profile-information-card">
                        <div class="profile-section-heading">
                            <span class="profile-section-icon">
                                <svg
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    aria-hidden="true"
                                >
                                    <circle
                                        cx="12"
                                        cy="8"
                                        r="4"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    />

                                    <path
                                        d="M4 21C4 16.6 7.6 13 12 13C16.4 13 20 16.6 20 21"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        stroke-linecap="round"
                                    />
                                </svg>
                            </span>

                            <div>
                                <h2>
                                    {{ __('authentication.personal_information') }}
                                </h2>

                                <p>
                                    {{ __('authentication.personal_information_description') }}
                                </p>
                            </div>
                        </div>

                        <dl class="profile-data-grid">
                            <div>
                                <dt>
                                    {{ __('authentication.first_name') }}
                                </dt>

                                <dd>
                                    {{ $viewData['user']->getName() }}
                                </dd>
                            </div>

                            <div>
                                <dt>
                                    {{ __('authentication.last_name') }}
                                </dt>

                                <dd>
                                    {{ $viewData['user']->getLastName() }}
                                </dd>
                            </div>

                            <div>
                                <dt>
                                    {{ __('authentication.birth_date') }}
                                </dt>

                                <dd>
                                    {{ $viewData['user']->getBirthDate()?->format('Y-m-d') }}
                                </dd>
                            </div>

                            <div>
                                <dt>
                                    {{ __('authentication.identification_number') }}
                                </dt>

                                <dd>
                                    {{ $viewData['user']->getIdentificationNumber() }}
                                </dd>
                            </div>

                            <div class="profile-data-full">
                                <dt>
                                    {{ __('authentication.email') }}
                                </dt>

                                <dd>
                                    {{ $viewData['user']->getEmail() }}
                                </dd>
                            </div>

                            <div class="profile-data-full">
                                <dt>
                                    {{ __('authentication.address') }}
                                </dt>

                                <dd>
                                    {{ $viewData['user']->getAddress() }}
                                </dd>
                            </div>
                        </dl>
                    </article>

                    <div class="profile-lower-grid">
                        <article class="profile-information-card">
                            <div class="profile-section-heading">
                                <span
                                    class="profile-section-icon profile-section-icon-orange"
                                >
                                    <svg
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        aria-hidden="true"
                                    >
                                        <path
                                            d="M3 16L5.5 9.5C6 8.3 7 7.5 8.3 7.5H15.7C17 7.5 18 8.3 18.5 9.5L21 16"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            stroke-linecap="round"
                                        />

                                        <path
                                            d="M3 16H21V19H18V17.5H6V19H3V16Z"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            stroke-linejoin="round"
                                        />
                                    </svg>
                                </span>

                                <div>
                                    <h2>
                                        {{ __('authentication.driving_information') }}
                                    </h2>

                                    <p>
                                        {{ __('authentication.driving_information_description') }}
                                    </p>
                                </div>
                            </div>

                            <dl class="profile-data-list">
                                <div>
                                    <dt>
                                        {{ __('authentication.driver_license_number') }}
                                    </dt>

                                    <dd>
                                        {{ $viewData['user']->getLicenseNumber() }}
                                    </dd>
                                </div>

                                <div>
                                    <dt>
                                        {{ __('authentication.health_provider') }}
                                    </dt>

                                    <dd>
                                        {{ $viewData['user']->getEps() }}
                                    </dd>
                                </div>
                            </dl>
                        </article>

                        <article class="profile-information-card">
                            <div class="profile-section-heading">
                                <span
                                    class="profile-section-icon profile-section-icon-gold"
                                >
                                    <svg
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        aria-hidden="true"
                                    >
                                        <path
                                            d="M7 3H10L11.5 7L9 8.5C10.3 11.2 12.8 13.7 15.5 15L17 12.5L21 14V17C21 19.2 19.2 21 17 21C9.3 21 3 14.7 3 7C3 4.8 4.8 3 7 3Z"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        />
                                    </svg>
                                </span>

                                <div>
                                    <h2>
                                        {{ __('authentication.emergency_information') }}
                                    </h2>

                                    <p>
                                        {{ __('authentication.emergency_information_description') }}
                                    </p>
                                </div>
                            </div>

                            <dl class="profile-data-list">
                                <div>
                                    <dt>
                                        {{ __('authentication.emergency_contact_first_name') }}
                                    </dt>

                                    <dd>
                                        {{ $viewData['user']->getEmergencyContactName() }}
                                    </dd>
                                </div>

                                <div>
                                    <dt>
                                        {{ __('authentication.emergency_contact_last_name') }}
                                    </dt>

                                    <dd>
                                        {{ $viewData['user']->getEmergencyContactLastName() }}
                                    </dd>
                                </div>

                                <div>
                                    <dt>
                                        {{ __('authentication.emergency_contact_phone') }}
                                    </dt>

                                    <dd>
                                        {{ $viewData['user']->getEmergencyContact() }}
                                    </dd>
                                </div>
                            </dl>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection