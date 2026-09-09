<section
    id="before-after-filters"
    class="sticky top-0 z-40 border-y border-neutral-200/70 bg-white/90 backdrop-blur-xl sm:top-20"
>
    <div class="mx-auto max-w-7xl px-4 sm:px-8 lg:px-12">
        <div
            class="flex gap-2 overflow-x-auto py-2.5 sm:py-4"
            style="scrollbar-width: none;"
        >

            @foreach ($treatments as $treatment)
                <a
                    href="#treatment-{{ $treatment->id }}"
                    data-treatment-chip="{{ $treatment->id }}"
                    class="before-after-chip shrink-0 rounded-full border border-neutral-200 bg-white px-4 py-2 text-xs font-medium text-neutral-600 transition hover:border-wfsc-coral hover:text-wfsc-coral sm:px-5 sm:py-2.5 sm:text-sm"
                >
                    {{ $treatment->name }}
                </a>
            @endforeach

        </div>
    </div>
</section>