@php
    $mapBranches = $branches
        ->filter(function ($branch) {
            return $branch->latitude !== null
                && $branch->longitude !== null;
        })
        ->map(function ($branch) {
            return [
                'id' => $branch->id,
                'name' => $branch->name,
                'address' => $branch->address,
                'latitude' => (float) $branch->latitude,
                'longitude' => (float) $branch->longitude,
                'maps_url' => $branch->google_maps_url,
            ];
        })
        ->values();
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
        @if ($mapBranches->isNotEmpty())

            <div class="grid gap-8 {{ $mapBranches->count() > 1 ? 'grid-cols-1 lg:grid-cols-2' : 'grid-cols-1' }}">

                @foreach ($mapBranches as $index => $branch)

                    <div
                        data-reveal="up"
                        data-delay="{{ 100 + ($index * 100) }}"
                        class="reveal-hidden overflow-hidden rounded-[2rem] border border-neutral-200 bg-neutral-100 p-4 shadow-[0_8px_30px_rgba(0,0,0,0.04)] flex flex-col"
                    >

                        <div class="mb-3 px-2 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">

                            <div>

                                <h3 class="text-lg font-bold text-neutral-900">
                                    {{ $branch['name'] }}
                                </h3>

                                @if ($branch['address'])

                                    <p class="mt-0.5 text-xs text-neutral-600">
                                        {{ $branch['address'] }}
                                    </p>

                                @endif

                            </div>

                            @if ($branch['maps_url'])

                                <a
                                    href="{{ $branch['maps_url'] }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex shrink-0 items-center text-xs font-semibold text-[#FF5252] transition hover:underline"
                                >
                                    Buka Google Maps →
                                </a>

                            @endif

                        </div>

                        <div
                            id="branch-map-{{ $index }}"
                            class="w-full flex-1 rounded-[1.5rem] min-h-[380px] {{ $mapBranches->count() === 1 ? 'h-[480px]' : 'h-[400px]' }}"
                        ></div>

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


@if ($mapBranches->isNotEmpty())

    @push('styles')

        <link
            rel="stylesheet"
            href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        >

    @endpush


    @push('scripts')

        <script
            src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        ></script>

        <script>

            document.addEventListener('DOMContentLoaded', function () {

                const branches = @json($mapBranches);

                if (!branches.length) {
                    return;
                }

                branches.forEach(function (branch, index) {

                    const container = document.getElementById('branch-map-' + index);
                    if (!container) return;

                    const map = L.map('branch-map-' + index).setView([
                        branch.latitude,
                        branch.longitude
                    ], 15);


                    L.tileLayer(
                        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                        {
                            attribution: '&copy; OpenStreetMap contributors',
                        }
                    ).addTo(map);


                    const marker = L.marker([
                        branch.latitude,
                        branch.longitude
                    ]).addTo(map);


                    let popup = `
                        <div style="min-width: 180px;">

                            <strong style="
                                font-size: 14px;
                                font-weight: 700;
                            ">
                                ${branch.name}
                            </strong>
                    `;


                    if (branch.address) {

                        popup += `
                            <p style="
                                margin-top: 6px;
                                font-size: 12px;
                                line-height: 1.5;
                                color: #666;
                            ">
                                ${branch.address}
                            </p>
                        `;

                    }


                    if (branch.maps_url) {

                        popup += `
                            <a
                                href="${branch.maps_url}"
                                target="_blank"
                                rel="noopener noreferrer"
                                style="
                                    display: inline-block;
                                    margin-top: 6px;
                                    font-size: 12px;
                                    font-weight: 600;
                                    color: #FF5252;
                                    text-decoration: none;
                                "
                            >
                                Buka Google Maps →
                            </a>
                        `;

                    }


                    popup += `
                        </div>
                    `;


                    marker.bindPopup(popup);

                });

            });

        </script>

    @endpush

@endif