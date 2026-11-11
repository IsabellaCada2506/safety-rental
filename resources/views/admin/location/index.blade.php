{{--
    Author: Isabella Ocampo
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
                    {{ __('location.admin_area') }}
                </span>

                <h1 class="admin-title">
                    {{ __('location.heading_management') }}
                </h1>

                <p class="admin-subtitle">
                    {{ __('location.registered_locations') }}
                </p>
            </div>

            <div class="d-flex align-items-center gap-2">
                <a
                    class="admin-index-create-btn"
                    href="{{ route('admin.location.create') }}"
                >
                    <span class="admin-index-create-icon" aria-hidden="true">+</span>
                    <span>{{ __('location.btn_create') }}</span>
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

        @if (session('error'))
            <div
                class="alert alert-danger admin-alert"
                role="alert"
            >
                {{ session('error') }}
            </div>
        @endif

        <div class="collection-grid">
            @forelse ($viewData['locations'] as $location)
<article class="collection-card branch-card">
    <div class="branch-card-banner">
        <span class="branch-card-marker" aria-hidden="true">⌖</span>
        <span>{{ $location->getCity() }}</span>
    </div>
    <div class="collection-card-body">
        <span class="collection-eyebrow">{{ $location->getHeadquarters() }}</span>
        <h2 class="collection-card-title">{{ $location->getName() }}</h2>
        <dl class="collection-facts collection-facts-stacked">
            <div><dt>{{ __('location.address') }}</dt><dd>{{ $location->getAddress() }}</dd></div>
            <div><dt>{{ __('location.telephone') }}</dt><dd>{{ $location->getTelephone() }}</dd></div>
        </dl>
        <div class="branch-card-counts"><span>{{ $location->getCarsCount() }} {{ __('location.cars_count') }}</span><span>{{ $location->getReservationsCount() }} {{ __('location.reservations_count') }}</span></div>
        <div class="collection-actions"><a class="collection-button collection-button-edit" href="{{ route('admin.location.edit', ['id' => $location->getId()]) }}">{{ __('location.btn_edit') }}</a>
<form method="POST" action="{{ route('admin.location.delete', ['id' => $location->getId()]) }}" data-confirm-message="{{ __('location.confirm_delete') }}">
    @csrf
    @method('DELETE')
    <button type="submit" class="collection-button collection-button-danger">{{ __('location.btn_delete') }}</button>
</form></div>
    </div>
</article>
            @empty
                <div class="collection-empty" role="status">{{ __('location.no_locations_found') }}</div>
            @endforelse
        </div>
    </div>
</section>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/card-actions.js') }}?v=1" defer></script>
@endpush
