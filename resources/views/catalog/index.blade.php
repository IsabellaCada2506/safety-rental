{{--
    Author: Wendy Atehortua
    Date: 2026-09-10
    Description: This view displays the list of vehicles available for rent in the catalog. It shows each vehicle's image, brand, model, mileage, and price per day. Users can click on a vehicle to view its details.
--}}

@extends('layouts.app')

@section('content')
<div class="container py-5 catalog-page">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="fw-bold text-dark">{{ __('catalog.title') }}</h1>
            <p class="text-muted">{{ __('catalog.subtitle') }}</p>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 g-4">
        @forelse ($viewData['cars'] as $car)
            <div class="col">
                <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden">
                    <x-car-image
                        :image="$car->getImage()"
                        class="card-img-top object-fit-cover catalog-card-image"
                    />

                    <div class="card-body d-flex flex-column justify-content-between p-4">
                        <div>
                            <p class="text-muted small mb-1">
                                {{ number_format($car->getMileage(), 0, ',', '.') }} {{ __('catalog.km_unit') }}
                            </p>
                            <h3 class="card-title fw-bold text-dark fs-5 mb-2">
                                {{ optional($car->getCategory())->getBrand() }} {{ optional($car->getCategory())->getModel() }}
                            </h3>
                            <p class="text-primary fw-bold fs-4 mb-3">
                                ${{ number_format($car->getPrice(), 0, ',', '.') }}
                                <span class="fs-6 text-muted fw-normal">{{ __('catalog.per_day') }}</span>
                            </p>
                        </div>
                        <div>
                            <a href="{{ route('catalog.show', ['id' => $car->getId()]) }}" class="btn btn-dark w-100 fw-semibold rounded-pill py-2">
                                {{ __('catalog.view_details') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted fs-5">{{ __('catalog.empty') }}</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
