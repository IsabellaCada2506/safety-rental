{{--
    Author: Alejandro Correa Marin
    Author: Wendy Atehortua
    Date: 2026-09-13
    Description: Admin detail view for a payment record with optional refund action.
--}}

@extends('layouts.app')

@section('title', $viewData['title'])

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
            </div>

            <a href="{{ route('admin.payment.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                &larr; {{ __('payment.back_to_admin_list') }}
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

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-4 bg-white p-4 mb-4">
                    <h4 class="fw-bold text-dark mb-3">{{ __('payment.heading') }}</h4>
                    <div class="row g-3 small">
                        <div class="col-sm-6">
                            <span class="text-muted d-block">{{ __('payment.payment_code') }}</span>
                            <strong class="text-dark">#{{ $viewData['payment']->getCode() }}</strong>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted d-block">{{ __('payment.status') }}</span>
                            <span class="badge {{ $viewData['payment']->getStatusBadgeClass() }} px-2 py-1 rounded-pill">
                                {{ __('payment.status_' . $viewData['payment']->getStatus()) }}
                            </span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted d-block">{{ __('payment.amount') }}</span>
                            <strong class="text-dark">${{ number_format($viewData['payment']->getAmount(), 0, ',', '.') }}</strong>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted d-block">{{ __('payment.method') }}</span>
                            <strong class="text-dark">{{ $viewData['payment']->getMethodLabel() }}</strong>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted d-block">{{ __('payment.transaction_code') }}</span>
                            <strong class="text-dark">{{ $viewData['payment']->getTransactionCode() }}</strong>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted d-block">{{ __('payment.date') }}</span>
                            <strong class="text-dark">{{ $viewData['payment']->getDate()?->format('d/m/Y') }}</strong>
                        </div>
                    </div>
                </div>

                @if ($viewData['reservation'])
                    <div class="card shadow-sm border-0 rounded-4 bg-white p-4">
                        <h5 class="fw-bold text-dark mb-3">{{ __('payment.reservation') }}</h5>
                        <div class="row g-3 small">
                            <div class="col-sm-6">
                                <span class="text-muted d-block">{{ __('reservation.reservation_code') }}</span>
                                <strong class="text-dark">#{{ $viewData['reservation']->getCode() }}</strong>
                            </div>
                            <div class="col-sm-6">
                                <span class="text-muted d-block">{{ __('payment.customer') }}</span>
                                <strong class="text-dark">
                                    {{ $viewData['reservation']->getUser()?->getName() }}
                                    {{ $viewData['reservation']->getUser()?->getLastName() }}
                                </strong>
                            </div>
                            <div class="col-sm-6">
                                <span class="text-muted d-block">{{ __('payment.vehicle') }}</span>
                                <strong class="text-dark">
                                    {{ optional($viewData['reservation']->getCar()?->getCategory())->getBrand() }}
                                    {{ optional($viewData['reservation']->getCar()?->getCategory())->getModel() }}
                                </strong>
                            </div>
                            <div class="col-sm-6">
                                <span class="text-muted d-block">{{ __('reservation.total_price') }}</span>
                                <strong class="text-dark">${{ number_format($viewData['reservation']->getTotalPrice(), 0, ',', '.') }}</strong>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm border-0 rounded-4 bg-white p-4">
                    <h5 class="fw-bold text-dark mb-3">{{ __('payment.actions') }}</h5>
                    @if ($viewData['payment']->isCompleted())
                        <form
                            action="{{ route('admin.payment.refund', ['id' => $viewData['payment']->getId()]) }}"
                            method="POST"
                            onsubmit="return confirm('{{ __('payment.refund_confirm') }}');"
                        >
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline-danger w-100 py-2 rounded-pill fw-semibold">
                                {{ __('payment.refund_payment') }}
                            </button>
                        </form>
                    @endif

                    @if ($viewData['reservation'])
                        <a
                            href="{{ route('admin.reservation.show', ['id' => $viewData['reservation']->getId()]) }}"
                            class="btn btn-outline-dark w-100 py-2 rounded-pill fw-semibold mt-2"
                        >
                            {{ __('payment.back_to_reservation') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
