{{--
    Author: Alejandro Correa Marin
    Author: Wendy Atehortua
    Author: Isabella Cadavid Posada
    Date: 2026-11-04
    Description: Administrative payment cards with translated payment details and status.
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
            </div>

            <a
                href="{{ route('admin.dashboard.index') }}"
                class="record-button record-button-secondary"
            >
                <span aria-hidden="true">←</span>
                {{ __('authentication.dashboard') }}
            </a>
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

        <div class="record-list">
            @forelse ($viewData['payments'] as $payment)
                <article class="record-card">
                    <header class="record-card-header">
                        <div>
                            <span class="record-eyebrow">
                                {{ __('payment.payment_code') }}
                            </span>

                            <h2 class="record-code">
                                #{{ $payment->getCode() }}
                            </h2>
                        </div>

                        <div class="record-header-meta">
                            <div class="record-date">
                                <span>{{ __('payment.date') }}</span>
                                <strong>
                                    {{ $payment->getDate()?->format('d/m/Y') ?? '—' }}
                                </strong>
                            </div>

                            <span
                                class="record-status"
                                data-state="{{ $payment->getStatus() }}"
                            >
                                {{ __('payment.status_'.$payment->getStatus()) }}
                            </span>
                        </div>
                    </header>

                    <dl class="record-information">
                        <div class="record-information-item">
                            <dt>{{ __('reservation.user_info') }}</dt>

                            <dd>
                                <strong>
                                    {{ $payment->getReservation()?->getUser()?->getName() }}
                                    {{ $payment->getReservation()?->getUser()?->getLastName() }}
                                </strong>

                                <span class="record-secondary">
                                    {{ $payment->getReservation()?->getUser()?->getEmail() ?? '—' }}
                                </span>
                            </dd>
                        </div>

                        <div class="record-information-item">
                            <dt>{{ __('payment.reservation') }}</dt>

                            <dd>
                                <strong>
                                    #{{ $payment->getReservation()?->getCode() ?? '—' }}
                                </strong>
                            </dd>
                        </div>

                        <div class="record-information-item">
                            <dt>{{ __('payment.method') }}</dt>

                            <dd>
                                {{ $payment->getMethodLabel() }}
                            </dd>
                        </div>

                        <div class="record-information-item">
                            <dt>{{ __('payment.transaction_code') }}</dt>

                            <dd class="record-reference">
                                {{ $payment->getTransactionCode() }}
                            </dd>
                        </div>
                    </dl>

                    <footer class="record-card-footer">
                        <div class="record-total">
                            <span>{{ __('payment.amount') }}</span>

                            <strong>
                                ${{ number_format($payment->getAmount(), 0, app()->getLocale() === 'es' ? ',' : '.', app()->getLocale() === 'es' ? '.' : ',') }}
                            </strong>
                        </div>

                        <a
                            href="{{ route('admin.payment.show', ['id' => $payment->getId()]) }}"
                            class="record-button record-button-primary"
                        >
                            {{ __('payment.view_details') }}
                            <span aria-hidden="true">→</span>
                        </a>
                    </footer>
                </article>
            @empty
                <div class="record-empty" role="status">
                    <p>{{ __('payment.no_payments') }}</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection