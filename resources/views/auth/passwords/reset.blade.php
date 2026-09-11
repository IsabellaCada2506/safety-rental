{{--
    Author: Isabella Cadavid Posada
    Date: 2026-09-06
    Description: View for submitting a new password using a reset token.
--}}

@extends('layouts.app')

@section('content')
    <section class="simple-page">
        <div class="road-line" aria-hidden="true"></div>

        <div class="simple-card">
            <div class="card-header">
                {{ __('authentication.reset_password') }}
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input name="token" type="hidden" value="{{ $viewData['token'] }}">

                    <div class="mb-4">
                        <label class="form-label" for="email">
                            {{ __('authentication.email') }}
                        </label>

                        <input
                            id="email"
                            class="form-control @error('email') is-invalid @enderror"
                            name="email"
                            type="email"
                            value="{{ old('email', $viewData['email']) }}"
                            autocomplete="email"
                            required
                            autofocus
                        >

                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="password">
                            {{ __('authentication.new_password') }}
                        </label>

                        <input
                            id="password"
                            class="form-control @error('password') is-invalid @enderror"
                            name="password"
                            type="password"
                            autocomplete="new-password"
                            required
                        >

                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="password_confirmation">
                            {{ __('authentication.confirm_password') }}
                        </label>

                        <input
                            id="password_confirmation"
                            class="form-control"
                            name="password_confirmation"
                            type="password"
                            autocomplete="new-password"
                            required
                        >
                    </div>

                    <button class="btn authentication-button w-100" type="submit">
                        {{ __('authentication.reset_password') }}
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection
