{{--
    Author: Isabella Ocampo
    Date: 2026-09-11
    Description: Admin view for editing an existing physical rental location.
--}}

@extends('layouts.app')

@section('content')
<section class="admin-page">
    <div
        class="admin-page-shape admin-page-shape-left"
        aria-hidden="true"
    ></div>

    <div
        class="admin-page-shape admin-page-shape-right"
        aria-hidden="true"
    ></div>

    <div class="container admin-container">
        <header class="admin-header">
            <div>
                <span class="admin-eyebrow">
                    {{ __('location.admin_area') }}
                </span>

                <h1 class="admin-title">
                    {{ __('location.heading_management') }}
                </h1>

                <p class="admin-subtitle">
                    {{ __('location.admin_title_edit') }}
                </p>
            </div>
        </header>

        @if ($errors->any())
            <div
                class="alert alert-danger admin-alert"
                role="alert"
            >
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
                action="{{ route('admin.location.update', ['id' => $viewData['location']->getId()]) }}"
            >
                @csrf
                @method('PUT')

                <div class="admin-form-grid">
                    <div>
                        <label
                            class="form-label"
                            for="location-name"
                        >
                            {{ __('location.name_label') }}
                            <span class="admin-form-required">*</span>
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="location-name"
                            name="name"
                            value="{{ old('name', $viewData['location']->getName()) }}"
                            placeholder="{{ __('location.name_placeholder') }}"
                            required
                        >
                    </div>

                    <div>
                        <label
                            class="form-label"
                            for="location-city"
                        >
                            {{ __('location.city_label') }}
                            <span class="admin-form-required">*</span>
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="location-city"
                            name="city"
                            value="{{ old('city', $viewData['location']->getCity()) }}"
                            placeholder="{{ __('location.city_placeholder') }}"
                            required
                        >
                    </div>

                    <div class="admin-form-field-full">
                        <label
                            class="form-label"
                            for="location-address"
                        >
                            {{ __('location.address_label') }}
                            <span class="admin-form-required">*</span>
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="location-address"
                            name="address"
                            value="{{ old('address', $viewData['location']->getAddress()) }}"
                            placeholder="{{ __('location.address_placeholder') }}"
                            required
                        >
                    </div>

                    <div>
                        <label
                            class="form-label"
                            for="location-headquarters"
                        >
                            {{ __('location.headquarters_label') }}
                            <span class="admin-form-required">*</span>
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="location-headquarters"
                            name="headquarters"
                            value="{{ old('headquarters', $viewData['location']->getHeadquarters()) }}"
                            placeholder="{{ __('location.headquarters_placeholder') }}"
                            required
                        >
                    </div>

                    <div>
                        <label
                            class="form-label"
                            for="location-telephone"
                        >
                            {{ __('location.telephone_label') }}
                            <span class="admin-form-required">*</span>
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="location-telephone"
                            name="telephone"
                            value="{{ old('telephone', $viewData['location']->getTelephone()) }}"
                            placeholder="{{ __('location.telephone_placeholder') }}"
                            required
                        >
                    </div>
                </div>

                <div class="admin-form-actions">
                    <a
                        href="{{ route('admin.location.index') }}"
                        class="admin-form-cancel-btn"
                    >
                        {{ __('location.btn_cancel') }}
                    </a>

                    <button
                        type="submit"
                        class="admin-form-save-btn"
                    >
                        {{ __('location.btn_update') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
