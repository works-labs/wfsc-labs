<section id="doctors" class="relative overflow-hidden bg-white py-16 sm:py-20 lg:py-32">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-12">

        {{-- Header & Navigation --}}
        <div class="mb-8 flex flex-col gap-6 sm:mb-12 lg:flex-row lg:items-end lg:justify-between">

            {{-- Text Header --}}
            <div class="max-w-2xl">
                <p data-reveal="left" data-delay="100" class="reveal-hidden text-xs font-semibold uppercase tracking-[0.25em] text-[#FF5252] sm:text-sm">
                    Our Doctors
                </p>

                <h2 data-reveal="left" data-delay="200" class="reveal-hidden mt-2 text-3xl font-bold tracking-tight text-neutral-900 sm:mt-3 sm:text-4xl lg:text-5xl">
                    Meet Our Doctors
                </h2>
            </div>

            {{-- Navigation Buttons --}}
            <div data-reveal="right" data-delay="300" class="reveal-hidden flex items-center gap-2.5 sm:gap-3">
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

            {{-- Container Slider Utama (Tidak diberi animasi reveal agar tidak bentrok dengan kalkulasi JS Slider) --}}
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
                                <a href="{{ route('doctor.show', $doctor->slug) }}" class="group block h-full">
                                    <div class="overflow-hidden rounded-[2rem] bg-neutral-100">
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
                                    </div>

                                    <div class="pt-5 text-center">
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