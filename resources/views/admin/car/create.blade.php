@extends('layouts.app')

@section('content')
<style>
    .custom-input::placeholder {
        color: rgba(255, 255, 255, 0.6) !important;
    }
</style>

<div style="background: linear-gradient(135deg, #6b240c, #2a0a03); min-height: 100vh; color: #ffffff; padding-top: 4rem; padding-bottom: 4rem;">
    <div class="container">
        <div class="mb-5">
            <span class="badge rounded-pill text-dark px-3 py-2 mb-3 fw-bold shadow-sm" style="background-color: #ffb037; font-size: 0.85rem;">
                {{ __('car.title_create') }}
            </span>
            
            <div class="d-flex align-items-center mb-2">
                <h1 class="fw-bold mb-0 me-4" style="font-size: 3rem; letter-spacing: -1px;">
                    {{ __('car.heading_management') }}
                </h1>
                <div class="flex-grow-1" style="border-bottom: 2px dashed rgba(255, 255, 255, 0.2);"></div>
            </div>
        </div>

        {{-- Mostrar errores de validación si el FormRequest rechaza algún dato --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4 shadow" role="alert" style="background-color: rgba(220, 53, 69, 0.2); border: 1px solid #dc3545; color: #fff;">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border-0 shadow-lg" style="background-color: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px); border-radius: 1rem;">
            <div class="card-body p-5">
                {{-- ASEGÚRATE DE QUE LA RUTA SEA EXACTAMENTE admin.car.store --}}
                <form method="POST" action="{{ route('admin.car.store') }}">
                    @csrf
                    
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label text-white fw-bold">{{ __('car.plate_label') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg custom-input" name="plate" value="{{ old('plate') }}" placeholder="{{ __('car.plate_placeholder') }}" style="background-color: rgba(0,0,0,0.4); border: 1px solid rgba(255,255,255,0.2); color: white;" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-white fw-bold">{{ __('car.color_label') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg custom-input" name="color" value="{{ old('color') }}" placeholder="{{ __('car.color_placeholder') }}" style="background-color: rgba(0,0,0,0.4); border: 1px solid rgba(255,255,255,0.2); color: white;" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-white fw-bold">{{ __('car.soat_label') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg custom-input" name="soat" value="{{ old('soat') }}" placeholder="{{ __('car.soat_placeholder') }}" style="background-color: rgba(0,0,0,0.4); border: 1px solid rgba(255,255,255,0.2); color: white;" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-white fw-bold">{{ __('car.transit_license_label') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg custom-input" name="transit_license" value="{{ old('transit_license') }}" placeholder="{{ __('car.transit_license_placeholder') }}" style="background-color: rgba(0,0,0,0.4); border: 1px solid rgba(255,255,255,0.2); color: white;" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-white fw-bold">{{ __('car.price_label') }} <span class="text-danger">*</span></label>
                            <input type="number" class="form-control form-control-lg custom-input" name="price" value="{{ old('price') }}" placeholder="Ej: 80000" style="background-color: rgba(0,0,0,0.4); border: 1px solid rgba(255,255,255,0.2); color: white;" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-white fw-bold">{{ __('car.mileage_label') }} <span class="text-danger">*</span></label>
                            <input type="number" class="form-control form-control-lg custom-input" name="mileage" value="{{ old('mileage') }}" placeholder="{{ __('car.mileage_placeholder') }}" style="background-color: rgba(0,0,0,0.4); border: 1px solid rgba(255,255,255,0.2); color: white;" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-white fw-bold">{{ __('car.image_label') }}</label>
                            <input type="url" class="form-control form-control-lg custom-input" name="image" value="{{ old('image') }}" placeholder="{{ __('car.image_placeholder') }}" style="background-color: rgba(0,0,0,0.4); border: 1px solid rgba(255,255,255,0.2); color: white;">
                        </div>
                        <div class="col-12">
                            <label class="form-label text-white fw-bold">{{ __('car.description_label') }}</label>
                            <textarea class="form-control form-control-lg custom-input" name="description" rows="4" placeholder="{{ __('car.description_placeholder') }}" style="background-color: rgba(0,0,0,0.4); border: 1px solid rgba(255,255,255,0.2); color: white;">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-5">
                        <a href="{{ route('admin.car.index') }}" class="btn btn-outline-light rounded-pill px-4 py-2 fw-semibold">
                            {{ __('car.btn_cancel') }}
                        </a>
                        <button type="submit" class="btn rounded-pill px-5 py-2 fw-bold text-dark shadow-sm" style="background-color: #ffb037;">
                            {{ __('car.btn_create') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection