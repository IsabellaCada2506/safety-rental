{{--
    Author: Isabella Cadavid Posada
    Date: 2026-09-11
    Description: Login form view for existing users.
--}}

@extends('layouts.app')

@section('content')
    <section class="ignition-page">
        <div class="ignition-grid">
            <div class="ignition-hero">
                <div class="ignition-hero-content">
                    <span class="logo-badge" aria-hidden="true">
                        <svg
                            viewBox="0 0 32 36"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M16 2L29 7V17C29 25 23.5 31 16 34C8.5 31 3 25 3 17V7Z"
                                fill="currentColor"
                            />

                            <path
                                d="M9 20L11.5 14.5C12 13.4 13 12.7 14.2 12.7H17.8C19 12.7 20 13.4 20.5 14.5L23 20"
                                stroke="var(--sr-gold)"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />

                            <path
                                d="M8 20H24V23C24 23.6 23.6 24 23 24H21.5C20.9 24 20.5 23.6 20.5 23V22H11.5V23C11.5 23.6 11.1 24 10.5 24H9C8.4 24 8 23.6 8 23V20Z"
                                stroke="var(--sr-gold)"
                                stroke-width="1.8"
                                stroke-linejoin="round"
                            />
                        </svg>
                    </span>

                    <h2 class="ignition-hero-title">
                        {{ __('authentication.road_waiting') }}
                    </h2>

                    <p class="ignition-hero-subtitle">
                        {{ __('authentication.road_waiting_description') }}
                    </p>
                </div>
            </div>

            <div class="ignition-panel">
                <div class="ignition-form-wrap">
                    <span class="ignition-key" aria-hidden="true">
                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <circle
                                cx="8"
                                cy="12"
                                r="4.5"
                                stroke="currentColor"
                                stroke-width="1.8"
                            />

                            <path
                                d="M12 12H21M17 12V15M20 12V14"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                            />
                        </svg>
                    </span>

                    <h1>
                        {{ __('authentication.welcome_back') }}
                    </h1>

                    <p class="authentication-description">
                        {{ __('authentication.login_description') }}
                    </p>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form
                        method="POST"
                        action="{{ route('auth.login.authenticate') }}"
                    >
                        @csrf

                        <div class="mb-4">
                            <label class="form-label" for="email">
                                {{ __('authentication.email') }}
                            </label>

                            <input
                                id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                autocomplete="email"
                                required
                                autofocus
                            >

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="password">
                                {{ __('authentication.password') }}
                            </label>

                            <input
                                id="password"
                                class="form-control @error('password') is-invalid @enderror"
                                name="password"
                                type="password"
                                autocomplete="current-password"
                                required
                            >

                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="login-options mb-4">
                            <div class="form-check">
                                <input
                                    id="remember"
                                    class="form-check-input"
                                    name="remember"
                                    type="checkbox"
                                    value="1"
                                    {{ old('remember') ? 'checked' : '' }}
                                >

                                <label
                                    class="form-check-label"
                                    for="remember"
                                >
                                    {{ __('authentication.remember_me') }}
                                </label>
                            </div>

                            <a
                                class="authentication-link"
                                href="{{ route('password.request') }}"
                            >
                                {{ __('authentication.forgot_password_question') }}
                            </a>
                        </div>

                        <button
                            class="btn authentication-button w-100"
                            type="submit"
                        >
                            {{ __('authentication.login') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection