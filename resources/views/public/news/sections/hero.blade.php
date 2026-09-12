@php
    use Illuminate\Support\Facades\Storage;
@endphp

@if ($featuredNews->isNotEmpty())

<section
    data-hero-slider
    class="relative isolate h-[520px] overflow-hidden text-white lg:h-[560px]"
>

    {{-- ========================================================= --}}
    {{-- Slides --}}
    {{-- ========================================================= --}}

    @foreach ($featuredNews as $index => $item)

        <div
            data-hero-slide
            class="{{ $index === 0 ? 'opacity-100' : 'opacity-0' }} pointer-events-none absolute inset-0 transition-opacity duration-700"
        >

            {{-- Background --}}
            <div class="absolute inset-0">

                @if ($item->thumbnail)

                    <img
                        src="{{ Storage::url($item->thumbnail) }}"
                        alt="{{ $item->title }}"
                        class="h-full w-full object-cover"
                    >

                @else

                    <div class="h-full w-full bg-neutral-900"></div>

                @endif

            </div>


            {{-- Overlay --}}
            <div
                class="absolute inset-0 bg-black/60"
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


            {{-- ================================================= --}}
            {{-- Clickable Hero --}}
            {{-- ================================================= --}}

            <a
                href="{{ route('news.show', $item->slug) }}"
                class="pointer-events-auto absolute inset-0"
            >

                <div
                    class="mx-auto flex h-full max-w-7xl items-center px-6 sm:px-8 lg:px-12"
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
                                News
                            </span>

                        </div>


                        {{-- Category --}}
                        @if ($item->category)

                            <p
                                class="text-sm font-semibold uppercase tracking-[0.2em] text-white/60"
                            >
                                {{ $item->category->name }}
                            </p>

                        @endif


                        {{-- Title --}}
                        <h1
                            class="mt-3 line-clamp-3 text-4xl font-black leading-tight tracking-tight sm:text-5xl lg:text-6xl"
                        >
                            {{ $item->title }}
                        </h1>


                        {{-- Excerpt --}}
                        @if ($item->excerpt)

                            <p
                                class="mt-6 line-clamp-3 max-w-2xl text-base leading-relaxed text-white/85 sm:text-lg"
                            >
                                {{ $item->excerpt }}
                            </p>

                        @endif


                        {{-- Date --}}
                        @if ($item->published_at)

                            <p class="mt-6 text-sm text-white/60">
                                {{ $item->published_at->format('d M Y') }}
                            </p>

                        @endif

                    </div>

                </div>

            </a>

        </div>

    @endforeach


    {{-- ========================================================= --}}
    {{-- Slider Dots --}}
    {{-- ========================================================= --}}

    @if ($featuredNews->count() > 1)

        <div
            class="absolute bottom-8 left-1/2 z-30 flex -translate-x-1/2 items-center gap-2"
        >

            @foreach ($featuredNews as $index => $item)

                <button
                    type="button"
                    data-hero-dot
                    data-dot-type="scale"
                    aria-label="Go to news {{ $index + 1 }}"
                    class="h-2 w-2 rounded-full transition-all duration-300 {{ $index === 0 ? 'scale-125 bg-[#FF5252]' : 'bg-white/50' }}"
                ></button>

            @endforeach

        </div>

    @endif

</section>

@endif