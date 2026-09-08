<section class="relative isolate overflow-hidden bg-wfsc-coral text-white">

    {{-- Decorative background --}}
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

            {{-- Category --}}
            @if ($treatment->category)
                <div
                    data-reveal="left"
                    data-delay="0"
                    class="reveal-hidden mb-6"
                >
                    <span
                        class="inline-flex items-center rounded-full border border-white/30 bg-white/10 px-4 py-2 text-sm font-medium backdrop-blur-sm"
                    >
                        {{ $treatment->category->name }}
                    </span>
                </div>
            @endif


            {{-- Treatment Name --}}
            <h1
                data-reveal="left"
                data-delay="100"
                class="reveal-hidden text-4xl font-black leading-tight tracking-tight sm:text-5xl lg:text-6xl"
            >
                {{ $treatment->name }}
            </h1>


            {{-- Short Description --}}
            @if ($treatment->short_description)
                <p
                    data-reveal="left"
                    data-delay="200"
                    class="reveal-hidden mt-6 max-w-2xl text-base leading-relaxed text-white/85 sm:text-lg"
                >
                    {{ $treatment->short_description }}
                </p>
            @endif


            {{-- Back Button --}}
            <div
                data-reveal="left"
                data-delay="300"
                class="reveal-hidden mt-10"
            >
                <a
                    href="{{ route('treatments.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-medium text-white/90 transition hover:text-white"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15 19l-7-7 7-7"
                        />
                    </svg>

                    Kembali ke Treatments
                </a>
            </div>

        </div>

    </div>

</section>