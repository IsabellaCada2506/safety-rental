{{--
    Author: Isabella Cadavid Posada
    Date: 2026-09-06
    Description: Registration form view for new users.
--}}

@extends('layouts.app')

@section('content')
    <section class="simple-page">
        <div class="road-line" aria-hidden="true"></div>

        <div class="simple-card registration-card">
            <div class="card-header">
                {{ __('authentication.create_account') }}
            </div>

            <div class="card-body">
                <form
                    method="POST"
                    action="{{ route('auth.register.store') }}"
                >
                    @csrf

                    <div class="registration-grid">
                        <div>
                            <label class="form-label" for="name">
                                {{ __('authentication.first_name') }}
                            </label>

                            <input
                                id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                name="name"
                                type="text"
                                value="{{ old('name') }}"
                                autocomplete="given-name"
                                required
                                autofocus
                            >

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label" for="last_name">
                                {{ __('authentication.last_name') }}
                            </label>

                            <input
                                id="last_name"
                                class="form-control @error('last_name') is-invalid @enderror"
                                name="last_name"
                                type="text"
                                value="{{ old('last_name') }}"
                                autocomplete="family-name"
                                required
                            >

                            @error('last_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label" for="birth_date">
                                {{ __('authentication.birth_date') }}
                            </label>

                            <input
                                id="birth_date"
                                class="form-control @error('birth_date') is-invalid @enderror"
                                name="birth_date"
                                type="date"
                                value="{{ old('birth_date') }}"
                                required
                            >

                            @error('birth_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label" for="identification_number">
                                {{ __('authentication.identification_number') }}
                            </label>

                            <input
                                id="identification_number"
                                class="form-control @error('identification_number') is-invalid @enderror"
                                name="identification_number"
                                type="number"
                                value="{{ old('identification_number') }}"
                                required
                            >

                            @error('identification_number')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label" for="license_number">
                                {{ __('authentication.driver_license_number') }}
                            </label>

                            <input
                                id="license_number"
                                class="form-control @error('license_number') is-invalid @enderror"
                                name="license_number"
                                type="number"
                                value="{{ old('license_number') }}"
                                required
                            >

                            @error('license_number')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label" for="eps">
                                {{ __('authentication.health_provider') }}
                            </label>

                            <input
                                id="eps"
                                class="form-control @error('eps') is-invalid @enderror"
                                name="eps"
                                type="text"
                                value="{{ old('eps') }}"
                                required
                            >

                            @error('eps')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="registration-full-width">
                            <label class="form-label" for="address">
                                {{ __('authentication.address') }}
                            </label>

                            <input
                                id="address"
                                class="form-control @error('address') is-invalid @enderror"
                                name="address"
                                type="text"
                                value="{{ old('address') }}"
                                autocomplete="street-address"
                                required
                            >

                            @error('address')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label" for="emergency_contact_name">
                                {{ __('authentication.emergency_contact_first_name') }}
                            </label>

                            <input
                                id="emergency_contact_name"
                                class="form-control @error('emergency_contact_name') is-invalid @enderror"
                                name="emergency_contact_name"
                                type="text"
                                value="{{ old('emergency_contact_name') }}"
                                required
                            >

                            @error('emergency_contact_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label" for="emergency_contact_last_name">
                                {{ __('authentication.emergency_contact_last_name') }}
                            </label>

                            <input
                                id="emergency_contact_last_name"
                                class="form-control @error('emergency_contact_last_name') is-invalid @enderror"
                                name="emergency_contact_last_name"
                                type="text"
                                value="{{ old('emergency_contact_last_name') }}"
                                required
                            >

                            @error('emergency_contact_last_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="registration-full-width">
                            <label class="form-label" for="emergency_contact">
                                {{ __('authentication.emergency_contact_phone') }}
                            </label>

                            <input
                                id="emergency_contact"
                                class="form-control @error('emergency_contact') is-invalid @enderror"
                                name="emergency_contact"
                                type="number"
                                value="{{ old('emergency_contact') }}"
                                autocomplete="tel"
                                required
                            >

                            @error('emergency_contact')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="registration-full-width">
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
                            >

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label" for="password">
                                {{ __('authentication.password') }}
                            </label>

                            <input
                                id="password"
                                class="form-control @error('password') is-invalid @enderror"
                                name="password"
                                type="password"
                                autocomplete="new-password"
                                required
                            >

                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label" for="password_confirmation">
                                {{ __('authentication.confirm_password') }}
                            </label>

                            <input
                                id="password_confirmation"
                                class="form-control"
                                name="password_confirmation"
                                type="password"
                                autocomplete="new-password"
                                required
                            >
                        </div>
                    </div>

                    <button
                        class="btn authentication-button w-100 mt-4"
                        type="submit"
                    >
                        {{ __('authentication.create_account') }}
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection