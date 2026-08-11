@php
    use Illuminate\Support\Facades\Storage;
@endphp

<section class="bg-neutral-100 py-24 lg:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-12">

        {{-- Section Heading --}}
        <div class="mb-14 text-center">
            <p class="text-sm font-medium uppercase tracking-[0.25em] text-neutral-500">
                Why Choose WFSC
            </p>

            <h2 class="mt-3 text-4xl font-bold tracking-tight text-neutral-900 lg:text-5xl">
                Why Choose WFSC?
            </h2>
        </div>

        {{-- Content --}}
        <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-20">

            {{-- LEFT : Why Choose --}}
            <div>
                @if ($whyChooseItems->isNotEmpty())

                    <div class="space-y-8">

                        @foreach ($whyChooseItems as $item)
                            <article class="flex gap-5">

                                {{-- Icon --}}
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-white shadow-sm">
                                    @if ($item->icon)
                                        <span class="text-lg">
                                            {{ $item->icon }}
                                        </span>
                                    @else
                                        <span class="text-neutral-400">
                                            ✓
                                        </span>
                                    @endif
                                </div>

                                {{-- Text --}}
                                <div>
                                    <h3 class="text-xl font-semibold text-neutral-900">
                                        {{ $item->title }}
                                    </h3>

                                    @if ($item->description)
                                        <p class="mt-2 max-w-lg leading-relaxed text-neutral-500">
                                            {{ $item->description }}
                                        </p>
                                    @endif
                                </div>

                            </article>
                        @endforeach

                    </div>

                @else

                    <p class="text-neutral-500">
                        No information available.
                    </p>

                @endif
            </div>


            {{-- RIGHT : Facility --}}
            <div
                data-facility-slider
                class="relative"
            >

                @if ($facilities->isNotEmpty())

                    <div class="relative overflow-hidden rounded-[2rem]">

                        @foreach ($facilities as $index => $facility)

                            <article
                                data-facility-slide
                                class="{{ $index === 0 ? '' : 'hidden' }}"
                            >

                                {{-- Image --}}
                                @if ($facility->image)
                                    <div class="aspect-[4/3] overflow-hidden rounded-[2rem] bg-neutral-200">
                                        <img
                                            src="{{ Storage::url($facility->image) }}"
                                            alt="{{ $facility->name }}"
                                            class="h-full w-full object-cover"
                                        >
                                    </div>
                                @endif

                                {{-- Facility Info --}}
                                <div class="mt-5">

                                    <h3 class="text-2xl font-semibold text-neutral-900">
                                        {{ $facility->name }}
                                    </h3>

                                    @if ($facility->description)
                                        <p class="mt-2 leading-relaxed text-neutral-500">
                                            {{ $facility->description }}
                                        </p>
                                    @endif

                                </div>

                            </article>

                        @endforeach

                    </div>


                    {{-- Facility Indicators --}}
                    @if ($facilities->count() > 1)

                        <div class="mt-6 flex gap-2">

                            @foreach ($facilities as $index => $facility)
                                <button
                                    type="button"
                                    data-facility-dot="{{ $index }}"
                                    class="h-2.5 w-2.5 rounded-full bg-neutral-300 transition"
                                    aria-label="Go to facility {{ $index + 1 }}"
                                ></button>
                            @endforeach

                        </div>

                    @endif

                @else

                    <div class="rounded-[2rem] bg-neutral-200 p-12 text-center">
                        <p class="text-neutral-500">
                            No facilities available.
                        </p>
                    </div>

                @endif

            </div>

        </div>

    </div>
</section>