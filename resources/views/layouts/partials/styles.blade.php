{{-- Shared styles first, module overrides after the theme. --}}
    <link href="{{ asset('css/base.css') }}?v=10" rel="stylesheet">
    <link href="{{ asset('css/components/navigation-base.css') }}?v=10" rel="stylesheet">
    <link href="{{ asset('css/components/footer.css') }}?v=10" rel="stylesheet">
    <link href="{{ asset('css/components/dashboard.css') }}?v=10" rel="stylesheet">
@if (request()->routeIs('admin.*'))
    <link href="{{ asset('css/admin/admin.css') }}?v=10" rel="stylesheet">
@endif

@if (request()->routeIs('login', 'register', 'password.*', 'verification.*'))
    <link href="{{ asset('css/auth/authentication.css') }}?v=10" rel="stylesheet">
@endif
@if (request()->routeIs('home.*'))
    <link href="{{ asset('css/user/dashboard.css') }}?v=10" rel="stylesheet">
@endif
@if (request()->routeIs('profile.*'))
    <link href="{{ asset('css/user/profile-base.css') }}?v=10" rel="stylesheet">
@endif
@if (request()->routeIs('welcome.index'))
    <link href="{{ asset('css/pages/welcome.css') }}?v=10" rel="stylesheet">
@endif
@if (request()->routeIs('catalog.*', 'locations.*', 'reservations.*', 'payments.*'))
    <link href="{{ asset('css/user/catalog-legacy.css') }}?v=10" rel="stylesheet">
@endif

    <link href="{{ asset('css/components/navigation.css') }}?v=10" rel="stylesheet">
@if (request()->routeIs('profile.*'))
    <link href="{{ asset('css/user/profile-edit.css') }}?v=10" rel="stylesheet">
@endif

    <link href="{{ asset('css/theme-blue.css') }}?v=10" rel="stylesheet">
    <link href="{{ asset('css/components/navigation-theme.css') }}?v=10" rel="stylesheet">
    <link href="{{ asset('css/components/footer-theme.css') }}?v=10" rel="stylesheet">
    <link href="{{ asset('css/components/dashboard-theme.css') }}?v=10" rel="stylesheet">
@if (request()->routeIs('admin.*'))
    <link href="{{ asset('css/admin/theme.css') }}?v=10" rel="stylesheet">
    <link href="{{ asset('css/admin/cards.css') }}?v=10" rel="stylesheet">
    <link href="{{ asset('css/admin/records.css') }}?v=10" rel="stylesheet">
@endif

@if (request()->routeIs('login', 'register', 'password.*', 'verification.*'))
    <link href="{{ asset('css/auth/theme.css') }}?v=10" rel="stylesheet">
@endif
@if (request()->routeIs('home.*'))
    <link href="{{ asset('css/user/dashboard-theme.css') }}?v=10" rel="stylesheet">
@endif
@if (request()->routeIs('profile.*'))
    <link href="{{ asset('css/user/profile-theme.css') }}?v=10" rel="stylesheet">
@endif

@if (request()->routeIs('welcome.index'))
    <link href="{{ asset('css/pages/welcome-theme.css') }}?v=10" rel="stylesheet">
@endif

@if (request()->routeIs('home.*'))
    <link href="{{ asset('css/user/home.css') }}?v=10" rel="stylesheet">
@endif

@if (request()->routeIs('catalog.*', 'locations.show'))
    <link href="{{ asset('css/user/catalog.css') }}?v=10" rel="stylesheet">
@endif

@if (request()->routeIs('locations.*'))
    <link href="{{ asset('css/user/locations.css') }}?v=10" rel="stylesheet">
@endif

@if (request()->routeIs('reservations.*'))
    <link href="{{ asset('css/user/reservations.css') }}?v=10" rel="stylesheet">
@endif

@if (request()->routeIs('profile.*'))
    <link href="{{ asset('css/user/profile.css') }}?v=10" rel="stylesheet">
@endif

@stack('styles')
    <link href="{{ asset('css/usability.css') }}?v=10" rel="stylesheet">

<link href="{{ asset('css/components/language-selector.css') }}?v=1" rel="stylesheet">
