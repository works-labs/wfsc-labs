<div
    id="before-after-lightbox"
    class="fixed inset-0 z-[100] hidden opacity-0 transition-opacity duration-300"
    aria-hidden="true"
>
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/80 backdrop-blur-sm"></div>

    {{-- Dialog --}}
    <div class="relative flex min-h-full items-center justify-center p-4 sm:p-6">
        <div
            class="relative w-full max-w-6xl overflow-hidden rounded-3xl bg-white shadow-2xl"
        >

            {{-- Close --}}
            <button
                id="lightbox-close"
                type="button"
                class="absolute right-4 top-4 z-20 flex h-10 w-10 items-center justify-center rounded-full bg-black/60 text-white backdrop-blur-md transition hover:bg-black/80"
                aria-label="Close"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 18 18 6M6 6l12 12"
                    />
                </svg>
            </button>

            {{-- Header --}}
            <div class="border-b border-neutral-100 px-6 py-5 sm:px-8">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-wfsc-coral">
                    Before & After
                </p>

                <h2 class="mt-1 text-xl font-bold text-neutral-900 sm:text-2xl">
                    Treatment Result
                </h2>
            </div>

            {{-- Before / After --}}
            <div class="grid grid-cols-1 gap-px bg-neutral-200 sm:grid-cols-2">

                {{-- Before --}}
                <div
                    id="lightbox-before-container"
                    class="relative flex min-h-[50vh] items-center justify-center overflow-hidden bg-neutral-100"
                >
                    <span class="absolute left-4 top-4 z-10 rounded-full bg-black/70 px-4 py-2 text-xs font-semibold text-white backdrop-blur-sm">
                        Before
                    </span>
                </div>

                {{-- After --}}
                <div
                    id="lightbox-after-container"
                    class="relative flex min-h-[50vh] items-center justify-center overflow-hidden bg-neutral-100"
                >
                    <span class="absolute left-4 top-4 z-10 rounded-full bg-wfsc-coral px-4 py-2 text-xs font-semibold text-white">
                        After
                    </span>
                </div>

            </div>

            {{-- Caption --}}
            <div
                id="lightbox-caption-container"
                class="hidden border-t border-neutral-100 px-6 py-5 sm:px-8"
            >
                <p
                    id="lightbox-caption"
                    class="text-sm leading-relaxed text-neutral-600"
                ></p>
            </div>

        </div>
    </div>
</div>