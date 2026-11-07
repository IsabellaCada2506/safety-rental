{{--
    Author: Wendy Atehortua
    Author: Isabella Cadavid Posada
    Date: 2026-11-04
    Description: Administrative card listing with translated actions and confirmation.
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
                    {{ __('car.registered_vehicles') }}
                </p>
            </div>

            <div class="d-flex align-items-center gap-2">
                <a
                    href="{{ route('admin.ranking.index') }}"
                    class="record-button record-button-secondary"
                >
                    {{ __('car.btn_ranking') }}
                </a>

                <a
                    class="admin-index-create-btn"
                    href="{{ route('admin.car.create') }}"
                >
                    <span class="admin-index-create-icon" aria-hidden="true">+</span>
                    <span>{{ __('car.btn_create') }}</span>
                </a>
            </div>
        </header>

        @if (session('success'))
            <div
                class="alert alert-success admin-alert"
                role="alert"
            >
                {{ session('success') }}
            </div>
        @endif

        <div class="collection-grid">
            @forelse ($viewData['cars'] as $car)
<article class="collection-card vehicle-card">
    <div class="vehicle-card-media">
        <x-car-image :image="$car->getImage()" :alt="($car->getCategory()?->getName() ?? __('car.image_alt')).' · '.$car->getPlate()" class="vehicle-card-image" loading="lazy" />
        <span class="collection-status {{ $car->isActive() ? 'collection-status-active' : 'collection-status-inactive' }}">{{ $car->isActive() ? __('car.status_active') : __('car.status_deactivated') }}</span>
    </div>
    <div class="collection-card-body">
        <span class="collection-eyebrow">{{ $car->getCategory()?->getType() ?? __('catalog.title') }}</span>
        <h2 class="collection-card-title">{{ $car->getCategory()?->getName() ?? $car->getPlate() }}</h2>
        <p class="vehicle-card-price">${{ number_format($car->getPrice(), 0, app()->getLocale() === 'es' ? ',' : '.', app()->getLocale() === 'es' ? '.' : ',') }} <span>{{ __('catalog.per_day') }}</span></p>
        <dl class="collection-facts">
            <div><dt>{{ __('car.plate') }}</dt><dd>{{ $car->getPlate() }}</dd></div>
            <div><dt>{{ __('car.color') }}</dt><dd>{{ $car->getColor() }}</dd></div>
            <div><dt>{{ __('car.mileage') }}</dt><dd>{{ number_format($car->getMileage(), 0, app()->getLocale() === 'es' ? ',' : '.', app()->getLocale() === 'es' ? '.' : ',') }} {{ __('catalog.km_unit') }}</dd></div>
            <div><dt>{{ __('car.branch') }}</dt><dd>{{ $car->getLocation()?->getName() ?? '—' }}</dd></div>
            <div><dt>{{ __('car.soat') }}</dt><dd>{{ $car->getSoat() }}</dd></div>
        </dl>
        <div class="collection-actions"><a class="collection-button collection-button-edit" href="{{ route('admin.car.edit', ['id' => $car->getId()]) }}">{{ __('car.btn_edit') }}</a>
<form method="POST" action="{{ route('admin.car.deactivate', ['id' => $car->getId()]) }}" data-confirm-message="{{ __('car.confirm_status_change') }}">
    @csrf
    @method('PATCH')
    <button type="submit" class="collection-button {{ $car->isActive() ? 'collection-button-danger' : 'collection-button-success' }}">{{ $car->isActive() ? __('car.btn_deactivate') : __('car.btn_activate') }}</button>
</form></div>
    </div>
</article>
            @empty
                <div class="collection-empty" role="status">{{ __('car.no_cars_found') }}</div>
            @endforelse
        </div>
    </div>
</section>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/card-actions.js') }}?v=1" defer></script>
@endpush
