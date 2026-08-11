@php
    use Illuminate\Support\Facades\Storage;
@endphp

<section class="bg-neutral-100 py-24 lg:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-12">

        {{-- Heading --}}
        <div class="mx-auto mb-16 max-w-2xl text-center">
            <p class="text-sm font-medium uppercase tracking-[0.25em] text-neutral-500">
                Our Facility
            </p>

            <h2 class="mt-3 text-4xl font-bold tracking-tight text-neutral-900 lg:text-5xl">
                Experience Our Space
            </h2>
        </div>

        @if ($facilities->isNotEmpty())

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">

                @foreach ($facilities as $facility)
                    <article
                        class="group overflow-hidden rounded-[2rem] bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl"
                    >

                        {{-- Image --}}
                        @if ($facility->image)
                            <div class="aspect-[4/3] overflow-hidden">
                                <img
                                    src="{{ Storage::url($facility->image) }}"
                                    alt="{{ $facility->name }}"
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                >
                            </div>
                        @endif

                        {{-- Content --}}
                        <div class="p-7">
                            <h3 class="text-xl font-semibold text-neutral-900">
                                {{ $facility->name }}
                            </h3>

                            @if ($facility->description)
                                <p class="mt-3 leading-relaxed text-neutral-500">
                                    {{ $facility->description }}
                                </p>
                            @endif
                        </div>

                    </article>
                @endforeach

            </div>

        @else

            <p class="py-12 text-center text-neutral-500">
                No facilities available.
            </p>

        @endif

    </div>
</section>