<section class="relative isolate overflow-hidden bg-neutral-900 text-white">

    {{-- Background Image --}}
    @if ($treatment->cover_image)
        <div class="absolute inset-0 z-0">
            <img
                src="{{ Storage::url($treatment->cover_image) }}"
                alt="{{ $treatment->name }}"
                class="h-full w-full object-cover object-center"
            >
            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/65 to-black/40"></div>
        </div>
    @else
        <div class="absolute inset-0 z-0 bg-wfsc-coral">
            {{-- Decorative background --}}
            <div
                class="absolute -right-32 -top-32 h-96 w-96 rounded-full bg-white/10 blur-3xl"
                aria-hidden="true"
            ></div>
            <div
                class="absolute -bottom-40 -left-32 h-96 w-96 rounded-full bg-white/10 blur-3xl"
                aria-hidden="true"
            ></div>
        </div>
    @endif

    {{-- Hero Content --}}
    <div
        class="relative z-10 mx-auto max-w-7xl px-6 pb-28 pt-36 sm:px-8 lg:px-12 lg:pb-36 lg:pt-44"
    >

        <div class="max-w-4xl">

            {{-- Category --}}
            @if ($treatment->category)
                <div
                    data-reveal="left"
                    data-delay="0"
                    class="reveal-hidden mb-6"
                >
                    <span
                        class="inline-flex items-center rounded-full border border-white/30 bg-white/10 px-4 py-2 text-sm font-medium backdrop-blur-sm"
                    >
                        {{ $treatment->category->name }}
                    </span>
                </div>
            @endif


            {{-- Treatment Name --}}
            <h1
                data-reveal="left"
                data-delay="100"
                class="reveal-hidden text-4xl font-black leading-tight tracking-tight sm:text-5xl lg:text-6xl"
            >
                {{ $treatment->name }}
            </h1>


            {{-- Short Description --}}
            @if ($treatment->short_description)
                <p
                    data-reveal="left"
                    data-delay="200"
                    class="reveal-hidden mt-6 max-w-2xl text-base leading-relaxed text-white/85 sm:text-lg"
                >
                    {{ $treatment->short_description }}
                </p>
            @endif


            {{-- Action Buttons (Konsultasi Gratis) --}}
            <div
                data-reveal="left"
                data-delay="300"
                class="reveal-hidden mt-8 flex flex-wrap items-center gap-3 sm:gap-4"
            >
                {{-- Konsultasi Gratis (WhatsApp) --}}
                @if (isset($whatsappUrl) && $whatsappUrl)
                    <a
                        href="{{ $whatsappUrl }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="group inline-flex items-center gap-2.5 rounded-full border border-rose-500 bg-rose-600 px-6 py-3 text-xs font-semibold text-white shadow-lg transition-all duration-300 hover:border-rose-400 hover:bg-rose-700 sm:px-7 sm:py-3.5 sm:text-sm"
                    >
                        <svg class="h-4 w-4 fill-current text-white sm:h-4.5 sm:w-4.5" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.198.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                        </svg>
                        <span>Konsultasi Gratis</span>
                    </a>
                @endif
            </div>

        </div>

    </div>

</section>