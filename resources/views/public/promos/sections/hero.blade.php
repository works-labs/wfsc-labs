@if ($desktopBanner || $mobileBanner)

@php
    $desktopContent = $desktopBanner ?? $mobileBanner;
    $mobileContent = $mobileBanner ?? $desktopBanner;
@endphp

<section class="public-responsive-banner relative isolate overflow-hidden bg-neutral-900 text-white">

    {{-- Background Image --}}
    <div class="absolute inset-0 -z-20">

        <picture>
            @if ($mobileBanner)
                <source media="(max-width: 639px)" srcset="{{ Storage::url($mobileBanner->image) }}">
            @endif
            @if ($desktopBanner)
                <img src="{{ Storage::url($desktopBanner->image) }}" alt="{{ $desktopBanner->title }}" class="h-full w-full object-cover">
            @else
                <img src="{{ Storage::url($mobileBanner->image) }}" alt="{{ $mobileBanner->title }}" class="h-full w-full object-cover">
            @endif
        </picture>

    </div>


    {{-- Overlay --}}
    <div
        class="absolute inset-0 -z-10 bg-black/50"
        aria-hidden="true"
    ></div>


    {{-- Decorative Background --}}
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


            {{-- Title --}}
            @if ($desktopContent->title)
                <h1
                    data-reveal="left"
                    data-delay="100"
                    class="reveal-hidden hidden text-4xl font-black leading-tight tracking-tight sm:block sm:text-5xl lg:text-6xl"
                >
                    {{ $desktopContent->title }}
                </h1>
            @endif

            @if ($mobileContent->title)
                <h1
                    data-reveal="left"
                    data-delay="100"
                    class="reveal-hidden text-4xl font-black leading-tight tracking-tight sm:hidden"
                >
                    {{ $mobileContent->title }}
                </h1>
            @endif


            {{-- Subtitle --}}
            @if ($desktopContent->subtitle)
                <p
                    data-reveal="left"
                    data-delay="200"
                    class="reveal-hidden mt-6 hidden line-clamp-2 max-w-2xl text-base leading-relaxed text-white/85 sm:block"
                >
                    {{ $desktopContent->subtitle }}
                </p>
            @endif

            @if ($mobileContent->subtitle)
                <p
                    data-reveal="left"
                    data-delay="200"
                    class="reveal-hidden mt-6 line-clamp-2 max-w-2xl text-base leading-relaxed text-white/85 sm:hidden"
                >
                    {{ $mobileContent->subtitle }}
                </p>
            @endif

        </div>

    </div>

</section>

@endif
