{{--
    Author: Alejandro Correa Marin
    Date: 2026-09-12
    Description: Admin view showing the top three most rented cars and a date range filter.
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
                    {{ __('ranking.subtitle') }}
                </p>
            </div>

            <a href="{{ route('admin.dashboard.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                &larr; {{ __('authentication.dashboard') }}
            </a>
        </header>

        @if ($errors->any())
            <div class="alert alert-danger admin-alert" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="GET" action="{{ route('admin.ranking.index') }}" class="card shadow-sm border-0 rounded-4 bg-white p-4 mb-4">
            @csrf
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="start_date" class="form-label fw-semibold">{{ __('ranking.start_date') }}</label>
                    <input
                        type="date"
                        id="start_date"
                        name="start_date"
                        class="form-control"
                        value="{{ $viewData['startDate'] }}"
                    >
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label fw-semibold">{{ __('ranking.end_date') }}</label>
                    <input
                        type="date"
                        id="end_date"
                        name="end_date"
                        class="form-control"
                        value="{{ $viewData['endDate'] }}"
                    >
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-dark rounded-pill fw-semibold px-4">
                        {{ __('ranking.apply_filter') }}
                    </button>
                    <a href="{{ route('admin.ranking.index') }}" class="btn btn-outline-secondary rounded-pill fw-semibold px-4">
                        {{ __('ranking.clear_filter') }}
                    </a>
                </div>
            </div>
        </form>

        @if (count($viewData['rankings']) === 0)
            <div class="card shadow-sm border-0 rounded-4 text-center py-5 bg-white">
                <div class="card-body">
                    <p class="text-muted mb-0">{{ __('ranking.empty') }}</p>
                </div>
            </div>
        @else
            <div class="admin-index-table-wrapper">
                <table class="admin-index-table">
                    <thead>
                        <tr>
                            <th>{{ __('ranking.position') }}</th>
                            <th>{{ __('ranking.vehicle') }}</th>
                            <th>{{ __('ranking.plate') }}</th>
                            <th>{{ __('ranking.rental_count') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($viewData['rankings'] as $ranking)
                            <tr>
                                <td>
                                    <strong>#{{ $ranking['position'] }}</strong>
                                </td>
                                <td>
                                    {{ optional($ranking['car']->getCategory())->getBrand() }}
                                    {{ optional($ranking['car']->getCategory())->getModel() }}
                                </td>
                                <td>{{ $ranking['car']->getPlate() }}</td>
                                <td>
                                    <strong>{{ $ranking['rentalCount'] }}</strong>
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
