<section class="relative isolate overflow-hidden bg-wfsc-coral text-white">

    @if ($banner && $banner->image)

        <img
            src="{{ Storage::url($banner->image) }}"
            alt="{{ $banner->title ?? 'Contact WFSC Clinic' }}"
            class="absolute inset-0 h-full w-full object-cover opacity-20 mix-blend-overlay"
        >

        <div class="absolute inset-0 bg-gradient-to-r from-black/40 via-black/20 to-transparent"></div>

    @endif


    {{-- Decorative Background Blur Circles --}}
    <div
        class="absolute -right-32 -top-32 h-96 w-96 rounded-full bg-white/10 blur-3xl"
        aria-hidden="true"
    ></div>

    <div
        class="absolute -bottom-40 -left-32 h-96 w-96 rounded-full bg-white/10 blur-3xl"
        aria-hidden="true"
    ></div>


    {{-- Hero Content --}}
    <div
        class="relative mx-auto max-w-7xl px-6 pb-20 pt-36 sm:px-8 lg:px-12 lg:pb-24 lg:pt-44"
    >

        <div class="max-w-4xl">

            {{-- Badge --}}
            <div
                data-reveal="left"
                data-delay="0"
                class="reveal-hidden mb-6"
            >

                <span
                    class="inline-flex items-center rounded-full border border-white/30 bg-white/10 px-4 py-2 text-sm font-medium backdrop-blur-sm"
                >
                    Contact Us
                </span>

            </div>


            {{-- Title --}}
            <h1
                data-reveal="left"
                data-delay="100"
                class="reveal-hidden text-4xl font-black leading-tight tracking-tight sm:text-5xl lg:text-6xl"
            >
                {{ $banner?->title ?? 'Temukan Kami' }}
            </h1>


            {{-- Subtitle / Description --}}
            <p
                data-reveal="left"
                data-delay="200"
                class="reveal-hidden mt-6 max-w-2xl text-base leading-relaxed text-white/85 sm:text-lg"
            >
                {{ $banner?->subtitle ?? 'Kunjungi cabang WFSC Clinic terdekat dan temukan layanan perawatan yang sesuai untukmu.' }}
            </p>

        </div>

    </div>

</section>