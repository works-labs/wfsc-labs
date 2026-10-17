<section class="public-responsive-banner relative isolate overflow-hidden bg-neutral-900 text-white">

    @if ($desktopBanner || $mobileBanner)

        <picture class="absolute inset-0">
            @if ($mobileBanner)
                <source media="(max-width: 639px)" srcset="{{ Storage::url($mobileBanner->image) }}">
            @endif
            @if ($desktopBanner)
                <img src="{{ Storage::url($desktopBanner->image) }}" alt="{{ $desktopBanner->title }}" class="h-full w-full object-cover">
            @else
                <img src="{{ Storage::url($mobileBanner->image) }}" alt="{{ $mobileBanner->title }}" class="h-full w-full object-cover">
            @endif
        </picture>

        <div class="absolute inset-0 bg-black/50"></div>

    @endif


    {{-- Decorative Background Blur Circles --}}
    <div
        class="absolute -right-32 -top-32 h-96 w-96 rounded-full bg-white/10 blur-3xl"
        aria-hidden="true"
    ></div>

    <div
        class="absolute -bottom-40 -left-32 h-96 w-96 rounded-full bg-white/10 blur-3xl"
        aria-hidden="true"
    ></div>


    {{-- Hero Content --}}
    <div
        class="relative mx-auto flex h-full max-w-7xl items-center px-6 sm:px-8 lg:px-12 lg:pt-20"
    >

        <div class="max-w-4xl">

            {{-- Badge --}}


            {{-- Title --}}
            <h1
                data-reveal="left"
                data-delay="100"
                class="reveal-hidden text-4xl font-black leading-tight tracking-tight sm:text-5xl lg:text-6xl"
            >
                {{ ($desktopBanner ?? $mobileBanner)?->title ?? 'Temukan Kami' }}
            </h1>


            {{-- Subtitle / Description --}}
            <p
                data-reveal="left"
                data-delay="200"
                class="reveal-hidden mt-6 line-clamp-2 max-w-2xl text-base leading-relaxed text-white/85"
            >
                {{ ($desktopBanner ?? $mobileBanner)?->subtitle ?? 'Kunjungi cabang WFSC Clinic terdekat dan temukan layanan perawatan yang sesuai untukmu.' }}
            </p>

        </div>

    </div>

</section>
