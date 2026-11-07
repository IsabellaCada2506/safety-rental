{{--
    Author: Isabella Cadavid Posada
    Author: Wendy Atehortua
    Date: 2026-09-10
    Description: Admin view for editing an existing vehicle category.
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
                    {{ __('category.admin_area') }}
                </span>

                <h1 class="admin-title">
                    {{ __('category.heading_management') }}
                </h1>

                <p class="admin-subtitle">
                    {{ __('category.btn_edit') }}: {{ $viewData['category']->getModel() }} {{ $viewData['category']->getBrand() }}
                </p>
            </div>

            <a href="{{ route('admin.category.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                &larr; {{ __('general.btn_back') }}
            </a>
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
                action="{{ route('admin.category.update', ['id' => $viewData['category']->getId()]) }}"
            >
                @csrf
                @method('PUT')

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
                            class="form-control @error('model') is-invalid @enderror"
                            id="category-model"
                            name="model"
                            value="{{ old('model', $viewData['category']->getModel()) }}"
                            placeholder="{{ __('category.model_placeholder') }}"
                            required
                            @error('model') aria-invalid="true" aria-describedby="category-model-error" @enderror
                        >
                        @error('model')
                            <div id="category-model-error" class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
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
                            class="form-control @error('brand') is-invalid @enderror"
                            id="category-brand"
                            name="brand"
                            value="{{ old('brand', $viewData['category']->getBrand()) }}"
                            placeholder="{{ __('category.brand_placeholder') }}"
                            required
                            @error('brand') aria-invalid="true" aria-describedby="category-brand-error" @enderror
                        >
                        @error('brand')
                            <div id="category-brand-error" class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
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
                            class="form-control @error('type') is-invalid @enderror"
                            id="category-type"
                            name="type"
                            value="{{ old('type', $viewData['category']->getType()) }}"
                            placeholder="{{ __('category.type_placeholder') }}"
                            required
                            @error('type') aria-invalid="true" aria-describedby="category-type-error" @enderror
                        >
                        @error('type')
                            <div id="category-type-error" class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
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
                            class="form-control @error('passenger_capacity') is-invalid @enderror"
                            id="category-passenger-capacity"
                            name="passenger_capacity"
                            value="{{ old('passenger_capacity', $viewData['category']->getPassengerCapacity()) }}"
                            placeholder="{{ __('category.passenger_capacity_placeholder') }}"
                            min="1"
                            required
                            @error('passenger_capacity') aria-invalid="true" aria-describedby="category-passenger-capacity-error" @enderror
                        >
                        @error('passenger_capacity')
                            <div id="category-passenger-capacity-error" class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
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
                            class="form-control @error('luggage_capacity') is-invalid @enderror"
                            id="category-luggage-capacity"
                            name="luggage_capacity"
                            value="{{ old('luggage_capacity', $viewData['category']->getLuggageCapacity()) }}"
                            placeholder="{{ __('category.luggage_capacity_placeholder') }}"
                            min="0"
                            required
                            @error('luggage_capacity') aria-invalid="true" aria-describedby="category-luggage-capacity-error" @enderror
                        >
                        @error('luggage_capacity')
                            <div id="category-luggage-capacity-error" class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
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
                        {{ __('category.btn_update') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
