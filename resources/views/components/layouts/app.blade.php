<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Page title, defaulting to 'Page Title' if $title is not provided -->
    <title>{{ $title ?? 'GR SHOP' }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">



    <!-- Including CSS and JS files managed by Vite -->
    @vite(['resources/css/app.css', 'resources/assets/css/bootstrap.min.css',
    'resources/assets/css/all.min.css',
    'resources/assets/css/animate.css',
    'resources/assets/css/magnific-popup.css',
    'resources/assets/css/meanmenu.css',
    'resources/assets/css/swiper-bundle.min.css',
    'resources/assets/css/nice-select.css',
    'resources/assets/css/main.css',
    "resources/assets/js/jquery-3.7.1.min.js",
    "resources/assets/js/viewport.jquery.js",
    "resources/assets/js/bootstrap.bundle.min.js",
    "resources/assets/js/jquery.nice-select.min.js",
    "resources/assets/js/jquery.waypoints.js",
    "resources/assets/js/jquery.counterup.min.js",
    "resources/assets/js/swiper-bundle.min.js",
    "resources/assets/js/jquery.meanmenu.min.js",
    "resources/assets/js/jquery.magnific-popup.min.js",
    "resources/assets/js/wow.min.js",
    "resources/assets/js/main.js",'resources/js/app.js'])

    <!-- Including Livewire styles -->
    @livewireStyles
</head>
<body>

    <!--<< Preloader Start >>-->
    @livewire('partials.preloader')

    @livewire('partials.offcanvas')

    @livewire('partials.header')

    @livewire('partials.searcharea')

    <!-- Including Livewire navbar component -->
    {{-- @livewire('partials.navbar') --}}

    <main>
        <!-- Placeholder for main content -->
        {{ $slot }}
    </main>

    <!-- Including Livewire footer component -->
    @livewire('partials.footer')

    <!-- Including Livewire scripts -->
    @livewireScripts
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <x-livewire-alert::scripts />



</body>
</html>
