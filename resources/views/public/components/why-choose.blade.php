@php
    use Illuminate\Support\Facades\Storage;
@endphp

<section class="relative overflow-hidden bg-neutral-100/80 py-16 sm:py-20 lg:py-32">
    {{-- Decorative Glow Background (Soft Ambient) --}}
    <div class="pointer-events-none absolute right-0 top-1/4 h-72 w-72 rounded-full bg-[#FF5252]/5 blur-3xl sm:h-96 sm:w-96"></div>
    <div class="pointer-events-none absolute bottom-0 left-0 h-72 w-72 rounded-full bg-[#FF5252]/5 blur-3xl sm:h-96 sm:w-96"></div>
    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-12">
        {{-- Section Heading (Fade-In Down) --}}
        <div class="mb-12 text-center sm:mb-16">
            <div data-reveal="down" data-delay="100" class="reveal-hidden inline-flex items-center gap-2 rounded-full border border-[#FF5252]/20 bg-[#FF5252]/5 px-3.5 py-1 sm:px-4 sm:py-1.5">
                <span class="h-1.5 w-1.5 rounded-full bg-[#FF5252]"></span>
                <span class="text-[11px] font-semibold uppercase tracking-[0.2em] text-[#FF5252] sm:text-xs">
                    Why Choose WFSC
                </span>
            </div>
            <h2 data-reveal="down" data-delay="200" class="reveal-hidden mt-3 text-3xl font-bold tracking-tight text-neutral-900 sm:mt-4 sm:text-4xl lg:text-5xl">
                Why Choose WFSC?
            </h2>
        </div>
        {{-- Content Grid --}}
        <div class="grid items-center gap-10 lg:grid-cols-12 lg:gap-12 xl:gap-20">
            {{-- LEFT : Why Choose Items (Staggered Animation) --}}
            <div class="lg:col-span-6 xl:col-span-7">
                @if ($whyChooseItems->isNotEmpty())
                    <div class="space-y-6 sm:space-y-8">
                        @foreach ($whyChooseItems as $index => $item)
                            <article 
                                data-reveal="left" 
                                data-delay="{{ 200 + ($index * 100) }}" 
                                class="reveal-hidden group flex gap-4 sm:gap-5"
                            >
                                {{-- Icon Box --}}
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl border border-neutral-200/80 bg-white shadow-sm transition-all duration-300 group-hover:border-[#FF5252]/30 group-hover:bg-[#FF5252] group-hover:text-white group-hover:shadow-lg group-hover:shadow-[#FF5252]/20 sm:h-14 sm:w-14">
                                    @if ($item->icon)
                                        <span class="text-lg transition-transform duration-300 group-hover:scale-110 sm:text-xl">
                                            {{ $item->icon }}
                                        </span>
                                    @else
                                        <span class="text-xs font-bold text-[#FF5252] transition-colors duration-300 group-hover:text-white sm:text-sm">
                                            ✓
                                        </span>
                                    @endif
                                </div>
                                {{-- Text --}}
                                <div class="pt-0.5 sm:pt-1">
                                    <h3 class="text-lg font-bold text-neutral-900 transition-colors duration-300 group-hover:text-[#FF5252] sm:text-xl">
                                        {{ $item->title }}
                                    </h3>
                                    @if ($item->description)
                                        <p class="mt-1.5 max-w-lg text-xs leading-relaxed text-neutral-500 sm:mt-2 sm:text-sm">
                                            {{ $item->description }}
                                        </p>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs text-neutral-500 sm:text-sm">
                        No information available.
                    </p>
                @endif
            </div>
            {{-- RIGHT : Facility Slider (Zoom Reveal) --}}
            <div
                data-reveal="zoom"
                data-delay="400"
                data-facility-slider
                class="reveal-hidden relative lg:col-span-6 xl:col-span-5"
            >
                @if ($facilities->isNotEmpty())
                    <div class="relative overflow-hidden rounded-2xl border border-neutral-200/80 bg-white p-2.5 shadow-xl shadow-neutral-200/50 sm:rounded-[2.5rem] sm:p-3">
                        @foreach ($facilities as $index => $facility)
                            <article
                                data-facility-slide
                                class="{{ $index === 0 ? '' : 'hidden' }} transition-opacity duration-500"
                            >
                                {{-- Image Container (Fluid Aspect Ratio) --}}
                                @if ($facility->image)
                                    <div class="relative aspect-[4/3] overflow-hidden rounded-xl bg-neutral-200 sm:rounded-[2rem]">
                                        <img
                                            src="{{ Storage::url($facility->image) }}"
                                            alt="{{ $facility->name }}"
                                            class="h-full w-full object-cover transition duration-700 hover:scale-105"
                                        >
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent"></div>
                                    </div>
                                @endif
                                {{-- Facility Info Box --}}
                                <div class="p-4 pt-5 sm:p-5 sm:pt-6">
                                    <span class="text-[10px] font-semibold uppercase tracking-wider text-[#FF5252] sm:text-[11px]">
                                        Our Facility
                                    </span>
                                    <h3 class="mt-1 text-xl font-bold text-neutral-900 sm:text-2xl">
                                        {{ $facility->name }}
                                    </h3>
                                    @if ($facility->description)
                                        <p class="mt-1.5 text-xs leading-relaxed text-neutral-500 sm:mt-2 sm:text-sm">
                                            {{ $facility->description }}
                                        </p>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>

                    {{-- Facility Indicators --}}
                    @if ($facilities->count() > 1)
                        <div class="mt-5 flex items-center justify-center gap-2 sm:mt-6">
                            @foreach ($facilities as $index => $facility)
                                <button
                                    type="button"
                                    data-facility-dot="{{ $index }}"
                                    class="h-1.5 rounded-full transition-all duration-300 sm:h-2 {{ $index === 0 ? 'w-6 bg-[#FF5252] sm:w-8' : 'w-1.5 bg-neutral-300 hover:bg-neutral-400 sm:w-2' }}"
                                    aria-label="Go to facility {{ $index + 1 }}"
                                ></button>
                            @endforeach
                        </div>
                    @endif
                @else

                    <div class="rounded-2xl border border-dashed border-neutral-300 bg-neutral-200/50 p-8 text-center sm:rounded-[2.5rem] sm:p-12">
                        <p class="text-xs text-neutral-500 sm:text-sm">
                            No facilities available.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>