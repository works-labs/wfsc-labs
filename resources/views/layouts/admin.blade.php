<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('assets/logo.PNG') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/logo.PNG') }}">
    <title>{{ $title ?? 'WFSC Admin' }}</title>

    @vite(['resources/css/app.css', 'resources/css/public.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="min-h-screen bg-[#F4F6F9] text-[var(--color-wfsc-dark)] selection:bg-[var(--color-wfsc-coral)] selection:text-white font-sans">

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <aside class="flex w-[280px] flex-col bg-white shadow-[4px_0_24px_rgba(42,43,46,0.03)] z-20">

            {{-- Logo --}}
            <div class="flex items-center gap-4 px-8 py-8 border-b border-gray-50">
                <img src="{{ asset('assets/logo.PNG') }}" alt="WFSC Logo" class="h-10 w-auto object-contain drop-shadow-sm">
                <div>
                    <h1 class="text-xl font-black tracking-tight text-[var(--color-wfsc-dark)]">WFSC</h1>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-[var(--color-wfsc-coral)]">Admin Panel</p>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="elegant-scrollbar flex-1 space-y-1 overflow-y-auto px-4 py-6">

                {{-- Dashboard --}}
                <a href="{{ route('admin.dashboard') }}" wire:navigate
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm transition-all duration-300 mb-6
                        {{ request()->routeIs('admin.dashboard')
                            ? 'bg-gradient-to-r from-[var(--color-wfsc-coral)] to-[#ff7676] text-white shadow-lg shadow-[var(--color-wfsc-coral)]/30 font-bold'
                            : 'text-gray-500 font-medium hover:bg-rose-50 hover:text-[var(--color-wfsc-coral)]' }}"
                >
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>

                {{-- Clinic Management --}}
                <div>
                    <p class="mb-3 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400">Clinic Management</p>

                    <a href="{{ route('admin.doctors.index') }}" wire:navigate
                        class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm transition-all duration-200
                            {{ request()->routeIs('admin.doctors.*') ? 'bg-rose-50 text-[var(--color-wfsc-coral)] font-bold' : 'text-gray-500 font-medium hover:bg-gray-50 hover:text-[var(--color-wfsc-dark)]' }}">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Doctors
                    </a>

                    <a href="{{ route('admin.treatment-categories.index') }}" wire:navigate
                        class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm transition-all duration-200
                            {{ request()->routeIs('admin.treatment-categories.*') ? 'bg-rose-50 text-[var(--color-wfsc-coral)] font-bold' : 'text-gray-500 font-medium hover:bg-gray-50 hover:text-[var(--color-wfsc-dark)]' }}">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        Treatment Categories
                    </a>

                    <a href="{{ route('admin.treatments.index') }}" wire:navigate
                        class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm transition-all duration-200
                            {{ request()->routeIs('admin.treatments.*') ? 'bg-rose-50 text-[var(--color-wfsc-coral)] font-bold' : 'text-gray-500 font-medium hover:bg-gray-50 hover:text-[var(--color-wfsc-dark)]' }}">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                        Treatments
                    </a>

                    <a href="{{ route('admin.facilities.index') }}" wire:navigate
                        class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm transition-all duration-200
                            {{ request()->routeIs('admin.facilities.*') ? 'bg-rose-50 text-[var(--color-wfsc-coral)] font-bold' : 'text-gray-500 font-medium hover:bg-gray-50 hover:text-[var(--color-wfsc-dark)]' }}">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        Facilities
                    </a>

                    <a href="{{ route('admin.branches.index') }}" wire:navigate
                        class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm transition-all duration-200
                            {{ request()->routeIs('admin.branches.*') ? 'bg-rose-50 text-[var(--color-wfsc-coral)] font-bold' : 'text-gray-500 font-medium hover:bg-gray-50 hover:text-[var(--color-wfsc-dark)]' }}">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Branches
                    </a>

                    <a href="{{ route('admin.bookings.index') }}" wire:navigate
                        class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm transition-all duration-200
                            {{ request()->routeIs('admin.bookings.*') ? 'bg-rose-50 text-[var(--color-wfsc-coral)] font-bold' : 'text-gray-500 font-medium hover:bg-gray-50 hover:text-[var(--color-wfsc-dark)]' }}">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Bookings
                    </a>
                </div>

                {{-- Products (Skincare) --}}
                <div class="pt-6">
                    <p class="mb-3 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400">Products</p>

                    <div x-data="{ open: {{ request()->routeIs('admin.skincare.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open" 
                            class="flex w-full items-center justify-between rounded-xl px-4 py-2.5 text-sm transition-all duration-200
                            {{ request()->routeIs('admin.skincare.*') ? 'text-[var(--color-wfsc-coral)] font-bold' : 'text-gray-500 font-medium hover:bg-gray-50 hover:text-[var(--color-wfsc-dark)]' }}">
                            <div class="flex items-center gap-3">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                <span>Skincare</span>
                            </div>
                            <svg :class="open ? 'rotate-180 text-[var(--color-wfsc-coral)]' : 'text-gray-400'" class="h-4 w-4 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        
                        <div x-show="open" x-collapse x-cloak class="mt-1 space-y-1 px-3">
                            <div class="border-l-2 border-rose-100 pl-3 ml-3 py-1 space-y-1">
                                <a href="{{ route('admin.skincare.categories.index') }}" wire:navigate
                                    class="block rounded-lg px-3 py-2 text-[13px] transition-all duration-200
                                        {{ request()->routeIs('admin.skincare.categories.*') ? 'text-[var(--color-wfsc-coral)] font-semibold bg-rose-50' : 'text-gray-500 hover:text-[var(--color-wfsc-coral)]' }}">
                                    Categories
                                </a>
                                <a href="{{ route('admin.skincare.attributes.index') }}" wire:navigate
                                    class="block rounded-lg px-3 py-2 text-[13px] transition-all duration-200
                                        {{ request()->routeIs('admin.skincare.attributes.*') ? 'text-[var(--color-wfsc-coral)] font-semibold bg-rose-50' : 'text-gray-500 hover:text-[var(--color-wfsc-coral)]' }}">
                                    Attributes
                                </a>
                                <a href="{{ route('admin.skincare.products.index') }}" wire:navigate
                                    class="block rounded-lg px-3 py-2 text-[13px] transition-all duration-200
                                        {{ request()->routeIs('admin.skincare.products.*') ? 'text-[var(--color-wfsc-coral)] font-semibold bg-rose-50' : 'text-gray-500 hover:text-[var(--color-wfsc-coral)]' }}">
                                    Products
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Content & Marketing (News & Promos) --}}
                <div class="pt-6">
                    <p class="mb-3 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400">Content & Marketing</p>
                    
                    {{-- News Dropdown --}}
                    <div x-data="{ open: {{ request()->routeIs('admin.news.*') ? 'true' : 'false' }} }" class="mb-1">
                        <button @click="open = !open" 
                            class="flex w-full items-center justify-between rounded-xl px-4 py-2.5 text-sm transition-all duration-200
                            {{ request()->routeIs('admin.news.*') ? 'text-[var(--color-wfsc-coral)] font-bold' : 'text-gray-500 font-medium hover:bg-gray-50 hover:text-[var(--color-wfsc-dark)]' }}">
                            <div class="flex items-center gap-3">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11l3 3m0 0l3-3m-3 3V8"/></svg>
                                <span>News & Articles</span>
                            </div>
                            <svg :class="open ? 'rotate-180 text-[var(--color-wfsc-coral)]' : 'text-gray-400'" class="h-4 w-4 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        
                        <div x-show="open" x-collapse x-cloak class="mt-1 space-y-1 px-3">
                            <div class="border-l-2 border-rose-100 pl-3 ml-3 py-1 space-y-1">
                                <a href="{{ route('admin.news.index') }}" wire:navigate
                                    class="block rounded-lg px-3 py-2 text-[13px] transition-all duration-200
                                        {{ request()->routeIs('admin.news.index', 'admin.news.create', 'admin.news.edit', 'admin.news.related') ? 'text-[var(--color-wfsc-coral)] font-semibold bg-rose-50' : 'text-gray-500 hover:text-[var(--color-wfsc-coral)]' }}">
                                    Articles
                                </a>
                                <a href="{{ route('admin.news.categories.index') }}" wire:navigate
                                    class="block rounded-lg px-3 py-2 text-[13px] transition-all duration-200
                                        {{ request()->routeIs('admin.news.categories.*') ? 'text-[var(--color-wfsc-coral)] font-semibold bg-rose-50' : 'text-gray-500 hover:text-[var(--color-wfsc-coral)]' }}">
                                    Categories
                                </a>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('admin.home.promos.index') }}" wire:navigate
                        class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm transition-all duration-200
                            {{ request()->routeIs('admin.home.promos.*') ? 'bg-rose-50 text-[var(--color-wfsc-coral)] font-bold' : 'text-gray-500 font-medium hover:bg-gray-50 hover:text-[var(--color-wfsc-dark)]' }}">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/></svg>
                        Promos
                    </a>
                </div>

                {{-- Website Pages / Appearance --}}
                <div class="pt-6">
                    <p class="mb-3 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400">Appearance</p>

                    <a href="{{ route('admin.home.hero-banners.index') }}" wire:navigate
                        class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm transition-all duration-200
                            {{ request()->routeIs('admin.home.hero-banners.*') ? 'bg-rose-50 text-[var(--color-wfsc-coral)] font-bold' : 'text-gray-500 font-medium hover:bg-gray-50 hover:text-[var(--color-wfsc-dark)]' }}">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Hero Banners
                    </a>

                    <a href="{{ route('admin.banners.index') }}" wire:navigate
                        class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm transition-all duration-200
                            {{ request()->routeIs('admin.banners.*') ? 'bg-rose-50 text-[var(--color-wfsc-coral)] font-bold' : 'text-gray-500 font-medium hover:bg-gray-50 hover:text-[var(--color-wfsc-dark)]' }}">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 4h16a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/></svg>
                        General Banners
                    </a>

                    <a href="{{ route('admin.home.doctor-home-sections.index') }}" wire:navigate
                        class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm transition-all duration-200
                            {{ request()->routeIs('admin.home.doctor-home-sections.*') ? 'bg-rose-50 text-[var(--color-wfsc-coral)] font-bold' : 'text-gray-500 font-medium hover:bg-gray-50 hover:text-[var(--color-wfsc-dark)]' }}">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                        Doctor Home Sections
                    </a>

                    <a href="{{ route('admin.home.why-choose-items.index') }}" wire:navigate
                        class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm transition-all duration-200
                            {{ request()->routeIs('admin.home.why-choose-items.*') ? 'bg-rose-50 text-[var(--color-wfsc-coral)] font-bold' : 'text-gray-500 font-medium hover:bg-gray-50 hover:text-[var(--color-wfsc-dark)]' }}">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Why Choose Us
                    </a>

                    <a href="{{ route('admin.home.site-statistics.index') }}" wire:navigate
                        class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm transition-all duration-200
                            {{ request()->routeIs('admin.home.site-statistics.*') ? 'bg-rose-50 text-[var(--color-wfsc-coral)] font-bold' : 'text-gray-500 font-medium hover:bg-gray-50 hover:text-[var(--color-wfsc-dark)]' }}">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        Site Statistics
                    </a>
                </div>

                {{-- System --}}
                <div class="pt-6">
                    <p class="mb-3 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400">System</p>

                    <a href="{{ route('admin.profile') }}" wire:navigate
                        class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm transition-all duration-200
                            {{ request()->routeIs('admin.profile') ? 'bg-rose-50 text-[var(--color-wfsc-coral)] font-bold' : 'text-gray-500 font-medium hover:bg-gray-50 hover:text-[var(--color-wfsc-dark)]' }}">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A8.967 8.967 0 0112 15c2.21 0 4.236.798 5.804 2.121M15 11a3 3 0 11-6 0 3 3 0 016 0zm6 1a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Profile
                    </a>

                    <a href="{{ route('admin.settings.index') }}" wire:navigate
                        class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm transition-all duration-200
                            {{ request()->routeIs('admin.settings.*') ? 'bg-rose-50 text-[var(--color-wfsc-coral)] font-bold' : 'text-gray-500 font-medium hover:bg-gray-50 hover:text-[var(--color-wfsc-dark)]' }}">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Site Settings
                    </a>
                </div>
            </nav>

            {{-- User Profile Area --}}
            <div class="p-6 pb-8 border-t border-gray-50 bg-white">
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-[var(--color-wfsc-coral)] to-[#ff7676] text-white font-bold shadow-md">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-bold text-[var(--color-wfsc-dark)]">{{ auth()->user()->name }}</p>
                        <p class="truncate text-xs font-medium text-gray-400">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                
                <a href="{{ route('admin.profile') }}" wire:navigate
                    class="mb-3 flex w-full items-center justify-center gap-2 rounded-xl py-2.5 text-xs font-bold transition-colors
                        {{ request()->routeIs('admin.profile') ? 'bg-rose-50 text-[var(--color-wfsc-coral)]' : 'bg-gray-50 text-gray-500 hover:bg-rose-50 hover:text-[var(--color-wfsc-coral)]' }}">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M4 20h4.586a1 1 0 00.707-.293L19.5 9.5a2.121 2.121 0 00-3-3L6.293 16.707A1 1 0 006 17.414V20z"/></svg>
                    Profile
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl bg-gray-50 py-2.5 text-xs font-bold text-gray-500 transition-colors hover:bg-rose-50 hover:text-red-600">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Log out
                    </button>
                </form>
            </div>

        </aside>

        {{-- Main Content --}}
        <main class="min-w-0 flex-1 flex flex-col">
            {{-- Elegant Header --}}
            <header class="sticky top-0 z-10 flex h-[90px] items-center border-b border-gray-100/50 bg-white/70 backdrop-blur-xl px-10">
                <h2 class="text-2xl font-bold tracking-tight text-[var(--color-wfsc-dark)]">
                    {{ $heading ?? 'Dashboard' }}
                </h2>
            </header>

            {{-- Page Content --}}
            <div class="flex-1 overflow-x-hidden p-10">
                {{ $slot }}
            </div>
        </main>
    </div>

    @livewireScripts
</body>
</html>
