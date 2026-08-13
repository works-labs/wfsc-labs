@php
    use Illuminate\Support\Facades\Storage;
@endphp

@extends('layouts.public')

@section('title', $news->title . ' - WFSC Clinic')

@section('content')

<main class="bg-white">

    <section class="pt-32 pb-20 lg:pt-40 lg:pb-28">
        <div class="mx-auto max-w-4xl px-6 lg:px-12">

            <a
                href="{{ url()->previous() }}"
                class="text-sm font-medium text-neutral-500 transition hover:text-neutral-900"
            >
                ← Back
            </a>

            @if ($news->published_at)
                <p class="mt-10 text-sm font-medium uppercase tracking-[0.25em] text-neutral-400">
                    {{ $news->published_at->format('d M Y') }}
                </p>
            @endif

            <h1 class="mt-4 text-4xl font-bold tracking-tight text-neutral-900 lg:text-6xl">
                {{ $news->title }}
            </h1>

            @if ($news->excerpt)
                <p class="mt-6 text-lg leading-relaxed text-neutral-500">
                    {{ $news->excerpt }}
                </p>
            @endif

            @if ($news->thumbnail)
                <div class="mt-12 overflow-hidden rounded-[2rem] bg-neutral-100">
                    <img
                        src="{{ Storage::url($news->thumbnail) }}"
                        alt="{{ $news->title }}"
                        class="w-full object-cover"
                    >
                </div>
            @endif

            <article class="prose prose-neutral mt-12 max-w-none">
                {!! $news->content !!}
            </article>

        </div>
    </section>

</main>

@endsection