<nav
    id="public-navbar"
    class="fixed inset-x-0 top-0 z-50 hidden text-white transition-all duration-300 lg:block"
>
    <div class="mx-auto flex h-20 max-w-[1440px] items-center justify-between px-6 lg:px-12">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="shrink-0">
            <img
                src="{{ asset('assets/logo.PNG') }}"
                alt="WFSC Clinic"
                class="h-10 w-auto"
            >
        </a>

        {{-- Desktop Navigation --}}
        <div class="flex items-center gap-7">
            <a href="{{ route('home') }}" class="public-nav-link">
                Home
            </a>

            <a href="#treatments" class="public-nav-link">
                Treatment
            </a>

            <a href="#before-after" class="public-nav-link">
                Before After
            </a>

            <a href="#promo" class="public-nav-link">
                Promo
            </a>

            <a href="#skincare" class="public-nav-link">
                Skincare
            </a>

            <a href="#news" class="public-nav-link">
                News
            </a>

            <a href="#about" class="public-nav-link">
                About Us
            </a>
        </div>

        {{-- CTA --}}
        <a
            href="#contact"
            class="public-nav-cta rounded-full border border-white px-6 py-3 text-sm font-medium transition-all duration-300"
        >
            Contact Us
        </a>
    </div>
</nav>

{{-- Mobile Bottom Navigation --}}
<nav
    class="fixed inset-x-0 bottom-0 z-50 lg:hidden"
>
    <div class="mx-auto flex h-16 items-center justify-around border-t border-black/10 bg-white/95 px-2 shadow-[0_-4px_20px_rgba(0,0,0,0.08)] backdrop-blur-xl">

        <a href="{{ route('home') }}" class="flex flex-col items-center gap-1 px-2 text-[11px] font-medium">
            <span>Home</span>
        </a>

        <a href="#treatments" class="flex flex-col items-center gap-1 px-2 text-[11px] font-medium">
            <span>Treatment</span>
        </a>

        <a href="#before-after" class="flex flex-col items-center gap-1 px-2 text-[11px] font-medium">
            <span>Before After</span>
        </a>

        <a href="#news" class="flex flex-col items-center gap-1 px-2 text-[11px] font-medium">
            <span>News</span>
        </a>

        <a href="#contact" class="flex flex-col items-center gap-1 px-2 text-[11px] font-medium">
            <span>Contact</span>
        </a>

    </div>
</nav>