<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>
    {{ filled($title ?? null) ? $title.' - '.config('app.name', 'WFSC Clinic') : config('app.name', 'WFSC Clinic') }}
</title>

<!-- Favicon & Icon Tab -->
<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
<link rel="icon" type="image/png" href="{{ asset('logo.PNG') }}">
<link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

<!-- Open Graph / Meta Thumbnail (Untuk Search & Social Media Sharing) -->
<meta property="og:type" content="website">
<meta property="og:title" content="{{ filled($title ?? null) ? $title.' - '.config('app.name', 'WFSC Clinic') : config('app.name', 'WFSC Clinic') }}">
<meta property="og:image" content="{{ asset('logo.PNG') }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:image" content="{{ asset('logo.PNG') }}">

@fonts

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
