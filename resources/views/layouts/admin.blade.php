<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" type="image/png" href="{{ asset('assets/logo.PNG') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/logo.PNG') }}">

    <title>{{ $title ?? 'WFSC Admin' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>


<body class="min-h-screen bg-gray-100">

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <aside class="flex w-64 flex-col border-r bg-white">

            {{-- Logo --}}
            <div class="border-b px-6 py-5">

                <h1 class="text-xl font-bold">
                    WFSC
                </h1>

                <p class="text-xs text-gray-500">
                    Admin Panel
                </p>

            </div>


            {{-- Navigation --}}
            <nav class="flex-1 space-y-1 overflow-y-auto p-4">

                {{-- Dashboard --}}
                <a
                    href="{{ route('admin.dashboard') }}"
                    wire:navigate
                    class="block rounded-lg px-4 py-2 text-sm font-medium
                        {{ request()->routeIs('admin.dashboard')
                            ? 'bg-gray-200 text-gray-900 font-semibold'
                            : 'text-gray-700 hover:bg-gray-100' }}"
                >
                    Dashboard
                </a>


                {{-- Management --}}
                <div class="pt-5">

                    <p class="px-4 pb-2 text-xs font-semibold uppercase tracking-wide text-gray-400">
                        Management
                    </p>


                    {{-- Doctors --}}
                    <a
                        href="{{ route('admin.doctors.index') }}"
                        wire:navigate
                        class="block rounded-lg px-4 py-2 text-sm
                            {{ request()->routeIs('admin.doctors.*')
                                ? 'bg-gray-200 text-gray-900 font-semibold'
                                : 'text-gray-700 hover:bg-gray-100' }}"
                    >
                        Doctors
                    </a>


                    {{-- Treatment Categories --}}
                    <a
                        href="{{ route('admin.treatment-categories.index') }}"
                        wire:navigate
                        class="block rounded-lg px-4 py-2 text-sm
                            {{ request()->routeIs('admin.treatment-categories.*')
                                ? 'bg-gray-200 text-gray-900 font-semibold'
                                : 'text-gray-700 hover:bg-gray-100' }}"
                    >
                        Treatment Categories
                    </a>


                    {{-- Treatments --}}
                    <a
                        href="{{ route('admin.treatments.index') }}"
                        wire:navigate
                        class="block rounded-lg px-4 py-2 text-sm
                            {{ request()->routeIs('admin.treatments.*')
                                ? 'bg-gray-200 text-gray-900 font-semibold'
                                : 'text-gray-700 hover:bg-gray-100' }}"
                    >
                        Treatments
                    </a>


                    {{-- Facilities --}}
                    <a
                        href="{{ route('admin.facilities.index') }}"
                        wire:navigate
                        class="block rounded-lg px-4 py-2 text-sm
                            {{ request()->routeIs('admin.facilities.*')
                                ? 'bg-gray-200 text-gray-900 font-semibold'
                                : 'text-gray-700 hover:bg-gray-100' }}"
                    >
                        Facilities
                    </a>


                    {{-- Branches --}}
                    <a
                        href="{{ route('admin.branches.index') }}"
                        wire:navigate
                        class="block rounded-lg px-4 py-2 text-sm
                            {{ request()->routeIs('admin.branches.*')
                                ? 'bg-gray-200 text-gray-900 font-semibold'
                                : 'text-gray-700 hover:bg-gray-100' }}"
                    >
                        Branches
                    </a>


                    {{-- News --}}
                    <a
                        href="{{ route('admin.news.index') }}"
                        wire:navigate
                        class="block rounded-lg px-4 py-2 text-sm
                            {{ request()->routeIs('admin.news.*')
                                ? 'bg-gray-200 text-gray-900 font-semibold'
                                : 'text-gray-700 hover:bg-gray-100' }}"
                    >
                        News
                    </a>


                    {{-- Bookings --}}
                    <a
                        href="{{ route('admin.bookings.index') }}"
                        wire:navigate
                        class="block rounded-lg px-4 py-2 text-sm
                            {{ request()->routeIs('admin.bookings.*')
                                ? 'bg-gray-200 text-gray-900 font-semibold'
                                : 'text-gray-700 hover:bg-gray-100' }}"
                    >
                        Bookings
                    </a>

                </div>


                {{-- Website --}}
                <div class="pt-5">

                    <p class="px-4 pb-2 text-xs font-semibold uppercase tracking-wide text-gray-400">
                        Website
                    </p>


                    {{-- Hero Banners --}}
                    <a
                        href="{{ route('admin.home.hero-banners.index') }}"
                        wire:navigate
                        class="block rounded-lg px-4 py-2 text-sm
                            {{ request()->routeIs('admin.home.hero-banners.*')
                                ? 'bg-gray-200 text-gray-900 font-semibold'
                                : 'text-gray-700 hover:bg-gray-100' }}"
                    >
                        Hero Banners
                    </a>


                    {{-- Site Statistics --}}
                    <a
                        href="{{ route('admin.home.site-statistics.index') }}"
                        wire:navigate
                        class="block rounded-lg px-4 py-2 text-sm
                            {{ request()->routeIs('admin.home.site-statistics.*')
                                ? 'bg-gray-200 text-gray-900 font-semibold'
                                : 'text-gray-700 hover:bg-gray-100' }}"
                    >
                        Site Statistics
                    </a>


                    {{-- Why Choose Us --}}
                    <a
                        href="{{ route('admin.home.why-choose-items.index') }}"
                        wire:navigate
                        class="block rounded-lg px-4 py-2 text-sm
                            {{ request()->routeIs('admin.home.why-choose-items.*')
                                ? 'bg-gray-200 text-gray-900 font-semibold'
                                : 'text-gray-700 hover:bg-gray-100' }}"
                    >
                        Why Choose Us
                    </a>


                    {{-- Promos --}}
                    <a
                        href="{{ route('admin.home.promos.index') }}"
                        wire:navigate
                        class="block rounded-lg px-4 py-2 text-sm
                            {{ request()->routeIs('admin.home.promos.*')
                                ? 'bg-gray-200 text-gray-900 font-semibold'
                                : 'text-gray-700 hover:bg-gray-100' }}"
                    >
                        Promos
                    </a>


                    {{-- Doctors on Home --}}
                    <a
                        href="{{ route('admin.home.doctor-home-sections.index') }}"
                        wire:navigate
                        class="block rounded-lg px-4 py-2 text-sm
                            {{ request()->routeIs('admin.home.doctor-home-sections.*')
                                ? 'bg-gray-200 text-gray-900 font-semibold'
                                : 'text-gray-700 hover:bg-gray-100' }}"
                    >
                        Doctors on Home
                    </a>

                </div>


                {{-- Settings --}}
                <div class="pt-5">

                    <p class="px-4 pb-2 text-xs font-semibold uppercase tracking-wide text-gray-400">
                        Settings
                    </p>


                    {{-- Site Settings --}}
                    <div
                        class="cursor-not-allowed rounded-lg px-4 py-2 text-sm text-gray-400"
                        title="Not implemented yet"
                    >
                        Site Settings
                    </div>

                </div>

            </nav>


            {{-- User --}}
            <div class="border-t p-4">

                <div class="mb-3 px-4">

                    <p class="text-sm font-medium">
                        {{ auth()->user()->name }}
                    </p>

                    <p class="text-xs text-gray-500">
                        {{ auth()->user()->email }}
                    </p>

                </div>


                {{-- Logout --}}
                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >

                    @csrf

                    <button
                        type="submit"
                        class="w-full rounded-lg px-4 py-2 text-left text-sm font-medium text-red-600 hover:bg-gray-100"
                    >
                        Logout
                    </button>

                </form>

            </div>

        </aside>


        {{-- Main Content --}}
        <main class="min-w-0 flex-1">

            {{-- Header --}}
            <header class="border-b bg-white px-8 py-5">

                <h2 class="text-lg font-semibold">
                    {{ $heading ?? 'Dashboard' }}
                </h2>

            </header>


            {{-- Page --}}
            <div class="p-8">

                {{ $slot }}

            </div>

        </main>

    </div>


    @livewireScripts

</body>

</html>
