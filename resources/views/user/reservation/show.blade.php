{{--
    Author: Isabella Ocampo
    Author: Alejandro Correa Marin
    Author: Wendy Atehortua
    Description: Customer reservation details with address-based pickup
    directions, payment information, receipts and cancellation actions.
--}}

@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<section class="integration-page">
    <header class="integration-hero">
        <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
            <div>
                <span class="integration-tag">
                    {{ __('reservation.reservation_code') }}
                    #{{ $viewData['reservation']->getCode() }}
                </span>

                <h1>{{ $viewData['title'] }}</h1>

                <p>{{ __('reservation.summary_heading') }}</p>
            </div>

            <a
                href="{{ route('reservations.index') }}"
                class="integration-button integration-button-secondary"
            >
                <span aria-hidden="true">←</span>
                {{ __('general.btn_back') }}
            </a>
        </div>
    </header>

    @if (session('success'))
        <div
            class="alert alert-success rounded-4 mb-4"
            role="status"
        >
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div
            class="alert alert-danger rounded-4 mb-4"
            role="alert"
        >
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="integration-grid">
        <div>
            <article class="integration-card">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                    <span class="integration-tag">
                        {{ __('reservation.reservation_code') }}
                        #{{ $viewData['reservation']->getCode() }}
                    </span>

                    <span
                        class="badge {{ $viewData['reservation']->getStateBadgeClass() }} px-3 py-2 rounded-pill"
                    >
                        {{ __('reservation.state_'.$viewData['reservation']->getState()) }}
                    </span>
                </div>

                <x-responsive-image
                    :src="$viewData['reservation']->getCar()?->getImage()"
                    :alt="$viewData['reservation']->getCar()?->getCategory()?->getName() ?? __('general.image_alt')"
                    class="img-fluid rounded-4 w-100 mb-4"
                />

                <h2 class="mb-2">
                    {{ $viewData['reservation']->getCar()?->getCategory()?->getBrand() }}
                    {{ $viewData['reservation']->getCar()?->getCategory()?->getModel() }}
                </h2>

                <p class="integration-muted mb-2">
                    {{ $viewData['reservation']->getCar()?->getCategory()?->getType() }}
                    ·
                    {{ $viewData['reservation']->getCar()?->getColor() }}
                </p>

                <p class="integration-muted mb-0">
                    {{ __('catalog.plate_label') }}:

                    <strong>
                        {{ $viewData['reservation']->getCar()?->getPlate() }}
                    </strong>
                </p>
            </article>

            <article class="integration-card">
                <h2>{{ __('reservation.pickup_location') }}</h2>

                @if ($viewData['reservation']->getLocation())
                    <p class="fw-bold mb-2">
                        {{ $viewData['reservation']->getLocation()->getName() }}
                    </p>

                    <p class="integration-muted mb-2">
                        {{ $viewData['reservation']->getLocation()->getAddress() }}
                        ·
                        {{ $viewData['reservation']->getLocation()->getCity() }}
                    </p>

                    <p class="integration-muted mb-0">
                        {{ $viewData['reservation']->getLocation()->getTelephone() }}
                    </p>

                    <div class="integration-actions">
                        <a
                            href="https://www.google.com/maps/dir/?api=1&destination={{ urlencode($viewData['reservation']->getLocation()->getAddress().', '.$viewData['reservation']->getLocation()->getCity().', Colombia') }}&travelmode=driving"
                            class="integration-button integration-button-secondary integration-button-wide"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            {{ __('integrations.open_maps') }}
                            <span aria-hidden="true">↗</span>
                        </a>
                    </div>
                @else
                    <p class="integration-notice mb-0">
                        {{ __('pickup.missing_destination') }}
                    </p>
                @endif
            </article>
        </div>

        <div>
            <article class="integration-card">
                <h2>{{ __('reservation.dates') }}</h2>

                <div class="integration-metrics mb-0">
                    <div class="integration-metric">
                        <span>{{ __('reservation.start_date') }}</span>

                        <p class="fw-bold mb-0">
                            {{ $viewData['reservation']->getStartDate()?->format('d/m/Y') }}
                        </p>
                    </div>

                    <div class="integration-metric">
                        <span>{{ __('reservation.end_date') }}</span>

                        <p class="fw-bold mb-0">
                            {{ $viewData['reservation']->getEndDate()?->format('d/m/Y') }}
                        </p>
                    </div>
                </div>
            </article>

            <article class="integration-card">
                <h2>{{ __('reservation.total_price') }}</h2>

                <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                    <span class="integration-muted">
                        {{ __('reservation.daily_rate') }}
                    </span>

                    <span class="fw-semibold text-end">
                        ${{ number_format(
                            $viewData['reservation']->getCar()?->getPrice() ?? 0,
                            0,
                            app()->getLocale() === 'es' ? ',' : '.',
                            app()->getLocale() === 'es' ? '.' : ','
                        ) }}
                    </span>
                </div>

                <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                    <span class="integration-muted">
                        {{ __('reservation.rental_days') }}
                    </span>

                    <span class="fw-semibold text-end">
                        {{ $viewData['reservation']->getDays() }}
                        {{ __('reservation.days_unit') }}
                    </span>
                </div>

                <hr>

                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <span class="fw-bold">
                        {{ __('reservation.total_price') }}
                    </span>

                    <strong class="fs-3 text-primary">
                        ${{ number_format(
                            $viewData['reservation']->getTotalPrice(),
                            0,
                            app()->getLocale() === 'es' ? ',' : '.',
                            app()->getLocale() === 'es' ? '.' : ','
                        ) }}
                    </strong>
                </div>
            </article>

            <article class="integration-card">
                <h2>{{ __('payment.heading') }}</h2>

                @if ($viewData['reservation']->getPayment())
                    <dl class="integration-fields">
                        <dt>{{ __('payment.status') }}</dt>

                        <dd>
                            <span
                                class="badge {{ $viewData['reservation']->getPayment()->getStatusBadgeClass() }} px-3 py-2 rounded-pill"
                            >
                                {{ __('payment.status_'.$viewData['reservation']->getPayment()->getStatus()) }}
                            </span>
                        </dd>

                        <dt>{{ __('payment.method') }}</dt>

                        <dd>
                            {{ $viewData['reservation']->getPayment()->getMethodLabel() }}
                        </dd>

                        <dt>{{ __('payment.transaction_code') }}</dt>

                        <dd>
                            {{ $viewData['reservation']->getPayment()->getTransactionCode() }}
                        </dd>

                        <dt>{{ __('payment.amount') }}</dt>

                        <dd>
                            ${{ number_format(
                                $viewData['reservation']->getPayment()->getAmount(),
                                0,
                                app()->getLocale() === 'es' ? ',' : '.',
                                app()->getLocale() === 'es' ? '.' : ','
                            ) }}
                        </dd>
                    </dl>
                @else
                    <p class="integration-notice mb-0">
                        {{ __('payment.unpaid') }}
                    </p>
                @endif

                @if ($viewData['reservation']->isPayable())
                    <a
                        href="{{ route('payments.create', ['id' => $viewData['reservation']->getId()]) }}"
                        class="integration-button integration-button-wide mt-4"
                    >
                        {{ __('payment.pay_now') }}
                        <span aria-hidden="true">→</span>
                    </a>
                @endif

                @if ($viewData['reservation']->hasSuccessfulPayment())
                    <a
                        href="{{ route('receipts.download', ['id' => $viewData['reservation']->getId()]) }}"
                        class="integration-button integration-button-secondary integration-button-wide mt-3"
                    >
                        {{ __('payment.download_receipt') }}
                    </a>
                @endif
            </article>

            @if ($viewData['reservation']->isCancellable())
                <div class="integration-actions">
                    <a
                        href="{{ route('reservations.cancel.form', ['id' => $viewData['reservation']->getId()]) }}"
                        class="btn btn-outline-danger rounded-pill px-4 py-2"
                    >
                        {{ __('reservation.cancel_reservation') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection