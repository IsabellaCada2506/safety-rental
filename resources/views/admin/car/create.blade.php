{{--
    Author: Wendy Atehortua
    Date: 2026-09-10
    Description: Admin view for creating a new car in the inventory.
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
                    {{ __('car.admin_area') }}
                </span>

                <h1 class="admin-title">
                    {{ __('car.heading_management') }}
                </h1>

                <p class="admin-subtitle">
                    {{ __('car.register_new_car') }}
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
                action="{{ route('admin.car.store') }}"
            >
                @csrf

                <div class="admin-form-grid">
                    <div>
                        <label
                            class="form-label"
                            for="car-plate"
                        >
                            {{ __('car.plate_label') }}
                            <span class="admin-form-required">*</span>
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="car-plate"
                            name="plate"
                            value="{{ old('plate') }}"
                            placeholder="{{ __('car.plate_placeholder') }}"
                            required
                        >
                    </div>

                    <div>
                        <label
                            class="form-label"
                            for="car-color"
                        >
                            {{ __('car.color_label') }}
                            <span class="admin-form-required">*</span>
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="car-color"
                            name="color"
                            value="{{ old('color') }}"
                            placeholder="{{ __('car.color_placeholder') }}"
                            required
                        >
                    </div>

                    <div>
                        <label
                            class="form-label"
                            for="car-soat"
                        >
                            {{ __('car.soat_label') }}
                            <span class="admin-form-required">*</span>
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="car-soat"
                            name="soat"
                            value="{{ old('soat') }}"
                            placeholder="{{ __('car.soat_placeholder') }}"
                            required
                        >
                    </div>

                    <div>
                        <label
                            class="form-label"
                            for="car-transit-license"
                        >
                            {{ __('car.transit_license_label') }}
                            <span class="admin-form-required">*</span>
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="car-transit-license"
                            name="transit_license"
                            value="{{ old('transit_license') }}"
                            placeholder="{{ __('car.transit_license_placeholder') }}"
                            required
                        >
                    </div>

                    <div>
                        <label
                            class="form-label"
                            for="car-price"
                        >
                            {{ __('car.price_label') }}
                            <span class="admin-form-required">*</span>
                        </label>

                        <input
                            type="number"
                            class="form-control"
                            id="car-price"
                            name="price"
                            value="{{ old('price') }}"
                            placeholder="{{ __('car.price_placeholder') }}"
                            required
                        >
                    </div>

                    <div>
                        <label
                            class="form-label"
                            for="car-mileage"
                        >
                            {{ __('car.mileage_label') }}
                            <span class="admin-form-required">*</span>
                        </label>

                        <input
                            type="number"
                            class="form-control"
                            id="car-mileage"
                            name="mileage"
                            value="{{ old('mileage') }}"
                            placeholder="{{ __('car.mileage_placeholder') }}"
                            required
                        >
                    </div>

                    <div class="admin-form-field-full">
                        <label
                            class="form-label"
                            for="car-category"
                        >
                            {{ __('car.category_label') }}
                            <span class="admin-form-required">*</span>
                        </label>

                        <select
                            class="form-select"
                            id="car-category"
                            name="category_id"
                            required
                        >
                            <option
                                value=""
                                disabled
                                {{ old('category_id') ? '' : 'selected' }}
                            >
                                {{ __('car.category_placeholder') }}
                            </option>

                            @foreach ($viewData['categories'] as $category)
                                <option
                                    value="{{ $category->getId() }}"
                                    {{ old('category_id') == $category->getId() ? 'selected' : '' }}
                                >
                                    {{ $category->getBrand() }} {{ $category->getModel() }} ({{ $category->getType() }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="admin-form-field-full">
                        <label
                            class="form-label"
                            for="car-image"
                        >
                            {{ __('car.image_label') }}
                        </label>

                        <input
                            type="url"
                            class="form-control"
                            id="car-image"
                            name="image"
                            value="{{ old('image') }}"
                            placeholder="{{ __('car.image_placeholder') }}"
                        >
                    </div>

                    <div class="admin-form-field-full">
                        <label
                            class="form-label"
                            for="car-description"
                        >
                            {{ __('car.description_label') }}
                        </label>

                        <textarea
                            class="form-control"
                            id="car-description"
                            name="description"
                            rows="4"
                            placeholder="{{ __('car.description_placeholder') }}"
                        >{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="admin-form-actions">
                    <a
                        href="{{ route('admin.car.index') }}"
                        class="admin-form-cancel-btn"
                    >
                        {{ __('car.btn_cancel') }}
                    </a>

                    <button
                        type="submit"
                        class="admin-form-save-btn"
                    >
                        {{ __('car.btn_create') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
