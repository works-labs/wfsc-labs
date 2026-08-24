<section class="relative flex min-h-[100dvh] flex-col justify-between overflow-hidden bg-neutral-900 text-white">
    
    {{-- Background Image & Overlay --}}
    <div class="absolute inset-0 z-0">
        @if ($heroBanners->isNotEmpty() && $heroBanners->first()->background_image)
            <img
                src="{{ asset('storage/' . $heroBanners->first()->background_image) }}"
                alt="Hero Background"
                class="h-full w-full object-cover transition-transform duration-[10000ms] ease-out hover:scale-105"
            >
        @endif
        
        <div class="absolute inset-0 bg-gradient-to-t from-neutral-900 via-neutral-900/70 to-black/40 lg:via-neutral-900/50"></div>
    </div>

    {{-- Main Hero Content --}}
    <div class="relative z-10 mx-auto flex w-full max-w-[1440px] grow items-center px-5 pt-28 pb-16 sm:px-8 lg:px-12 lg:pt-32 lg:pb-24">
        <div class="grid w-full items-center gap-10 lg:grid-cols-12 lg:gap-8">

            {{-- Text Content --}}
            <div class="order-1 max-w-2xl lg:col-span-7">
                @if ($hero = $heroBanners->first())

                    <p data-reveal="left" data-delay="100" class="reveal-hidden mb-3 text-xs font-semibold uppercase tracking-[0.25em] text-white/80 sm:text-sm">
                        {{ $hero->subtitle }}
                    </p>

                    {{-- Title --}}
                    <h1 data-reveal="left" data-delay="300" class="reveal-hidden text-3xl font-bold leading-[1.05] tracking-tight text-white sm:text-5xl md:text-6xl xl:text-7xl">
                        {{ $hero->title }}
                    </h1>

                                        {{-- Action Buttons --}}
                    <div data-reveal="left" data-delay="500" class="reveal-hidden mt-6 flex flex-wrap items-center gap-3 sm:mt-8 sm:gap-4">
                        
                        {{-- Secondary Consultation Button (Merah Solid) --}}
                    @if ($whatsappUrl)
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

                        {{-- Primary CTA Button (Dipindah ke Kanan) --}}
                        @if ($hero->cta_text && $hero->getCtaUrl())
                            <a
                                href="{{ $hero->getCtaUrl() }}"
                                class="group inline-flex items-center gap-3 rounded-full border border-white/40 bg-white/10 px-6 py-3 text-xs font-semibold text-white backdrop-blur-md transition-all duration-300 hover:border-white hover:bg-white hover:text-black sm:px-7 sm:py-3.5 sm:text-sm"
                                @if ($hero->cta_type === 'external' || $hero->cta_type === 'whatsapp')
                                    target="_blank"
                                    rel="noopener noreferrer"
                                @endif
                            >
                                <span>{{ $hero->cta_text }}</span>
                                <span class="transition-transform duration-300 group-hover:translate-x-1.5">→</span>
                            </a>
                        @endif

                    </div>
                @endif
            </div>

            {{-- Doctor Card --}}
            <div class="order-2 flex justify-center lg:col-span-5 lg:justify-end">
                @if ($heroDoctors->isNotEmpty() && ($doctor = $heroDoctors->first()->doctor))
                    @if ($doctor->photo)
                        <a 
                            href="{{ route('doctor.show', $doctor->slug) }}"
                            data-reveal="right" 
                            data-delay="400"
                            class="reveal-hidden group w-full max-w-[260px] animate-float-soft sm:max-w-[300px] lg:max-w-[320px] xl:max-w-[340px]"
                        >
                            <div class="relative aspect-[3/4] w-full overflow-hidden rounded-[1.75rem] border border-white/15 bg-white/10 p-1.5 shadow-2xl backdrop-blur-md transition-all duration-500 group-hover:border-white/40 sm:rounded-[2rem]">
                                <img
                                    src="{{ asset('storage/' . $doctor->photo) }}"
                                    alt="{{ $doctor->name }}"
                                    class="h-full w-full rounded-[1.4rem] object-cover object-top transition-transform duration-700 group-hover:scale-105 sm:rounded-[1.6rem]"
                                >
                            </div>

                            <div class="mt-3 text-center lg:text-left">
                                <p class="text-xs font-semibold text-white transition-colors duration-300 group-hover:text-white/80 sm:text-sm">
                                    {{ $doctor->title }} {{ $doctor->name }}
                                </p>

                                @if ($doctor->specialization)
                                    <p class="mt-0.5 text-[11px] text-white/60 sm:text-xs">
                                        {{ $doctor->specialization }}
                                    </p>
                                @endif
                            </div>
                        </a>
                    @endif
                @endif
            </div>

        </div>
    </div>

    {{-- Statistics Bar --}}
    @if ($statistics->isNotEmpty())
        <div data-reveal="zoom" data-delay="700" class="reveal-hidden relative z-20 mx-auto w-full max-w-[1440px] px-5 pb-8 sm:px-8 lg:absolute lg:bottom-8 lg:right-12 lg:w-auto lg:px-0 lg:pb-0">
            <div class="grid grid-cols-2 gap-2 rounded-2xl border border-white/20 bg-white/10 p-2.5 backdrop-blur-xl sm:grid-cols-4 sm:gap-3 sm:rounded-3xl sm:p-3 lg:flex lg:flex-row-reverse lg:items-center lg:gap-0 lg:p-2.5">
                @foreach ($statistics as $statistic)
                    <div class="min-w-[100px] px-3 py-2 text-center sm:px-4 lg:min-w-[125px] lg:border-r lg:border-white/15 lg:py-2 lg:text-left lg:first:border-r-0">
                        <div class="text-lg font-bold text-white sm:text-xl lg:text-2xl">
                            {{ $statistic->value }}{{ $statistic->suffix }}
                        </div>

                        <div class="mt-0.5 text-[10px] text-white/70 sm:text-xs">
                            {{ $statistic->label }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</section>