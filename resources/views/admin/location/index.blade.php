{{--
    Author: Isabella Ocampo
    Date: 2026-09-11
    Description: Admin view for listing, managing, and deleting physical rental locations.
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
                    {{ __('location.registered_locations') }}
                </p>
            </div>

            <a
                class="admin-index-create-btn"
                href="{{ route('admin.location.create') }}"
            >
                <span class="admin-index-create-icon" aria-hidden="true">+</span>
                <span>{{ __('location.btn_create') }}</span>
            </a>
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

        <div class="admin-index-table-wrapper">
            <table class="admin-index-table">
                <thead>
                    <tr>
                        <th>{{ __('location.id') }}</th>
                        <th>{{ __('location.name') }}</th>
                        <th>{{ __('location.address') }}</th>
                        <th>{{ __('location.headquarters') }}</th>
                        <th>{{ __('location.telephone') }}</th>
                        <th>{{ __('location.city') }}</th>
                        <th class="text-center">{{ __('location.cars_count') }}</th>
                        <th class="text-center">{{ __('location.reservations_count') }}</th>
                        <th class="text-center">{{ __('location.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($viewData['locations'] as $location)
                        <tr>
                            <td class="admin-index-id">#{{ $location->getId() }}</td>
                            <td class="admin-index-strong">{{ $location->getName() }}</td>
                            <td>{{ $location->getAddress() }}</td>
                            <td>
                                <span class="admin-index-type-badge">{{ $location->getHeadquarters() }}</span>
                            </td>
                            <td>{{ $location->getTelephone() }}</td>
                            <td>{{ $location->getCity() }}</td>
                            <td class="text-center">
                                <span class="admin-index-status-badge">{{ $location->cars_count ?? $location->getCars()->count() }}</span>
                            </td>
                            <td class="text-center">
                                <span class="admin-index-status-badge">{{ $location->reservations_count ?? $location->getReservations()->count() }}</span>
                            </td>
                            <td class="text-center">
                                <a
                                    href="{{ route('admin.location.edit', ['id' => $location->getId()]) }}"
                                    class="admin-index-btn admin-index-btn-edit"
                                >
                                    {{ __('location.btn_edit') }}
                                </a>
                                <form
                                    action="{{ route('admin.location.delete', ['id' => $location->getId()]) }}"
                                    method="POST"
                                    class="d-inline"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="admin-index-btn admin-index-btn-danger"
                                        onclick="return confirm('{{ __('location.confirm_delete') }}')"
                                    >
                                        {{ __('location.btn_delete') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="admin-index-empty">
                                {{ __('location.no_locations_found') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
