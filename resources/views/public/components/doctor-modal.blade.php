<div
    id="doctor-lightbox"
    class="fixed inset-0 z-[100] hidden opacity-0 transition-opacity duration-300"
    aria-hidden="true"
>
    {{-- Backdrop --}}
    <div
        id="doctor-lightbox-backdrop"
        class="absolute inset-0 bg-black/80 backdrop-blur-sm"
    ></div>

    {{-- Modal Wrapper --}}
    <div class="relative flex min-h-full items-center justify-center p-4 sm:p-6">
        <div
            id="doctor-lightbox-content"
            class="relative w-full max-w-2xl overflow-hidden rounded-3xl bg-white shadow-2xl transition-all duration-300"
        >
            {{-- Close Button --}}
            <button
                id="doctor-lightbox-close"
                type="button"
                class="absolute right-4 top-4 z-20 flex h-9 w-9 items-center justify-center rounded-full bg-neutral-900/60 text-white backdrop-blur-md transition hover:bg-neutral-900"
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

            {{-- Doctor Profile Body --}}
            <div class="p-6 sm:p-8">
                <div class="flex flex-col items-center text-center sm:flex-row sm:items-start sm:text-left gap-6">
                    
                    {{-- Doctor Photo --}}
                    <div class="relative aspect-[4/5] w-36 shrink-0 overflow-hidden rounded-2xl bg-neutral-100 shadow-md sm:w-44">
                        <img
                            id="doctor-lightbox-photo"
                            src=""
                            alt=""
                            class="h-full w-full object-cover"
                        >
                    </div>

                    {{-- Doctor Details --}}
                    <div class="flex-1">
                        <span
                            id="doctor-lightbox-specialization"
                            class="inline-block text-[11px] font-bold uppercase tracking-[0.18em] text-[#FF5252]"
                        ></span>

                        <h2
                            id="doctor-lightbox-name"
                            class="mt-1 text-2xl font-extrabold tracking-tight text-neutral-900 sm:text-3xl"
                        ></h2>

                        <p
                            id="doctor-lightbox-bio"
                            class="mt-3 text-xs leading-relaxed text-neutral-500 sm:text-sm"
                        ></p>

                        {{-- Quick Info Badges --}}
                        <div class="mt-4 flex flex-wrap items-center justify-center sm:justify-start gap-2">
                            <div
                                id="doctor-lightbox-education-container"
                                class="hidden rounded-xl border border-neutral-100 bg-neutral-50 px-3 py-1.5 text-left"
                            >
                                <span class="block text-[9px] font-bold uppercase tracking-wider text-neutral-400">Pendidikan</span>
                                <span id="doctor-lightbox-education" class="text-xs font-semibold text-neutral-800"></span>
                            </div>

                            <div
                                id="doctor-lightbox-experience-container"
                                class="hidden rounded-xl border border-neutral-100 bg-neutral-50 px-3 py-1.5 text-left"
                            >
                                <span class="block text-[9px] font-bold uppercase tracking-wider text-neutral-400">Pengalaman</span>
                                <span id="doctor-lightbox-experience" class="text-xs font-semibold text-neutral-800"></span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
