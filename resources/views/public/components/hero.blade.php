<section class="relative min-h-screen overflow-hidden bg-neutral-900 text-white">
    {{-- Background --}}
    <div class="absolute inset-0">
        @if ($heroBanners->isNotEmpty() && $heroBanners->first()->background_image)
            <img
                src="{{ asset('storage/' . $heroBanners->first()->background_image) }}"
                alt="Hero Background"
                class="h-full w-full object-cover"
            >
        @endif
        <div class="absolute inset-0 bg-black/30"></div>
    </div>

    {{-- Hero Content --}}
    <div class="relative z-10 mx-auto flex min-h-screen max-w-[1440px] items-center px-6 pb-24 pt-28 lg:px-12">
        <div class="grid w-full items-end gap-12 lg:grid-cols-[1fr_1fr]">

            {{-- Text --}}
            <div class="order-1 max-w-xl lg:pb-20">
                @if ($heroBanners->isNotEmpty())
                    @php
                        $hero = $heroBanners->first();
                    @endphp

                    <p class="mb-4 text-sm uppercase tracking-[0.3em]">
                        {{ $hero->subtitle }}
                    </p>

                    <h1 class="text-5xl font-bold leading-[0.95] tracking-tight sm:text-6xl lg:text-7xl">
                        {{ $hero->title }}
                    </h1>

                    @if ($hero->cta_text)
                        <a 
                            href="{{ $hero->cta_url ?: '#contact' }}"
                            class="mt-8 inline-flex rounded-full bg-white px-7 py-3 text-sm font-semibold text-black transition-transform hover:scale-105"
                        >
                            {{ $hero->cta_text }}
                        </a>
                    @endif
                @endif
            </div>

            {{-- Doctor --}}
            <div class="order-2 flex items-end justify-start lg:justify-end">
                @if ($heroDoctors->isNotEmpty())
                    @php
                        $doctor = $heroDoctors->first()->doctor;
                    @endphp

                    @if ($doctor?->photo)
                        <a 
                            href="{{ route('doctor.show', $doctor->slug) }}"
                            class="group inline-block"
                        >
                            <div class="h-120 w-80 overflow-hidden rounded-[2rem] border border-white/15 bg-white/10 p-1 shadow-2xl sm:h-120 sm:w-80">
                                <img
                                    src="{{ asset('storage/' . $doctor->photo) }}"
                                    alt="{{ $doctor->name }}"
                                    class="block h-full w-full rounded-[1.75rem] object-cover object-top transition-transform duration-500 group-hover:scale-105"
                                >
                            </div>

                            <div class="mt-3">
                                <p class="text-sm font-medium text-white">
                                    {{ $doctor->title }} {{ $doctor->name }}
                                </p>

                                @if ($doctor->specialization)
                                    <p class="mt-1 text-xs text-white/60">
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

    {{-- Statistics --}}
    @if ($statistics->isNotEmpty())
        <div class="absolute bottom-8 right-6 z-20 lg:right-12">
            <div class="flex max-w-xl flex-wrap gap-3 rounded-3xl border border-white/20 bg-white/10 p-3 backdrop-blur-xl">
                @foreach ($statistics as $statistic)
                    <div class="min-w-[120px] px-4 py-3">
                        <div class="text-2xl font-bold">
                            {{ $statistic->value }}{{ $statistic->suffix }}
                        </div>

                        <div class="mt-1 text-xs text-white/70">
                            {{ $statistic->label }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</section>