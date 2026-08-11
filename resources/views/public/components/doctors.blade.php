<section id="doctors" class="bg-white py-24 lg:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-12">

        <div class="mb-14 text-center">
            <p class="text-sm font-medium uppercase tracking-[0.25em] text-neutral-500">
                Our Doctors
            </p>

            <h2 class="mt-3 text-4xl font-bold tracking-tight text-neutral-900 lg:text-5xl">
                Meet Our Doctors
            </h2>
        </div>

        @if ($homeDoctors->isNotEmpty())

            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">

                @foreach ($homeDoctors as $item)

                    @php
                        $doctor = $item->doctor;
                    @endphp

                    @if ($doctor)
                        <a
                            href="{{ route('doctor.show', $doctor->slug) }}"
                            class="group block"
                        >
                            <div class="overflow-hidden rounded-[2rem] bg-neutral-100">

                                @if ($doctor->photo)
                                    <img
                                        src="{{ asset('storage/' . $doctor->photo) }}"
                                        alt="{{ $doctor->name }}"
                                        class="aspect-[4/5] w-full object-cover transition duration-700 ease-out group-hover:scale-105"
                                    >
                                @endif

                            </div>

                            <div class="pt-5 text-center">

                                @if ($doctor->specialization)
                                    <p class="text-sm uppercase tracking-[0.18em] text-neutral-400">
                                        {{ $doctor->specialization }}
                                    </p>
                                @endif

                                <h3 class="mt-2 text-xl font-semibold text-neutral-900">
                                    {{ $doctor->title }}
                                    {{ $doctor->name }}
                                </h3>

                                <span class="mt-4 inline-flex text-sm font-medium text-neutral-500 transition group-hover:text-[#FF5252]">
                                    View Profile →
                                </span>

                            </div>
                        </a>
                    @endif

                @endforeach

            </div>

        @else

            <p class="py-12 text-center text-neutral-500">
                No doctors available.
            </p>

        @endif

    </div>
</section>