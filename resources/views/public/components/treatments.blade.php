<section id="treatments" class="bg-white py-24 lg:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-12">

        <div class="mb-12 text-center">
            <p class="text-sm font-medium uppercase tracking-[0.25em] text-neutral-500">
                Treatments
            </p>

            <h2 class="mt-3 text-4xl font-bold tracking-tight text-neutral-900 lg:text-5xl">
                Our Treatments
            </h2>
        </div>

        @if ($treatmentCategories->isNotEmpty())
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($treatmentCategories as $category)
                    <article class="group overflow-hidden rounded-[1.5rem] bg-neutral-100">

                        <div class="aspect-[4/5] overflow-hidden">
                            @if ($category->image)
                                <img
                                    src="{{ asset('storage/' . $category->image) }}"
                                    alt="{{ $category->name }}"
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                >
                            @endif
                        </div>

                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-neutral-900">
                                {{ $category->name }}
                            </h3>

                            @if ($category->description)
                                <p class="mt-2 line-clamp-3 text-sm leading-relaxed text-neutral-500">
                                    {{ $category->description }}
                                </p>
                            @endif
                        </div>

                    </article>
                @endforeach
            </div>
        @else
            <p class="py-12 text-center text-neutral-500">
                No treatments available.
            </p>
        @endif

    </div>
</section>