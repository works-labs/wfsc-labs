<section id="doctors" class="relative overflow-hidden bg-white py-10 sm:py-14 lg:py-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-12">

        {{-- Header & Navigation --}}
        <div class="mx-auto mb-8 flex max-w-2xl flex-col items-center text-center gap-4 sm:mb-10 lg:mb-12">
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

            {{-- Slider Container: Diberi py-8 dan -my-8 agar shadow & scale tidak terpotong --}}
            <div data-doctor-slider class="relative -my-8 overflow-hidden py-8">
                <div data-doctor-track class="flex transition-transform duration-500 ease-out {{ $homeDoctors->count() < 3 ? 'lg:justify-center' : '' }}">

                    @foreach ($homeDoctors as $index => $item)
                        @php $doctor = $item->doctor; @endphp

                        @if ($doctor)
                            <div 
                                data-doctor-slide 
                                data-reveal="up"
                                data-delay="{{ 100 + ($index * 100) }}"
                                class="reveal-hidden w-full shrink-0 basis-full sm:basis-1/2 lg:basis-1/3"
                            >
                                {{-- Card Wrapper --}}
                                <div class="doctor-card-inner flex h-full w-full px-4 transition-all duration-500 ease-out">
                                    @if ($doctor->isFounder())
                                        {{-- JIKA FOUNDER: Diarahkan ke halaman detail dokter --}}
                                        <a
                                            href="{{ route('doctor.show', $doctor->slug) }}"
                                            class="group relative flex h-full w-full flex-col rounded-[2rem] bg-white p-3.5 border transition-all duration-300 border-[#FF5252]/40 shadow-lg hover:shadow-xl hover:border-[#FF5252]"
                                        >
                                            <div class="relative aspect-[4/5] w-full overflow-hidden rounded-[1.5rem] bg-neutral-100">
                                                <div class="absolute left-3 top-3 z-10">
                                                    <div class="inline-flex items-center gap-1.5 rounded-full border border-amber-300/60 bg-gradient-to-r from-amber-500 via-[#FF5252] to-rose-600 px-3.5 py-1.5 text-[10px] font-black uppercase tracking-[0.18em] text-white shadow-lg shadow-rose-500/30 backdrop-blur-md">
                                                        <span class="text-amber-200">♛</span>
                                                        <span>Founder</span>
                                                    </div>
                                                </div>

                                                @if ($doctor->photo)
                                                    <img
                                                        src="{{ asset('storage/' . $doctor->photo) }}"
                                                        alt="{{ $doctor->name }}"
                                                        class="h-full w-full object-cover transition duration-700 ease-out group-hover:scale-105"
                                                    >
                                                @else
                                                    <div class="flex h-full w-full items-center justify-center text-sm text-neutral-400">
                                                        No photo
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="flex flex-col flex-1 justify-between p-4 text-center">
                                                <div>
                                                    @if ($doctor->specialization)
                                                        <p class="text-xs font-semibold uppercase tracking-[0.15em] text-[#FF5252]">
                                                            {{ $doctor->specialization }}
                                                        </p>
                                                    @endif

                                                    <h3 class="mt-1 text-lg font-bold text-neutral-900 transition duration-300 group-hover:text-[#FF5252] sm:text-xl">
                                                        {{ $doctor->title }} {{ $doctor->name }}
                                                    </h3>
                                                </div>

                                                <span class="mt-3 inline-flex items-center justify-center gap-1.5 text-xs font-semibold text-neutral-500 transition duration-300 group-hover:text-[#FF5252]">
                                                    <span>View Profile</span>
                                                    <span class="transition-transform duration-300 group-hover:translate-x-1">→</span>
                                                </span>
                                            </div>
                                        </a>
                                    @else
                                        {{-- JIKA BUKAN FOUNDER: Membuka Pop-up Lightbox Modal --}}
                                        <article
                                            data-doctor-lightbox-trigger
                                            data-doctor-photo="{{ $doctor->photo ? asset('storage/' . $doctor->photo) : '' }}"
                                            data-doctor-name="{{ $doctor->title }} {{ $doctor->name }}"
                                            data-doctor-specialization="{{ $doctor->specialization }}"
                                            data-doctor-bio="{{ $doctor->short_bio ?: $doctor->bio }}"
                                            data-doctor-education="{{ $doctor->education }}"
                                            data-doctor-experience="{{ $doctor->experience }}"
                                            class="group relative cursor-pointer flex h-full w-full flex-col rounded-[2rem] bg-white p-3.5 border border-neutral-200 shadow-lg transition-all duration-300 hover:shadow-xl hover:border-[#FF5252]/40"
                                        >
                                            <div class="relative aspect-[4/5] w-full overflow-hidden rounded-[1.5rem] bg-neutral-100">
                                                @if ($doctor->photo)
                                                    <img
                                                        src="{{ asset('storage/' . $doctor->photo) }}"
                                                        alt="{{ $doctor->name }}"
                                                        class="h-full w-full object-cover transition duration-700 ease-out group-hover:scale-105"
                                                    >
                                                @else
                                                    <div class="flex h-full w-full items-center justify-center text-sm text-neutral-400">
                                                        No photo
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="flex flex-col flex-1 justify-between p-4 text-center">
                                                <div>
                                                    @if ($doctor->specialization)
                                                        <p class="text-xs font-semibold uppercase tracking-[0.15em] text-[#FF5252]">
                                                            {{ $doctor->specialization }}
                                                        </p>
                                                    @endif

                                                    <h3 class="mt-1 text-lg font-bold text-neutral-900 transition duration-300 group-hover:text-[#FF5252] sm:text-xl">
                                                        {{ $doctor->title }} {{ $doctor->name }}
                                                    </h3>
                                                </div>

                                                <button
                                                    type="button"
                                                    class="mt-3 inline-flex items-center justify-center gap-1.5 text-xs font-semibold text-neutral-500 transition duration-300 group-hover:text-[#FF5252]"
                                                >
                                                    <span>Quick View</span>
                                                    <span class="transition-transform duration-300 group-hover:translate-x-1">→</span>
                                                </button>
                                            </div>
                                        </article>
                                    @endif
                                </div>
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

    {{-- Include Modal Lightbox Dokter (Non-Founder) --}}
    @include('public.components.doctor-modal')

</section>