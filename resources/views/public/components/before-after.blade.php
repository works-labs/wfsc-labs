@php
    use Illuminate\Support\Facades\Storage;
@endphp

<section id="before-after" class="relative overflow-hidden bg-[#FAF9F6] py-24 lg:py-32">
    {{-- Ambient Glow Decorative Background --}}
    <div class="pointer-events-none absolute -left-20 top-1/2 h-96 w-96 -translate-y-1/2 rounded-full bg-[#FF5252]/5 blur-3xl"></div>
    <div class="pointer-events-none absolute -right-20 top-1/2 h-96 w-96 -translate-y-1/2 rounded-full bg-[#FF5252]/5 blur-3xl"></div>

    <div class="relative mx-auto max-w-7xl px-6 lg:px-12">

        {{-- Heading --}}
        <div class="mb-16 text-center">
            <div class="inline-flex items-center gap-2 rounded-full border border-[#FF5252]/20 bg-[#FF5252]/5 px-4 py-1.5">
                <span class="h-1.5 w-1.5 rounded-full bg-[#FF5252]"></span>
                <span class="text-xs font-semibold uppercase tracking-[0.2em] text-[#FF5252]">
                    Real Results
                </span>
            </div>

            <h2 class="mt-4 text-4xl font-bold tracking-tight text-neutral-900 lg:text-5xl">
                See The Difference
            </h2>

            <p class="mx-auto mt-4 max-w-xl text-sm leading-relaxed text-neutral-500">
                Bukti nyata transformasi dan hasil perawatan pasien kami di WFSC Clinic.
            </p>
        </div>

        {{-- Slider --}}
        @if ($treatmentBeforeAfters->isNotEmpty())
            <div
                data-before-after-slider
                class="relative mx-auto max-w-5xl"
            >
                <div class="relative overflow-hidden rounded-[2.5rem] border border-neutral-200/80 bg-white p-4 md:p-6 shadow-xl shadow-neutral-200/50">
                    
                    @foreach ($treatmentBeforeAfters as $index => $item)
                        <article
                            data-before-after-slide
                            class="{{ $index === 0 ? '' : 'hidden' }} transition-opacity duration-500"
                        >
                            {{-- Side-by-Side Comparison Grid --}}
                            <div class="grid gap-4 md:grid-cols-2 md:gap-6">

                                {{-- BEFORE MEDIA --}}
                                @php
                                    $beforeUrl = Storage::url($item->before_media);
                                    $beforeExtension = strtolower(
                                        pathinfo($item->before_media, PATHINFO_EXTENSION)
                                    );
                                @endphp

                                <div class="relative aspect-[4/3] overflow-hidden rounded-[1.75rem] bg-neutral-100 border border-neutral-200/60">
                                    {{-- Badge Label --}}
                                    <div class="absolute left-4 top-4 z-10 rounded-full bg-black/60 px-3.5 py-1 text-[11px] font-bold uppercase tracking-wider text-white backdrop-blur-md">
                                        Before
                                    </div>

                                    @if (in_array($beforeExtension, ['mp4', 'webm', 'mov']))
                                        <video
                                            autoplay
                                            muted
                                            loop
                                            playsinline
                                            class="h-full w-full object-cover"
                                        >
                                            <source
                                                src="{{ $beforeUrl }}"
                                                type="{{ $beforeExtension === 'mov' ? 'video/quicktime' : 'video/' . $beforeExtension }}"
                                            >
                                            Browser kamu tidak mendukung video.
                                        </video>
                                    @else
                                        <img
                                            src="{{ $beforeUrl }}"
                                            alt="Before {{ $item->treatment?->name }}"
                                            class="h-full w-full object-cover transition duration-700 hover:scale-105"
                                        >
                                    @endif
                                </div>


                                {{-- AFTER MEDIA --}}
                                @php
                                    $afterUrl = Storage::url($item->after_media);
                                    $afterExtension = strtolower(
                                        pathinfo($item->after_media, PATHINFO_EXTENSION)
                                    );
                                @endphp

                                <div class="relative aspect-[4/3] overflow-hidden rounded-[1.75rem] bg-neutral-100 border border-neutral-200/60">
                                    {{-- Badge Label --}}
                                    <div class="absolute left-4 top-4 z-10 rounded-full bg-[#FF5252] px-3.5 py-1 text-[11px] font-bold uppercase tracking-wider text-white shadow-md shadow-[#FF5252]/30">
                                        After
                                    </div>

                                    @if (in_array($afterExtension, ['mp4', 'webm', 'mov']))
                                        <video
                                            autoplay
                                            muted
                                            loop
                                            playsinline
                                            class="h-full w-full object-cover"
                                        >
                                            <source
                                                src="{{ $afterUrl }}"
                                                type="{{ $afterExtension === 'mov' ? 'video/quicktime' : 'video/' . $afterExtension }}"
                                            >
                                            Browser kamu tidak mendukung video.
                                        </video>
                                    @else
                                        <img
                                            src="{{ $afterUrl }}"
                                            alt="After {{ $item->treatment?->name }}"
                                            class="h-full w-full object-cover transition duration-700 hover:scale-105"
                                        >
                                    @endif
                                </div>

                            </div>

                            {{-- Caption Info Box --}}
                            <div class="mt-8 border-t border-neutral-100 pt-6 text-center">
                                @if ($item->treatment)
                                    <span class="text-[11px] font-bold uppercase tracking-wider text-[#FF5252]">
                                        Treatment Result
                                    </span>
                                    <h3 class="mt-1 text-2xl font-bold tracking-tight text-neutral-900">
                                        {{ $item->treatment->name }}
                                    </h3>
                                @endif

                                @if ($item->caption)
                                    <p class="mx-auto mt-2 max-w-2xl text-sm leading-relaxed text-neutral-500">
                                        {{ $item->caption }}
                                    </p>
                                @endif
                            </div>

                        </article>
                    @endforeach

                </div>

                {{-- Indicators (Pill Style) --}}
                @if ($treatmentBeforeAfters->count() > 1)
                    <div class="mt-8 flex justify-center items-center gap-2">
                        @foreach ($treatmentBeforeAfters as $index => $item)
                            <button
                                type="button"
                                data-before-after-dot="{{ $index }}"
                                class="h-2 rounded-full transition-all duration-300 {{ $index === 0 ? 'w-8 bg-[#FF5252]' : 'w-2 bg-neutral-300 hover:bg-neutral-400' }}"
                                aria-label="Go to slide {{ $index + 1 }}"
                            ></button>
                        @endforeach
                    </div>
                @endif
            </div>
        @else
            <div class="rounded-2xl border border-dashed border-neutral-300 bg-white/50 py-16 text-center">
                <p class="text-sm text-neutral-400">
                    No before and after results available at the moment.
                </p>
            </div>
        @endif

    </div>
</section>