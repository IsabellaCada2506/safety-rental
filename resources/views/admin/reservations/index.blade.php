{{--
    Author: Isabella Ocampo
    Date: 2026-09-11
    Description: Admin view for managing and auditing customer reservations.
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
                    {{ __('authentication.reservations_description') }}
                </p>
            </div>

            <a href="{{ route('admin.dashboard.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                &larr; {{ __('authentication.dashboard') }}
            </a>
        </header>

        @if (session('success'))
            <div class="alert alert-success admin-alert" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger admin-alert" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Filter Pills --}}
        <div class="d-flex gap-2 mb-4 flex-wrap">
            <a
                href="{{ route('admin.reservation.index') }}"
                class="badge rounded-pill text-decoration-none px-3 py-2 {{ empty($viewData['currentState']) ? 'bg-dark text-white' : 'bg-light text-dark' }}"
            >
                {{ __('reservation.filter_all') }}
            </a>
            <a
                href="{{ route('admin.reservation.index', ['state' => 'pending']) }}"
                class="badge rounded-pill text-decoration-none px-3 py-2 {{ $viewData['currentState'] === 'pending' ? 'bg-warning text-dark' : 'bg-light text-dark' }}"
            >
                {{ __('reservation.state_pending') }}
            </a>
            <a
                href="{{ route('admin.reservation.index', ['state' => 'confirmed']) }}"
                class="badge rounded-pill text-decoration-none px-3 py-2 {{ $viewData['currentState'] === 'confirmed' ? 'bg-success text-white' : 'bg-light text-dark' }}"
            >
                {{ __('reservation.state_confirmed') }}
            </a>
            <a
                href="{{ route('admin.reservation.index', ['state' => 'cancelled']) }}"
                class="badge rounded-pill text-decoration-none px-3 py-2 {{ $viewData['currentState'] === 'cancelled' ? 'bg-danger text-white' : 'bg-light text-dark' }}"
            >
                {{ __('reservation.state_cancelled') }}
            </a>
        </div>

        @if ($viewData['reservations']->isEmpty())
            <div class="card shadow-sm border-0 rounded-4 text-center py-5 bg-white">
                <div class="card-body">
                    <p class="text-muted mb-0">{{ __('reservation.no_reservations') }}</p>
                </div>
            </div>
        @else
            <div class="admin-index-table-wrapper">
                <table class="admin-index-table">
                    <thead>
                        <tr>
                            <th>{{ __('reservation.code') }}</th>
                            <th>{{ __('reservation.customer') }}</th>
                            <th>{{ __('reservation.vehicle') }}</th>
                            <th>{{ __('reservation.pickup_location') }}</th>
                            <th>{{ __('reservation.dates') }}</th>
                            <th>{{ __('reservation.total_price') }}</th>
                            <th>{{ __('reservation.status') }}</th>
                            <th class="text-end">{{ __('reservation.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($viewData['reservations'] as $reservation)
                            <tr>
                                <td>
                                    <strong>#{{ $reservation->getCode() }}</strong>
                                </td>
                                <td>
                                    {{ $reservation->getUser()?->getName() }} {{ $reservation->getUser()?->getLastName() }}
                                    <div class="text-muted small">{{ $reservation->getUser()?->getEmail() }}</div>
                                </td>
                                <td>
                                    {{ optional($reservation->getCar()?->getCategory())->getBrand() }} {{ optional($reservation->getCar()?->getCategory())->getModel() }}
                                    <div class="text-muted small">{{ $reservation->getCar()?->getPlate() }}</div>
                                </td>
                                <td>
                                    {{ $reservation->getLocation()?->getName() }}
                                </td>
                                <td>
                                    {{ $reservation->getStartDate()?->format('d/m/Y') }} - {{ $reservation->getEndDate()?->format('d/m/Y') }}
                                    <div class="text-muted small">({{ $reservation->getDays() }} {{ __('reservation.days_unit') }})</div>
                                </td>
                                <td>
                                    <strong>${{ number_format($reservation->getTotalPrice(), 0, ',', '.') }}</strong>
                                </td>
                                <td>
                                    <span class="badge {{ $reservation->getStateBadgeClass() }} px-2 py-1 rounded-pill">
                                        {{ __('reservation.state_' . $reservation->getState()) }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-1 align-items-center">
                                        @if ($reservation->isPending())
                                            <form action="{{ route('admin.reservation.confirm', ['id' => $reservation->getId()]) }}" method="POST" class="m-0">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-success rounded-pill px-2 py-1" title="{{ __('reservation.confirm_reservation') }}">
                                                    ✓
                                                </button>
                                            </form>
                                        @endif

                                        @if ($reservation->isCancellable())
                                            <form
                                                action="{{ route('admin.reservation.cancel', ['id' => $reservation->getId()]) }}"
                                                method="POST"
                                                class="m-0"
                                                onsubmit="return confirm('{{ __('reservation.cancellation_confirm') }}');"
                                            >
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-1" title="{{ __('reservation.cancel_reservation') }}">
                                                    ✕
                                                </button>
                                            </form>
                                        @endif

                                        <a href="{{ route('admin.reservation.show', ['id' => $reservation->getId()]) }}" class="btn btn-sm btn-outline-primary rounded-pill px-2 py-1">
                                            {{ __('reservation.view_details') }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</section>
@endsection
