@php
    $isHome = request()->routeIs('home');
    $isTreatments = request()->routeIs('treatments.*') || request()->routeIs('treatment.*');
    $isBeforeAfter = request()->routeIs('before-after.*');
    $isPromos = request()->routeIs('promos.*');
    $isSkincare = request()->routeIs('skincare.*');
    $isNews = request()->routeIs('news.*');
    $isContact = request()->routeIs('contact-us.*');
@endphp

{{-- Desktop Top Navigation --}}
<nav
    id="public-navbar"
    class="fixed inset-x-0 top-0 z-50 hidden bg-white/90 backdrop-blur-xl transition-all duration-500 lg:block"
>
    <div class="mx-auto flex h-20 max-w-[1440px] items-center justify-between px-6 transition-all duration-500 lg:px-12">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="shrink-0 transition-transform duration-300 hover:scale-105">
            <img
                src="{{ asset('assets/logo.PNG') }}"
                alt="WFSC Clinic"
                class="h-10 w-auto object-contain"
            >
        </a>

        {{-- Desktop Navigation Links --}}
        <div class="flex items-center gap-8">
            <a href="{{ route('home') }}" class="public-nav-link {{ $isHome ? 'is-active' : '' }}">Home</a>
            <a href="{{ route('treatments.index') }}" class="public-nav-link {{ $isTreatments ? 'is-active' : '' }}">Treatment</a>
            <a href="{{ route('before-after.index') }}" class="public-nav-link {{ $isBeforeAfter ? 'is-active' : '' }}">Before After</a>
            <a href="{{ route('promos.index') }}" class="public-nav-link {{ $isPromos ? 'is-active' : '' }}">Promo</a>
            <a href="{{ route('skincare.index') }}" class="public-nav-link {{ $isSkincare ? 'is-active' : '' }}">Skincare</a>
            <a href="{{ route('news.index') }}" class="public-nav-link {{ $isNews ? 'is-active' : '' }}">News</a>
            <a href="{{ route('contact-us.index') }}" class="public-nav-link {{ $isContact ? 'is-active' : '' }}">Contact Us</a>
        </div>

        {{-- CTA Button --}}
        <a
            href="{{ route('contact-us.index') }}"
            class="public-nav-cta group relative inline-flex items-center gap-2 overflow-hidden rounded-full px-7 py-2.5 text-sm font-semibold tracking-wide transition-all duration-300"
        >
            <span>Contact Us</span>
            <span class="transition-transform duration-300 group-hover:translate-x-1">→</span>
        </a>
    </div>
</nav>

