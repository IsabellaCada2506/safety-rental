{{--
    Author: Wendy Atehortua
    Date: 2026-09-11
    Description: Admin view for listing, managing, and toggling status of vehicles in the inventory with branch location.
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
                    {{ __('car.registered_vehicles') }}
                </p>
            </div>

            <a
                class="admin-index-create-btn"
                href="{{ route('admin.car.create') }}"
            >
                <span class="admin-index-create-icon" aria-hidden="true">+</span>
                <span>{{ __('car.btn_create') }}</span>
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

        <div class="admin-index-table-wrapper">
            <table class="admin-index-table">
                <thead>
                    <tr>
                        <th>{{ __('car.id') }}</th>
                        <th>{{ __('car.plate') }}</th>
                        <th>{{ __('car.color') }}</th>
                        <th>{{ __('car.soat') }}</th>
                        <th>{{ __('car.price') }}</th>
                        <th>{{ __('car.mileage') }}</th>
                        <th>{{ __('car.branch') }}</th>
                        <th>{{ __('car.status') }}</th>
                        <th class="text-center">{{ __('car.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($viewData['cars'] as $car)
                        <tr>
                            <td class="admin-index-id">#{{ $car->getId() }}</td>
                            <td>{{ $car->getPlate() }}</td>
                            <td>{{ $car->getColor() }}</td>
                            <td>{{ $car->getSoat() }}</td>
                            <td>${{ number_format($car->getPrice(), 0, ',', '.') }}</td>
                            <td>{{ number_format($car->getMileage(), 0, ',', '.') }} km</td>
                            <td>{{ $car->getLocation() ? $car->getLocation()->getName() : '-' }}</td>
                            <td>
                                <span class="admin-index-status-badge">{{ $car->isActive() ? __('car.status_active') : __('car.status_deactivated') }}</span>
                            </td>
                            <td class="text-center">
                                <a
                                    href="{{ route('admin.car.edit', ['id' => $car->getId()]) }}"
                                    class="admin-index-btn admin-index-btn-edit"
                                >
                                    {{ __('car.btn_edit') }}
                                </a>
                                <form
                                    action="{{ route('admin.car.deactivate', ['id' => $car->getId()]) }}"
                                    method="POST"
                                    class="d-inline"
                                >
                                    @csrf
                                    @method('PATCH')
                                    @if ($car->isActive())
                                        <button
                                            type="submit"
                                            class="admin-index-btn admin-index-btn-danger"
                                            onclick="return confirm('{{ __('car.confirm_status_change') }}')"
                                        >
                                            {{ __('car.btn_deactivate') }}
                                        </button>
                                    @else
                                        <button
                                            type="submit"
                                            class="admin-index-btn admin-index-btn-success"
                                            onclick="return confirm('{{ __('car.confirm_status_change') }}')"
                                        >
                                            {{ __('car.btn_activate') }}
                                        </button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="admin-index-empty">
                                {{ __('car.no_cars_found') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection