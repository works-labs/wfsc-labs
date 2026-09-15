<section id="treatments" class="relative bg-[#FAF9F6] py-10 sm:py-14 lg:py-20 overflow-hidden">
    {{-- Aksen Dekoratif Latar Belakang (Soft Glow) --}}
    <div class="pointer-events-none absolute -left-20 top-1/2 h-96 w-96 -translate-y-1/2 rounded-full bg-[#FF5252]/5 blur-3xl"></div>
    <div class="pointer-events-none absolute -right-20 top-1/3 h-96 w-96 rounded-full bg-[#FF5252]/5 blur-3xl"></div>

    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-12">

        {{-- Section Header & Navigation --}}
        <div class="mb-8 flex flex-col items-center text-center gap-4 sm:mb-10 lg:mb-12">
            <div>
                <div data-reveal="down" data-delay="100" class="reveal-hidden inline-flex items-center gap-2 rounded-full border border-[#FF5252]/20 bg-[#FF5252]/5 px-3.5 py-1 sm:px-4 sm:py-1.5">
                    <span class="h-1.5 w-1.5 rounded-full bg-[#FF5252]"></span>
                    <span class="text-[11px] font-semibold uppercase tracking-[0.2em] text-[#FF5252] sm:text-xs">
                        Expert Care & Treatment
                    </span>
                </div>

                <h2 data-reveal="down" data-delay="200" class="reveal-hidden mt-3 text-3xl font-bold tracking-tight text-neutral-900 sm:mt-4 sm:text-4xl lg:text-5xl">
                    Our Signature Treatments
                </h2>
                
                <p data-reveal="down" data-delay="300" class="reveal-hidden mx-auto mt-3 max-w-xl text-xs leading-relaxed text-neutral-500 sm:mt-4 sm:text-sm">
                    Rangkaian perawatan estetika medis berstandar tinggi yang dirancang khusus untuk kesehatan dan kemilau alami kulit Anda.
                </p>
            </div>
        </div>

        {{-- Treatment Cards (Mobile: Compact Horizontal Card / Tablet & Desktop: Vertical Grid Card) --}}
        @if ($treatmentCategories->isNotEmpty())
            <div data-reveal="zoom" data-delay="400" class="reveal-hidden grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-6 lg:grid-cols-4">
                @foreach ($treatmentCategories as $category)
                    <article class="group flex flex-row items-center gap-4 overflow-hidden rounded-[1.5rem] border border-neutral-200/80 bg-white p-3 shadow-sm transition-all duration-300 hover:border-[#FF5252]/30 hover:shadow-md sm:flex-col sm:items-stretch sm:justify-between sm:rounded-[1.75rem] sm:p-0 sm:shadow-[0_4px_20px_rgba(0,0,0,0.03)] sm:hover:-translate-y-2 sm:hover:shadow-[0_12px_30px_rgba(255,82,82,0.12)]">

                        {{-- Mobile Left Thumbnail / Desktop Top Image --}}
                        <div class="relative aspect-square w-24 shrink-0 overflow-hidden rounded-xl bg-neutral-100 sm:aspect-[4/5] sm:w-full sm:rounded-none">
                            @if ($category->image)
                                <img
                                    src="{{ asset('storage/' . $category->image) }}"
                                    alt="{{ $category->name }}"
                                    class="h-full w-full object-cover transition duration-700 ease-out group-hover:scale-105"
                                >
                            @else
                                <div class="flex h-full w-full items-center justify-center bg-neutral-100 text-[10px] text-neutral-400 sm:text-xs">
                                    No image
                                </div>
                            @endif

                            {{-- Soft Gradient Overlay saat Hover (Desktop) --}}
                            <div class="hidden sm:block absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
                        </div>

                        {{-- Content Box --}}
                        <div class="flex flex-1 flex-col justify-between py-1 sm:p-6">
                            <div>
                                <span class="text-[10px] font-semibold uppercase tracking-wider text-neutral-400 sm:text-[11px]">
                                    Aesthetic Care
                                </span>

                                <h3 class="mt-0.5 text-base font-bold tracking-tight text-neutral-900 transition-colors duration-300 group-hover:text-[#FF5252] sm:mt-1 sm:text-xl">
                                    {{ $category->name }}
                                </h3>

                                @if ($category->description)
                                    <p class="mt-1 line-clamp-2 text-xs leading-relaxed text-neutral-500 sm:mt-2.5 sm:line-clamp-3 sm:text-sm">
                                        {{ $category->description }}
                                    </p>
                                @endif
                            </div>

                            {{-- Action Link --}}
                            <div class="mt-3 border-t border-neutral-100 pt-2.5 sm:mt-4 sm:pt-4">
                                <a 
                                    href="{{ route('treatments.index') }}#category-{{ $category->id }}" 
                                    class="inline-flex w-full items-center justify-between text-[11px] font-bold uppercase tracking-wider text-neutral-900 transition-all duration-300 group-hover:text-[#FF5252] sm:text-xs"
                                >
                                    <span>Explore Treatments</span>
                                    <span class="flex h-5 w-5 items-center justify-center rounded-full bg-neutral-100 text-neutral-900 transition-all duration-300 group-hover:bg-[#FF5252] group-hover:text-white group-hover:translate-x-1 sm:h-7 sm:w-7">
                                        →
                                    </span>
                                </a>
                            </div>
                        </div>

                    </article>
                @endforeach
            </div>
        @else
            <div class="rounded-2xl border border-dashed border-neutral-200 bg-white py-12 text-center">
                <p class="text-sm text-neutral-400">
                    No treatments available at the moment.
                </p>
            </div>
        @endif

    </div>
</section>