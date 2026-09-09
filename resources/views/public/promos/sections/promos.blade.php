<section class="py-12 sm:py-16">

    <div class="mx-auto max-w-7xl px-6 sm:px-8 lg:px-12">

        {{-- Section Header --}}
        <div
            data-reveal="up"
            data-delay="0"
            class="reveal-hidden max-w-3xl"
        >

            <span
                class="text-sm font-semibold uppercase tracking-[0.2em] text-wfsc-coral"
            >
                Promo
            </span>

            <h2
                class="mt-2 text-3xl font-black tracking-tight text-neutral-900 sm:text-4xl"
            >
                Promo Menarik Untuk Kamu
            </h2>

            <p
                class="mt-3 text-base leading-relaxed text-neutral-600"
            >
                Nikmati berbagai penawaran dan promo menarik dari WFSC Clinic.
            </p>

        </div>


        {{-- Promo Cards --}}
        @if ($promos->isNotEmpty())

            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

                @foreach ($promos as $index => $promo)

                    <button
                        type="button"

                        data-promo-lightbox-trigger

                        data-promo-title="{{ $promo->title }}"
                        data-promo-description="{{ $promo->description ?? '' }}"
                        data-promo-image="{{ $promo->image ? Storage::url($promo->image) : '' }}"

                        data-reveal="up"
                        data-delay="{{ ($index + 1) * 100 }}"

                        class="reveal-hidden group overflow-hidden rounded-2xl border border-neutral-200 bg-white text-left shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl"
                    >

                        {{-- Promo Image --}}
                        @if ($promo->image)

                            <div
                                class="relative aspect-[4/3] overflow-hidden bg-neutral-100"
                            >

                                <img
                                    src="{{ Storage::url($promo->image) }}"
                                    alt="{{ $promo->title }}"
                                    loading="lazy"
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                >

                                {{-- Overlay --}}
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 transition duration-300 group-hover:opacity-100"
                                ></div>

                            </div>

                        @endif


                        {{-- Card Content --}}
                        <div class="p-5">

                            <div
                                class="flex items-start justify-between gap-4"
                            >

                                <h3
                                    class="text-lg font-bold text-neutral-900"
                                >
                                    {{ $promo->title }}
                                </h3>


                                {{-- Arrow --}}
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="mt-1 h-4 w-4 shrink-0 text-neutral-400 transition duration-300 group-hover:translate-x-1 group-hover:text-wfsc-coral"
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


                            @if ($promo->description)

                                <p
                                    class="mt-2 line-clamp-3 text-sm leading-relaxed text-neutral-500"
                                >
                                    {{ $promo->description }}
                                </p>

                            @endif

                        </div>

                    </button>

                @endforeach

            </div>

        @else

            {{-- Empty State --}}
            <div
                class="mt-8 rounded-2xl border border-dashed border-neutral-200 px-6 py-16 text-center"
            >

                <p class="text-sm text-neutral-500">
                    Belum ada promo yang tersedia saat ini.
                </p>

            </div>

        @endif

    </div>

</section>