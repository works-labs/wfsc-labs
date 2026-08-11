<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'WFSC Clinic')</title>

    @vite([
        'resources/css/public.css',
        'resources/js/public.js',
    ])
</head>

<body class="@yield('body_class')">
    @include('public.components.navbar')
    @yield('content')
</body>
</html>