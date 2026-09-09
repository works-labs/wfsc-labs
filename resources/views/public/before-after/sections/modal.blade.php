<div
    id="before-after-lightbox"
    class="fixed inset-0 z-[100] hidden opacity-0 transition-opacity duration-300"
    aria-hidden="true"
>
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/80 backdrop-blur-sm"></div>

    {{-- Dialog --}}
    <div
        class="relative flex min-h-full items-center justify-center p-3 sm:p-6"
    >
        <div
            class="relative w-full max-w-6xl overflow-hidden rounded-2xl bg-white shadow-2xl sm:rounded-3xl"
        >

            {{-- Close --}}
            <button
                id="lightbox-close"
                type="button"
                class="absolute right-3 top-3 z-20 flex h-9 w-9 items-center justify-center rounded-full bg-black/60 text-white backdrop-blur-md transition hover:bg-black/80 sm:right-4 sm:top-4 sm:h-10 sm:w-10"
                aria-label="Close"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 sm:h-5 sm:w-5"
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
            <div class="border-b border-neutral-100 px-5 py-4 sm:px-8 sm:py-5">
                <p
                    class="text-[10px] font-semibold uppercase tracking-[0.2em] text-wfsc-coral sm:text-xs"
                >
                    Before & After
                </p>

                <h2
                    class="mt-1 text-lg font-bold text-neutral-900 sm:text-2xl"
                >
                    Treatment Result
                </h2>
            </div>


            {{-- Before / After --}}
            <div class="grid grid-cols-1 gap-px bg-neutral-200 sm:grid-cols-2">

                {{-- Before --}}
                <div
                    id="lightbox-before-container"
                    class="relative flex h-[38vh] min-h-[240px] max-h-[360px] items-center justify-center overflow-hidden bg-neutral-100 sm:h-[60vh] sm:min-h-[400px] sm:max-h-none"
                >
                    <span
                        class="absolute left-3 top-3 z-10 rounded-full bg-black/70 px-3 py-1.5 text-[10px] font-semibold text-white backdrop-blur-sm sm:left-4 sm:top-4 sm:px-4 sm:py-2 sm:text-xs"
                    >
                        Before
                    </span>
                </div>


                {{-- After --}}
                <div
                    id="lightbox-after-container"
                    class="relative flex h-[38vh] min-h-[240px] max-h-[360px] items-center justify-center overflow-hidden bg-neutral-100 sm:h-[60vh] sm:min-h-[400px] sm:max-h-none"
                >
                    <span
                        class="absolute left-3 top-3 z-10 rounded-full bg-wfsc-coral px-3 py-1.5 text-[10px] font-semibold text-white sm:left-4 sm:top-4 sm:px-4 sm:py-2 sm:text-xs"
                    >
                        After
                    </span>
                </div>

            </div>


            {{-- Caption --}}
            <div
                id="lightbox-caption-container"
                class="hidden border-t border-neutral-100 px-5 py-4 sm:px-8 sm:py-5"
            >
                <p
                    id="lightbox-caption"
                    class="text-xs leading-relaxed text-neutral-600 sm:text-sm"
                ></p>
            </div>

        </div>
    </div>
</div>