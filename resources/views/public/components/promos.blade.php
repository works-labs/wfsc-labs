@php
    use Illuminate\Support\Facades\Storage;
@endphp

@if ($promos->isNotEmpty())
    <section id="promos" class="relative overflow-hidden bg-[#FAF9F6] py-16 sm:py-20 lg:py-32">

        {{-- Ambient Glow Background --}}
        <div class="pointer-events-none absolute -left-20 top-1/2 h-72 w-72 -translate-y-1/2 rounded-full bg-[#FF5252]/5 blur-3xl sm:h-96 sm:w-96"></div>
        <div class="pointer-events-none absolute -right-20 top-1/2 h-72 w-72 -translate-y-1/2 rounded-full bg-[#FF5252]/5 blur-3xl sm:h-96 sm:w-96"></div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-12">

            {{-- Header & Navigation --}}
            <div class="mx-auto mb-10 flex max-w-2xl flex-col items-center gap-6 text-center sm:mb-14 lg:mb-16">

                {{-- Text Header --}}
                <div>
                    <p
                        data-reveal="fade-up"
                        data-delay="100"
                        class="reveal-hidden text-xs font-semibold uppercase tracking-[0.25em] text-[#FF5252] sm:text-sm"
                    >
                        Special Offer
                    </p>

                    <h2
                        data-reveal="fade-up"
                        data-delay="200"
                        class="reveal-hidden mt-2 text-3xl font-bold tracking-tight text-neutral-900 sm:mt-3 sm:text-4xl lg:text-5xl"
                    >
                        Our Promo
                    </h2>

                    <p
                        data-reveal="fade-up"
                        data-delay="300"
                        class="reveal-hidden mx-auto mt-3 max-w-xl text-xs leading-relaxed text-neutral-500 sm:mt-4 sm:text-sm"
                    >
                        Nikmati penawaran terbatas dan diskon spesial untuk perawatan terbaik Anda.
                    </p>
                </div>

                {{-- Navigation Buttons --}}
                @if ($promos->count() > 1)
                    <div
                        data-reveal="fade-up"
                        data-delay="400"
                        class="reveal-hidden flex items-center justify-center gap-2.5 sm:gap-3"
                    >
                        <button
                            type="button"
                            data-promo-prev
                            class="flex h-10 w-10 items-center justify-center rounded-full border border-neutral-200 bg-white text-neutral-900 transition-all duration-300 hover:border-[#FF5252] hover:bg-[#FF5252] hover:text-white disabled:cursor-not-allowed disabled:opacity-40 sm:h-11 sm:w-11"
                            aria-label="Previous promotions"
                        >
                            ←
                        </button>

                        <button
                            type="button"
                            data-promo-next
                            class="flex h-10 w-10 items-center justify-center rounded-full border border-neutral-200 bg-white text-neutral-900 transition-all duration-300 hover:border-[#FF5252] hover:bg-[#FF5252] hover:text-white disabled:cursor-not-allowed disabled:opacity-40 sm:h-11 sm:w-11"
                            aria-label="Next promotions"
                        >
                            →
                        </button>
                    </div>
                @endif

            </div>


            {{-- Slider Container (-my-8 py-8 mencegah shadow/scale terpotong) --}}
            <div
                data-reveal="zoom"
                data-delay="500"
                data-promo-slider
                class="reveal-hidden relative -my-8 overflow-hidden py-8"
            >

                <div
                    data-promo-track
                    class="flex items-center transition-transform duration-500 ease-out"
                >

                    @foreach ($promos as $index => $promo)

                        @php
                            $imageUrl = $promo->image
                                ? Storage::url($promo->image)
                                : (
                                    $promo->treatmentProduct?->image
                                        ? Storage::url($promo->treatmentProduct->image)
                                        : null
                                );

                            $promoCount = $promos->count();

                            if ($promoCount === 1) {
                                $slideWidth = 'w-full';
                            } elseif ($promoCount === 2) {
                                $slideWidth = 'w-full sm:w-1/2';
                            } else {
                                $slideWidth = 'w-full sm:w-1/2 lg:w-1/3';
                            }
                        @endphp

                        <div
                            data-promo-slide
                            class="shrink-0 px-3 {{ $slideWidth }}"
                        >
                            {{-- Inner Wrapper untuk penanganan Scale & Shadow --}}
                            <div class="promo-card-inner transition-all duration-500 ease-out">
                                <article
                                    class="group flex h-full flex-col overflow-hidden rounded-[2rem] border border-neutral-200/80 bg-white p-3 shadow-lg transition-all duration-300 hover:shadow-xl"
                                >

                                    {{-- Image (Presisi 1000x1000px dengan aspect-square) --}}
                                    <div class="relative aspect-square w-full overflow-hidden rounded-[1.5rem] bg-neutral-100">

                                        @if ($imageUrl)
                                            <img
                                                src="{{ $imageUrl }}"
                                                alt="{{ $promo->title }}"
                                                class="h-full w-full object-cover transition duration-700 ease-out group-hover:scale-105"
                                            >
                                        @else
                                            <div class="flex h-full items-center justify-center text-xs text-neutral-400 sm:text-sm">
                                                No image
                                            </div>
                                        @endif

                                        {{-- Date Badge --}}
                                        <div class="absolute left-3 top-3 z-10">
                                            <div class="inline-flex items-center gap-1.5 rounded-full bg-neutral-900/85 px-3 py-1.5 text-[10px] font-medium text-white shadow-lg backdrop-blur-md">

                                                <svg
                                                    class="h-3.5 w-3.5 text-[#FF5252]"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke-width="2"
                                                    stroke="currentColor"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"
                                                    />
                                                </svg>

                                                @if ($promo->start_date && $promo->end_date)
                                                    <span>
                                                        {{ $promo->start_date->format('d M') }}
                                                        –
                                                        {{ $promo->end_date->format('d M Y') }}
                                                    </span>
                                                @elseif ($promo->end_date)
                                                    <span>
                                                        Berlaku s/d {{ $promo->end_date->format('d M Y') }}
                                                    </span>
                                                @else
                                                    <span class="font-semibold uppercase tracking-wider text-[#FF5252]">
                                                        Limited Offer
                                                    </span>
                                                @endif

                                            </div>
                                        </div>

                                    </div>


                                    {{-- Content --}}
                                    <div class="flex grow flex-col p-4">

                                        <h3 class="text-lg font-bold leading-snug text-neutral-900 transition duration-300 group-hover:text-[#FF5252] sm:text-xl">
                                            {{ $promo->title }}
                                        </h3>

                                        @if ($promo->description)
                                            <p class="mt-2 line-clamp-2 text-xs leading-relaxed text-neutral-500 sm:text-sm">
                                                {{ $promo->description }}
                                            </p>
                                        @endif

                                        @if ($promo->cta_text && $promo->cta_url)
                                            <div class="mt-auto pt-4">
                                                <a
                                                    href="{{ $promo->cta_url }}"
                                                    class="inline-flex items-center gap-1.5 text-xs font-semibold text-neutral-900 transition duration-300 group-hover:text-[#FF5252] sm:text-sm"
                                                >
                                                    <span>{{ $promo->cta_text }}</span>

                                                    <span class="transition-transform duration-300 group-hover:translate-x-1">
                                                        →
                                                    </span>
                                                </a>
                                            </div>
                                        @endif

                                    </div>

                                </article>
                            </div>
                        </div>

                    @endforeach

                </div>
            </div>


            {{-- Dynamic Dots --}}
            @if ($promos->count() > 1)
                <div
                    data-reveal="zoom"
                    data-delay="600"
                    data-promo-dots
                    class="reveal-hidden mt-6 flex justify-center gap-2 sm:mt-8"
                ></div>
            @endif

        </div>
    </section>
@endif