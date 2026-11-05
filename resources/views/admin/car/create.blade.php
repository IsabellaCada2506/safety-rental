{{--
    Author: Isabella Cadavid Posada
    Author: Wendy Atehortua
    Date: 2026-11-05
    Description: Admin view for creating a new vehicle with category and branch location associations.
--}}

@extends('layouts.app')

@section('title', $viewData['title'])

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
                            class="form-control @error('plate') is-invalid @enderror"
                            id="car-plate"
                            name="plate"
                            value="{{ old('plate') }}"
                            placeholder="{{ __('car.plate_placeholder') }}"
                            required
                            @error('plate') aria-invalid="true" aria-describedby="car-plate-error" @enderror
                        >
                        @error('plate')
                            <div id="car-plate-error" class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
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
                            class="form-control @error('color') is-invalid @enderror"
                            id="car-color"
                            name="color"
                            value="{{ old('color') }}"
                            placeholder="{{ __('car.color_placeholder') }}"
                            required
                            @error('color') aria-invalid="true" aria-describedby="car-color-error" @enderror
                        >
                        @error('color')
                            <div id="car-color-error" class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
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
                            class="form-control @error('soat') is-invalid @enderror"
                            id="car-soat"
                            name="soat"
                            value="{{ old('soat') }}"
                            placeholder="{{ __('car.soat_placeholder') }}"
                            required
                            @error('soat') aria-invalid="true" aria-describedby="car-soat-error" @enderror
                        >
                        @error('soat')
                            <div id="car-soat-error" class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
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
                            class="form-control @error('transit_license') is-invalid @enderror"
                            id="car-transit-license"
                            name="transit_license"
                            value="{{ old('transit_license') }}"
                            placeholder="{{ __('car.transit_license_placeholder') }}"
                            required
                            @error('transit_license') aria-invalid="true" aria-describedby="car-transit-license-error" @enderror
                        >
                        @error('transit_license')
                            <div id="car-transit-license-error" class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
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
                            class="form-control @error('price') is-invalid @enderror"
                            id="car-price"
                            name="price"
                            value="{{ old('price') }}"
                            placeholder="{{ __('car.price_placeholder') }}"
                            required
                            @error('price') aria-invalid="true" aria-describedby="car-price-error" @enderror
                        >
                        @error('price')
                            <div id="car-price-error" class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
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
                            class="form-control @error('mileage') is-invalid @enderror"
                            id="car-mileage"
                            name="mileage"
                            value="{{ old('mileage') }}"
                            placeholder="{{ __('car.mileage_placeholder') }}"
                            required
                            @error('mileage') aria-invalid="true" aria-describedby="car-mileage-error" @enderror
                        >
                        @error('mileage')
                            <div id="car-mileage-error" class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
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
                            class="form-select @error('category_id') is-invalid @enderror"
                            id="car-category"
                            name="category_id"
                            required
                            @error('category_id') aria-invalid="true" aria-describedby="car-category-error" @enderror
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
                        @error('category_id')
                            <div id="car-category-error" class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="admin-form-field-full">
                        <label
                            class="form-label"
                            for="car-location"
                        >
                            {{ __('car.location_label') }}
                            <span class="admin-form-required">*</span>
                        </label>

                        <select
                            class="form-select @error('location_id') is-invalid @enderror"
                            id="car-location"
                            name="location_id"
                            required
                            @error('location_id') aria-invalid="true" aria-describedby="car-location-error" @enderror
                        >
                            <option
                                value=""
                                disabled
                                {{ old('location_id') ? '' : 'selected' }}
                            >
                                {{ __('car.location_placeholder') }}
                            </option>

                            @foreach ($viewData['locations'] as $location)
                                <option
                                    value="{{ $location->getId() }}"
                                    {{ old('location_id') == $location->getId() ? 'selected' : '' }}
                                >
                                    {{ $location->getName() }} - {{ $location->getCity() }} ({{ $location->getHeadquarters() }})
                                </option>
                            @endforeach
                        </select>
                        @error('location_id')
                            <div id="car-location-error" class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
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
                            class="form-control @error('image') is-invalid @enderror"
                            id="car-image"
                            name="image"
                            value="{{ old('image') }}"
                            placeholder="{{ __('car.image_placeholder') }}"
                            @error('image') aria-invalid="true" aria-describedby="car-image-error" @enderror
                        >
                        @error('image')
                            <div id="car-image-error" class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="admin-form-field-full">
                        <label
                            class="form-label"
                            for="car-description"
                        >
                            {{ __('car.description_label') }}
                        </label>

                        <textarea
                            class="form-control @error('description') is-invalid @enderror"
                            id="car-description"
                            name="description"
                            rows="4"
                            placeholder="{{ __('car.description_placeholder') }}"
                            @error('description') aria-invalid="true" aria-describedby="car-description-error" @enderror
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <div id="car-description-error" class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
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
