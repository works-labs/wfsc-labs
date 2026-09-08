{{-- =========================================================
    3. BEFORE & AFTER SECTION
========================================================== --}}
@if ($treatment->beforeAfters->isNotEmpty())

<section class="py-10 lg:py-14">
    <div class="mx-auto max-w-7xl px-6 lg:px-12">

        <div class="mb-6 text-center lg:mb-8">
            <p class="text-xs font-medium uppercase tracking-[0.25em] text-neutral-400">
                Results
            </p>
            <h2 class="mt-1.5 text-2xl font-bold tracking-tight text-neutral-900 lg:text-3xl">
                Before & After
            </h2>
            <p class="mx-auto mt-2 max-w-xl text-xs sm:text-sm text-neutral-500">
                See the results of our treatment.
            </p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($treatment->beforeAfters as $item)
                @php
                    $beforeExt = $item->before_media ? strtolower(pathinfo($item->before_media, PATHINFO_EXTENSION)) : null;
                    $afterExt = $item->after_media ? strtolower(pathinfo($item->after_media, PATHINFO_EXTENSION)) : null;

                    $isBeforeVid = in_array($beforeExt, ['mp4', 'webm', 'mov']);
                    $isAfterVid = in_array($afterExt, ['mp4', 'webm', 'mov']);

                    $beforeSrc = $item->before_media ? Storage::url($item->before_media) : '';
                    $afterSrc = $item->after_media ? Storage::url($item->after_media) : '';
                @endphp

                <article 
                    class="group cursor-pointer overflow-hidden rounded-2xl bg-neutral-100 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md"
                    data-lightbox-trigger
                    data-before-src="{{ $beforeSrc }}"
                    data-before-type="{{ $isBeforeVid ? 'video' : 'image' }}"
                    data-after-src="{{ $afterSrc }}"
                    data-after-type="{{ $isAfterVid ? 'video' : 'image' }}"
                    data-caption="{{ $item->caption ?? '' }}"
                >
                    <div class="grid grid-cols-2 gap-0.5 bg-neutral-200">
                        @if ($item->before_media)
                            <div class="relative aspect-square overflow-hidden bg-neutral-200">
                                @if ($isBeforeVid)
                                    <video autoplay muted loop playsinline class="h-full w-full object-cover">
                                        <source src="{{ $beforeSrc }}" type="{{ $beforeExt === 'mov' ? 'video/quicktime' : 'video/' . $beforeExt }}">
                                    </video>
                                @else
                                    <img src="{{ $beforeSrc }}" alt="Before {{ $treatment->name }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                                @endif
                                <span class="absolute bottom-2 left-2 rounded-full bg-black/60 px-2.5 py-1 text-[10px] font-semibold tracking-wider text-white backdrop-blur-sm">
                                    BEFORE
                                </span>
                            </div>
                        @endif

                        @if ($item->after_media)
                            <div class="relative aspect-square overflow-hidden bg-neutral-200">
                                @if ($isAfterVid)
                                    <video autoplay muted loop playsinline class="h-full w-full object-cover">
                                        <source src="{{ $afterSrc }}" type="{{ $afterExt === 'mov' ? 'video/quicktime' : 'video/' . $afterExt }}">
                                    </video>
                                @else
                                    <img src="{{ $afterSrc }}" alt="After {{ $treatment->name }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                                @endif
                                <span class="absolute bottom-2 left-2 rounded-full bg-black/60 px-2.5 py-1 text-[10px] font-semibold tracking-wider text-white backdrop-blur-sm">
                                    AFTER
                                </span>
                            </div>
                        @endif
                    </div>

                    @if ($item->caption)
                        <p class="line-clamp-2 p-3 text-xs leading-relaxed text-neutral-600">
                            {{ $item->caption }}
                        </p>
                    @endif
                </article>
            @endforeach
        </div>

    </div>
</section>

{{-- Modal Popup Lightbox --}}
<div id="before-after-lightbox" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/80 p-4 sm:p-6 backdrop-blur-sm transition-opacity duration-300 opacity-0" aria-hidden="true">
    <div class="relative my-auto w-full max-w-4xl overflow-hidden rounded-3xl bg-neutral-900 shadow-2xl">
        <button id="lightbox-close" type="button" class="absolute right-4 top-4 z-20 rounded-full bg-black/60 p-2 text-white/80 backdrop-blur-md transition-colors hover:bg-black/90 hover:text-white" aria-label="Close modal">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="grid max-h-[70vh] grid-cols-1 bg-black sm:max-h-[75vh] sm:grid-cols-2">
            <div id="lightbox-before-container" class="relative flex h-[35vh] items-center justify-center overflow-hidden bg-neutral-950 sm:h-[60vh]">
                <span class="absolute left-4 top-4 z-10 rounded-full bg-black/60 px-3 py-1 text-xs font-semibold text-white backdrop-blur-sm">BEFORE</span>
            </div>
            <div id="lightbox-after-container" class="relative flex h-[35vh] items-center justify-center overflow-hidden bg-neutral-950 sm:h-[60vh]">
                <span class="absolute left-4 top-4 z-10 rounded-full bg-black/60 px-3 py-1 text-xs font-semibold text-white backdrop-blur-sm">AFTER</span>
            </div>
        </div>

        <div id="lightbox-caption-container" class="hidden border-t border-neutral-800 bg-neutral-900 p-4 text-center text-xs leading-relaxed text-neutral-300 sm:p-5 sm:text-sm">
            <p id="lightbox-caption"></p>
        </div>
    </div>
</div>

@endif