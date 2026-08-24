@php
    use Illuminate\Support\Facades\Storage;
@endphp

<section id="before-after" class="relative overflow-hidden bg-[#FAF9F6] py-16 sm:py-20 lg:py-32">
    {{-- Ambient Glow Background --}}
    <div class="pointer-events-none absolute -left-20 top-1/2 h-72 w-72 -translate-y-1/2 rounded-full bg-[#FF5252]/5 blur-3xl sm:h-96 sm:w-96"></div>
    <div class="pointer-events-none absolute -right-20 top-1/2 h-72 w-72 -translate-y-1/2 rounded-full bg-[#FF5252]/5 blur-3xl sm:h-96 sm:w-96"></div>

    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-12">

        {{-- Heading Section --}}
        <div class="mb-10 text-center sm:mb-16">
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

        {{-- Slider Container --}}
        @if ($treatmentBeforeAfters->isNotEmpty())
            <div
                data-reveal="zoom"
                data-delay="400"
                data-before-after-slider
                class="reveal-hidden relative mx-auto max-w-5xl"
            >
                <div class="relative overflow-hidden rounded-2xl border border-neutral-200/80 bg-white p-3 shadow-xl shadow-neutral-200/50 sm:rounded-[2.5rem] sm:p-5 md:p-6">
                    
                    @foreach ($treatmentBeforeAfters as $index => $item)
                        <article
                            data-before-after-slide
                            class="{{ $index === 0 ? '' : 'hidden' }} transition-opacity duration-500"
                        >
                            {{-- Grid Media Comparison --}}
                            <div class="grid gap-3 sm:gap-4 md:grid-cols-2 md:gap-6">

                                {{-- Loop Media (Before = 0, After = 1) untuk mempersingkat kode --}}
                                @foreach ([
                                    ['key' => 'before_media', 'label' => 'Before', 'badge' => 'bg-black/60 text-white', 'alt' => 'Before ' . $item->treatment?->name],
                                    ['key' => 'after_media', 'label' => 'After', 'badge' => 'bg-[#FF5252] text-white shadow-md shadow-[#FF5252]/30', 'alt' => 'After ' . $item->treatment?->name]
                                ] as $media)
                                    @php
                                        $file = $item->{$media['key']};
                                        $url = Storage::url($file);
                                        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                    @endphp

                                    <div class="relative aspect-[4/3] overflow-hidden rounded-xl border border-neutral-200/60 bg-neutral-100 sm:rounded-[1.75rem]">
                                        {{-- Badge --}}
                                        <div class="absolute left-3 top-3 z-10 rounded-full px-3 py-1 text-[10px] font-bold uppercase tracking-wider backdrop-blur-md sm:left-4 sm:top-4 sm:px-3.5 sm:text-[11px] {{ $media['badge'] }}">
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
                            <div class="mt-6 border-t border-neutral-100 pt-5 text-center sm:mt-8 sm:pt-6">
                                @if ($item->treatment)
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-[#FF5252] sm:text-[11px]">
                                        Treatment Result
                                    </span>
                                    <h3 class="mt-1 text-xl font-bold tracking-tight text-neutral-900 sm:text-2xl">
                                        {{ $item->treatment->name }}
                                    </h3>
                                @endif

                                @if ($item->caption)
                                    <p class="mx-auto mt-1.5 max-w-2xl text-xs leading-relaxed text-neutral-500 sm:mt-2 sm:text-sm">
                                        {{ $item->caption }}
                                    </p>
                                @endif
                            </div>

                        </article>
                    @endforeach

                </div>

                {{-- Indicators (Pill Style) --}}
                @if ($treatmentBeforeAfters->count() > 1)
                    <div class="mt-6 flex items-center justify-center gap-2 sm:mt-8">
                        @foreach ($treatmentBeforeAfters as $index => $item)
                            <button
                                type="button"
                                data-before-after-dot="{{ $index }}"
                                class="h-1.5 rounded-full transition-all duration-300 sm:h-2 {{ $index === 0 ? 'w-6 bg-[#FF5252] sm:w-8' : 'w-1.5 bg-neutral-300 hover:bg-neutral-400 sm:w-2' }}"
                                aria-label="Go to slide {{ $index + 1 }}"
                            ></button>
                        @endforeach
                    </div>
                @endif
            </div>
        @else
            <div class="rounded-2xl border border-dashed border-neutral-300 bg-white/50 py-12 text-center sm:py-16">
                <p class="text-xs text-neutral-400 sm:text-sm">
                    No before and after results available at the moment.
                </p>
            </div>
        @endif

    </div>
</section>