@php
    use Illuminate\Support\Facades\Storage;
    use App\Support\NewsContentRenderer;

    $renderedContent = NewsContentRenderer::render(
        $news->content,
        $bacaJuga
    );
@endphp

@extends('layouts.public')

@section('title', $news->title . ' - WFSC Clinic')

@section('content')

<main class="bg-white">

    {{-- =========================================================
        ARTICLE HEADER
    ========================================================== --}}
    <section class="pt-32 pb-12 lg:pt-40 lg:pb-14">

        <div class="mx-auto max-w-4xl px-6 lg:px-12">

            {{-- Back --}}
            <a
                href="{{ route('news.index') }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-neutral-500 transition hover:text-neutral-900"
            >
                <span>←</span>
                <span>Back to News</span>
            </a>


            {{-- Meta --}}
            <div class="mt-9 flex flex-wrap items-center gap-x-4 gap-y-2">

                @if ($news->category)

                    <span
                        class="rounded-full bg-neutral-100 px-3 py-1.5 text-xs font-semibold text-neutral-700"
                    >
                        {{ $news->category->name }}
                    </span>

                @endif


                @if ($news->published_at)

                    <span class="text-sm text-neutral-400">
                        {{ $news->published_at->format('d M Y') }}
                    </span>

                @endif

            </div>


            {{-- Title --}}
            <h1
                class="mt-5 max-w-4xl text-4xl font-bold tracking-tight text-neutral-900 sm:text-5xl lg:text-[3.5rem] lg:leading-[1.1]"
            >
                {{ $news->title }}
            </h1>


            {{-- Excerpt --}}
            @if ($news->excerpt)

                <p
                    class="mt-6 max-w-3xl text-lg leading-relaxed text-neutral-500 lg:text-xl"
                >
                    {{ $news->excerpt }}
                </p>

            @endif


            {{-- Hero Image --}}
            @if ($news->thumbnail)

                <div class="mt-10 overflow-hidden rounded-2xl bg-neutral-100">

                    <div class="aspect-[16/9] w-full max-h-[420px]">

                        <img
                            src="{{ Storage::url($news->thumbnail) }}"
                            alt="{{ $news->title }}"
                            class="h-full w-full object-cover"
                        >

                    </div>

                </div>

            @endif

        </div>

    </section>


    {{-- =========================================================
        ARTICLE CONTENT
    ========================================================== --}}
    <section class="pb-20 lg:pb-24">

        <div class="mx-auto max-w-3xl px-6 lg:px-12">

            <article
                class="
                    prose
                    prose-neutral
                    prose-lg
                    max-w-none

                    prose-headings:font-semibold
                    prose-headings:tracking-tight
                    prose-headings:text-neutral-900

                    prose-h2:mt-12
                    prose-h2:mb-4
                    prose-h2:text-2xl
                    prose-h2:leading-tight

                    prose-h3:mt-10
                    prose-h3:mb-3
                    prose-h3:text-xl

                    prose-p:leading-8
                    prose-p:text-neutral-700

                    prose-strong:font-semibold
                    prose-strong:text-neutral-900

                    prose-a:font-medium
                    prose-a:text-wfsc-coral
                    prose-a:no-underline
                    hover:prose-a:underline

                    prose-ul:my-6
                    prose-ol:my-6
                    prose-li:my-1

                    prose-blockquote:border-l-4
                    prose-blockquote:border-wfsc-coral
                    prose-blockquote:bg-neutral-50
                    prose-blockquote:py-2
                    prose-blockquote:text-neutral-600

                    prose-img:rounded-2xl
                    prose-img:shadow-sm
                "
            >
                {!! $renderedContent !!}
            </article>

        </div>

    </section>


    {{-- =========================================================
        ARTIKEL TERKAIT
    ========================================================== --}}
    @if ($recommendedNews->isNotEmpty())

        <section class="border-t border-neutral-200 bg-neutral-50 py-16 lg:py-20">

            <div class="mx-auto max-w-4xl px-6 lg:px-12">

                {{-- Section heading --}}
                <div>

                    <p
                        class="text-xs font-semibold uppercase tracking-[0.2em] text-neutral-400"
                    >
                        Related Articles
                    </p>

                    <h2
                        class="mt-2 text-2xl font-bold tracking-tight text-neutral-900 lg:text-3xl"
                    >
                        Artikel Terkait
                    </h2>

                    <p
                        class="mt-2 max-w-2xl text-sm leading-relaxed text-neutral-500"
                    >
                        Artikel lain yang mungkin relevan dengan topik ini.
                    </p>

                </div>


                {{-- List --}}
                <div class="mt-8 divide-y divide-neutral-200">

                    @foreach ($recommendedNews as $item)

                        <a
                            href="{{ route('news.show', $item->slug) }}"
                            class="group flex gap-5 py-6 first:pt-0 last:pb-0"
                        >

                            {{-- Thumbnail --}}
                            <div
                                class="w-32 shrink-0 overflow-hidden rounded-xl bg-neutral-200 sm:w-44"
                            >

                                <div class="aspect-[16/10] w-full">

                                    @if ($item->thumbnail)

                                        <img
                                            src="{{ Storage::url($item->thumbnail) }}"
                                            alt="{{ $item->title }}"
                                            class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                        >

                                    @else

                                        <div
                                            class="flex h-full w-full items-center justify-center bg-neutral-100"
                                        >
                                            <span class="text-xs text-neutral-400">
                                                No image
                                            </span>
                                        </div>

                                    @endif

                                </div>

                            </div>


                            {{-- Content --}}
                            <div class="min-w-0 flex-1">

                                <div
                                    class="flex flex-wrap items-center gap-x-3 gap-y-1"
                                >

                                    @if ($item->category)

                                        <span
                                            class="text-xs font-semibold uppercase tracking-wider text-neutral-400"
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


                                <h3
                                    class="mt-1.5 text-base font-semibold leading-snug text-neutral-900 transition group-hover:text-neutral-600 sm:text-lg"
                                >
                                    {{ $item->title }}
                                </h3>


                                @if ($item->excerpt)

                                    <p
                                        class="mt-2 line-clamp-2 text-sm leading-relaxed text-neutral-500"
                                    >
                                        {{ $item->excerpt }}
                                    </p>

                                @endif

                            </div>

                        </a>

                    @endforeach

                </div>

            </div>

        </section>

    @endif

</main>

@endsection