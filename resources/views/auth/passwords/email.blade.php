{{--
    Author: Isabella Cadavid Posada
    Date: 2026-09-11
    Description: View for requesting a password reset link by email.
--}}

@extends('layouts.app')

@section('content')
    <section class="simple-page">
        <div class="simple-card">
            <div class="card-header">
                {{ __('authentication.forgot_password') }}
            </div>

            <div class="card-body">
                <p class="authentication-description">
                    {{ __('authentication.forgot_password_description') }}
                </p>

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label" for="email">
                            {{ __('authentication.email') }}
                        </label>

                        <input
                            id="email"
                            class="form-control @error('email') is-invalid @enderror"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
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

                    <button class="btn authentication-button w-100" type="submit">
                        {{ __('authentication.send_reset_link') }}
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection
