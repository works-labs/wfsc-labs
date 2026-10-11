<section
    id="treatment-{{ $treatment->id }}"
    data-treatment-section="{{ $treatment->id }}"
    class="scroll-mt-24 border-b border-neutral-100 py-10 sm:py-14"
>
    <div class="mx-auto max-w-7xl px-6 sm:px-8 lg:px-12">

        {{-- Treatment Header --}}
        <div
            data-reveal="up"
            data-delay="0"
            class="reveal-hidden"
        >
            <h2
                class="text-3xl font-black tracking-tight text-neutral-900 sm:text-4xl"
            >
                {{ $treatment->name }}
            </h2>

            @if ($treatment->short_description)
                <p
                    class="mt-3 max-w-2xl text-base leading-relaxed text-neutral-600"
                >
                    {{ $treatment->short_description }}
                </p>
            @endif
        </div>


        {{-- Before & After Cards --}}
        <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

            @foreach ($treatment->beforeAfters as $index => $beforeAfter)

                @php
                    $displayMedia = $beforeAfter->after_media ?: $beforeAfter->before_media;
                    $displayMediaType = $beforeAfter->after_media
                        ? $beforeAfter->after_media_type
                        : $beforeAfter->before_media_type;
                @endphp

                <button
                    type="button"
                    data-lightbox-trigger

                    data-before-src="{{ Storage::url($beforeAfter->before_media) }}"
                    data-before-type="{{ $beforeAfter->before_media_type }}"

                    data-after-src="{{ Storage::url($displayMedia) }}"
                    data-after-type="{{ $displayMediaType }}"

                    data-caption="{{ $beforeAfter->caption }}"
                    data-treatment="{{ $treatment->name }}"

                    data-reveal="up"
                    data-delay="{{ ($index + 1) * 100 }}"

                    class="reveal-hidden group relative overflow-hidden rounded-2xl border border-neutral-200 bg-white text-left shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl"
                >

                    {{-- Single Result Media --}}
                    <div class="relative aspect-[4/5] overflow-hidden bg-neutral-100">
                        @if ($displayMediaType === 'video')
                            <video
                                src="{{ Storage::url($displayMedia) }}"
                                muted
                                loop
                                autoplay
                                playsinline
                                class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                            ></video>
                        @else
                            <img
                                src="{{ Storage::url($displayMedia) }}"
                                alt="Hasil {{ $treatment->name }}"
                                loading="lazy"
                                class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                            >
                        @endif

                        <span class="absolute left-3 top-3 rounded-full bg-wfsc-coral px-3 py-1 text-xs font-semibold text-white">
                            Hasil
                        </span>

                        {{-- Popup Indicator --}}
                        <span
                            class="pointer-events-none absolute bottom-3 right-3 flex h-10 w-10 items-center justify-center rounded-full bg-white/95 text-neutral-700 shadow-lg ring-1 ring-white/80 transition duration-300 group-hover:scale-110 group-hover:bg-wfsc-coral group-hover:text-white"
                            aria-hidden="true"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m2.1-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />
                            </svg>
                        </span>
                    </div>


                    {{-- Card Information --}}
                    <div class="p-4 sm:p-5">

                        <div
                            class="flex items-center justify-between gap-4"
                        >

                            <span
                                class="text-sm font-semibold text-neutral-900"
                            >
                                {{ $treatment->name }}
                            </span>

                            {{-- Arrow --}}
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 shrink-0 text-neutral-400 transition duration-300 group-hover:translate-x-1 group-hover:text-wfsc-coral"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6"
                                />
                            </svg>

                        </div>


                    @if ($beforeAfter->caption)

                            <p
                                class="mt-2 line-clamp-2 text-sm leading-relaxed text-neutral-500"
                            >
                                {{ $beforeAfter->caption }}
                            </p>
                        @endif
                    </div>

                </button>
            @endforeach
        </div>
    </div>
</section>
