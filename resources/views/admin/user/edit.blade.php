{{--
    Author: Isabella Cadavid Posada
    Author: Alejandro Correa Marin
    Date: 2026-11-05
    Description: Admin form for editing an existing user account.
--}}

@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<section class="admin-page">
    <div class="admin-page-shape admin-page-shape-left" aria-hidden="true"></div>
    <div class="admin-page-shape admin-page-shape-right" aria-hidden="true"></div>

    <div class="container admin-container">
        <header class="admin-header">
            <div>
                <span class="admin-eyebrow">
                    {{ __('car.admin_area') }}
                </span>
                <h1 class="admin-title">
                    {{ $viewData['title'] }}
                </h1>
                <p class="admin-subtitle">
                    {{ $viewData['user']->getName() }} {{ $viewData['user']->getLastName() }}
                </p>
            </div>

            <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                &larr; {{ __('general.btn_back') }}
            </a>
        </header>

        @if ($errors->any())
            <div class="alert alert-danger admin-alert" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="admin-form-card">
            <form
                method="POST"
                action="{{ route('admin.user.update', ['id' => $viewData['user']->getId()]) }}"
            >
                @csrf
                @method('PUT')

                <div class="admin-form-grid">
                    <div>
                        <label class="form-label" for="name">
                            {{ __('authentication.first_name') }}
                            <span class="admin-form-required">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            id="name"
                            name="name"
                            value="{{ old('name', $viewData['user']->getName()) }}"
                            required
                            @error('name') aria-invalid="true" aria-describedby="name-error" @enderror
                        >
                        @error('name')
                            <div id="name-error" class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label class="form-label" for="last_name">
                            {{ __('authentication.last_name') }}
                            <span class="admin-form-required">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control @error('last_name') is-invalid @enderror"
                            id="last_name"
                            name="last_name"
                            value="{{ old('last_name', $viewData['user']->getLastName()) }}"
                            required
                            @error('last_name') aria-invalid="true" aria-describedby="last_name-error" @enderror
                        >
                        @error('last_name')
                            <div id="last_name-error" class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label class="form-label" for="email">
                            {{ __('authentication.email') }}
                            <span class="admin-form-required">*</span>
                        </label>
                        <input
                            type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            id="email"
                            name="email"
                            value="{{ old('email', $viewData['user']->getEmail()) }}"
                            required
                            @error('email') aria-invalid="true" aria-describedby="email-error" @enderror
                        >
                        @error('email')
                            <div id="email-error" class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label class="form-label" for="role">
                            {{ __('user.role') }}
                            <span class="admin-form-required">*</span>
                        </label>
                        <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required @error('role') aria-invalid="true" aria-describedby="role-error" @enderror>
                            @foreach ($viewData['roleOptions'] as $role => $roleLabel)
                                <option value="{{ $role }}" @selected(old('role', $viewData['user']->getRole()) === $role)>
                                    {{ $roleLabel }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <div id="role-error" class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label class="form-label" for="birth_date">
                            {{ __('authentication.birth_date') }}
                            <span class="admin-form-required">*</span>
                        </label>
                        <input
                            type="date"
                            class="form-control @error('birth_date') is-invalid @enderror"
                            id="birth_date"
                            name="birth_date"
                            value="{{ old('birth_date', $viewData['user']->getBirthDate()?->format('Y-m-d')) }}"
                            required
                            @error('birth_date') aria-invalid="true" aria-describedby="birth_date-error" @enderror
                        >
                        @error('birth_date')
                            <div id="birth_date-error" class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label class="form-label" for="address">
                            {{ __('authentication.address') }}
                            <span class="admin-form-required">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control @error('address') is-invalid @enderror"
                            id="address"
                            name="address"
                            value="{{ old('address', $viewData['user']->getAddress()) }}"
                            required
                            @error('address') aria-invalid="true" aria-describedby="address-error" @enderror
                        >
                        @error('address')
                            <div id="address-error" class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label class="form-label" for="license_number">
                            {{ __('authentication.driver_license_number') }}
                            <span class="admin-form-required">*</span>
                        </label>
                        <input
                            type="number"
                            class="form-control @error('license_number') is-invalid @enderror"
                            id="license_number"
                            name="license_number"
                            value="{{ old('license_number', $viewData['user']->getLicenseNumber()) }}"
                            required
                            @error('license_number') aria-invalid="true" aria-describedby="license_number-error" @enderror
                        >
                        @error('license_number')
                            <div id="license_number-error" class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label class="form-label" for="identification_number">
                            {{ __('authentication.identification_number') }}
                            <span class="admin-form-required">*</span>
                        </label>
                        <input
                            type="number"
                            class="form-control @error('identification_number') is-invalid @enderror"
                            id="identification_number"
                            name="identification_number"
                            value="{{ old('identification_number', $viewData['user']->getIdentificationNumber()) }}"
                            required
                            @error('identification_number') aria-invalid="true" aria-describedby="identification_number-error" @enderror
                        >
                        @error('identification_number')
                            <div id="identification_number-error" class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label class="form-label" for="emergency_contact_name">
                            {{ __('authentication.emergency_contact_first_name') }}
                            <span class="admin-form-required">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control @error('emergency_contact_name') is-invalid @enderror"
                            id="emergency_contact_name"
                            name="emergency_contact_name"
                            value="{{ old('emergency_contact_name', $viewData['user']->getEmergencyContactName()) }}"
                            required
                            @error('emergency_contact_name') aria-invalid="true" aria-describedby="emergency_contact_name-error" @enderror
                        >
                        @error('emergency_contact_name')
                            <div id="emergency_contact_name-error" class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label class="form-label" for="emergency_contact_last_name">
                            {{ __('authentication.emergency_contact_last_name') }}
                            <span class="admin-form-required">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control @error('emergency_contact_last_name') is-invalid @enderror"
                            id="emergency_contact_last_name"
                            name="emergency_contact_last_name"
                            value="{{ old('emergency_contact_last_name', $viewData['user']->getEmergencyContactLastName()) }}"
                            required
                            @error('emergency_contact_last_name') aria-invalid="true" aria-describedby="emergency_contact_last_name-error" @enderror
                        >
                        @error('emergency_contact_last_name')
                            <div id="emergency_contact_last_name-error" class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label class="form-label" for="emergency_contact">
                            {{ __('authentication.emergency_contact_phone') }}
                            <span class="admin-form-required">*</span>
                        </label>
                        <input
                            type="number"
                            class="form-control @error('emergency_contact') is-invalid @enderror"
                            id="emergency_contact"
                            name="emergency_contact"
                            value="{{ old('emergency_contact', $viewData['user']->getEmergencyContact()) }}"
                            required
                            @error('emergency_contact') aria-invalid="true" aria-describedby="emergency_contact-error" @enderror
                        >
                        @error('emergency_contact')
                            <div id="emergency_contact-error" class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label class="form-label" for="eps">
                            {{ __('authentication.health_provider') }}
                            <span class="admin-form-required">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control @error('eps') is-invalid @enderror"
                            id="eps"
                            name="eps"
                            value="{{ old('eps', $viewData['user']->getEps()) }}"
                            required
                            @error('eps') aria-invalid="true" aria-describedby="eps-error" @enderror
                        >
                        @error('eps')
                            <div id="eps-error" class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label class="form-label" for="password">
                            {{ __('user.password') }}
                        </label>
                        <input
                            type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            id="password"
                            name="password"
                            @error('password') aria-invalid="true" aria-describedby="password-error" @enderror
                        >
                        @error('password')
                            <div id="password-error" class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                        <small class="text-muted">{{ __('user.password_help') }}</small>
                    </div>

                    <div>
                        <label class="form-label" for="password_confirmation">
                            {{ __('user.password_confirmation') }}
                        </label>
                        <input
                            type="password"
                            class="form-control @error('password_confirmation') is-invalid @enderror"
                            id="password_confirmation"
                            name="password_confirmation"
                            @error('password_confirmation') aria-invalid="true" aria-describedby="password_confirmation-error" @enderror
                        >
                        @error('password_confirmation')
                            <div id="password_confirmation-error" class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-dark rounded-pill fw-semibold px-4">
                        {{ __('user.btn_save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
