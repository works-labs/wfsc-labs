<section id="treatments" class="relative bg-[#FAF9F6] py-24 lg:py-32 overflow-hidden">
    {{-- Aksen Dekoratif Latar Belakang (Soft Glow) --}}
    <div class="pointer-events-none absolute -left-20 top-1/2 h-96 w-96 -translate-y-1/2 rounded-full bg-[#FF5252]/5 blur-3xl"></div>
    <div class="pointer-events-none absolute -right-20 top-1/3 h-96 w-96 rounded-full bg-[#FF5252]/5 blur-3xl"></div>

    <div class="relative mx-auto max-w-7xl px-6 lg:px-12">

        {{-- Section Header --}}
        <div class="mb-16 text-center">
            <div class="inline-flex items-center gap-2 rounded-full border border-[#FF5252]/20 bg-[#FF5252]/5 px-4 py-1.5">
                <span class="h-1.5 w-1.5 rounded-full bg-[#FF5252]"></span>
                <span class="text-xs font-semibold uppercase tracking-[0.2em] text-[#FF5252]">
                    Expert Care & Treatment
                </span>
            </div>

            <h2 class="mt-4 text-4xl font-bold tracking-tight text-neutral-900 lg:text-5xl">
                Our Signature Treatments
            </h2>
            
            <p class="mx-auto mt-4 max-w-xl text-base leading-relaxed text-neutral-500">
                Rangkaian perawatan estetika medis berstandar tinggi yang dirancang khusus untuk kesehatan dan kemilau alami kulit Anda.
            </p>
        </div>

        {{-- Treatment Cards (Mobile: Horizontal Scroll / Desktop: 4 Grid) --}}
        @if ($treatmentCategories->isNotEmpty())
            <div class="flex gap-6 overflow-x-auto snap-x snap-mandatory pb-6 pt-2 scrollbar-none sm:grid sm:grid-cols-2 sm:overflow-visible sm:pb-0 sm:pt-0 lg:grid-cols-4">
                @foreach ($treatmentCategories as $category)
                    <article class="group flex w-[80vw] shrink-0 snap-center flex-col justify-between overflow-hidden rounded-[1.75rem] border border-neutral-200/80 bg-white shadow-[0_4px_20px_rgba(0,0,0,0.03)] transition-all duration-500 hover:-translate-y-2 hover:border-[#FF5252]/30 hover:shadow-[0_12px_30px_rgba(255,82,82,0.12)] sm:w-auto">

                        <div>
                            {{-- Image Container --}}
                            <div class="relative aspect-[4/5] overflow-hidden bg-neutral-100">
                                @if ($category->image)
                                    <img
                                        src="{{ asset('storage/' . $category->image) }}"
                                        alt="{{ $category->name }}"
                                        class="h-full w-full object-cover transition duration-700 ease-out group-hover:scale-105"
                                    >
                                @else
                                    <div class="flex h-full w-full items-center justify-center bg-neutral-100 text-xs text-neutral-400">
                                        (Foto Treatment)
                                    </div>
                                @endif

                                {{-- Soft Gradient Overlay saat Hover --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
                            </div>

                            {{-- Content --}}
                            <div class="p-6">
                                <span class="text-[11px] font-semibold uppercase tracking-wider text-neutral-400">
                                    Aesthetic Care
                                </span>

                                <h3 class="mt-1 text-xl font-bold tracking-tight text-neutral-900 transition-colors duration-300 group-hover:text-[#FF5252]">
                                    {{ $category->name }}
                                </h3>

                                @if ($category->description)
                                    <p class="mt-2.5 line-clamp-3 text-sm leading-relaxed text-neutral-500">
                                        {{ $category->description }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        {{-- Action Read More --}}
                        <div class="px-6 pb-6 pt-0">
                            <a 
                                href="{{ route('treatments.index') }}" 
                                class="inline-flex w-full items-center justify-between border-t border-neutral-100 pt-4 text-xs font-bold uppercase tracking-wider text-neutral-900 transition-all duration-300 group-hover:border-[#FF5252]/20 group-hover:text-[#FF5252]"
                            >
                                <span>Explore Treatments</span>
                                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-neutral-100 text-neutral-900 transition-all duration-300 group-hover:bg-[#FF5252] group-hover:text-white group-hover:translate-x-1">
                                    →
                                </span>
                            </a>
                        </div>

                    </article>
                @endforeach
            </div>
        @else
            <div class="rounded-2xl border border-dashed border-neutral-200 bg-white py-16 text-center">
                <p class="text-sm text-neutral-400">
                    No treatments available at the moment.
                </p>
            </div>
        @endif

    </div>
</section>