{{-- Author: Isabella Cadavid Posada --}}

@extends('layouts.app')

@push('styles')
    <link
        href="{{ asset('css/pages/profile-edit.css') }}?v=4"
        rel="stylesheet"
    >
@endpush

@section('content')
    <section class="profile-edit-page">
        <div
            class="profile-edit-orb profile-edit-orb-left"
            aria-hidden="true"
        ></div>

        <div
            class="profile-edit-orb profile-edit-orb-right"
            aria-hidden="true"
        ></div>

        <div class="container profile-edit-container">
            <header class="profile-edit-hero">
                <a
                    class="profile-edit-back"
                    href="{{ route('profile.index') }}"
                >
                    <span aria-hidden="true">←</span>

                    {{ __('authentication.back_to_profile') }}
                </a>

                <div class="profile-edit-hero-content">
                    <div>
                        <span class="profile-edit-eyebrow">
                            {{ __('authentication.customer_area') }}
                        </span>

                        <h1>
                            {{ $viewData['title'] }}
                        </h1>

                        <p>
                            {{ __('authentication.edit_profile_description') }}
                        </p>
                    </div>

                    <div
                        class="profile-edit-avatar"
                        aria-hidden="true"
                    >
                        {{ strtoupper(substr($viewData['user']->getName(), 0, 1)) }}
                        {{ strtoupper(substr($viewData['user']->getLastName() ?? '', 0, 1)) }}
                    </div>
                </div>
            </header>

            <form
                class="profile-edit-form"
                method="POST"
                action="{{ route('profile.update') }}"
            >
                @csrf
                @method('PUT')

                @include('profile.partials.form')

                <footer class="profile-edit-actions">
                    <a
                        class="profile-edit-cancel"
                        href="{{ route('profile.index') }}"
                    >
                        {{ __('authentication.cancel') }}
                    </a>

                    <button
                        class="profile-edit-save"
                        type="submit"
                    >
                        {{ __('authentication.save_changes') }}
                    </button>
                </footer>
            </form>
        </div>
    </section>
@endsection