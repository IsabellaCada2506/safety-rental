{{--
    Author: Isabella Cadavid Posada
    Author: Alejandro Correa Marin
    Date: 2026-11-04
    Description: Shared layout with Manrope typography, blue theme, consistent favicon and accessible navigation.
--}}

@if (isset($viewData) && ! empty($viewData['isPrintableDocument']))
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <link
        rel="icon"
        type="image/png"
        href="{{ asset('images/favicon.png') }}?v=1"
    >

    <title>
        {{ $viewData['title'] ?? __('authentication.application_name') }}
    </title>

    @stack('styles')
</head>
<body>
    @yield('content')
</body>
</html>
@else
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <link
        rel="icon"
        type="image/png"
        href="{{ asset('images/favicon.png') }}?v=1"
    >

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        {{ $viewData['title'] ?? __('authentication.application_name') }}
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    @include('layouts.partials.styles')
</head>
<body>
    <a class="skip-link" href="#main-content">
        {{ __('general.skip_to_content') }}
    </a>

    @include('components.navigation.navbar')

    <main id="main-content" tabindex="-1">
        @yield('content')
    </main>

    <footer class="safety-footer">
        <div class="container safety-footer-inner">
            <span
                class="brand-mark brand-mark-sm"
                aria-hidden="true"
            >
                <svg
                    width="20"
                    height="22"
                    viewBox="0 0 32 36"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M16 2L29 7V17C29 25 23.5 31 16 34C8.5 31 3 25 3 17V7Z"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linejoin="round"
                    />

                    <path
                        d="M9 20L11.5 14.5C12 13.4 13 12.7 14.2 12.7H17.8C19 12.7 20 13.4 20.5 14.5L23 20"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />

                    <path
                        d="M8 20H24V23C24 23.6 23.6 24 23 24H21.5C20.9 24 20.5 23.6 20.5 23V22H11.5V23C11.5 23.6 11.1 24 10.5 24H9C8.4 24 8 23.6 8 23V20Z"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linejoin="round"
                    />

                    <circle
                        cx="12"
                        cy="22.5"
                        r="1.3"
                        fill="currentColor"
                    />

                    <circle
                        cx="20"
                        cy="22.5"
                        r="1.3"
                        fill="currentColor"
                    />
                </svg>
            </span>

            <span>
                {{ __('authentication.application_name') }}
            </span>

            <span aria-hidden="true">·</span>

            <span>
                {{ __('general.footer_rights') }}
            </span>
        </div>
    </footer>

    @if (request()->routeIs('reservations.show', 'admin.reservation.show', 'admin.payment.show'))
        <script
            src="{{ asset('js/components/confirm.js') }}?v=1"
            defer
        ></script>
    @endif

    @stack('scripts')
</body>
</html>
@endif