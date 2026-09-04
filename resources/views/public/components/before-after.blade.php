@php
    use Illuminate\Support\Facades\Storage;
@endphp

<section id="before-after" class="relative overflow-hidden bg-[#FAF9F6] py-16 sm:py-20 lg:py-32">
    {{-- Ambient Glow Background --}}
    <div class="pointer-events-none absolute -left-20 top-1/2 h-72 w-72 -translate-y-1/2 rounded-full bg-[#FF5252]/5 blur-3xl sm:h-96 sm:w-96"></div>
    <div class="pointer-events-none absolute -right-20 top-1/2 h-72 w-72 -translate-y-1/2 rounded-full bg-[#FF5252]/5 blur-3xl sm:h-96 sm:w-96"></div>

    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-12">

        {{-- Heading & Navigation Section --}}
        <div class="mb-10 flex flex-col items-center text-center gap-6 sm:mb-14 lg:mb-16">
            <div>
                <div data-reveal="down" data-delay="100" class="reveal-hidden inline-flex items-center gap-2 rounded-full border border-[#FF5252]/20 bg-[#FF5252]/5 px-3.5 py-1 sm:px-4 sm:py-1.5">
                    <span class="h-1.5 w-1.5 rounded-full bg-[#FF5252]"></span>
                    <span class="text-[11px] font-semibold uppercase tracking-[0.2em] text-[#FF5252] sm:text-xs">
                        Real Results
                    </span>
                </div>

                <h2 data-reveal="down" data-delay="200" class="reveal-hidden mt-3 text-3xl font-bold tracking-tight text-neutral-900 sm:mt-4 sm:text-4xl lg:text-5xl">
                    See The Difference
                </h2>

                <p data-reveal="down" data-delay="300" class="reveal-hidden mx-auto mt-3 max-w-xl text-xs leading-relaxed text-neutral-500 sm:mt-4 sm:text-sm">
                    Bukti nyata transformasi dan hasil perawatan pasien kami di WFSC Clinic.
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
                                <article class="flex h-full flex-col overflow-hidden rounded-[2rem] border border-neutral-200/80 bg-white p-3.5 shadow-md transition-all duration-300 sm:p-4">
                                    
                                    {{-- Grid Media Comparison (Rasio 1350x1080 -> aspect-[5/4]) --}}
                                    <div class="grid grid-cols-2 gap-2 sm:gap-2.5">
                                        @foreach ([
                                            ['key' => 'before_media', 'label' => 'Before', 'badge' => 'bg-black/60 text-white', 'alt' => 'Before ' . $item->treatment?->name],
                                            ['key' => 'after_media', 'label' => 'After', 'badge' => 'bg-[#FF5252] text-white shadow-md shadow-[#FF5252]/30', 'alt' => 'After ' . $item->treatment?->name]
                                        ] as $media)
                                            @php
                                                $file = $item->{$media['key']};
                                                $url = Storage::url($file);
                                                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                            @endphp

                                            <div class="relative aspect-[5/4] overflow-hidden rounded-[1.25rem] border border-neutral-200/60 bg-neutral-100">
                                                {{-- Badge --}}
                                                <div class="absolute left-2 top-2 z-10 rounded-full px-2.5 py-0.5 text-[9px] font-bold uppercase tracking-wider backdrop-blur-md sm:left-2.5 sm:top-2.5 sm:px-3 sm:py-1 sm:text-[10px] {{ $media['badge'] }}">
                                                    {{ $media['label'] }}
                                                </div>

                                                @if (in_array($ext, ['mp4', 'webm', 'mov']))
                                                    <video autoplay muted loop playsinline class="h-full w-full object-cover">
                                                        <source src="{{ $url }}" type="{{ $ext === 'mov' ? 'video/quicktime' : 'video/' . $ext }}">
                                                        Browser kamu tidak mendukung video.
                                                    </video>
                                                @else
                                                    <img
                                                        src="{{ $url }}"
                                                        alt="{{ $media['alt'] }}"
                                                        class="h-full w-full object-cover transition duration-700 hover:scale-105"
                                                    >
                                                @endif
                                            </div>
                                        @endforeach
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