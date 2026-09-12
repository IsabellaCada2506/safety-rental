{{--
    Author: Isabella Ocampo
    Date: 2026-09-11
    Description: Reservation creation view allowing customer to select branch and rental dates.
--}}

@extends('layouts.app')

@section('content')
<div class="container py-5 catalog-page">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="fw-bold fs-3 text-dark mb-1">{{ $viewData['title'] }}</h1>
                    <p class="text-muted small mb-0">{{ __('catalog.title_show') }}</p>
                </div>
                <a href="{{ route('catalog.show', ['id' => $viewData['car']->getId()]) }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    &larr; {{ __('catalog.back') }}
                </a>
            </div>

            @if ($errors->has('conflict'))
                <div class="alert alert-danger rounded-4 shadow-sm mb-4" role="alert">
                    <strong>{{ __('reservation.car_unavailable') }}</strong>
                    <div class="mt-1 small">{{ $errors->first('conflict') }}</div>
                </div>
            @endif

            <div class="row g-4">
                {{-- Vehicle Details Card --}}
                <div class="col-md-5">
                    <div class="card shadow-sm border-0 rounded-4 overflow-hidden bg-white h-100">
                        <x-car-image
                            :image="$viewData['car']->getImage()"
                            class="card-img-top object-fit-cover"
                            style="height: 220px;"
                        />
                        <div class="card-body p-4">
                            <h4 class="fw-bold text-dark mb-1">
                                {{ optional($viewData['car']->getCategory())->getBrand() }} {{ optional($viewData['car']->getCategory())->getModel() }}
                            </h4>
                            <p class="text-muted small mb-3">
                                {{ optional($viewData['car']->getCategory())->getType() }} | {{ ucfirst($viewData['car']->getColor()) }} | {{ __('catalog.plate_label') }}: <strong>{{ $viewData['car']->getPlate() }}</strong>
                            </p>

                            <div class="bg-light p-3 rounded-3 mb-3 small">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">{{ __('catalog.passengers_label') }}:</span>
                                    <span class="fw-semibold">{{ optional($viewData['car']->getCategory())->getPassengerCapacity() }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">{{ __('catalog.luggage_label') }}:</span>
                                    <span class="fw-semibold">{{ optional($viewData['car']->getCategory())->getLuggageCapacity() }} {{ __('catalog.units') }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">{{ __('reservation.daily_rate') }}:</span>
                                    <span class="fw-bold text-dark fs-6">${{ number_format($viewData['car']->getPrice(), 0, ',', '.') }}</span>
                                </div>
                            </div>

                            @if($viewData['car']->getDescription())
                                <p class="text-muted small mb-0">{{ $viewData['car']->getDescription() }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Reservation Form --}}
                <div class="col-md-7">
                    <div class="card shadow-sm border-0 rounded-4 bg-white p-4">
                        <form action="{{ route('reservations.store') }}" method="POST" id="reservationForm">
                            @csrf
                            <input type="hidden" name="car_id" value="{{ $viewData['car']->getId() }}">

                            <div class="mb-3">
                                <label for="location_id" class="form-label fw-semibold small text-dark">
                                    {{ __('reservation.pickup_location') }} <span class="text-danger">*</span>
                                </label>
                                <select
                                    name="location_id"
                                    id="location_id"
                                    class="form-select rounded-3 @error('location_id') is-invalid @enderror"
                                    required
                                >
                                    <option value="" disabled {{ old('location_id') ? '' : 'selected' }}>
                                        -- {{ __('reservation.select_location') }} --
                                    </option>
                                    @foreach ($viewData['locations'] as $location)
                                        <option
                                            value="{{ $location->getId() }}"
                                            {{ old('location_id') == $location->getId() ? 'selected' : '' }}
                                        >
                                            {{ $location->getName() }} ({{ $location->getCity() }} - {{ $location->getAddress() }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('location_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-sm-6">
                                    <label for="start_date" class="form-label fw-semibold small text-dark">
                                        {{ __('reservation.start_date') }} <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="date"
                                        name="start_date"
                                        id="start_date"
                                        class="form-control rounded-3 @error('start_date') is-invalid @enderror"
                                        value="{{ old('start_date', date('Y-m-d')) }}"
                                        min="{{ date('Y-m-d') }}"
                                        required
                                    >
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-6">
                                    <label for="end_date" class="form-label fw-semibold small text-dark">
                                        {{ __('reservation.end_date') }} <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="date"
                                        name="end_date"
                                        id="end_date"
                                        class="form-control rounded-3 @error('end_date') is-invalid @enderror"
                                        value="{{ old('end_date', date('Y-m-d', strtotime('+3 days'))) }}"
                                        min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                        required
                                    >
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Live Cost Calculation Box --}}
                            <div class="bg-light p-3 rounded-4 mb-4 border">
                                <h6 class="fw-bold text-dark mb-2">{{ __('reservation.summary_heading') }}</h6>
                                <div class="d-flex justify-content-between small text-muted mb-1">
                                    <span>{{ __('reservation.rental_days') }}:</span>
                                    <span id="previewDays" class="fw-semibold text-dark">1 {{ __('reservation.days_unit') }}</span>
                                </div>
                                <div class="d-flex justify-content-between small text-muted mb-2">
                                    <span>{{ __('reservation.daily_rate') }}:</span>
                                    <span class="fw-semibold text-dark">${{ number_format($viewData['car']->getPrice(), 0, ',', '.') }}</span>
                                </div>
                                <hr class="my-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-dark">{{ __('reservation.total_price') }}:</span>
                                    <span id="previewTotal" class="fw-bold text-primary fs-5">${{ number_format($viewData['car']->getPrice(), 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold rounded-pill shadow-sm">
                                {{ __('reservation.confirm_booking') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const previewDays = document.getElementById('previewDays');
        const previewTotal = document.getElementById('previewTotal');
        const dailyPrice = {{ $viewData['car']->getPrice() }};

        function recalculate() {
            const startVal = startDateInput.value;
            const endVal = endDateInput.value;

            if (startVal && endVal) {
                const start = new Date(startVal);
                const end = new Date(endVal);
                const diffTime = end - start;
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                if (diffDays > 0) {
                    previewDays.textContent = diffDays + ' {{ __("reservation.days_unit") }}';
                    const total = diffDays * dailyPrice;
                    previewTotal.textContent = '$' + total.toLocaleString('es-CO');
                } else {
                    previewDays.textContent = '1 {{ __("reservation.days_unit") }}';
                    previewTotal.textContent = '$' + dailyPrice.toLocaleString('es-CO');
                }
            }
        }

        startDateInput.addEventListener('change', function () {
            endDateInput.min = this.value;
            recalculate();
        });

        endDateInput.addEventListener('change', recalculate);
        recalculate();
    });
</script>
@endpush
@endsection
