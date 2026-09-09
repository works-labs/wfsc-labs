@if ($banner)

<section class="relative isolate overflow-hidden text-white">

    {{-- Background Image --}}
    <div class="absolute inset-0 -z-20">

        <img
            src="{{ Storage::url($banner->image) }}"
            alt="{{ $banner->title }}"
            class="h-full w-full object-cover"
        >

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
        class="relative mx-auto max-w-7xl px-6 pb-28 pt-36 sm:px-8 lg:px-12 lg:pb-36 lg:pt-44"
    >

        <div class="max-w-4xl">

            {{-- Label --}}
            <div
                data-reveal="left"
                data-delay="0"
                class="reveal-hidden mb-6"
            >
                <span
                    class="inline-flex items-center rounded-full border border-white/30 bg-white/10 px-4 py-2 text-sm font-medium backdrop-blur-sm"
                >
                    Promo
                </span>
            </div>


            {{-- Title --}}
            @if ($banner->title)
                <h1
                    data-reveal="left"
                    data-delay="100"
                    class="reveal-hidden text-4xl font-black leading-tight tracking-tight sm:text-5xl lg:text-6xl"
                >
                    {{ $banner->title }}
                </h1>
            @endif


            {{-- Subtitle --}}
            @if ($banner->subtitle)
                <p
                    data-reveal="left"
                    data-delay="200"
                    class="reveal-hidden mt-6 max-w-2xl text-base leading-relaxed text-white/85 sm:text-lg"
                >
                    {{ $banner->subtitle }}
                </p>
            @endif

        </div>

    </div>

</section>

@endif