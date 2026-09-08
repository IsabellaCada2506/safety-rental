{{--
    Author: Alejandro
    Date: 07/09/2026
    Description: Administrator navigation with management links and logout.
--}}

<nav
    class="navbar navbar-expand-lg safety-navbar admin-navbar"
    aria-label="{{ __('admin.administration') }}"
>
    <div class="container">
        <a
            class="navbar-brand"
            href="{{ route('admin.dashboard.index') }}"
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

        <div class="admin-navigation">
            <a
                class="btn-pill-ghost"
                href="{{ route('admin.dashboard.index') }}"
            >
                {{ __('admin.dashboard') }}
            </a>

            <a
                class="btn-pill-ghost"
                href="{{ route('admin.dashboard.index') }}#admin-vehicles"
            >
                {{ __('admin.vehicles') }}
            </a>

            <a
                class="btn-pill-ghost"
                href="{{ route('admin.dashboard.index') }}#admin-reservations"
            >
                {{ __('admin.reservations') }}
            </a>

            <a
                class="btn-pill-ghost"
                href="{{ route('admin.dashboard.index') }}#admin-locations"
            >
                {{ __('admin.locations') }}
            </a>

            <a
                class="btn-pill-ghost"
                href="{{ route('admin.dashboard.index') }}#admin-metrics"
            >
                {{ __('admin.metrics') }}
            </a>

            <form
                class="logout-form"
                method="POST"
                action="{{ route('auth.logout') }}"
            >
                @csrf

                <button
                    class="btn-logout"
                    type="submit"
                >
                    {{ __('admin.logout') }}
                </button>
            </form>
        </div>
    </div>
</nav>
