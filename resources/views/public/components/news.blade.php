<section id="news" class="relative overflow-hidden bg-white py-16 sm:py-20 lg:py-32">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-12">

        {{-- Header & Navigation (Centered & Dibatasi Lebarnya) --}}
        <div class="mx-auto mb-10 flex max-w-2xl flex-col items-center text-center gap-6 sm:mb-14 lg:mb-16">

            {{-- Text Header --}}
            <div>
                <p data-reveal="fade-up" data-delay="100" class="reveal-hidden text-xs font-semibold uppercase tracking-[0.25em] text-[#FF5252] sm:text-sm">
                    Latest News
                </p>

                <h2 data-reveal="fade-up" data-delay="200" class="reveal-hidden mt-2 text-3xl font-bold tracking-tight text-neutral-900 sm:mt-3 sm:text-4xl lg:text-5xl">
                    News & Updates
                </h2>
            </div>

            {{-- Navigation Buttons --}}
            <div data-reveal="fade-up" data-delay="300" class="reveal-hidden flex items-center justify-center gap-2.5 sm:gap-3">
                <button
                    type="button"
                    data-news-prev
                    class="flex h-10 w-10 items-center justify-center rounded-full border border-neutral-200 bg-white text-neutral-900 transition-all duration-300 hover:border-[#FF5252] hover:bg-[#FF5252] hover:text-white disabled:cursor-not-allowed disabled:opacity-40 sm:h-11 sm:w-11"
                    aria-label="Previous news"
                >
                    ←
                </button>

                <button
                    type="button"
                    data-news-next
                    class="flex h-10 w-10 items-center justify-center rounded-full border border-neutral-200 bg-white text-neutral-900 transition-all duration-300 hover:border-[#FF5252] hover:bg-[#FF5252] hover:text-white disabled:cursor-not-allowed disabled:opacity-40 sm:h-11 sm:w-11"
                    aria-label="Next news"
                >
                    →
                </button>
            </div>
        </div>

        {{-- Slider Track --}}
        @if ($news->isNotEmpty())

            <div
                data-reveal="zoom"
                data-delay="400"
                data-news-slider
                class="reveal-hidden relative overflow-hidden"
            >
                <div data-news-track class="-mx-2 flex transition-transform duration-500 ease-out sm:-mx-3">

                    @foreach ($news as $item)
                        <div data-news-slide class="w-full shrink-0 px-2 sm:w-1/2 sm:px-3 lg:w-1/3">
                            <a href="{{ route('news.show', $item->slug) }}" class="group block h-full">
                                <article class="flex h-full flex-col overflow-hidden rounded-2xl border border-neutral-200/80 bg-neutral-50 transition-all duration-500 hover:-translate-y-1.5 hover:border-[#FF5252]/30 hover:shadow-[0_20px_40px_rgba(255,82,82,0.10)] sm:rounded-[2rem]">

                                    <div class="aspect-[16/10] overflow-hidden bg-neutral-200">
                                        @if ($item->thumbnail)
                                            <img
                                                src="{{ asset('storage/' . $item->thumbnail) }}"
                                                alt="{{ $item->title }}"
                                                class="h-full w-full object-cover transition duration-700 ease-out group-hover:scale-105"
                                            >
                                        @else
                                            <div class="flex h-full items-center justify-center text-xs text-neutral-400 sm:text-sm">
                                                No image
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex grow flex-col p-4 sm:p-6">
                                        @if ($item->published_at)
                                            <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-[#FF5252] sm:text-xs">
                                                {{ $item->published_at->format('d M Y') }}
                                            </p>
                                        @endif

                                        <h3 class="mt-2 text-lg font-bold leading-snug text-neutral-900 transition duration-300 group-hover:text-[#FF5252] sm:mt-3 sm:text-xl">
                                            {{ $item->title }}
                                        </h3>

                                        @if ($item->excerpt)
                                            <p class="mt-2 line-clamp-2 text-xs leading-relaxed text-neutral-500 sm:mt-3 sm:line-clamp-3 sm:text-sm">
                                                {{ $item->excerpt }}
                                            </p>
                                        @endif

                                        <div class="mt-auto pt-4 sm:pt-5">
                                            <span class="inline-flex items-center gap-1 text-xs font-semibold text-neutral-900 transition duration-300 group-hover:text-[#FF5252] sm:text-sm">
                                                <span>Read More</span>
                                                <span class="transition-transform duration-300 group-hover:translate-x-1">→</span>
                                            </span>
                                        </div>
                                    </div>

                                </article>
                            </a>
                        </div>
                    @endforeach

                </div>
            </div>

            {{-- Dynamic Dots --}}
            <div data-reveal="zoom" data-delay="600" data-news-dots class="reveal-hidden mt-6 flex justify-center gap-2 sm:mt-8"></div>

        @else
            <div class="rounded-2xl border border-dashed border-neutral-300 bg-neutral-50 py-12 text-center sm:py-16">
                <p class="text-xs text-neutral-400 sm:text-sm">
                    No news available.
                </p>
            </div>
        @endif

    </div>
</section>