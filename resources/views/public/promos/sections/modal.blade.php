<div
    id="promo-lightbox"
    class="fixed inset-0 z-[100] hidden opacity-0 transition-opacity duration-300"
    aria-hidden="true"
>
    {{-- Backdrop --}}
    <div
        class="absolute inset-0 bg-black/80 backdrop-blur-sm"
    ></div>


    {{-- Modal Wrapper --}}
    <div
        class="relative flex min-h-full items-center justify-center p-4 sm:p-6"
    >

        <div
            id="promo-lightbox-content"
            class="relative w-full max-w-5xl overflow-hidden rounded-3xl bg-white shadow-2xl"
        >

            {{-- Close Button --}}
            <button
                id="promo-lightbox-close"
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


            {{-- Promo Image --}}
            <div
                id="promo-lightbox-image-container"
                class="relative flex max-h-[70vh] min-h-[300px] items-center justify-center overflow-hidden bg-neutral-100"
            >

                <img
                    id="promo-lightbox-image"
                    src=""
                    alt=""
                    class="max-h-[70vh] w-full object-contain"
                >

            </div>


            {{-- Promo Information --}}
            <div class="px-6 py-6 sm:px-8 sm:py-7">

                {{-- Label --}}
                <span
                    class="text-xs font-semibold uppercase tracking-[0.2em] text-wfsc-coral"
                >
                    Promo
                </span>


                {{-- Title --}}
                <h2
                    id="promo-lightbox-title"
                    class="mt-2 text-2xl font-black tracking-tight text-neutral-900 sm:text-3xl"
                ></h2>


                {{-- Description --}}
                <div
                    id="promo-lightbox-description-container"
                    class="mt-4 hidden"
                >
                    <p
                        id="promo-lightbox-description"
                        class="text-sm leading-relaxed text-neutral-600 sm:text-base"
                    ></p>
                </div>

            </div>

        </div>

    </div>

</div>