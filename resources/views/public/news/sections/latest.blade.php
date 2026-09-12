@php
    use Illuminate\Support\Facades\Storage;
@endphp

<section class="py-12 sm:py-16">

    <div class="mx-auto max-w-7xl px-6 sm:px-8 lg:px-12">

        {{-- Section Header --}}
        <div
            data-reveal="up"
            data-delay="0"
            class="reveal-hidden max-w-3xl"
        >

            <span
                class="text-sm font-semibold uppercase tracking-[0.2em] text-wfsc-coral"
            >
                News
            </span>

            <h2
                class="mt-2 text-3xl font-black tracking-tight text-neutral-900 sm:text-4xl"
            >
                Berita & Artikel Terbaru
            </h2>

            <p
                class="mt-3 text-base leading-relaxed text-neutral-600"
            >
                Temukan informasi, tips, dan artikel terbaru dari WFSC Clinic.
            </p>

        </div>


        {{-- News Cards --}}
        @if ($news->isNotEmpty())

            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

                @foreach ($news as $index => $item)

                    <a
                        href="{{ route('news.show', $item->slug) }}"
                        data-reveal="up"
                        data-delay="{{ ($index + 1) * 100 }}"
                        class="reveal-hidden group overflow-hidden rounded-2xl border border-neutral-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl"
                    >

                        {{-- Thumbnail --}}
                        @if ($item->thumbnail)

                            <div
                                class="relative aspect-[16/10] overflow-hidden bg-neutral-100"
                            >

                                <img
                                    src="{{ Storage::url($item->thumbnail) }}"
                                    alt="{{ $item->title }}"
                                    loading="lazy"
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                >

                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 transition duration-300 group-hover:opacity-100"
                                ></div>

                            </div>

                        @else

                            <div
                                class="flex aspect-[16/10] items-center justify-center bg-neutral-100"
                            >

                                <span class="text-sm text-neutral-400">
                                    No image
                                </span>

                            </div>

                        @endif


                        {{-- Card Content --}}
                        <div class="p-5">

                            {{-- Meta --}}
                            <div class="flex flex-wrap items-center gap-x-3 gap-y-1">

                                @if ($item->category)

                                    <span
                                        class="text-xs font-semibold uppercase tracking-wider text-wfsc-coral"
                                    >
                                        {{ $item->category->name }}
                                    </span>

                                @endif


                                @if ($item->published_at)

                                    <span class="text-xs text-neutral-400">
                                        {{ $item->published_at->format('d M Y') }}
                                    </span>

                                @endif

                            </div>


                            {{-- Title + Arrow --}}
                            <div class="mt-2 flex items-start justify-between gap-4">

                                <h3
                                    class="text-lg font-bold leading-snug text-neutral-900 transition group-hover:text-neutral-600"
                                >
                                    {{ $item->title }}
                                </h3>


                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="mt-1 h-4 w-4 shrink-0 text-neutral-400 transition duration-300 group-hover:translate-x-1 group-hover:text-wfsc-coral"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6"
                                    />
                                </svg>

                            </div>


                            {{-- Excerpt --}}
                            @if ($item->excerpt)

                                <p
                                    class="mt-2 line-clamp-3 text-sm leading-relaxed text-neutral-500"
                                >
                                    {{ $item->excerpt }}
                                </p>

                            @endif

                        </div>

                    </a>

                @endforeach

            </div>


            {{-- Pagination --}}
            @if ($news->hasPages())

                <div class="mt-10">
                    {{ $news->links() }}
                </div>

            @endif

        @else

            {{-- Empty State --}}
            <div
                class="mt-8 rounded-2xl border border-dashed border-neutral-200 px-6 py-16 text-center"
            >

                <p class="text-sm text-neutral-500">
                    Belum ada berita yang tersedia saat ini.
                </p>

            </div>

        @endif

    </div>

</section>