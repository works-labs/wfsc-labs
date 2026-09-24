<section
    id="before-after-filters"
    class="sticky top-0 z-40 border-y border-neutral-200/70 bg-white/90 backdrop-blur-xl sm:top-20"
>
    <div class="mx-auto max-w-7xl px-4 sm:px-8 lg:px-12">
        <div class="py-2.5 sm:py-3" data-chip-scroll-container>
            <div
                class="flex gap-2 overflow-x-auto scrollbar-hide"
                style="scrollbar-width: none;"
                data-chip-scroll-track
            >

                @foreach ($treatments as $treatment)
                    <a
                        href="#treatment-{{ $treatment->id }}"
                        data-treatment-chip="{{ $treatment->id }}"
                        class="before-after-chip shrink-0 rounded-full border border-neutral-200 bg-white px-4 py-2 text-xs font-medium text-neutral-600 transition hover:border-wfsc-coral hover:text-wfsc-coral [&.bg-wfsc-coral]:hover:text-white sm:px-5 sm:py-2.5 sm:text-sm"
                    >
                        {{ $treatment->name }}
                    </a>
                @endforeach

            </div>

            {{-- Scroll Indicator Dots --}}
            <div class="mt-2 flex items-center justify-center gap-1.5 opacity-60">
                <span data-chip-dot class="h-1.5 w-1.5 rounded-full bg-[#FF5252] transition-colors duration-300"></span>
                <span data-chip-dot class="h-1.5 w-1.5 rounded-full bg-neutral-300 transition-colors duration-300"></span>
                <span data-chip-dot class="h-1.5 w-1.5 rounded-full bg-neutral-300 transition-colors duration-300"></span>
            </div>
        </div>
    </div>
</section>