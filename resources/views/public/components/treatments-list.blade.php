<section id="treatment-list" class="relative overflow-hidden bg-white py-16 sm:py-20 lg:py-32">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-12">
        {{-- Header & Navigation (Centered dengan Max-Width agar tidak melebar penuh) --}}
        <div class="mx-auto mb-10 flex max-w-2xl flex-col items-center text-center gap-6 sm:mb-14 lg:mb-16">
            {{-- Header Text --}}
            <div>
                <div data-reveal="fade-up" data-delay="100" class="reveal-hidden inline-flex items-center gap-2 rounded-full border border-[#FF5252]/20 bg-[#FF5252]/5 px-3.5 py-1 sm:px-4 sm:py-1.5">
                    <span class="h-1.5 w-1.5 rounded-full bg-[#FF5252]"></span>
                    <span class="text-[11px] font-semibold uppercase tracking-[0.2em] text-[#FF5252] sm:text-xs">
                        Our Treatments
                    </span>
                </div>
                {{-- Responsive Heading --}}
                <h2 data-reveal="fade-up" data-delay="200" class="reveal-hidden mt-3 text-3xl font-bold tracking-tight text-neutral-900 sm:mt-4 sm:text-4xl md:text-5xl">
                    Find the Right Treatment
                    <span class="text-[#FF5252]">for You</span>
                </h2>
                <p data-reveal="fade-up" data-delay="300" class="reveal-hidden mt-3 text-sm leading-relaxed text-neutral-500 sm:mt-4 sm:text-base">
                    Pilihan perawatan estetika yang dirancang untuk membantu
                    memenuhi kebutuhan kulit dan kecantikan Anda.
                </p>
            </div>
            {{-- Navigation Buttons --}}
            <div data-reveal="fade-up" data-delay="300" class="reveal-hidden flex items-center justify-center gap-2.5 sm:gap-3">
                <button
                    type="button"
                    data-treatment-list-prev
                    class="flex h-10 w-10 items-center justify-center rounded-full border border-neutral-200 bg-white text-neutral-900 transition-all duration-300 hover:border-[#FF5252] hover:bg-[#FF5252] hover:text-white disabled:cursor-not-allowed disabled:opacity-40 sm:h-11 sm:w-11"
                    aria-label="Previous treatments"
                >
                    ←
                </button>
                <button
                    type="button"
                    data-treatment-list-next
                    class="flex h-10 w-10 items-center justify-center rounded-full border border-neutral-200 bg-white text-neutral-900 transition-all duration-300 hover:border-[#FF5252] hover:bg-[#FF5252] hover:text-white disabled:cursor-not-allowed disabled:opacity-40 sm:h-11 sm:w-11"
                    aria-label="Next treatments"
                >
                    →
                </button>
            </div>
        </div>

        {{-- Slider Track --}}
        @if ($treatments->isNotEmpty())
            <div
                data-reveal="zoom"
                data-delay="400"
                data-treatment-list-slider
                class="reveal-hidden relative overflow-hidden"
            >
                <div
                    data-treatment-list-track
                    class="-mx-2 flex transition-transform duration-500 ease-out sm:-mx-3"
                >
                    @foreach ($treatments as $treatment)
                        {{-- Item Card Responsive Columns: 1 Kolom Mobile, 2 Kolom Tablet/Laptop Kecil, 4 Kolom Desktop --}}
                        <div
                            data-treatment-list-slide
                            class="w-full shrink-0 px-2 sm:w-1/2 sm:px-3 lg:w-1/3 xl:w-1/4"
                        >
                            <article
                                class="group flex h-full flex-col overflow-hidden rounded-2xl border border-neutral-200/80 bg-white transition-all duration-500 hover:-translate-y-1.5 hover:border-[#FF5252]/30 hover:shadow-[0_20px_40px_rgba(255,82,82,0.12)] sm:rounded-[1.75rem]"
                            >
                                {{-- Responsive Aspect Ratio Image Container --}}
                                <div class="relative aspect-[4/4] overflow-hidden bg-neutral-100 sm:aspect-[4/5]">
                                    @if ($treatment->cover_image)
                                        <img
                                            src="{{ asset('storage/' . $treatment->cover_image) }}"
                                            alt="{{ $treatment->name }}"
                                            class="h-full w-full object-cover transition duration-700 ease-out group-hover:scale-105"
                                        >
                                    @else
                                        <div class="flex h-full w-full items-center justify-center text-xs text-neutral-400 sm:text-sm">
                                            No Image
                                        </div>
                                    @endif
                                    {{-- Hover Overlay --}}
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
                                    {{-- Featured Badge --}}
                                    @if ($treatment->is_featured)
                                        <div class="absolute left-3 top-3 rounded-full bg-white/90 px-2.5 py-1 text-[9px] font-bold uppercase tracking-wider text-[#FF5252] backdrop-blur shadow-sm sm:left-4 sm:top-4 sm:px-3 sm:py-1.5 sm:text-[10px]">
                                            Featured
                                        </div>
                                    @endif
                                </div>
                                {{-- Card Content Body --}}
                                <div class="flex grow flex-col p-4 sm:p-6">
                                    {{-- Category --}}
                                    @if ($treatment->category)
                                        <span class="text-[10px] font-semibold uppercase tracking-[0.15em] text-[#FF5252] sm:text-[11px]">
                                            {{ $treatment->category->name }}
                                        </span>
                                    @endif
                                    {{-- Name --}}
                                    <h3 class="mt-1.5 text-lg font-bold tracking-tight text-neutral-900 transition-colors duration-300 group-hover:text-[#FF5252] sm:mt-2 sm:text-xl">
                                        {{ $treatment->name }}
                                    </h3>
                                    {{-- Description --}}
                                    @if ($treatment->short_description)
                                        <p class="mt-2 line-clamp-2 text-xs leading-relaxed text-neutral-500 sm:mt-3 sm:line-clamp-3 sm:text-sm">
                                            {{ $treatment->short_description }}
                                        </p>
                                    @endif
                                    {{-- Action Footer --}}
                                    <div class="mt-auto pt-4 sm:pt-5">
                                        <div class="border-t border-neutral-100 pt-3 sm:pt-4">
                                            <a
                                                href="{{ route('treatment.show', $treatment->slug) }}"
                                                class="inline-flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-wider text-neutral-900 transition-colors duration-300 hover:text-[#FF5252] sm:gap-2 sm:text-xs"
                                            >
                                                <span>View Treatment</span>
                                                <span class="transition-transform duration-300 group-hover:translate-x-1">
                                                    →
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
            {{-- Progress Dots --}}
            <div
                data-reveal="zoom"
                data-delay="600"
                data-treatment-list-dots
                class="reveal-hidden mt-6 flex justify-center gap-2 sm:mt-8"
            ></div>
        @else
            <div class="rounded-2xl border border-dashed border-neutral-200 bg-neutral-50 py-12 text-center sm:py-16">
                <p class="text-xs text-neutral-400 sm:text-sm">
                    No treatments available at the moment.
                </p>
            </div>
        @endif
    </div>
</section>