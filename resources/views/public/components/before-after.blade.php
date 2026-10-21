@php
    use Illuminate\Support\Facades\Storage;
@endphp

<section id="before-after" class="relative overflow-hidden bg-[#FAF9F6] py-10 sm:py-14 lg:py-20">
    {{-- Ambient Glow Background --}}
    <div class="pointer-events-none absolute -left-20 top-1/2 h-72 w-72 -translate-y-1/2 rounded-full bg-[#FF5252]/5 blur-3xl sm:h-96 sm:w-96"></div>
    <div class="pointer-events-none absolute -right-20 top-1/2 h-72 w-72 -translate-y-1/2 rounded-full bg-[#FF5252]/5 blur-3xl sm:h-96 sm:w-96"></div>

    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-12">

        {{-- Heading & Navigation Section --}}
        <div class="mb-8 flex flex-col items-center text-center gap-4 sm:mb-10 lg:mb-12">
            <div>
                <div data-reveal="down" data-delay="100" class="reveal-hidden inline-flex items-center gap-2 rounded-full border border-[#FF5252]/20 bg-[#FF5252]/5 px-3.5 py-1 sm:px-4 sm:py-1.5">
                    <span class="h-1.5 w-1.5 rounded-full bg-[#FF5252]"></span>
                    <span class="text-[11px] font-semibold uppercase tracking-[0.2em] text-[#FF5252] sm:text-xs">
                        See The Difference
                    </span>
                </div>

                <h2 data-reveal="down" data-delay="200" class="reveal-hidden mt-3 text-3xl font-bold tracking-tight text-neutral-900 sm:mt-4 sm:text-4xl lg:text-5xl">
                    Before & After
                </h2>

                <p data-reveal="down" data-delay="300" class="reveal-hidden mx-auto mt-3 max-w-xl text-xs leading-relaxed text-neutral-500 sm:mt-4 sm:text-sm">
                    Setiap treatment disesuaikan dengan kebutuhan pasien untuk mendapatkan hasil yang optimal, proporsional, dan natural.
                </p>
            </div>

            {{-- Navigation Buttons --}}
            @if ($treatmentBeforeAfters->count() > 1)
                <div data-reveal="fade-up" data-delay="350" class="reveal-hidden flex items-center justify-center gap-2.5 sm:gap-3">
                    <button
                        type="button"
                        data-before-after-prev
                        class="flex h-10 w-10 items-center justify-center rounded-full border border-neutral-200 bg-white text-neutral-900 transition-all duration-300 hover:border-[#FF5252] hover:bg-[#FF5252] hover:text-white disabled:cursor-not-allowed disabled:opacity-40 sm:h-11 sm:w-11"
                        aria-label="Previous result"
                    >
                        ←
                    </button>

                    <button
                        type="button"
                        data-before-after-next
                        class="flex h-10 w-10 items-center justify-center rounded-full border border-neutral-200 bg-white text-neutral-900 transition-all duration-300 hover:border-[#FF5252] hover:bg-[#FF5252] hover:text-white disabled:cursor-not-allowed disabled:opacity-40 sm:h-11 sm:w-11"
                        aria-label="Next result"
                    >
                        →
                    </button>
                </div>
            @endif
        </div>

        {{-- Track Slider Container --}}
        @if ($treatmentBeforeAfters->isNotEmpty())
            <div
                data-reveal="zoom"
                data-delay="400"
                data-before-after-slider
                class="reveal-hidden relative -my-10 overflow-hidden py-10"
            >
                <div 
                    data-before-after-track 
                    class="flex items-center transition-transform duration-500 ease-out"
                >
                    @foreach ($treatmentBeforeAfters as $index => $item)
                        {{-- Kembalikan ke grid standar 1/3 desktop, 1/2 tablet, 1 mobile --}}
                        <div 
                            data-before-after-slide 
                            class="w-full shrink-0 px-2 sm:w-1/2 sm:px-3 lg:w-1/3"
                        >
                            {{-- Inner Wrapper khusus animasi --}}
                            <div class="before-after-card-inner transition-all duration-500 ease-out">
                                <article class="mx-auto flex h-full w-full max-w-[260px] flex-col overflow-hidden rounded-[2rem] border border-neutral-200/80 bg-white p-3 shadow-md transition-all duration-300 sm:max-w-xs sm:p-4">
                                    
                                    {{-- Single combined before-after image (rasio 4:5) --}}
                                    @php
                                        $file = $item->after_media ?: $item->before_media;
                                        $url = Storage::url($file);
                                        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                    @endphp

                                    <div class="relative aspect-[4/5] overflow-hidden rounded-[1.25rem] border border-neutral-200/60 bg-neutral-100">
                                        @if (in_array($ext, ['mp4', 'webm', 'mov']))
                                            <video autoplay muted loop playsinline class="h-full w-full object-cover">
                                                <source src="{{ $url }}" type="{{ $ext === 'mov' ? 'video/quicktime' : 'video/' . $ext }}">
                                                Browser kamu tidak mendukung video.
                                            </video>
                                        @else
                                            <img
                                                src="{{ $url }}"
                                                alt="Before After {{ $item->treatment?->name }}"
                                                class="h-full w-full object-cover transition duration-700 hover:scale-105"
                                            >
                                        @endif

                                        <button
                                            type="button"
                                            data-lightbox-trigger
                                            data-after-src="{{ $url }}"
                                            data-after-type="{{ in_array($ext, ['mp4', 'webm', 'mov']) ? 'video' : 'image' }}"
                                            data-caption="{{ $item->caption }}"
                                            class="absolute bottom-3 right-3 z-10 flex h-10 w-10 items-center justify-center rounded-full bg-white/95 text-neutral-700 shadow-lg ring-1 ring-white/80 transition duration-300 hover:scale-110 hover:bg-[#FF5252] hover:text-white"
                                            aria-label="Perbesar hasil before after"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m2.1-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />
                                            </svg>
                                        </button>
                                    </div>

                                    {{-- Caption Info Box --}}
                                    <div class="flex grow flex-col justify-between pt-3.5 text-center sm:pt-4">
                                        <div>
                                            @if ($item->treatment)
                                                <span class="text-[10px] font-bold uppercase tracking-wider text-[#FF5252] sm:text-[11px]">
                                                    Treatment Result
                                                </span>
                                                <h3 class="mt-0.5 text-base font-bold tracking-tight text-neutral-900 sm:text-lg">
                                                    {{ $item->treatment->name }}
                                                </h3>
                                            @endif

                                            @if ($item->caption)
                                                <p class="mt-1 line-clamp-2 text-xs leading-relaxed text-neutral-500">
                                                    {{ $item->caption }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                </article>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Dynamic Dots --}}
            @if ($treatmentBeforeAfters->count() > 1)
                <div 
                    data-reveal="zoom" 
                    data-delay="500" 
                    data-before-after-dots 
                    class="reveal-hidden mt-6 flex justify-center gap-2 sm:mt-8"
                ></div>
            @endif
        @else
            <div class="rounded-2xl border border-dashed border-neutral-300 bg-white/50 py-12 text-center sm:py-16">
                <p class="text-xs text-neutral-400 sm:text-sm">
                    No before and after results available at the moment.
                </p>
            </div>
        @endif

    </div>
</section>
