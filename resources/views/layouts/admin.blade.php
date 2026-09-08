{{--
    Author: Alejandro
    Date: 07/09/2026
    Description: Administrator Blade layout used by administration pages.
--}}

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        {{ $viewData['title'] ?? __('admin.layout_title') }}
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
        href="{{ asset('css/authentication.css') }}?v=6"
        rel="stylesheet"
    >

    <link
        href="{{ asset('css/navigation.css') }}?v=6"
        rel="stylesheet"
    >

    <link
        href="{{ asset('css/admin.css') }}?v=1"
        rel="stylesheet"
    >

    @stack('styles')
</head>

<body class="admin-layout">
    @include('components.navigation.admin-navbar')

    <main>
        @yield('content')
    </main>

    <footer class="safety-footer">
        <div class="container safety-footer-inner">
            <span>
                {{ __('admin.administration') }}
            </span>

            <span aria-hidden="true">
                ·
            </span>

            <span>
                {{ __('authentication.application_name') }}
            </span>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
