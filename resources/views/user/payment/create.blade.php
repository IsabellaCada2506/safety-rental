{{--
    Author: Isabella Cadavid Posada
    Author: Alejandro Correa Marin
    Date: 2026-11-05
    Description: Customer form for recording a simulated reservation payment.
--}}

@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<div class="container py-5 catalog-page">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="fw-bold fs-3 text-dark mb-1">{{ $viewData['title'] }}</h1>
                    <p class="text-muted small mb-0">{{ __('payment.subtitle') }}</p>
                </div>
                <a href="{{ route('reservations.show', ['id' => $viewData['reservation']->getId()]) }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    &larr; {{ __('general.btn_back') }}
                </a>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger rounded-4 shadow-sm mb-4" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card shadow-sm border-0 rounded-4 bg-white mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between small text-muted mb-2">
                        <span>{{ __('payment.reservation') }}</span>
                        <strong class="text-dark">#{{ $viewData['reservation']->getCode() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between small text-muted mb-2">
                        <span>{{ __('payment.vehicle') }}</span>
                        <strong class="text-dark">
                            {{ optional($viewData['reservation']->getCar()?->getCategory())->getBrand() }}
                            {{ optional($viewData['reservation']->getCar()?->getCategory())->getModel() }}
                        </strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-dark">{{ __('payment.approved_amount') }}</span>
                        <span class="fw-bold text-primary fs-4">${{ number_format($viewData['approvedAmount'], 0, app()->getLocale() === 'es' ? ',' : '.', app()->getLocale() === 'es' ? '.' : ',') }}</span>
                    </div>
                </div>
            </div>

            <form action="{{ route('payments.store', ['id' => $viewData['reservation']->getId()]) }}" method="POST" class="card shadow-sm border-0 rounded-4 bg-white">
                @csrf
                <div class="card-body p-4">
                    <h2 class="fw-bold fs-5 text-dark mb-3">{{ __('payment.heading') }}</h2>

                    <div class="mb-3">
                        <label for="method" class="form-label fw-semibold">{{ __('payment.method') }}</label>
                        <select id="method" name="method" class="form-select rounded-3 @error('method') is-invalid @enderror" @error('method') aria-invalid="true" aria-describedby="method-error" @enderror>
                            <option value="">{{ __('payment.select_method') }}</option>
                            @foreach ($viewData['methodOptions'] as $method => $methodLabel)
                                <option value="{{ $method }}" @selected(old('method') === $method)>
                                    {{ $methodLabel }}
                                </option>
                            @endforeach
                        </select>
                        @error('method')
                            <div id="method-error" class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <fieldset class="mb-4">
                        <legend class="form-label fw-semibold">{{ __('payment.simulated_result') }}</legend>
                        <div class="form-check">
                            <input
                                class="form-check-input @error('simulated_result') is-invalid @enderror"
                                type="radio"
                                name="simulated_result"
                                @error('simulated_result')
                                    aria-invalid="true"
                                    aria-describedby="simulated-result-error"
                                @enderror
                                id="simulated_result_success"
                                value="success"
                                @checked(old('simulated_result', 'success') === 'success')
                            >
                            <label class="form-check-label" for="simulated_result_success">
                                {{ __('payment.simulate_success') }}
                            </label>
                        </div>
                        <div class="form-check">
                            <input
                                class="form-check-input @error('simulated_result') is-invalid @enderror"
                                type="radio"
                                name="simulated_result"
                                @error('simulated_result')
                                    aria-invalid="true"
                                    aria-describedby="simulated-result-error"
                                @enderror
                                id="simulated_result_failure"
                                value="failure"
                                @checked(old('simulated_result') === 'failure')
                            >
                            <label class="form-check-label" for="simulated_result_failure">
                                {{ __('payment.simulate_failure') }}
                            </label>
                        </div>
                        @error('simulated_result')
                            <div id="simulated-result-error" class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </fieldset>

                    <button type="submit" class="btn btn-dark w-100 rounded-pill py-2 fw-semibold">
                        {{ __('payment.submit_payment') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
