{{-- =========================================================
    4. PRODUCTS USED SECTION
========================================================== --}}
@if ($treatment->products->isNotEmpty())

<section class="bg-neutral-50 py-10 lg:py-14">
    <div class="mx-auto max-w-5xl px-6 lg:px-12">

        <div class="mb-6 lg:mb-8">
            <p class="text-xs font-medium uppercase tracking-[0.25em] text-neutral-400">
                Recommended
            </p>
            <h2 class="mt-1.5 text-2xl font-bold tracking-tight text-neutral-900 lg:text-3xl">
                Products Used
            </h2>
        </div>

        <div class="flex flex-col gap-3 sm:gap-4">
            @foreach ($treatment->products as $product)
                <article class="group flex flex-col items-center overflow-hidden rounded-2xl bg-white p-3.5 shadow-sm transition-all duration-300 hover:shadow-md sm:flex-row sm:gap-5 sm:p-4">
                    @if ($product->image)
                        <div class="h-28 w-full flex-shrink-0 overflow-hidden rounded-xl bg-neutral-100 sm:h-24 sm:w-24">
                            <img
                                src="{{ Storage::url($product->image) }}"
                                alt="{{ $product->name }}"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                            >
                        </div>
                    @else
                        <div class="flex h-28 w-full flex-shrink-0 items-center justify-center rounded-xl bg-neutral-100 text-neutral-400 sm:h-24 sm:w-24">
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    @endif

                    <div class="mt-3 flex-1 text-center sm:mt-0 sm:text-left">
                        <h3 class="text-base font-bold text-neutral-900">
                            {{ $product->name }}
                        </h3>
                        @if ($product->description)
                            <p class="mt-1 text-xs leading-relaxed text-neutral-500 sm:text-sm">
                                {{ $product->description }}
                            </p>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>

    </div>
</section>

@endif