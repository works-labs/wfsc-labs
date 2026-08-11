@php
    use Illuminate\Support\Facades\Storage;
@endphp
<section class="bg-white py-24 lg:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-12">

        {{-- Heading --}}
        <div class="mb-12 text-center">
            <p class="text-sm font-medium uppercase tracking-[0.25em] text-neutral-500">
                Before After
            </p>

            <h2 class="mt-3 text-4xl font-bold tracking-tight text-neutral-900 lg:text-5xl">
                See The Difference
            </h2>
        </div>

        {{-- Slider --}}
        @if ($treatmentBeforeAfters->isNotEmpty())
           <div
    data-before-after-slider
    class="relative mx-auto max-w-4xl"
>
                <div class="relative overflow-hidden rounded-[2rem]">
                    @foreach ($treatmentBeforeAfters as $index => $item)
                        <article
                            data-before-after-slide
                            class="{{ $index === 0 ? '' : 'hidden' }}"
                        >
                            <div class="grid gap-4 md:grid-cols-2">

                                {{-- Before --}}
                               @php
                                    $beforeUrl = Storage::url($item->before_media);
                                    $beforeExtension = strtolower(
                                        pathinfo($item->before_media, PATHINFO_EXTENSION)
                                    );
                                @endphp

                                @if (in_array($beforeExtension, ['mp4', 'webm', 'mov']))
                                    <video
                                        autoplay
                                        mutedSS
                                        loop
                                        playsinline
                                        class="h-full w-full object-cover"
                                    >
                                        <source
                                            src="{{ $beforeUrl }}"
                                            type="{{ $beforeExtension === 'mov' ? 'video/quicktime' : 'video/' . $beforeExtension }}"
                                        >
                                        Browser kamu tidak mendukung video.
                                    </video>
                                @else
                                    <img
                                        src="{{ $beforeUrl }}"
                                        alt="Before {{ $item->treatment?->name }}"
                                        class="h-full w-full object-cover"
                                    >
                                @endif
                                {{-- After --}}
                                @php
                                    $afterUrl = Storage::url($item->after_media);
                                    $afterExtension = strtolower(
                                        pathinfo($item->after_media, PATHINFO_EXTENSION)
                                    );
                                @endphp

                                @if (in_array($afterExtension, ['mp4', 'webm', 'mov']))
                                    <video
                                        autoplay
                                        muted
                                        loop
                                        playsinline
                                        class="h-full w-full object-cover"
                                    >
                                        <source
                                            src="{{ $afterUrl }}"
                                            type="{{ $afterExtension === 'mov' ? 'video/quicktime' : 'video/' . $afterExtension }}"
                                        >
                                        Browser kamu tidak mendukung video.
                                    </video>
                                @else
                                    <img
                                        src="{{ $afterUrl }}"
                                        alt="After {{ $item->treatment?->name }}"
                                        class="h-full w-full object-cover"
                                    >
                                @endif
                            {{-- Caption --}}
                            <div class="mt-6 text-center">
                                @if ($item->treatment)
                                    <h3 class="text-xl font-semibold text-neutral-900">
                                        {{ $item->treatment->name }}
                                    </h3>
                                @endif

                                @if ($item->caption)
                                    <p class="mx-auto mt-2 max-w-2xl text-neutral-500">
                                        {{ $item->caption }}
                                    </p>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Indicators --}}
                @if ($treatmentBeforeAfters->count() > 1)
                    <div class="mt-8 flex justify-center gap-2">
                        @foreach ($treatmentBeforeAfters as $index => $item)
                            <button
                                type="button"
                                data-before-after-dot="{{ $index }}"
                                class="h-2.5 w-2.5 rounded-full transition"
                                aria-label="Go to slide {{ $index + 1 }}"
                            ></button>
                        @endforeach
                    </div>
                @endif
            </div>
        @else
            <p class="py-12 text-center text-neutral-500">
                No before and after results available.
            </p>
        @endif

    </div>
</section>