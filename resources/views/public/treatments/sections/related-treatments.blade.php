@if ($treatment->relatedTreatments->isNotEmpty())
<section class="bg-neutral-50 py-20 sm:py-24">
    <div class="mx-auto max-w-7xl px-6 sm:px-8 lg:px-12">

        <div
            data-reveal="up"
            data-delay="0"
            class="reveal-hidden mx-auto max-w-2xl text-center"
        >
            <span class="text-sm font-semibold uppercase tracking-[0.2em] text-wfsc-coral">
                Related Treatments
            </span>

            <h2 class="mt-3 text-3xl font-black tracking-tight text-neutral-900 sm:text-4xl">
                Perawatan yang Mungkin Anda Butuhkan
            </h2>

            <p class="mt-4 text-base leading-relaxed text-neutral-600">
                Temukan perawatan lain yang dapat melengkapi kebutuhan perawatan Anda.
            </p>
        </div>

        <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($treatment->relatedTreatments as $index => $relatedTreatment)
                <article
                    data-reveal="up"
                    data-delay="{{ ($index + 1) * 100 }}"
                    class="reveal-hidden group overflow-hidden rounded-2xl border border-neutral-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg"
                >
                    <a
                        href="{{ route('treatment.show', $relatedTreatment) }}"
                        class="block"
                    >
                        @if ($relatedTreatment->cover_image)
                            <div class="aspect-[16/10] overflow-hidden bg-neutral-100">
                                <img
                                    src="{{ Storage::url($relatedTreatment->cover_image) }}"
                                    alt="{{ $relatedTreatment->name }}"
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                    loading="lazy"
                                >
                            </div>
                        @else
                            <div class="flex aspect-[16/10] items-center justify-center bg-wfsc-coral/10">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-12 w-12 text-wfsc-coral/50"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9.75 3.75h4.5m-6.75 3h9m-11.25 0h13.5v10.5a3 3 0 0 1-3 3h-7.5a3 3 0 0 1-3-3V6.75Z"
                                    />
                                </svg>
                            </div>
                        @endif

                        <div class="p-6">
                            @if ($relatedTreatment->category)
                                <span class="text-xs font-semibold uppercase tracking-wider text-wfsc-coral">
                                    {{ $relatedTreatment->category->name }}
                                </span>
                            @endif

                            <h3 class="mt-2 text-xl font-bold text-neutral-900 transition group-hover:text-wfsc-coral">
                                {{ $relatedTreatment->name }}
                            </h3>

                            @if ($relatedTreatment->short_description)
                                <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-neutral-600">
                                    {{ $relatedTreatment->short_description }}
                                </p>
                            @endif

                            <div class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-wfsc-coral">
                                Lihat Treatment

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M5 12h14m-6-6 6 6-6 6"
                                    />
                                </svg>
                            </div>
                        </div>
                    </a>
                </article>
            @endforeach
        </div>

    </div>
</section>
@endif