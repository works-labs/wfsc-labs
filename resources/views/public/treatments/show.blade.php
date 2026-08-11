@extends('layouts.public')

@section('title', $treatment->name . ' - WFSC Clinic')

@section('content')

<main class="bg-white">

```
{{-- =========================================================
    1. HERO
========================================================== --}}
<section class="pt-32 pb-20 lg:pt-40 lg:pb-28">
    <div class="mx-auto max-w-7xl px-6 lg:px-12">

        <a
            href="{{ route('treatments.index') }}"
            class="inline-flex text-sm font-medium text-neutral-500 transition hover:text-neutral-900"
        >
            ← Back to Treatments
        </a>

        <div class="mt-10 grid items-center gap-12 lg:grid-cols-2 lg:gap-20">

            {{-- Treatment Image --}}
            <div>
                @if ($treatment->cover_image)
                    <div class="overflow-hidden rounded-[2rem] bg-neutral-100">
                        <img
                            src="{{ Storage::url($treatment->cover_image) }}"
                            alt="{{ $treatment->name }}"
                            class="aspect-[4/3] h-full w-full object-cover"
                        >
                    </div>
                @else
                    <div class="flex aspect-[4/3] items-center justify-center rounded-[2rem] bg-neutral-100">
                        <span class="text-sm text-neutral-400">
                            No image available
                        </span>
                    </div>
                @endif
            </div>

            {{-- Treatment Information --}}
            <div>

                @if ($treatment->category)
                    <p class="text-sm font-medium uppercase tracking-[0.25em] text-neutral-500">
                        {{ $treatment->category->name }}
                    </p>
                @endif

                <h1 class="mt-4 text-4xl font-bold tracking-tight text-neutral-900 lg:text-6xl">
                    {{ $treatment->name }}
                </h1>

                @if ($treatment->short_description)
                    <p class="mt-6 max-w-xl text-lg leading-relaxed text-neutral-500">
                        {{ $treatment->short_description }}
                    </p>
                @endif

            </div>

        </div>

    </div>
</section>


{{-- =========================================================
    2. TREATMENT DESCRIPTION + PROCEDURE VIDEOS
========================================================== --}}
@if ($treatment->description || $treatment->videos->isNotEmpty())

    <section class="border-t border-neutral-200 bg-neutral-50 py-20 lg:py-28">

        <div class="mx-auto max-w-7xl px-6 lg:px-12">

            <div class="grid gap-14 lg:grid-cols-2 lg:gap-20">

                {{-- Description --}}
                @if ($treatment->description)
                    <div class="flex flex-col justify-center">

                        <p class="text-sm font-medium uppercase tracking-[0.25em] text-neutral-400">
                            About This Treatment
                        </p>

                        <h2 class="mt-4 text-3xl font-bold tracking-tight text-neutral-900 lg:text-4xl">
                            {{ $treatment->name }}
                        </h2>

                        <div class="mt-6 text-lg leading-8 text-neutral-600">
                            {{ $treatment->description }}
                        </div>

                    </div>
                @endif


                {{-- Procedure Videos --}}
                @if ($treatment->procedureVideos->isNotEmpty())
                    <div>

                        <p class="text-sm font-medium uppercase tracking-[0.25em] text-neutral-400">
                            Procedure
                        </p>

                        <h2 class="mt-4 text-3xl font-bold tracking-tight text-neutral-900">
                            See How It Works
                        </h2>

                        <div class="mt-8 space-y-8">

                            @foreach ($treatment->procedureVideos as $video)

                                <article>

                                    <div class="overflow-hidden rounded-[1.5rem] bg-black shadow-sm">

                                        <video
                                            controls
                                            playsinline
                                            preload="metadata"
                                            class="aspect-video w-full object-cover"
                                        >
                                            <source
                                                src="{{ Storage::url($video->video_path) }}"
                                                type="video/mp4"
                                            >

                                            Browser kamu tidak mendukung video.
                                        </video>

                                    </div>

                                    @if ($video->title)
                                        <h3 class="mt-4 text-xl font-semibold text-neutral-900">
                                            {{ $video->title }}
                                        </h3>
                                    @endif

                                    @if ($video->description)
                                        <p class="mt-2 leading-relaxed text-neutral-500">
                                            {{ $video->description }}
                                        </p>
                                    @endif

                                </article>

                            @endforeach

                        </div>

                    </div>
                @endif

            </div>

        </div>

    </section>

@endif


{{-- =========================================================
    3. BEFORE & AFTER
========================================================== --}}
@if ($treatment->beforeAfters->isNotEmpty())

    <section class="py-20 lg:py-28">

        <div class="mx-auto max-w-7xl px-6 lg:px-12">

            <div class="mb-12 text-center">

                <p class="text-sm font-medium uppercase tracking-[0.25em] text-neutral-400">
                    Results
                </p>

                <h2 class="mt-3 text-3xl font-bold tracking-tight text-neutral-900 lg:text-4xl">
                    Before & After
                </h2>

                <p class="mx-auto mt-4 max-w-2xl text-neutral-500">
                    See the results of our treatment.
                </p>

            </div>


            <div class="grid gap-8 md:grid-cols-2">

                @foreach ($treatment->beforeAfters as $item)

                    <article class="overflow-hidden rounded-[2rem] bg-neutral-100">

                        <div class="grid grid-cols-2">

                            {{-- Before --}}
                            @if ($item->before_media)

                                @php
                                    $beforeExtension = strtolower(
                                        pathinfo($item->before_media, PATHINFO_EXTENSION)
                                    );
                                @endphp

                                <div class="relative aspect-[3/4] overflow-hidden bg-neutral-200">

                                    @if (in_array($beforeExtension, ['mp4', 'webm', 'mov']))

                                        <video
                                            autoplay
                                            muted
                                            loop
                                            playsinline
                                            class="h-full w-full object-cover"
                                        >
                                            <source
                                                src="{{ Storage::url($item->before_media) }}"
                                                type="{{ $beforeExtension === 'mov' ? 'video/quicktime' : 'video/' . $beforeExtension }}"
                                            >

                                            Browser kamu tidak mendukung video.
                                        </video>

                                    @else

                                        <img
                                            src="{{ Storage::url($item->before_media) }}"
                                            alt="Before {{ $treatment->name }}"
                                            class="h-full w-full object-cover"
                                        >

                                    @endif

                                    <span class="absolute bottom-4 left-4 rounded-full bg-black/70 px-3 py-1.5 text-xs font-medium text-white">
                                        Before
                                    </span>

                                </div>

                            @endif


                            {{-- After --}}
                            @if ($item->after_media)

                                @php
                                    $afterExtension = strtolower(
                                        pathinfo($item->after_media, PATHINFO_EXTENSION)
                                    );
                                @endphp

                                <div class="relative aspect-[3/4] overflow-hidden bg-neutral-200">

                                    @if (in_array($afterExtension, ['mp4', 'webm', 'mov']))

                                        <video
                                            autoplay
                                            muted
                                            loop
                                            playsinline
                                            class="h-full w-full object-cover"
                                        >
                                            <source
                                                src="{{ Storage::url($item->after_media) }}"
                                                type="{{ $afterExtension === 'mov' ? 'video/quicktime' : 'video/' . $afterExtension }}"
                                            >

                                            Browser kamu tidak mendukung video.
                                        </video>

                                    @else

                                        <img
                                            src="{{ Storage::url($item->after_media) }}"
                                            alt="After {{ $treatment->name }}"
                                            class="h-full w-full object-cover"
                                        >

                                    @endif

                                    <span class="absolute bottom-4 left-4 rounded-full bg-black/70 px-3 py-1.5 text-xs font-medium text-white">
                                        After
                                    </span>

                                </div>

                            @endif

                        </div>


                        @if ($item->caption)
                            <p class="p-5 text-sm leading-relaxed text-neutral-500">
                                {{ $item->caption }}
                            </p>
                        @endif

                    </article>

                @endforeach

            </div>

        </div>

    </section>

@endif


{{-- =========================================================
    4. RECOMMENDED PRODUCTS
========================================================== --}}
@if ($treatment->products->isNotEmpty())

    <section class="bg-neutral-50 py-20 lg:py-28">

        <div class="mx-auto max-w-7xl px-6 lg:px-12">

            <div class="mb-12">

                <p class="text-sm font-medium uppercase tracking-[0.25em] text-neutral-400">
                    Recommended
                </p>

                <h2 class="mt-3 text-3xl font-bold tracking-tight text-neutral-900 lg:text-4xl">
                    Products Used
                </h2>

            </div>


            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

                @foreach ($treatment->products as $product)

                    <article class="overflow-hidden rounded-[1.5rem] bg-white shadow-sm">

                        {{-- Product Image --}}
                        @if ($product->image)

                            <div class="aspect-[4/3] overflow-hidden bg-neutral-100">

                                <img
                                    src="{{ Storage::url($product->image) }}"
                                    alt="{{ $product->name }}"
                                    class="h-full w-full object-cover transition duration-500 hover:scale-105"
                                >

                            </div>

                        @endif


                        <div class="p-6">

                            <h3 class="text-lg font-semibold text-neutral-900">
                                {{ $product->name }}
                            </h3>

                            @if ($product->description)

                                <p class="mt-2 text-sm leading-relaxed text-neutral-500">
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


{{-- =========================================================
    5. CTA
========================================================== --}}
<section class="bg-neutral-900 py-20 text-white lg:py-28">

    <div class="mx-auto max-w-4xl px-6 text-center lg:px-12">

        <p class="text-sm font-medium uppercase tracking-[0.25em] text-neutral-400">
            WFSC Clinic
        </p>

        <h2 class="mt-4 text-3xl font-bold tracking-tight lg:text-5xl">
            Ready to learn more?
        </h2>

        <p class="mx-auto mt-5 max-w-2xl text-neutral-400">
            Consult with our team to find the treatment that is right for you.
        </p>

        <a
            href="#"
            class="mt-8 inline-flex items-center rounded-full bg-white px-7 py-3 text-sm font-semibold text-neutral-900 transition hover:bg-neutral-200"
        >
            Book a Consultation
        </a>

    </div>

</section>
```

</main>

@endsection
