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

                <button
                    type="button"
                    data-lightbox-trigger

                    data-before-src="{{ Storage::url($beforeAfter->before_media) }}"
                    data-before-type="{{ $beforeAfter->before_media_type }}"

                    data-after-src="{{ Storage::url($beforeAfter->after_media) }}"
                    data-after-type="{{ $beforeAfter->after_media_type }}"

                    data-caption="{{ $beforeAfter->caption }}"
                    data-treatment="{{ $treatment->name }}"

                    data-reveal="up"
                    data-delay="{{ ($index + 1) * 100 }}"

                    class="reveal-hidden group overflow-hidden rounded-2xl border border-neutral-200 bg-white text-left shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl"
                >

                    {{-- Media --}}
                    <div class="grid grid-cols-2">

                        {{-- Before --}}
                        <div
                            class="relative aspect-[4/5] overflow-hidden bg-neutral-100"
                        >

                            @if ($beforeAfter->before_media_type === 'video')

                                <video
                                    src="{{ Storage::url($beforeAfter->before_media) }}"
                                    muted
                                    loop
                                    autoplay
                                    playsinline
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                ></video>

                            @else

                                <img
                                    src="{{ Storage::url($beforeAfter->before_media) }}"
                                    alt="Before {{ $treatment->name }}"
                                    loading="lazy"
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                >

                            @endif

                            <span
                                class="absolute left-3 top-3 rounded-full bg-black/70 px-3 py-1 text-xs font-semibold text-white backdrop-blur-sm"
                            >
                                Before
                            </span>

                        </div>


                        {{-- After --}}
                        <div
                            class="relative aspect-[4/5] overflow-hidden bg-neutral-100"
                        >

                            @if ($beforeAfter->after_media_type === 'video')

                                <video
                                    src="{{ Storage::url($beforeAfter->after_media) }}"
                                    muted
                                    loop
                                    autoplay
                                    playsinline
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                ></video>

                            @else

                                <img
                                    src="{{ Storage::url($beforeAfter->after_media) }}"
                                    alt="After {{ $treatment->name }}"
                                    loading="lazy"
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                >

                            @endif

                            <span
                                class="absolute right-3 top-3 rounded-full bg-wfsc-coral px-3 py-1 text-xs font-semibold text-white"
                            >
                                After
                            </span>

                        </div>

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