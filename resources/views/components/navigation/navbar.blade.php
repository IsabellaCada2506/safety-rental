{{--
    Author: Isabella Cadavid Posada
    Date: 2026-09-06
    Description: Navigation bar for authenticated users and guests in the Safety Rental application.
--}}

<nav class="navbar navbar-expand-lg safety-navbar">
    <div class="container">
        <a
            class="navbar-brand"
            href="{{ route('welcome.index') }}"
        >
            <span class="brand-mark" aria-hidden="true">
                <svg
                    width="26"
                    height="28"
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

            {{ __('authentication.application_name') }}
        </a>

        @auth
            <div class="nav-authenticated d-flex align-items-center gap-3">
                @if (! auth()->user()->isAdmin())
                    <a
                        class="btn-pill-ghost text-decoration-none"
                        href="{{ route('home.index') }}"
                    >
                        {{ __('authentication.home') }}
                    </a>

                    <a
                        class="btn-pill-ghost text-decoration-none"
                        href="{{ route('catalog.index') }}"
                    >
                        {{ __('catalog.title') }}
                    </a>

                    <a
                        class="btn-pill-solid profile-navigation-button"
                        href="{{ route('profile.index') }}"
                        aria-label="{{ __('authentication.profile') }}"
                        title="{{ __('authentication.profile') }}"
                    >
                        <svg
                            width="20"
                            height="20"
                            viewBox="0 0 24 24"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true"
                        >
                            <circle
                                cx="12"
                                cy="8"
                                r="4"
                                stroke="currentColor"
                                stroke-width="1.8"
                            />

                            <path
                                d="M4.5 21C4.5 16.6 7.9 13.5 12 13.5C16.1 13.5 19.5 16.6 19.5 21"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                            />
                        </svg>
                    </a>
                @else
                    <a
                        class="btn-pill-ghost text-decoration-none"
                        href="{{ route('admin.dashboard.index') }}"
                    >
                        {{ __('authentication.dashboard') }}
                    </a>

                    <a
                        class="btn-pill-ghost text-decoration-none"
                        href="{{ route('admin.car.index') }}"
                    >
                        {{ __('car.manage_cars') }}
                    </a>

                    <a
                        class="btn-pill-ghost text-decoration-none"
                        href="{{ route('admin.category.index') }}"
                    >
                        {{ __('category.manage_categories') }}
                    </a>
                @endif

                <form
                    class="logout-form m-0"
                    method="POST"
                    action="{{ route('auth.logout') }}"
                >
                    @csrf

                    <button
                        class="btn-logout"
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