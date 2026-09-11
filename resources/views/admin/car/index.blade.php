@extends('layouts.app')

@section('content')
<div style="background: linear-gradient(135deg, #6b240c, #2a0a03); min-height: 100vh; color: #ffffff; padding-top: 4rem; padding-bottom: 4rem;">
    <div class="container">
        <div class="mb-5">
            <span class="badge rounded-pill text-dark px-3 py-2 mb-3 fw-bold" style="background-color: #ffb037; font-size: 0.85rem;">
                Admin area
            </span>
            
            <div class="d-flex align-items-center mb-2">
                <h1 class="fw-bold mb-0 me-4" style="font-size: 3.5rem; letter-spacing: -1px;">
                    {{ __('car.heading_management') }}
                </h1>
                <div class="flex-grow-1" style="border-bottom: 2px dashed rgba(255, 255, 255, 0.2);"></div>
            </div>

            <p style="color: rgba(255, 255, 255, 0.7); font-size: 1.1rem; margin-bottom: 2.5rem;">
                {{ __('car.registered_vehicles') }}
            </p>
            
            <a href="{{ route('admin.car.create') }}" class="d-inline-flex align-items-center text-decoration-none" style="background-color: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 50px; padding: 0.4rem 1.5rem 0.4rem 0.4rem; color: #ffffff;">
                <span class="rounded-circle d-flex justify-content-center align-items-center me-3 text-dark fw-bold" style="background-color: #ffb037; width: 32px; height: 32px; font-size: 1.2rem;">+</span>
                <span class="fw-semibold">{{ __('car.btn_create') }}</span>
            </a>
        </div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="background-color: rgba(25, 135, 84, 0.2); border: 1px solid #198754; color: #fff;">
                {{ session('success') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        <div class="table-responsive mt-5">
            <table class="table text-white align-middle" style="background-color: transparent;">
                <thead style="border-bottom: 2px solid rgba(255,255,255,0.2);">
                    <tr>
                        <th class="text-white bg-transparent border-0 py-3">{{ __('car.id') }}</th>
                        <th class="text-white bg-transparent border-0 py-3">{{ __('car.plate') }}</th>
                        <th class="text-white bg-transparent border-0 py-3">{{ __('car.color') }}</th>
                        <th class="text-white bg-transparent border-0 py-3">{{ __('car.soat') }}</th>
                        <th class="text-white bg-transparent border-0 py-3">{{ __('car.price_per_day') }}</th>
                        <th class="text-white bg-transparent border-0 py-3">{{ __('car.mileage') }}</th>
                        <th class="text-white bg-transparent border-0 py-3">{{ __('car.status') }}</th>
                        <th class="text-white bg-transparent border-0 py-3 text-center">{{ __('car.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($viewData['cars'] as $car)
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.08);">
                            <td class="text-white bg-transparent border-0 py-3 fw-bold" style="color: #ffb037 !important;">#{{ $car->getId() }}</td>
                            <td class="text-white bg-transparent border-0 py-3">{{ $car->getPlate() }}</td>
                            <td class="text-white bg-transparent border-0 py-3">{{ $car->getColor() }}</td>
                            <td class="text-white bg-transparent border-0 py-3">{{ $car->getSoat() }}</td>
                            <td class="text-white bg-transparent border-0 py-3">${{ number_format($car->getPrice(), 0, ',', '.') }}</td>
                            <td class="text-white bg-transparent border-0 py-3">{{ number_format($car->getMileage(), 0, ',', '.') }} km</td>
                            <td class="text-white bg-transparent border-0 py-3">
                                <span class="badge rounded-pill text-dark" style="background-color: #ffb037;">{{ $car->getStatus() }}</span>
                            </td>

                            
                            <td class="text-white bg-transparent border-0 py-3 text-center">
                                <a href="{{ route('admin.car.edit', ['id' => $car->getId()]) }}" class="btn btn-sm rounded-pill px-3 me-1" style="background-color: rgba(255,255,255,0.1); color: #ffffff; border: 1px solid rgba(255,255,255,0.2);">
                                    {{ __('car.btn_edit') }}
                                </a>
                                <form action="{{ route('admin.car.deactivate', ['id' => $car->getId()]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('{{ __('car.confirm_status_change') }}')">
                                        {{ __('car.btn_deactivate') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-white bg-transparent border-0" style="opacity: 0.5;">
                                {{ __('car.no_cars_found') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection