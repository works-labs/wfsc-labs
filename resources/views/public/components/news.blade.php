<section id="news" class="relative overflow-hidden bg-white py-24 lg:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-12">

        {{-- Heading --}}
        <div class="mb-14 text-center">
            <p class="text-sm font-medium uppercase tracking-[0.25em] text-neutral-500">
                Latest News
            </p>

            <h2 class="mt-3 text-4xl font-bold tracking-tight text-neutral-900 lg:text-5xl">
                News & Updates
            </h2>
        </div>

        @if ($news->isNotEmpty())

            @php
                $newsChunks = $news->chunk(3);
            @endphp

            <div data-news-slider class="relative">

                {{-- Slides --}}
                <div class="relative">

                    @foreach ($newsChunks as $chunkIndex => $chunk)

                        <div
                            data-news-slide
                            class="{{ $chunkIndex === 0 ? '' : 'hidden' }}"
                        >
                            <div class="grid gap-8 md:grid-cols-3">

                                @foreach ($chunk as $item)

                                    <a
                                        href="{{ route('news.show', $item->slug) }}"
                                        class="group block"
                                    >
                                        <article class="overflow-hidden rounded-[2rem] bg-neutral-100">

                                            {{-- Image --}}
                                            <div class="aspect-[4/3] overflow-hidden bg-neutral-200">

                                                @if ($item->thumbnail)

                                                    <img
                                                        src="{{ asset('storage/' . $item->thumbnail) }}"
                                                        alt="{{ $item->title }}"
                                                        class="h-full w-full object-cover transition duration-700 ease-out group-hover:scale-105"
                                                    >

                                                @else

                                                    <div class="flex h-full items-center justify-center text-sm text-neutral-400">
                                                        No image
                                                    </div>

                                                @endif

                                            </div>

                                            {{-- Content --}}
                                            <div class="p-6">

                                                @if ($item->published_at)

                                                    <p class="text-xs font-medium uppercase tracking-[0.18em] text-neutral-400">
                                                        {{ $item->published_at->format('d M Y') }}
                                                    </p>

                                                @endif

                                                <h3 class="mt-3 text-xl font-semibold leading-snug text-neutral-900 transition group-hover:text-[#FF5252]">
                                                    {{ $item->title }}
                                                </h3>

                                                @if ($item->excerpt)

                                                    <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-neutral-500">
                                                        {{ $item->excerpt }}
                                                    </p>

                                                @endif

                                                <span class="mt-5 inline-flex text-sm font-medium text-neutral-500 transition group-hover:text-[#FF5252]">
                                                    Read More →
                                                </span>

                                            </div>

                                        </article>
                                    </a>

                                @endforeach

                            </div>
                        </div>

                    @endforeach

                </div>

                {{-- Navigation --}}
                @if ($newsChunks->count() > 1)

                    <div class="mt-12 flex items-center justify-center gap-6">

                        {{-- Previous --}}
                        <button
                            type="button"
                            data-news-prev
                            class="flex h-10 w-10 items-center justify-center rounded-full border border-neutral-200 text-neutral-600 transition hover:border-[#FF5252] hover:bg-[#FF5252] hover:text-white"
                            aria-label="Previous news"
                        >
                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15 19l-7-7 7-7"
                                />
                            </svg>
                        </button>

                        {{-- Dots --}}
                        <div class="flex items-center gap-2">

                            @foreach ($newsChunks as $index => $chunk)

                                <button
                                    type="button"
                                    data-news-dot="{{ $index }}"
                                    class="{{ $index === 0
                                        ? 'w-8 bg-[#FF5252]'
                                        : 'w-2 bg-neutral-300' }}
                                        h-2 rounded-full transition-all duration-300"
                                    aria-label="Go to news slide {{ $index + 1 }}"
                                ></button>

                            @endforeach

                        </div>

                        {{-- Next --}}
                        <button
                            type="button"
                            data-news-next
                            class="flex h-10 w-10 items-center justify-center rounded-full border border-neutral-200 text-neutral-600 transition hover:border-[#FF5252] hover:bg-[#FF5252] hover:text-white"
                            aria-label="Next news"
                        >
                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M9 5l7 7-7 7"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    fill="none"
                                />
                            </svg>
                        </button>

                    </div>

                @endif

            </div>

        @else

            <p class="py-12 text-center text-neutral-500">
                No news available.
            </p>

        @endif

    </div>
</section>