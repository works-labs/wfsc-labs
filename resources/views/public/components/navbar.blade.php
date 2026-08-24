{{-- Desktop Top Navigation --}}
<nav
    id="public-navbar"
    class="fixed inset-x-0 top-0 z-50 hidden text-white transition-all duration-500 lg:block"
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
            <a href="{{ route('home') }}" class="public-nav-link">Home</a>
            <a href="{{ route('treatments.index') }}" class="public-nav-link">Treatment</a>
            <a href="#before-after" class="public-nav-link">Before After</a>
            <a href="#promo" class="public-nav-link">Promo</a>
            <a href="#skincare" class="public-nav-link">Skincare</a>
            <a href="#news" class="public-nav-link">News</a>
            <a href="#about" class="public-nav-link">About Us</a>
        </div>

        {{-- CTA Button --}}
        <a
            href="#contact"
            class="public-nav-cta group relative inline-flex items-center gap-2 overflow-hidden rounded-full px-7 py-2.5 text-sm font-semibold tracking-wide transition-all duration-300"
        >
            <span>Contact Us</span>
            <span class="transition-transform duration-300 group-hover:translate-x-1">→</span>
        </a>
    </div>
</nav>

{{-- Mobile Bottom Navigation --}}
<nav class="fixed inset-x-0 bottom-0 z-50 lg:hidden">
    <div class="mx-auto flex h-16 items-center justify-around border-t border-neutral-200/60 bg-white/85 px-3 shadow-[0_-8px_30px_rgba(0,0,0,0.08)] backdrop-blur-xl">

        {{-- Home --}}
        <a href="{{ route('home') }}" class="group flex flex-col items-center gap-1 text-[11px] font-medium text-neutral-500 transition-colors duration-300 hover:text-[#FF5252]">
            <svg class="h-5 w-5 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span>Home</span>
        </a>

        {{-- Treatment --}}
        <a href="#treatments" class="group flex flex-col items-center gap-1 text-[11px] font-medium text-neutral-500 transition-colors duration-300 hover:text-[#FF5252]">
            <svg class="h-5 w-5 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
            </svg>
            <span>Treatment</span>
        </a>

        {{-- Before After --}}
        <a href="#before-after" class="group flex flex-col items-center gap-1 text-[11px] font-medium text-neutral-500 transition-colors duration-300 hover:text-[#FF5252]">
            <svg class="h-5 w-5 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
            </svg>
            <span>Results</span>
        </a>

        {{-- News --}}
        <a href="#news" class="group flex flex-col items-center gap-1 text-[11px] font-medium text-neutral-500 transition-colors duration-300 hover:text-[#FF5252]">
            <svg class="h-5 w-5 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
            </svg>
            <span>News</span>
        </a>

        {{-- Contact CTA Highlighted --}}
        <a href="#contact" class="group flex flex-col items-center gap-1 text-[11px] font-semibold text-[#FF5252]">
            <div class="flex h-7 w-7 items-center justify-center rounded-full bg-[#FF5252]/10 transition-transform duration-300 group-hover:scale-110 group-hover:bg-[#FF5252] group-hover:text-white">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
            </div>
            <span>Contact</span>
        </a>

    </div>
</nav>