{{-- Mobile Bottom Navigation --}}
<nav class="fixed inset-x-0 bottom-0 z-50 lg:hidden">
    <div class="mx-auto flex h-16 items-center justify-around border-t border-neutral-200/60 bg-white/90 px-1 shadow-[0_-8px_30px_rgba(0,0,0,0.08)] backdrop-blur-xl">

        {{-- Home --}}
        <a href="{{ route('home') }}" class="group flex flex-col items-center gap-1 text-[10px] {{ $isHome ? 'font-semibold text-[#FF5252]' : 'font-medium text-neutral-500 hover:text-[#FF5252]' }} transition-colors duration-300">
            <svg class="h-5 w-5 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span>Home</span>
        </a>

        {{-- Treatment --}}
        <a href="{{ route('treatments.index') }}" class="group flex flex-col items-center gap-1 text-[10px] {{ $isTreatments ? 'font-semibold text-[#FF5252]' : 'font-medium text-neutral-500 hover:text-[#FF5252]' }} transition-colors duration-300">
            <svg class="h-5 w-5 transition-transform duration-300 group-hover:scale-110" viewBox="0 0 512 512" fill="none" stroke="currentColor">
                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M 125 15 H 207 A 10 10 0 0 1 217 25 V 39 A 10 10 0 0 1 207 49 H 125 A 10 10 0 0 1 115 39 V 25 A 10 10 0 0 1 125 15 Z" stroke-width="24"/>
                    <path d="M 166 49 V 110" stroke-width="24"/>
                    <rect x="115" y="110" width="102" height="270" rx="18" ry="18" stroke-width="24"/>
                    <path d="M 115 170 H 155" stroke-width="20"/>
                    <path d="M 115 220 H 145" stroke-width="20"/>
                    <path d="M 115 270 H 155" stroke-width="20"/>
                    <path d="M 115 320 H 145" stroke-width="20"/>
                    <path d="M 115 195 H 217" stroke-width="20"/>
                    <rect x="148" y="380" width="36" height="30" rx="6" ry="6" stroke-width="20"/>
                    <path d="M 166 410 V 492" stroke-width="20"/>
                </g>
            </svg>
            <span>Treatment</span>
        </a>

        {{-- Promo --}}
        <a href="{{ route('promos.index') }}" class="group flex flex-col items-center gap-1 text-[10px] {{ $isPromos ? 'font-semibold text-[#FF5252]' : 'font-medium text-neutral-500 hover:text-[#FF5252]' }} transition-colors duration-300">
            <svg class="h-5 w-5 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
            </svg>
            <span>Promo</span>
        </a>

        {{-- Skincare --}}
        <a href="{{ route('skincare.index') }}" class="group flex flex-col items-center gap-1 text-[10px] {{ $isSkincare ? 'font-semibold text-[#FF5252]' : 'font-medium text-neutral-500 hover:text-[#FF5252]' }} transition-colors duration-300">
            <svg class="h-5 w-5 transition-transform duration-300 group-hover:scale-110" viewBox="0 0 512 512" fill="none" stroke="currentColor">
                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="24">
                    <path d="M72,60 L72,120 M42,90 L102,90" />
                    <path d="M448,370 L448,430 M418,400 L478,400" />
                    <path d="M200,105 A135,135 0 1,1 410,310" />
                    <path d="M235,120 A100,100 0 1,1 395,275" />
                    <path d="M110,215 C110,180 145,170 150,150 C160,110 200,115 215,140 C230,160 270,165 315,180 C325,183 330,195 330,215" />
                    <rect x="95" y="215" width="240" height="45" rx="15" />
                    <rect x="50" y="260" width="330" height="190" rx="35" />
                    <line x1="175" y1="360" x2="255" y2="360" stroke-width="24" />
                    <line x1="175" y1="395" x2="255" y2="395" stroke-width="24" />
                </g>
            </svg>
            <span>Skincare</span>
        </a>

        {{-- Before After / Result --}}
        <a href="{{ route('before-after.index') }}" class="group flex flex-col items-center gap-1 text-[10px] {{ $isBeforeAfter ? 'font-semibold text-[#FF5252]' : 'font-medium text-neutral-500 hover:text-[#FF5252]' }} transition-colors duration-300">
            <svg class="h-5 w-5 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                {{-- Face half acne half clean icon --}}
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3a9 9 0 100 18 9 9 0 000-18zM12 3v18M7.5 9.5h.01M6.5 13h.01M8.5 15.5h.01M16.5 10a1.5 1.5 0 01-1.5-1.5M14.5 15a2.5 2.5 0 003 0"/>
            </svg>
            <span>Result</span>
        </a>

        {{-- News --}}
        <a href="{{ route('news.index') }}" class="group flex flex-col items-center gap-1 text-[10px] {{ $isNews ? 'font-semibold text-[#FF5252]' : 'font-medium text-neutral-500 hover:text-[#FF5252]' }} transition-colors duration-300">
            <svg class="h-5 w-5 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
            </svg>
            <span>News</span>
        </a>

        {{-- Contact --}}
        <a href="{{ route('contact-us.index') }}" class="group flex flex-col items-center gap-1 text-[10px] {{ $isContact ? 'font-semibold text-[#FF5252]' : 'font-medium text-neutral-500 hover:text-[#FF5252]' }} transition-colors duration-300">
            <div class="flex h-6 w-6 items-center justify-center rounded-full {{ $isContact ? 'bg-[#FF5252] text-white' : 'bg-[#FF5252]/10 text-[#FF5252] group-hover:bg-[#FF5252] group-hover:text-white' }} transition-all duration-300 group-hover:scale-110">
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
            </div>
            <span>Contact</span>
        </a>

    </div>
</nav>
