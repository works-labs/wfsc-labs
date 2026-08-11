@php
    use Illuminate\Support\Facades\Storage;
@endphp

<section class="relative overflow-hidden bg-neutral-100/80 py-24 lg:py-32">
    {{-- Decorative Glow Background (Soft Ambient) --}}
    <div class="pointer-events-none absolute right-0 top-1/4 h-96 w-96 rounded-full bg-[#FF5252]/5 blur-3xl"></div>
    <div class="pointer-events-none absolute bottom-0 left-0 h-96 w-96 rounded-full bg-[#FF5252]/5 blur-3xl"></div>

    <div class="relative mx-auto max-w-7xl px-6 lg:px-12">

        {{-- Section Heading --}}
        <div class="mb-16 text-center">
            <div class="inline-flex items-center gap-2 rounded-full border border-[#FF5252]/20 bg-[#FF5252]/5 px-4 py-1.5">
                <span class="h-1.5 w-1.5 rounded-full bg-[#FF5252]"></span>
                <span class="text-xs font-semibold uppercase tracking-[0.2em] text-[#FF5252]">
                    Why Choose WFSC
                </span>
            </div>

            <h2 class="mt-4 text-4xl font-bold tracking-tight text-neutral-900 lg:text-5xl">
                Why Choose WFSC?
            </h2>
        </div>

        {{-- Content Grid --}}
        <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-20">

            {{-- LEFT : Why Choose Items --}}
            <div>
                @if ($whyChooseItems->isNotEmpty())

                    <div class="space-y-8">

                        @foreach ($whyChooseItems as $item)
                            <article class="group flex gap-5">

                                {{-- Icon Box --}}
                                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl border border-neutral-200/80 bg-white shadow-sm transition-all duration-300 group-hover:border-[#FF5252]/30 group-hover:bg-[#FF5252] group-hover:text-white group-hover:shadow-lg group-hover:shadow-[#FF5252]/20">
                                    @if ($item->icon)
                                        <span class="text-xl transition-transform duration-300 group-hover:scale-110">
                                            {{ $item->icon }}
                                        </span>
                                    @else
                                        <span class="text-sm font-bold text-[#FF5252] transition-colors duration-300 group-hover:text-white">
                                            ✓
                                        </span>
                                    @endif
                                </div>

                                {{-- Text --}}
                                <div class="pt-1">
                                    <h3 class="text-xl font-bold text-neutral-900 transition-colors duration-300 group-hover:text-[#FF5252]">
                                        {{ $item->title }}
                                    </h3>

                                    @if ($item->description)
                                        <p class="mt-2 max-w-lg text-sm leading-relaxed text-neutral-500">
                                            {{ $item->description }}
                                        </p>
                                    @endif
                                </div>

                            </article>
                        @endforeach

                    </div>

                @else

                    <p class="text-neutral-500">
                        No information available.
                    </p>

                @endif
            </div>


            {{-- RIGHT : Facility Slider --}}
            <div
                data-facility-slider
                class="relative"
            >

                @if ($facilities->isNotEmpty())

                    <div class="relative overflow-hidden rounded-[2.5rem] border border-neutral-200/80 bg-white p-3 shadow-xl shadow-neutral-200/50">

                        @foreach ($facilities as $index => $facility)

                            <article
                                data-facility-slide
                                class="{{ $index === 0 ? '' : 'hidden' }} transition-opacity duration-500"
                            >

                                {{-- Image with Subtle Gradient --}}
                                @if ($facility->image)
                                    <div class="relative aspect-[4/3] overflow-hidden rounded-[2rem] bg-neutral-200">
                                        <img
                                            src="{{ Storage::url($facility->image) }}"
                                            alt="{{ $facility->name }}"
                                            class="h-full w-full object-cover transition duration-700 hover:scale-105"
                                        >
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent"></div>
                                    </div>
                                @endif

                                {{-- Facility Info Box --}}
                                <div class="p-5 pt-6">
                                    <span class="text-[11px] font-semibold uppercase tracking-wider text-[#FF5252]">
                                        Our Facility
                                    </span>

                                    <h3 class="mt-1 text-2xl font-bold text-neutral-900">
                                        {{ $facility->name }}
                                    </h3>

                                    @if ($facility->description)
                                        <p class="mt-2 text-sm leading-relaxed text-neutral-500">
                                            {{ $facility->description }}
                                        </p>
                                    @endif
                                </div>

                            </article>

                        @endforeach

                    </div>


                    {{-- Facility Indicators (Pill Style) --}}
                    @if ($facilities->count() > 1)

                        <div class="mt-6 flex items-center justify-center gap-2">

                            @foreach ($facilities as $index => $facility)
                                <button
                                    type="button"
                                    data-facility-dot="{{ $index }}"
                                    class="h-2 rounded-full transition-all duration-300 {{ $index === 0 ? 'w-8 bg-[#FF5252]' : 'w-2 bg-neutral-300 hover:bg-neutral-400' }}"
                                    aria-label="Go to facility {{ $index + 1 }}"
                                ></button>
                            @endforeach

                        </div>

                    @endif

                @else

                    <div class="rounded-[2.5rem] border border-dashed border-neutral-300 bg-neutral-200/50 p-12 text-center">
                        <p class="text-sm text-neutral-500">
                            No facilities available.
                        </p>
                    </div>

                @endif

            </div>

        </div>

    </div>
</section>