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
                Treatment Results
            </h2>
            <p class="mx-auto mt-2 max-w-xl text-xs sm:text-sm text-neutral-500">
                See the results of our treatment.
            </p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($treatment->beforeAfters as $item)
                @php
                    $displayMedia = $item->after_media ?: $item->before_media;
                    $displayExt = $displayMedia ? strtolower(pathinfo($displayMedia, PATHINFO_EXTENSION)) : null;
                    $isDisplayVideo = in_array($displayExt, ['mp4', 'webm', 'mov']);
                    $displaySrc = $displayMedia ? Storage::url($displayMedia) : '';
                @endphp

                <article 
                    class="group cursor-pointer overflow-hidden rounded-2xl bg-neutral-100 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md"
                    data-lightbox-trigger
                    data-after-src="{{ $displaySrc }}"
                    data-after-type="{{ $isDisplayVideo ? 'video' : 'image' }}"
                    data-caption="{{ $item->caption ?? '' }}"
                >
                    <div class="relative aspect-[4/5] overflow-hidden bg-neutral-200">
                        @if ($isDisplayVideo)
                            <video autoplay muted loop playsinline class="h-full w-full object-cover">
                                <source src="{{ $displaySrc }}" type="{{ $displayExt === 'mov' ? 'video/quicktime' : 'video/' . $displayExt }}">
                            </video>
                        @else
                            <img src="{{ $displaySrc }}" alt="Hasil {{ $treatment->name }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                        @endif
                        <span class="absolute bottom-2 left-2 rounded-full bg-wfsc-coral px-2.5 py-1 text-[10px] font-semibold tracking-wider text-white backdrop-blur-sm">
                            HASIL
                        </span>
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

        <div class="max-h-[75vh] bg-black">
            <div id="lightbox-after-container" class="relative flex h-[65vh] items-center justify-center overflow-hidden bg-neutral-950">
                <span class="absolute left-4 top-4 z-10 rounded-full bg-wfsc-coral px-3 py-1 text-xs font-semibold text-white backdrop-blur-sm">HASIL</span>
            </div>
        </div>

        <div id="lightbox-caption-container" class="hidden border-t border-neutral-800 bg-neutral-900 p-4 text-center text-xs leading-relaxed text-neutral-300 sm:p-5 sm:text-sm">
            <p id="lightbox-caption"></p>
        </div>
    </div>
</div>

@endif
