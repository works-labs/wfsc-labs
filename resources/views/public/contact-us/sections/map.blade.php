@php
    $surabayaIframe = 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d4570.895262191231!2d112.6430698!3d-7.2790707!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fda60cca1a45%3A0x51617295fc499b11!2sWFSC%20Aesthetic%20%26%20Anti%20Aging%20Clinic%20Surabaya!5e1!3m2!1sid!2sid!4v1790226158694!5m2!1sid!2sid';
    $berauIframe = 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d4604.761953993778!2d117.4944879!3d2.1587691!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x320df5fad707a147%3A0xc04a928aa82c0247!2sWijaya%20Farma%20Anti%20Aging%20%26%20Aesthetic%20Clinic!5e1!3m2!1sid!2sid!4v1790226207962!5m2!1sid!2sid';
@endphp

<section class="relative bg-white px-6 py-16 lg:px-12 lg:py-24">

    <div class="mx-auto max-w-7xl">

        {{-- Header --}}
        <div
            data-reveal="up"
            data-delay="0"
            class="reveal-hidden mb-10 flex flex-col gap-4 sm:mb-14"
        >

            <span class="text-sm font-semibold uppercase tracking-[0.2em] text-wfsc-coral">
                Location
            </span>

            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">

                <div>

                    <h2 class="text-3xl font-black tracking-tight text-neutral-900 sm:text-4xl">
                        Temukan Lokasi Kami
                    </h2>

                    <p class="mt-3 max-w-2xl text-base leading-relaxed text-neutral-600">
                        Lihat lokasi seluruh cabang WFSC Clinic dan pilih cabang yang paling nyaman untuk Anda kunjungi.
                    </p>

                </div>

            </div>

        </div>


        {{-- Map Grid --}}
        @if ($branches->isNotEmpty())

            <div class="grid gap-8 {{ $branches->count() > 1 ? 'grid-cols-1 lg:grid-cols-2' : 'grid-cols-1' }}">

                @foreach ($branches as $index => $branch)
                    @php
                        $isBerau = Str::contains(strtolower($branch->name), 'berau') || Str::contains(strtolower($branch->address ?? ''), 'berau');
                        $embedSrc = $branch->google_maps_embed_url ?? ($isBerau ? $berauIframe : $surabayaIframe);
                    @endphp

                    <div
                        data-reveal="up"
                        data-delay="{{ 100 + ($index * 100) }}"
                        class="reveal-hidden overflow-hidden rounded-[2rem] border border-neutral-200 bg-neutral-100 p-4 shadow-[0_8px_30px_rgba(0,0,0,0.04)] flex flex-col"
                    >

                        <div class="mb-3 px-2 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">

                            <div>

                                <h3 class="text-lg font-bold text-neutral-900">
                                    {{ $branch->name }}
                                </h3>

                                @if ($branch->address)

                                    <p class="mt-0.5 text-xs text-neutral-600">
                                        {{ $branch->address }}
                                    </p>

                                @endif

                            </div>

                            @if ($branch->google_maps_url)

                                <a
                                    href="{{ $branch->google_maps_url }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex shrink-0 items-center text-xs font-semibold text-[#FF5252] transition hover:underline"
                                >
                                    Buka Google Maps →
                                </a>

                            @endif

                        </div>

                        <div class="w-full flex-1 overflow-hidden rounded-[1.5rem] min-h-[380px] {{ $branches->count() === 1 ? 'h-[480px]' : 'h-[400px]' }}">
                            <iframe
                                src="{{ $embedSrc }}"
                                class="w-full h-full border-0"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="strict-origin-when-cross-origin"
                            ></iframe>
                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="rounded-[1.75rem] border border-dashed border-neutral-300 bg-[#FAF9F6] px-6 py-20 text-center">

                <p class="text-sm text-neutral-500">
                    Lokasi cabang belum tersedia.
                </p>

            </div>

        @endif

    </div>

</section>