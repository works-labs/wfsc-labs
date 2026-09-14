<section class="relative overflow-hidden bg-[#FAF9F6] px-6 py-16 lg:px-12 lg:py-24">

    {{-- Decorative Glow --}}
    <div class="pointer-events-none absolute -left-20 top-1/4 h-96 w-96 rounded-full bg-[#FF5252]/5 blur-3xl"></div>

    <div class="relative mx-auto max-w-7xl">

        {{-- Section Header --}}
        <div
            data-reveal="up"
            data-delay="0"
            class="reveal-hidden mx-auto max-w-2xl text-center"
        >

            <span class="text-sm font-semibold uppercase tracking-[0.2em] text-wfsc-coral">
                Our Branches
            </span>

            <h2 class="mt-3 text-3xl font-black tracking-tight text-neutral-900 sm:text-4xl">
                Kunjungi Cabang Kami
            </h2>

            <p class="mt-4 text-base leading-relaxed text-neutral-600">
                Temukan lokasi WFSC Clinic dan kunjungi cabang yang paling dekat dengan Anda.
            </p>

        </div>


        @if ($branches->isNotEmpty())

            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:mt-14 lg:grid-cols-3">

                @foreach ($branches as $index => $branch)

                    <article
                        data-reveal="up"
                        data-delay="{{ ($index + 1) * 100 }}"
                        class="reveal-hidden group flex flex-col overflow-hidden rounded-[1.75rem] border border-neutral-200/80 bg-white p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] transition-all duration-500 hover:-translate-y-2 hover:border-[#FF5252]/30 hover:shadow-[0_12px_30px_rgba(255,82,82,0.12)]"
                    >

                        {{-- Location Icon --}}
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#FF5252]/10 text-[#FF5252] transition duration-300 group-hover:bg-[#FF5252] group-hover:text-white">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                />

                            </svg>

                        </div>


                        {{-- Content --}}
                        <div class="mt-6">

                            <h3 class="text-xl font-bold tracking-tight text-neutral-900 transition-colors duration-300 group-hover:text-[#FF5252]">
                                {{ $branch->name }}
                            </h3>

                            @if ($branch->address)

                                <p class="mt-3 text-sm leading-relaxed text-neutral-500">
                                    {{ $branch->address }}
                                </p>

                            @endif

                        </div>


                        {{-- Action --}}
                        <div class="mt-auto pt-8">

                            @if ($branch->google_maps_url)

                                <a
                                    href="{{ $branch->google_maps_url }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex w-full items-center justify-between border-t border-neutral-100 pt-4 text-xs font-bold uppercase tracking-wider text-neutral-900 transition-all duration-300 group-hover:border-[#FF5252]/20 group-hover:text-[#FF5252]"
                                >
                                    <span>Lihat Lokasi</span>

                                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-neutral-100 text-neutral-900 transition-all duration-300 group-hover:translate-x-1 group-hover:bg-[#FF5252] group-hover:text-white">
                                        →
                                    </span>

                                </a>

                            @endif

                        </div>

                    </article>

                @endforeach

            </div>

        @else

            <div class="mt-10 rounded-[1.75rem] border border-dashed border-neutral-300 bg-white/50 px-6 py-20 text-center">

                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-[#FF5252]/5 text-[#FF5252]">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0l-2 7H6l-2-7m16 0H4"
                        />
                    </svg>

                </div>

                <h3 class="mt-5 text-lg font-bold text-neutral-900">
                    Cabang Belum Tersedia
                </h3>

                <p class="mt-2 text-sm text-neutral-500">
                    Informasi cabang WFSC Clinic akan segera tersedia.
                </p>

            </div>

        @endif

    </div>

</section>