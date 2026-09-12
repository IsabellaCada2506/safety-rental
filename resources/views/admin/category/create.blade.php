{{--
    Author: Wendy Atehortua
    Date: 2026-09-10
    Description: Admin view for creating a new vehicle category.
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
                    {{ __('category.admin_area') }}
                </span>

                <h1 class="admin-title">
                    {{ __('category.heading_management') }}
                </h1>

                <p class="admin-subtitle">
                    {{ __('category.register_new_category') }}
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
                action="{{ route('admin.category.store') }}"
            >
                @csrf

                <div class="admin-form-grid">
                    <div>
                        <label
                            class="form-label"
                            for="category-model"
                        >
                            {{ __('category.model_label') }}
                            <span class="admin-form-required">*</span>
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="category-model"
                            name="model"
                            value="{{ old('model') }}"
                            placeholder="{{ __('category.model_placeholder') }}"
                            required
                        >
                    </div>

                    <div>
                        <label
                            class="form-label"
                            for="category-brand"
                        >
                            {{ __('category.brand_label') }}
                            <span class="admin-form-required">*</span>
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="category-brand"
                            name="brand"
                            value="{{ old('brand') }}"
                            placeholder="{{ __('category.brand_placeholder') }}"
                            required
                        >
                    </div>

                    <div class="admin-form-field-full">
                        <label
                            class="form-label"
                            for="category-type"
                        >
                            {{ __('category.type_label') }}
                            <span class="admin-form-required">*</span>
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="category-type"
                            name="type"
                            value="{{ old('type') }}"
                            placeholder="{{ __('category.type_placeholder') }}"
                            required
                        >
                    </div>

                    <div>
                        <label
                            class="form-label"
                            for="category-passenger-capacity"
                        >
                            {{ __('category.passenger_capacity_label') }}
                            <span class="admin-form-required">*</span>
                        </label>

                        <input
                            type="number"
                            class="form-control"
                            id="category-passenger-capacity"
                            name="passenger_capacity"
                            value="{{ old('passenger_capacity') }}"
                            placeholder="{{ __('category.passenger_capacity_placeholder') }}"
                            min="1"
                            required
                        >
                    </div>

                    <div>
                        <label
                            class="form-label"
                            for="category-luggage-capacity"
                        >
                            {{ __('category.luggage_capacity_label') }}
                            <span class="admin-form-required">*</span>
                        </label>

                        <input
                            type="number"
                            class="form-control"
                            id="category-luggage-capacity"
                            name="luggage_capacity"
                            value="{{ old('luggage_capacity') }}"
                            placeholder="{{ __('category.luggage_capacity_placeholder') }}"
                            min="0"
                            required
                        >
                    </div>
                </div>

                <div class="admin-form-actions">
                    <a
                        href="{{ route('admin.category.index') }}"
                        class="admin-form-cancel-btn"
                    >
                        {{ __('category.btn_cancel') }}
                    </a>

                    <button
                        type="submit"
                        class="admin-form-save-btn"
                    >
                        {{ __('category.btn_save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
