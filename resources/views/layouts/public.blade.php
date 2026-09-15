<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'WFSC Clinic')</title>

    <!-- Favicon & Icon Tab -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" href="{{ asset('logo.PNG') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    <!-- Open Graph / Meta Thumbnail (Untuk Search & Social Sharing) -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', 'WFSC Clinic')">
    <meta property="og:image" content="{{ asset('logo.PNG') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:image" content="{{ asset('logo.PNG') }}">

    @vite([
        'resources/css/public.css',
        'resources/js/public.js',
    ])

    @stack('styles')
</head>

<body class="@yield('body_class')">
    @include('public.components.navbar')
    @yield('content')
    @include('public.components.floating-whatsapp')

    @stack('scripts')
</body>
</html>