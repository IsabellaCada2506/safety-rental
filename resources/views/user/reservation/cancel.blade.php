{{--
    Author: Wendy Atehortua
    Date: 2026-11-06
    Description: Contextual cancellation survey view for customers with predefined reasons and back action.
--}}

@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
                <div class="text-center mb-4">
                    <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill fw-bold text-uppercase mb-2">
                        {{ __('reservation.cancel_reservation') }}
                    </span>
                    <h1 class="h3 fw-bold text-dark mt-2">
                        {{ __('reservation.cancel_survey_title', ['code' => $viewData['reservation']->getCode()]) }}
                    </h1>
                    <p class="text-muted small">
                        {{ __('reservation.cancel_survey_subtitle') }}
                    </p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger rounded-3" role="alert">
                        <ul class="mb-0 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form
                    action="{{ route('reservations.cancel', ['id' => $viewData['reservation']->getId()]) }}"
                    method="POST"
                >
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <label for="reason" class="form-label fw-semibold text-dark">
                            {{ __('reservation.cancellation_reason_label') }}
                        </label>
                        <select
                            id="reason"
                            name="reason"
                            class="form-select form-select-lg rounded-3"
                            required
                        >
                            <option value="" selected disabled>{{ __('reservation.select_cancellation_reason') }}</option>
                            <option value="{{ __('reservation.reason_plan_change') }}">{{ __('reservation.reason_plan_change') }}</option>
                            <option value="{{ __('reservation.reason_found_cheaper') }}">{{ __('reservation.reason_found_cheaper') }}</option>
                            <option value="{{ __('reservation.reason_trip_cancelled') }}">{{ __('reservation.reason_trip_cancelled') }}</option>
                            <option value="{{ __('reservation.reason_financial') }}">{{ __('reservation.reason_financial') }}</option>
                            <option value="{{ __('reservation.reason_other') }}">{{ __('reservation.reason_other') }}</option>
                        </select>
                    </div>

                    <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between gap-3 mt-4">
                        <a
                            href="{{ route('reservations.show', ['id' => $viewData['reservation']->getId()]) }}"
                            class="btn btn-outline-secondary rounded-pill px-4 py-2 w-100 w-sm-auto order-2 order-sm-1"
                        >
                            &larr; {{ __('general.btn_back') }}
                        </a>

                        <button
                            type="submit"
                            class="btn btn-danger rounded-pill px-4 py-2 fw-semibold w-100 w-sm-auto order-1 order-sm-2 shadow-sm"
                        >
                            {{ __('reservation.confirm_cancellation_btn') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

