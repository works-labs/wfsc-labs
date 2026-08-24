<section class="relative min-h-[100dvh] overflow-hidden bg-neutral-900 text-white flex flex-col justify-between">
    
    {{-- Background Image & Overlay --}}
    <div class="absolute inset-0 z-0">
        @if ($heroBanners->isNotEmpty() && $heroBanners->first()->background_image)
            <img
                src="{{ asset('storage/' . $heroBanners->first()->background_image) }}"
                alt="Hero Background"
                class="h-full w-full object-cover transition-transform duration-[10000ms] ease-out hover:scale-105"
            >
        @endif
        
        {{-- Multi-layer Overlay agar readable di semua layar --}}
        <div class="absolute inset-0 bg-gradient-to-t from-neutral-900 via-neutral-900/70 to-black/40 lg:via-neutral-900/50"></div>
    </div>

    {{-- Main Hero Content --}}
    <div class="relative z-10 mx-auto flex w-full max-w-[1440px] grow items-center px-5 pt-28 pb-16 sm:px-8 lg:px-12 lg:pt-32 lg:pb-24">
        <div class="grid w-full items-center gap-10 lg:grid-cols-12 lg:gap-8">

            {{-- Text Content --}}
            <div class="order-1 max-w-2xl lg:col-span-7 mix-blend-difference">
                @if ($heroBanners->isNotEmpty())
                    @php $hero = $heroBanners->first(); @endphp

                    <p data-reveal="left" data-delay="100" class="reveal-hidden mb-3 text-xs font-semibold uppercase tracking-[0.25em] text-white/80 sm:text-sm">
                        {{ $hero->subtitle }}
                    </p>

                    {{-- Title dengan Fluid Typography (clamp/responsive) --}}
                    <h1 data-reveal="left" data-delay="300" class="reveal-hidden text-3xl font-bold leading-[1.05] tracking-tight text-white sm:text-5xl md:text-6xl xl:text-7xl">
                        {{ $hero->title }}
                    </h1>

                    @if ($hero->cta_text && $hero->getCtaUrl())
                        <div data-reveal="left" data-delay="500" class="reveal-hidden mt-6 sm:mt-8">
                            <a
                                href="{{ $hero->getCtaUrl() }}"
                                class="group inline-flex items-center gap-3 rounded-full border border-white/40 bg-white/10 px-6 py-3 text-xs font-semibold text-white backdrop-blur-md transition-all duration-300 hover:border-white hover:bg-white hover:text-black sm:px-8 sm:py-3.5 sm:text-sm"
                                @if ($hero->cta_type === 'external' || $hero->cta_type === 'whatsapp')
                                    target="_blank"
                                    rel="noopener noreferrer"
                                @endif
                            >
                                <span>{{ $hero->cta_text }}</span>
                                <span class="transition-transform duration-300 group-hover:translate-x-1.5">→</span>
                            </a>
                        </div>
                    @endif
                @endif
            </div>

            {{-- Doctor Card (Responsive Aspect Ratio & Fluid Width) --}}
            <div class="order-2 flex justify-center lg:col-span-5 lg:justify-end">
                @if ($heroDoctors->isNotEmpty())
                    @php $doctor = $heroDoctors->first()->doctor; @endphp

                    @if ($doctor?->photo)
                        <a 
                            href="{{ route('doctor.show', $doctor->slug) }}"
                            data-reveal="right" 
                            data-delay="400"
                            class="reveal-hidden group w-full max-w-[260px] animate-float-soft sm:max-w-[300px] lg:max-w-[320px] xl:max-w-[340px]"
                        >
                            {{-- Ganti fixed h-120 w-80 jadi aspect ratio & w-full --}}
                            <div class="relative aspect-[3/4] w-full overflow-hidden rounded-[1.75rem] border border-white/15 bg-white/10 p-1.5 backdrop-blur-md shadow-2xl transition-all duration-500 group-hover:border-white/40 sm:rounded-[2rem]">
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

    {{-- Statistics Bar (Responsive Floating / Stack di Mobile) --}}
    @if ($statistics->isNotEmpty())
        <div data-reveal="zoom" data-delay="700" class="reveal-hidden relative z-20 mx-auto w-full max-w-[1440px] px-5 pb-8 sm:px-8 lg:absolute lg:bottom-8 lg:right-12 lg:w-auto lg:px-0 lg:pb-0">
            <div class="grid grid-cols-2 gap-2 rounded-2xl border border-white/20 bg-white/10 p-2.5 backdrop-blur-xl sm:grid-cols-3 sm:gap-3 sm:rounded-3xl sm:p-3 lg:flex lg:flex-wrap">
                @foreach ($statistics as $statistic)
                    <div class="min-w-[100px] px-3 py-2 text-center lg:min-w-[120px] lg:px-4 lg:py-3 lg:text-left">
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