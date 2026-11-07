{{--
    Author: Isabella Cadavid Posada
    Date: 2026-09-06
    Description: View for editing the authenticated user's profile.
--}}

@extends('layouts.app')

@section('title', $viewData['title'])

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
                    class="btn btn-outline-secondary btn-sm rounded-pill px-3 mb-3 d-inline-block text-decoration-none"
                    href="{{ route('profile.index') }}"
                >
                    &larr; {{ __('general.btn_back') }}
                </a>

                <div class="profile-edit-hero-content">
                    <div>
                        <span class="profile-edit-eyebrow">
                            {{ __('authentication.user_area') }}
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

                @include('user.profile.partials.form')

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