@php
    use Illuminate\Support\Facades\Storage;
@endphp

@if ($promos->isNotEmpty())
    <section id="promos" class="bg-neutral-100 py-24 lg:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-12">

            <div class="mb-12 text-center">
                <p class="text-sm font-medium uppercase tracking-[0.25em] text-neutral-500">
                    Special Offer
                </p>

                <h2 class="mt-3 text-4xl font-bold tracking-tight text-neutral-900 lg:text-5xl">
                    Our Promo
                </h2>
            </div>

            <div class="grid gap-8 md:grid-cols-2">
                @foreach ($promos as $promo)
                    <article class="group overflow-hidden rounded-[2rem] bg-white">

                        @if ($promo->image)
                            <div class="overflow-hidden">
                                <img
                                    src="{{ Storage::url($promo->image) }}"
                                    alt="{{ $promo->title }}"
                                    class="aspect-[16/9] w-full object-cover transition duration-700 group-hover:scale-105"
                                >
                            </div>
                        @endif

                        <div class="p-8 lg:p-10">

                            <h3 class="text-2xl font-semibold tracking-tight text-neutral-900">
                                {{ $promo->title }}
                            </h3>

                            @if ($promo->description)
                                <p class="mt-4 leading-relaxed text-neutral-600">
                                    {{ $promo->description }}
                                </p>
                            @endif

                            @if ($promo->cta_text && $promo->cta_url)
                                <a
                                    href="{{ $promo->cta_url }}"
                                    class="mt-6 inline-flex items-center text-sm font-semibold text-neutral-900 transition hover:text-[#FF5252]"
                                >
                                    {{ $promo->cta_text }}
                                    <span class="ml-2 transition group-hover:translate-x-1">→</span>
                                </a>
                            @endif

                        </div>

                    </article>
                @endforeach
            </div>

        </div>
    </section>
@endif