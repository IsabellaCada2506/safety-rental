{{--
    Author: Isabella Cadavid Posada
    Author: Alejandro Correa Marin
    Author: Wendy Atehortua
    Date: 2026-11-06
    Description: Shared navigation with centered links, grouped profile dropdown with logout, clean language selector, and sticky positioning.
--}}

<nav class="navbar navbar-expand-lg safety-navbar sticky-top">
    <div class="container d-flex align-items-center justify-content-between">
        {{-- Brand / Logo (Left) --}}
        <a
            class="navbar-brand me-4"
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

                    <circle cx="12" cy="22.5" r="1.3" fill="currentColor"/>
                    <circle cx="20" cy="22.5" r="1.3" fill="currentColor"/>
                </svg>
            </span>

            {{ __('authentication.application_name') }}
        </a>

        {{-- Center Navigation Links --}}
        <div class="nav-center-links d-none d-lg-flex align-items-center justify-content-center flex-grow-1 gap-2">
            @auth
                @if (! auth()->user()->isAdmin())
                    <a
                        class="btn-pill-ghost text-decoration-none"
                        href="{{ route('home.index') }}"
                        @if (request()->routeIs('home.index'))
                            aria-current="page"
                        @endif
                    >
                        {{ __('general.nav_home') }}
                    </a>

                    <a
                        class="btn-pill-ghost text-decoration-none"
                        href="{{ route('catalog.index') }}"
                        @if (request()->routeIs('catalog.*'))
                            aria-current="page"
                        @endif
                    >
                        {{ __('general.nav_catalog') }}
                    </a>

                    <a
                        class="btn-pill-ghost text-decoration-none"
                        href="{{ route('locations.index') }}"
                        @if (request()->routeIs('locations.*'))
                            aria-current="page"
                        @endif
                    >
                        {{ __('general.nav_locations') }}
                    </a>

                    <a
                        class="btn-pill-ghost text-decoration-none"
                        href="{{ route('reservations.index') }}"
                        @if (request()->routeIs('reservations.*'))
                            aria-current="page"
                        @endif
                    >
                        {{ __('general.nav_reservations') }}
                    </a>
                @else
                    <a
                        class="btn-pill-ghost text-decoration-none"
                        href="{{ route('admin.dashboard.index') }}"
                        @if (request()->routeIs('admin.dashboard.index'))
                            aria-current="page"
                        @endif
                    >
                        {{ __('authentication.home') }}
                    </a>

                    <a
                        class="btn-pill-ghost text-decoration-none"
                        href="{{ route('admin.car.index') }}"
                        @if (request()->routeIs('admin.car.*'))
                            aria-current="page"
                        @endif
                    >
                        {{ __('general.nav_cars') }}
                    </a>

                    <a
                        class="btn-pill-ghost text-decoration-none"
                        href="{{ route('admin.category.index') }}"
                        @if (request()->routeIs('admin.category.*'))
                            aria-current="page"
                        @endif
                    >
                        {{ __('general.nav_categories') }}
                    </a>

                    <a
                        class="btn-pill-ghost text-decoration-none"
                        href="{{ route('admin.location.index') }}"
                        @if (request()->routeIs('admin.location.*'))
                            aria-current="page"
                        @endif
                    >
                        {{ __('general.nav_locations') }}
                    </a>

                    <a
                        class="btn-pill-ghost text-decoration-none"
                        href="{{ route('admin.reservation.index') }}"
                        @if (request()->routeIs('admin.reservation.*'))
                            aria-current="page"
                        @endif
                    >
                        {{ __('authentication.reservations') }}
                    </a>

                    <a
                        class="btn-pill-ghost text-decoration-none"
                        href="{{ route('admin.payment.index') }}"
                        @if (request()->routeIs('admin.payment.*'))
                            aria-current="page"
                        @endif
                    >
                        {{ __('general.nav_payments') }}
                    </a>

                    <a
                        class="btn-pill-ghost text-decoration-none"
                        href="{{ route('admin.user.index') }}"
                        @if (request()->routeIs('admin.user.*'))
                            aria-current="page"
                        @endif
                    >
                        {{ __('general.nav_users') }}
                    </a>
                @endif
            @endauth
        </div>

        {{-- Right Side: Profile / Auth Actions & Language Selector --}}
        <div class="nav-right-actions d-flex align-items-center gap-3 ms-auto">
            @auth
                {{-- Grouped Profile Dropdown with Logout --}}
                <div class="user-profile-dropdown position-relative">
                    <details class="language-dropdown">
                        <summary class="language-dropdown-toggle d-flex align-items-center gap-2" title="{{ __('authentication.profile') }}">
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
                            <span class="d-none d-sm-inline fw-semibold">{{ auth()->user()->getName() }}</span>
                            <span class="language-dropdown-arrow" aria-hidden="true">▾</span>
                        </summary>

                        <div class="language-dropdown-menu" style="min-width: 170px;">
                            @if (! auth()->user()->isAdmin())
                                <a
                                    class="language-dropdown-option text-decoration-none d-block py-2 px-3"
                                    href="{{ route('profile.index') }}"
                                >
                                    {{ __('authentication.profile') }}
                                </a>
                            @else
                                <a
                                    class="language-dropdown-option text-decoration-none d-block py-2 px-3"
                                    href="{{ route('admin.dashboard.index') }}"
                                >
                                    {{ __('authentication.dashboard') }}
                                </a>
                            @endif

                            <div class="dropdown-divider my-1 border-top border-secondary"></div>

                            <form
                                class="logout-form m-0"
                                method="POST"
                                action="{{ route('auth.logout') }}"
                            >
                                @csrf
                                <button class="language-dropdown-option w-100 text-start py-2 px-3 border-0 bg-transparent text-danger fw-semibold" type="submit">
                                    {{ __('authentication.logout') }}
                                </button>
                            </form>
                        </div>
                    </details>
                </div>
            @else
                <div class="nav-guest d-flex align-items-center gap-2">
                    <a
                        class="guest-navigation-link btn-pill-ghost text-decoration-none"
                        href="{{ route('login') }}"
                        @if (request()->routeIs('login'))
                            aria-current="page"
                        @endif
                    >
                        {{ __('authentication.login') }}
                    </a>

                    <a
                        class="btn-pill-solid text-decoration-none"
                        href="{{ route('register') }}"
                        @if (request()->routeIs('register'))
                            aria-current="page"
                        @endif
                    >
                        {{ __('authentication.create_account') }}
                    </a>
                </div>
            @endauth

            @include('components.navigation.language-selector')
        </div>
    </div>
</nav>
