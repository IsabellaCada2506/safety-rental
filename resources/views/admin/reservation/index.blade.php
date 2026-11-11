{{--
    Author: Isabella Ocampo
    Author: Isabella Cadavid Posada
    Date: 2026-11-04
    Description: Administrative reservation cards with state filters and existing management actions.
--}}

@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<section class="admin-page records-page">
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

            <div class="d-flex align-items-center gap-2">
                <a
                    href="{{ route('admin.metrics.index') }}"
                    class="record-button record-button-secondary"
                >
                    {{ __('reservation.btn_metrics') }}
                </a>

                <details class="language-dropdown position-relative">
                    <summary
                        class="record-button record-button-primary"
                        style="list-style: none; cursor: pointer;"
                    >
                        <span>{{ __('reservation.download_report') }}</span>
                        <span class="language-dropdown-arrow" aria-hidden="true">▾</span>
                    </summary>

                    <div class="language-dropdown-menu" style="min-width: 190px;">
                        <a
                            class="language-dropdown-option text-decoration-none d-block py-2 px-3"
                            href="{{ route('admin.reservation.report', ['format' => 'pdf']) }}"
                            target="_blank"
                        >
                            {{ __('reservation.report_format_pdf') }}
                        </a>

                        <div class="dropdown-divider my-1 border-top border-secondary"></div>

                        <a
                            class="language-dropdown-option text-decoration-none d-block py-2 px-3"
                            href="{{ route('admin.reservation.report', ['format' => 'excel']) }}"
                        >
                            {{ __('reservation.report_format_excel') }}
                        </a>
                    </div>
                </details>
            </div>
        </header>

        @if (session('success'))
            <div class="alert alert-success admin-alert" role="status">
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

        <nav
            class="record-filters"
            aria-label="{{ __('reservation.status') }}"
        >
            <a
                href="{{ route('admin.reservation.index') }}"
                class="record-filter"
                @if (empty($viewData['currentState']))
                    aria-current="page"
                @endif
            >
                {{ __('reservation.filter_all') }}
            </a>

            <a
                href="{{ route('admin.reservation.index', ['state' => 'pending']) }}"
                class="record-filter"
                @if ($viewData['currentState'] === 'pending')
                    aria-current="page"
                @endif
            >
                {{ __('reservation.state_pending') }}
            </a>

            <a
                href="{{ route('admin.reservation.index', ['state' => 'confirmed']) }}"
                class="record-filter"
                @if ($viewData['currentState'] === 'confirmed')
                    aria-current="page"
                @endif
            >
                {{ __('reservation.state_confirmed') }}
            </a>

            <a
                href="{{ route('admin.reservation.index', ['state' => 'cancelled']) }}"
                class="record-filter"
                @if ($viewData['currentState'] === 'cancelled')
                    aria-current="page"
                @endif
            >
                {{ __('reservation.state_cancelled') }}
            </a>

            <a
                href="{{ route('admin.reservation.index', ['state' => 'completed']) }}"
                class="record-filter"
                @if ($viewData['currentState'] === 'completed')
                    aria-current="page"
                @endif
            >
                {{ __('reservation.state_completed') }}
            </a>
        </nav>

        <div class="record-list">
            @forelse ($viewData['reservations'] as $reservation)
                <article class="record-card">
                    <header class="record-card-header">
                        <div>
                            <span class="record-eyebrow">
                                {{ __('reservation.reservation_code') }}
                            </span>

                            <h2 class="record-code">
                                #{{ $reservation->getCode() }}
                            </h2>
                        </div>

                        <span
                            class="record-status"
                            data-state="{{ $reservation->getState() }}"
                        >
                            {{ __('reservation.state_'.$reservation->getState()) }}
                        </span>
                    </header>

                    <dl class="record-information">
                        <div class="record-information-item">
                            <dt>{{ __('reservation.user_info') }}</dt>

                            <dd>
                                <strong>
                                    {{ $reservation->getUser()?->getName() }}
                                    {{ $reservation->getUser()?->getLastName() }}
                                </strong>

                                <span class="record-secondary">
                                    {{ $reservation->getUser()?->getEmail() ?? '—' }}
                                </span>
                            </dd>
                        </div>

                        <div class="record-information-item">
                            <dt>{{ __('reservation.vehicle') }}</dt>

                            <dd>
                                <strong>
                                    {{ $reservation->getCar()?->getCategory()?->getBrand() }}
                                    {{ $reservation->getCar()?->getCategory()?->getModel() }}
                                </strong>

                                <span class="record-secondary">
                                    {{ $reservation->getCar()?->getPlate() ?? '—' }}
                                </span>
                            </dd>
                        </div>

                        <div class="record-information-item">
                            <dt>{{ __('reservation.dates') }}</dt>

                            <dd>
                                <strong>
                                    {{ $reservation->getStartDate()?->format('d/m/Y') ?? '—' }}
                                    <span aria-hidden="true">→</span>
                                    {{ $reservation->getEndDate()?->format('d/m/Y') ?? '—' }}
                                </strong>

                                <span class="record-secondary">
                                    {{ $reservation->getDays() }}
                                    {{ __('reservation.days_unit') }}
                                </span>
                            </dd>
                        </div>

                        <div class="record-information-item">
                            <dt>{{ __('reservation.pickup_location') }}</dt>

                            <dd>
                                {{ $reservation->getLocation()?->getName() ?? '—' }}
                            </dd>
                        </div>
                    </dl>

                    <footer class="record-card-footer">
                        <div class="record-total">
                            <span>{{ __('reservation.total_price') }}</span>

                            <strong>
                                ${{ number_format($reservation->getTotalPrice(), 0, app()->getLocale() === 'es' ? ',' : '.', app()->getLocale() === 'es' ? '.' : ',') }}
                            </strong>
                        </div>

                        <div class="record-actions">
                            @if ($reservation->isPending())
                                <form
                                    action="{{ route('admin.reservation.confirm', ['id' => $reservation->getId()]) }}"
                                    method="POST"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="record-button record-button-success"
                                    >
                                        {{ __('reservation.confirm_reservation') }}
                                    </button>
                                </form>
                            @endif

                            @if ($reservation->isCancellable())
                                <form
                                    action="{{ route('admin.reservation.cancel', ['id' => $reservation->getId()]) }}"
                                    method="POST"
                                    data-reservation-confirm="{{ __('reservation.cancellation_confirm') }}"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="record-button record-button-danger"
                                    >
                                        {{ __('reservation.cancel_reservation') }}
                                    </button>
                                </form>
                            @endif

                            <a
                                href="{{ route('admin.reservation.show', ['id' => $reservation->getId()]) }}"
                                class="record-button record-button-primary"
                            >
                                {{ __('reservation.view_details') }}
                                <span aria-hidden="true">→</span>
                            </a>
                        </div>
                    </footer>
                </article>
            @empty
                <div class="record-empty" role="status">
                    <p>{{ __('reservation.no_reservations') }}</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection

@push('scripts')
    <script
        src="{{ asset('js/admin/admin-records.js') }}?v=1"
        defer
    ></script>
@endpush