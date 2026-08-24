@php
    use Illuminate\Support\Facades\Storage;
@endphp

@if ($promos->isNotEmpty())
    <section id="promos" class="relative overflow-hidden bg-[#FAF9F6] py-16 sm:py-20 lg:py-32">
        {{-- Ambient Glow Background --}}
        <div class="pointer-events-none absolute -left-20 top-1/2 h-72 w-72 -translate-y-1/2 rounded-full bg-[#FF5252]/5 blur-3xl sm:h-96 sm:w-96"></div>
        <div class="pointer-events-none absolute -right-20 top-1/2 h-72 w-72 -translate-y-1/2 rounded-full bg-[#FF5252]/5 blur-3xl sm:h-96 sm:w-96"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-12">

            {{-- Heading Section --}}
            <div class="mb-10 text-center sm:mb-16">
                <div data-reveal="down" data-delay="100" class="reveal-hidden inline-flex items-center gap-2 rounded-full border border-[#FF5252]/20 bg-[#FF5252]/5 px-3.5 py-1 sm:px-4 sm:py-1.5">
                    <span class="h-1.5 w-1.5 rounded-full bg-[#FF5252]"></span>
                    <span class="text-[11px] font-semibold uppercase tracking-[0.2em] text-[#FF5252] sm:text-xs">
                        Special Offer
                    </span>
                </div>

                <h2 data-reveal="down" data-delay="200" class="reveal-hidden mt-3 text-3xl font-bold tracking-tight text-neutral-900 sm:mt-4 sm:text-4xl lg:text-5xl">
                    Our Promo
                </h2>

                <p data-reveal="down" data-delay="300" class="reveal-hidden mx-auto mt-3 max-w-xl text-xs leading-relaxed text-neutral-500 sm:mt-4 sm:text-sm">
                    Nikmati penawaran terbatas dan diskon spesial untuk perawatan terbaik Anda.
                </p>
            </div>

            {{-- Slider Container --}}
            <div
                data-reveal="zoom"
                data-delay="400"
                data-promo-slider
                class="reveal-hidden relative mx-auto max-w-4xl"
            >
                <div class="relative overflow-hidden rounded-2xl border border-neutral-200/80 bg-white p-3 shadow-xl shadow-neutral-200/50 sm:rounded-[2.5rem] sm:p-5 md:p-6">
                    
                    @foreach ($promos as $index => $promo)
                        @php
                            // Check image fallback to linked product if promo image is empty
                            $imageUrl = $promo->image 
                                ? Storage::url($promo->image) 
                                : ($promo->treatmentProduct?->image ? Storage::url($promo->treatmentProduct->image) : null);
                        @endphp

                        <article
                            data-promo-slide
                            class="{{ $index === 0 ? '' : 'hidden' }} transition-opacity duration-500"
                        >
                            {{-- Image Container with Floating Date Badge --}}
                            @if ($imageUrl)
                                <div class="relative aspect-[16/9] overflow-hidden rounded-xl border border-neutral-200/60 bg-neutral-100 sm:rounded-[1.75rem]">
                                    <img
                                        src="{{ $imageUrl }}"
                                        alt="{{ $promo->title }}"
                                        class="h-full w-full object-cover transition duration-700 hover:scale-105"
                                    >

                                    {{-- Floating Date Chip / Badge --}}
                                    <div class="absolute left-3 top-3 z-10 sm:left-5 sm:top-5">
                                        <div class="inline-flex items-center gap-1.5 rounded-full bg-neutral-900/85 px-3 py-1.5 text-[11px] font-medium text-white shadow-lg backdrop-blur-md sm:px-4 sm:py-2 sm:text-xs">
                                            <svg class="h-3.5 w-3.5 text-[#FF5252]" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                            </svg>
                                            
                                            @if ($promo->start_date && $promo->end_date)
                                                <span>{{ $promo->start_date->format('d M') }} – {{ $promo->end_date->format('d M Y') }}</span>
                                            @elseif ($promo->end_date)
                                                <span>Berlaku s/d {{ $promo->end_date->format('d M Y') }}</span>
                                            @else
                                                <span class="font-semibold uppercase tracking-wider text-[#FF5252]">Limited Offer</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Caption / Info Box Centered --}}
                            <div class="mt-6 border-t border-neutral-100 pt-5 text-center sm:mt-8 sm:pt-6">
                                <h3 class="text-xl font-bold tracking-tight text-neutral-900 sm:text-2xl lg:text-3xl">
                                    {{ $promo->title }}
                                </h3>

                                @if ($promo->description)
                                    <p class="mx-auto mt-2 max-w-2xl text-xs leading-relaxed text-neutral-500 sm:text-sm">
                                        {{ $promo->description }}
                                    </p>
                                @endif

                                @if ($promo->cta_text && $promo->cta_url)
                                    <div class="mt-5 sm:mt-6">
                                        <a
                                            href="{{ $promo->cta_url }}"
                                            class="group inline-flex items-center justify-center rounded-full bg-[#FF5252] px-6 py-2.5 text-xs font-semibold text-white shadow-lg shadow-[#FF5252]/25 transition hover:bg-[#e04343] sm:px-7 sm:py-3 sm:text-sm"
                                        >
                                            {{ $promo->cta_text }}
                                            <span class="ml-2 transition-transform duration-300 group-hover:translate-x-1">→</span>
                                        </a>
                                    </div>
                                @endif
                            </div>

                        </article>
                    @endforeach

                </div>

                {{-- Indicators (Pill Style) --}}
                @if ($promos->count() > 1)
                    <div class="mt-6 flex items-center justify-center gap-2 sm:mt-8">
                        @foreach ($promos as $index => $promo)
                            <button
                                type="button"
                                data-promo-dot="{{ $index }}"
                                class="h-1.5 rounded-full transition-all duration-300 sm:h-2 {{ $index === 0 ? 'w-6 bg-[#FF5252] sm:w-8' : 'w-1.5 bg-neutral-300 hover:bg-neutral-400 sm:w-2' }}"
                                aria-label="Go to slide {{ $index + 1 }}"
                            ></button>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </section>
@endif