<section id="doctors" class="relative overflow-hidden bg-white py-16 sm:py-20 lg:py-32">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-12">

        {{-- Header & Navigation (Centered & Dibatasi Lebarnya) --}}
        <div class="mx-auto mb-10 flex max-w-2xl flex-col items-center text-center gap-6 sm:mb-14 lg:mb-16">

            {{-- Text Header --}}
            <div>
                <p data-reveal="fade-up" data-delay="100" class="reveal-hidden text-xs font-semibold uppercase tracking-[0.25em] text-[#FF5252] sm:text-sm">
                    Our Doctors
                </p>

                <h2 data-reveal="fade-up" data-delay="200" class="reveal-hidden mt-2 text-3xl font-bold tracking-tight text-neutral-900 sm:mt-3 sm:text-4xl lg:text-5xl">
                    Meet Our Doctors
                </h2>
            </div>

            {{-- Navigation Buttons --}}
            <div data-reveal="fade-up" data-delay="300" class="reveal-hidden flex items-center justify-center gap-2.5 sm:gap-3">
                <button
                    type="button"
                    data-doctor-prev
                    class="flex h-10 w-10 items-center justify-center rounded-full border border-neutral-200 bg-white text-neutral-900 transition-all duration-300 hover:border-[#FF5252] hover:bg-[#FF5252] hover:text-white disabled:cursor-not-allowed disabled:opacity-40 sm:h-11 sm:w-11"
                    aria-label="Previous doctors"
                >
                    ←
                </button>

                <button
                    type="button"
                    data-doctor-next
                    class="flex h-10 w-10 items-center justify-center rounded-full border border-neutral-200 bg-white text-neutral-900 transition-all duration-300 hover:border-[#FF5252] hover:bg-[#FF5252] hover:text-white disabled:cursor-not-allowed disabled:opacity-40 sm:h-11 sm:w-11"
                    aria-label="Next doctors"
                >
                    →
                </button>
            </div>

        </div>

        {{-- Slider Track --}}
        @if ($homeDoctors->isNotEmpty())

            {{-- Container Slider Utama --}}
            <div data-doctor-slider class="relative overflow-hidden">
                <div data-doctor-track class="-mx-3 flex transition-transform duration-500 ease-out">

                    @foreach ($homeDoctors as $index => $item)
                        @php $doctor = $item->doctor; @endphp

                        @if ($doctor)
                            <div 
                                data-doctor-slide 
                                data-reveal="up"
                                data-delay="{{ 100 + ($index * 100) }}"
                                class="reveal-hidden w-full shrink-0 px-3 sm:w-1/2 lg:w-1/3"
                            >
                                <a
                                    href="{{ route('doctor.show', $doctor->slug) }}"
                                    class="group block h-full"
                                >
                                    {{-- Image Container --}}
                                    <div
                                        class="relative overflow-hidden rounded-[2rem] bg-neutral-100
                                        {{ $doctor->isFounder()
                                            ? 'border-2 border-[#FF5252] shadow-[0_12px_40px_rgba(255,82,82,0.16)]'
                                            : 'border border-transparent'
                                        }}"
                                    >
                                        {{-- Founder Badge --}}
                                        @if ($doctor->isFounder())
                                            <div class="absolute left-4 top-4 z-10">
                                                <div class="inline-flex items-center gap-1.5 rounded-full border border-[#FF5252]/20 bg-white/95 px-3 py-1.5 text-[10px] font-bold uppercase tracking-[0.15em] text-[#FF5252] shadow-lg backdrop-blur-sm">
                                                    <span class="text-sm leading-none">♛</span>
                                                    <span>Founder</span>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- Doctor Photo --}}
                                        @if ($doctor->photo)
                                            <img
                                                src="{{ asset('storage/' . $doctor->photo) }}"
                                                alt="{{ $doctor->name }}"
                                                class="aspect-[4/5] w-full object-cover transition duration-700 ease-out group-hover:scale-105"
                                            >
                                        @else
                                            <div class="flex aspect-[4/5] items-center justify-center text-sm text-neutral-400">
                                                No photo
                                            </div>
                                        @endif

                                        {{-- Founder Corner Accent --}}
                                        @if ($doctor->isFounder())
                                            <div class="absolute bottom-4 right-4 flex h-10 w-10 items-center justify-center rounded-full bg-[#FF5252] text-white shadow-lg">
                                                <span class="text-lg">♛</span>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Doctor Info & Link --}}
                                    <div class="pt-5 text-center">
                                        @if ($doctor->isFounder())
                                            <div class="mb-2 inline-flex items-center gap-1.5 rounded-full bg-[#FF5252]/5 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.16em] text-[#FF5252]">
                                                <span>♛</span>
                                                <span>Founder</span>
                                            </div>
                                        @endif

                                        @if ($doctor->specialization)
                                            <p class="text-xs uppercase tracking-[0.18em] text-neutral-400 sm:text-sm">
                                                {{ $doctor->specialization }}
                                            </p>
                                        @endif

                                        <h3 class="mt-2 text-lg font-semibold text-neutral-900 transition duration-300 group-hover:text-[#FF5252] sm:text-xl">
                                            {{ $doctor->title }} {{ $doctor->name }}
                                        </h3>

                                        <span class="mt-3 inline-flex items-center gap-1 text-xs font-medium text-neutral-500 transition duration-300 group-hover:text-[#FF5252] sm:mt-4 sm:text-sm">
                                            <span>View Profile</span>
                                            <span class="transition-transform duration-300 group-hover:translate-x-1">→</span>
                                        </span>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @endforeach

                </div>
            </div>

            {{-- Dynamic Dots --}}
            <div data-doctor-dots class="mt-8 flex justify-center gap-2"></div>

        @else
            <div class="rounded-2xl border border-dashed border-neutral-300 bg-neutral-50 py-12 text-center sm:py-16">
                <p class="text-xs text-neutral-400 sm:text-sm">
                    No doctors available.
                </p>
            </div>
        @endif

    </div>
</section>