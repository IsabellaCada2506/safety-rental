{{--
    Author: Isabella Cadavid Posada
    Date: 2026-09-11
    Description: View prompting the user to verify their email address.
--}}

@extends('layouts.app')

@section('content')
    <section class="simple-page">
        <div class="simple-card">
            <div class="card-header">
                {{ __('authentication.verify_email') }}
            </div>

            <div class="card-body">
                @if (session('status') === 'verification-link-sent')
                    <div class="alert alert-success mb-4" role="alert">
                        {{ __('authentication.verification_sent') }}
                    </div>
                @endif

                <p>
                    {{ __('authentication.verification_instructions') }}
                </p>

                <form
                    method="POST"
                    action="{{ route('verification.send') }}"
                >
                    @csrf

                    <button
                        class="btn authentication-button"
                        type="submit"
                    >
                        {{ __('authentication.resend_verification') }}
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection