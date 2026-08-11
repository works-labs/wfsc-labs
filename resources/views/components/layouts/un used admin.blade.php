<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'WFSC Admin' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="min-h-screen bg-gray-100">

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <aside class="flex w-64 flex-col border-r bg-white">

            <div class="border-b px-6 py-5">
                <h1 class="text-xl font-bold">
                    WFSC
                </h1>

                <p class="text-xs text-gray-500">
                    Admin Panel
                </p>
            </div>

            <nav class="flex-1 space-y-1 p-4">

                <a
                    href="{{ route('admin.dashboard') }}"
                    class="block rounded-lg px-4 py-2 text-sm font-medium hover:bg-gray-100"
                >
                    Dashboard
                </a>

                <div class="pt-4">
                    <p class="px-4 pb-2 text-xs font-semibold uppercase text-gray-400">
                        Management
                    </p>

                    <a
                        href="{{ route('admin.doctors.index') }}"
                        class="block rounded-lg px-4 py-2 text-sm hover:bg-gray-100"
                    >
                        Doctors
                    </a>

                    <a
                        href="#"
                        class="block rounded-lg px-4 py-2 text-sm text-gray-400"
                    >
                        Treatments
                    </a>

                    <a
                        href="#"
                        class="block rounded-lg px-4 py-2 text-sm text-gray-400"
                    >
                        News
                    </a>

                    <a
                        href="#"
                        class="block rounded-lg px-4 py-2 text-sm text-gray-400"
                    >
                        Facilities
                    </a>

                    <a
                        href="#"
                        class="block rounded-lg px-4 py-2 text-sm text-gray-400"
                    >
                        Bookings
                    </a>
                </div>

                <div class="pt-4">
                    <p class="px-4 pb-2 text-xs font-semibold uppercase text-gray-400">
                        Website
                    </p>

                    <a
                        href="#"
                        class="block rounded-lg px-4 py-2 text-sm text-gray-400"
                    >
                        Home Content
                    </a>

                    <a
                        href="#"
                        class="block rounded-lg px-4 py-2 text-sm text-gray-400"
                    >
                        Site Settings
                    </a>
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

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button
                        type="submit"
                        class="w-full rounded-lg px-4 py-2 text-left text-sm hover:bg-gray-100"
                    >
                        Logout
                    </button>
                </form>

            </div>

        </aside>

        {{-- Main --}}
        <main class="min-w-0 flex-1">

            <header class="border-b bg-white px-8 py-5">
                <h2 class="text-lg font-semibold">
                    {{ $heading ?? 'Dashboard' }}
                </h2>
            </header>

            <div class="p-8">
                {{ $slot }}
            </div>

        </main>

    </div>

    @livewireScripts

</body>
</html>
