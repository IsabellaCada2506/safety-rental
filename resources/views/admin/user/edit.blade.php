{{--
    Author: Alejandro Correa Marin
    Date: 2026-09-12
    Description: Admin form for editing an existing user account.
--}}

@extends('layouts.app')

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
                &larr; {{ __('user.btn_back') }}
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
                            class="form-control"
                            id="name"
                            name="name"
                            value="{{ old('name', $viewData['user']->getName()) }}"
                            required
                        >
                    </div>

                    <div>
                        <label class="form-label" for="last_name">
                            {{ __('authentication.last_name') }}
                            <span class="admin-form-required">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            id="last_name"
                            name="last_name"
                            value="{{ old('last_name', $viewData['user']->getLastName()) }}"
                            required
                        >
                    </div>

                    <div>
                        <label class="form-label" for="email">
                            {{ __('authentication.email') }}
                            <span class="admin-form-required">*</span>
                        </label>
                        <input
                            type="email"
                            class="form-control"
                            id="email"
                            name="email"
                            value="{{ old('email', $viewData['user']->getEmail()) }}"
                            required
                        >
                    </div>

                    <div>
                        <label class="form-label" for="role">
                            {{ __('user.role') }}
                            <span class="admin-form-required">*</span>
                        </label>
                        <select class="form-select" id="role" name="role" required>
                            @foreach ($viewData['roleOptions'] as $role => $roleLabel)
                                <option value="{{ $role }}" @selected(old('role', $viewData['user']->getRole()) === $role)>
                                    {{ $roleLabel }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="form-label" for="birth_date">
                            {{ __('authentication.birth_date') }}
                            <span class="admin-form-required">*</span>
                        </label>
                        <input
                            type="date"
                            class="form-control"
                            id="birth_date"
                            name="birth_date"
                            value="{{ old('birth_date', $viewData['user']->getBirthDate()?->format('Y-m-d')) }}"
                            required
                        >
                    </div>

                    <div>
                        <label class="form-label" for="address">
                            {{ __('authentication.address') }}
                            <span class="admin-form-required">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            id="address"
                            name="address"
                            value="{{ old('address', $viewData['user']->getAddress()) }}"
                            required
                        >
                    </div>

                    <div>
                        <label class="form-label" for="license_number">
                            {{ __('authentication.driver_license_number') }}
                            <span class="admin-form-required">*</span>
                        </label>
                        <input
                            type="number"
                            class="form-control"
                            id="license_number"
                            name="license_number"
                            value="{{ old('license_number', $viewData['user']->getLicenseNumber()) }}"
                            required
                        >
                    </div>

                    <div>
                        <label class="form-label" for="identification_number">
                            {{ __('authentication.identification_number') }}
                            <span class="admin-form-required">*</span>
                        </label>
                        <input
                            type="number"
                            class="form-control"
                            id="identification_number"
                            name="identification_number"
                            value="{{ old('identification_number', $viewData['user']->getIdentificationNumber()) }}"
                            required
                        >
                    </div>

                    <div>
                        <label class="form-label" for="emergency_contact_name">
                            {{ __('authentication.emergency_contact_first_name') }}
                            <span class="admin-form-required">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            id="emergency_contact_name"
                            name="emergency_contact_name"
                            value="{{ old('emergency_contact_name', $viewData['user']->getEmergencyContactName()) }}"
                            required
                        >
                    </div>

                    <div>
                        <label class="form-label" for="emergency_contact_last_name">
                            {{ __('authentication.emergency_contact_last_name') }}
                            <span class="admin-form-required">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            id="emergency_contact_last_name"
                            name="emergency_contact_last_name"
                            value="{{ old('emergency_contact_last_name', $viewData['user']->getEmergencyContactLastName()) }}"
                            required
                        >
                    </div>

                    <div>
                        <label class="form-label" for="emergency_contact">
                            {{ __('authentication.emergency_contact_phone') }}
                            <span class="admin-form-required">*</span>
                        </label>
                        <input
                            type="number"
                            class="form-control"
                            id="emergency_contact"
                            name="emergency_contact"
                            value="{{ old('emergency_contact', $viewData['user']->getEmergencyContact()) }}"
                            required
                        >
                    </div>

                    <div>
                        <label class="form-label" for="eps">
                            {{ __('authentication.health_provider') }}
                            <span class="admin-form-required">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            id="eps"
                            name="eps"
                            value="{{ old('eps', $viewData['user']->getEps()) }}"
                            required
                        >
                    </div>

                    <div>
                        <label class="form-label" for="password">
                            {{ __('user.password') }}
                        </label>
                        <input
                            type="password"
                            class="form-control"
                            id="password"
                            name="password"
                        >
                        <small class="text-muted">{{ __('user.password_help') }}</small>
                    </div>

                    <div>
                        <label class="form-label" for="password_confirmation">
                            {{ __('user.password_confirmation') }}
                        </label>
                        <input
                            type="password"
                            class="form-control"
                            id="password_confirmation"
                            name="password_confirmation"
                        >
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
