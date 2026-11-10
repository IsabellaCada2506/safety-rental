@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<section class="admin-page">
    <div class="container admin-container">
        <header class="admin-header">
            <div>
                <span class="admin-eyebrow">
                    {{ __('location.admin_area') }}
                </span>

                <h1 class="admin-title">
                    {{ $viewData['title'] }}
                </h1>
            </div>

            <a
                href="{{ route('admin.location.index') }}"
                class="integration-button integration-button-secondary"
            >
                {{ __('general.btn_back') }}
            </a>
        </header>

        @if ($errors->any())
            <div class="alert alert-danger rounded-4" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="admin-form-card">
            <form
                method="POST"
                action="{{ route('admin.location.update', ['id' => $viewData['location']->getId()]) }}"
            >
                @csrf
                @method('PUT')

                @include('admin.location.partials.fields')

                <div class="admin-form-actions">
                    <a
                        href="{{ route('admin.location.index') }}"
                        class="admin-form-cancel-btn"
                    >
                        {{ __('location.btn_cancel') }}
                    </a>

                    <button
                        type="submit"
                        class="admin-form-save-btn"
                    >
                        {{ __('location.btn_update') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection