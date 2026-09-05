{{-- Author: Isabella Cadavid Posada --}}

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
        href="https://fonts.googleapis.com/css2?family=Anton&family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <link
        href="{{ asset('css/authentication.css') }}"
        rel="stylesheet"
    >
</head>

<body>
    <nav class="navbar navbar-expand-lg safety-navbar">
        <div class="container">
            <a
                class="navbar-brand"
                href="{{ route('welcome.index') }}"
            >
                <span class="brand-mark" aria-hidden="true">
                    <svg
                        viewBox="0 0 32 36"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M16 2 L29 7V17C29 25 23.5 31 16 34C8.5 31 3 25 3 17V7Z"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linejoin="round"
                        />
                        <path
                            d="M9 20 L11.5 14.5C12 13.4 13 12.7 14.2 12.7H17.8C19 12.7 20 13.4 20.5 14.5L23 20"
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

                {{ __('authentication.application_name') }}
            </a>

            @auth
                <div class="d-flex align-items-center gap-3">
                    <span class="navbar-user">
                        {{ __('authentication.signed_in_as') }}

                        <strong>
                            {{ auth()->user()->getName() }}
                        </strong>
                    </span>

                    <form
                        method="POST"
                        action="{{ route('auth.logout') }}"
                    >
                        @csrf

                        <button
                            class="btn-logout btn-sm"
                            type="submit"
                        >
                            {{ __('authentication.logout') }}
                        </button>
                    </form>
                </div>
            @else
                <div class="nav-guest">
                    <a href="{{ route('login') }}">
                        {{ __('authentication.login') }}
                    </a>

                    <a
                        class="btn-pill-solid"
                        href="{{ route('register') }}"
                    >
                        {{ __('authentication.create_account') }}
                    </a>
                </div>
            @endauth
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="safety-footer">
        <div class="container safety-footer-inner">
            <span
                class="brand-mark brand-mark-sm"
                aria-hidden="true"
            >
                <svg
                    viewBox="0 0 32 36"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M16 2 L29 7V17C29 25 23.5 31 16 34C8.5 31 3 25 3 17V7Z"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linejoin="round"
                    />
                    <path
                        d="M9 20 L11.5 14.5C12 13.4 13 12.7 14.2 12.7H17.8C19 12.7 20 13.4 20.5 14.5L23 20"
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
                </svg>
            </span>

            <span>
                {{ __('authentication.application_name') }}
            </span>
        </div>
    </footer>
</body>
</html>