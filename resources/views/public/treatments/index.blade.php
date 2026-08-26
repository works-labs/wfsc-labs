@extends('layouts.public')

@section('title', 'Treatments - WFSC Clinic')
@section('body_class', 'public-page-light')

@section('content')

{{-- Category Navigation (Centered) --}}
<section class="relative border-b border-neutral-200/80 bg-[#FAF9F6] pt-32 lg:pt-40">
    <div class="mx-auto max-w-7xl px-6 lg:px-12">

        <div
            class="flex items-center justify-center overflow-x-auto scrollbar-hide gap-2 md:gap-6"
            data-treatment-tabs
        >

            @foreach ($categories as $index => $category)
                <button
                    type="button"
                    data-treatment-tab="{{ $category->id }}"
                    class="treatment-tab shrink-0 border-b-2 px-4 py-5 font-medium transition-all duration-300 focus:outline-none
                        {{ $index === 0
                            ? 'border-[#FF5252] text-xl md:text-2xl font-bold text-neutral-900'
                            : 'border-transparent text-sm md:text-base font-normal text-neutral-400 hover:text-neutral-700' }}"
                >
                    {{ $category->name }}
                </button>
            @endforeach

        </div>

    </div>
</section>


{{-- Treatments List Section --}}
<section class="relative overflow-hidden bg-[#FAF9F6] px-6 py-16 lg:px-12 lg:py-24">
    
    {{-- Aksen Dekoratif Latar Belakang (Soft Glow Coral) --}}
    <div class="pointer-events-none absolute -left-20 top-1/4 h-96 w-96 rounded-full bg-[#FF5252]/5 blur-3xl"></div>
    <div class="pointer-events-none absolute -right-20 top-1/2 h-96 w-96 rounded-full bg-[#FF5252]/5 blur-3xl"></div>

    <div class="relative mx-auto max-w-7xl">

        @forelse ($categories as $category)

            <div
                data-treatment-panel="{{ $category->id }}"
                class="{{ $loop->first ? '' : 'hidden' }} transition-opacity duration-500"
            >

                {{-- Category Heading (Centered & Dibatasi Lebarnya) --}}
                <div class="mx-auto mb-10 flex max-w-2xl flex-col items-center text-center gap-2 sm:mb-14 lg:mb-16">

                    <div class="inline-flex items-center gap-2 rounded-full border border-[#FF5252]/20 bg-[#FF5252]/5 px-3.5 py-1">
                        <span class="h-1.5 w-1.5 rounded-full bg-[#FF5252]"></span>
                        <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#FF5252]">
                            Category {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>

                    <h2 class="mt-3 text-3xl font-bold tracking-tight text-neutral-900 sm:text-4xl lg:text-5xl">
                        {{ $category->name }}
                    </h2>

                    @if ($category->description)
                        <p class="mt-3 text-sm leading-relaxed text-neutral-500 sm:mt-4 sm:text-base">
                            {{ $category->description }}
                        </p>
                    @endif

                </div>


                {{-- Treatment Cards Grid --}}
                @if ($category->treatments->isNotEmpty())

                    <div class="grid gap-x-6 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">

                        @foreach ($category->treatments as $treatment)

                            <article class="group flex flex-col justify-between overflow-hidden rounded-[1.75rem] border border-neutral-200/80 bg-white p-4 shadow-[0_4px_20px_rgba(0,0,0,0.03)] transition-all duration-500 hover:-translate-y-2 hover:border-[#FF5252]/30 hover:shadow-[0_12px_30px_rgba(255,82,82,0.12)]">

                                <div>
                                    {{-- Image --}}
                                    <a
                                        href="{{ route('treatment.show', $treatment->slug) }}"
                                        class="relative block overflow-hidden rounded-[1.25rem] bg-neutral-100"
                                    >

                                        @if ($treatment->cover_image)

                                            <img
                                                src="{{ asset('storage/' . $treatment->cover_image) }}"
                                                alt="{{ $treatment->name }}"
                                                class="aspect-[4/3] w-full object-cover transition duration-700 ease-out group-hover:scale-105"
                                            >

                                        @else

                                            <div class="flex aspect-[4/3] items-center justify-center bg-neutral-100">
                                                <span class="text-sm text-neutral-400">
                                                    {{ $treatment->name }}
                                                </span>
                                            </div>

                                        @endif

                                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>

                                    </a>


                                    {{-- Content --}}
                                    <div class="px-2 pt-5">

                                        <div class="flex items-start justify-between gap-4">

                                            <div>

                                                <h3 class="text-xl font-bold tracking-tight text-neutral-900 transition-colors duration-300 group-hover:text-[#FF5252]">
                                                    {{ $treatment->name }}
                                                </h3>

                                                @if ($treatment->short_description)
                                                    <p class="mt-2 line-clamp-3 text-sm leading-relaxed text-neutral-500">
                                                        {{ $treatment->short_description }}
                                                    </p>
                                                @endif

                                            </div>

                                            @if ($treatment->is_featured)
                                                <span class="shrink-0 rounded-full border border-[#FF5252]/20 bg-[#FF5252]/10 px-3 py-1 text-[11px] font-semibold uppercase tracking-wider text-[#FF5252]">
                                                    Featured
                                                </span>
                                            @endif

                                        </div>

                                    </div>
                                </div>


                                {{-- Read More Action --}}
                                <div class="px-2 pb-2 pt-6">
                                    <a
                                        href="{{ route('treatment.show', $treatment->slug) }}"
                                        class="inline-flex w-full items-center justify-between border-t border-neutral-100 pt-4 text-xs font-bold uppercase tracking-wider text-neutral-900 transition-all duration-300 group-hover:border-[#FF5252]/20 group-hover:text-[#FF5252]"
                                    >
                                        <span>Read More</span>
                                        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-neutral-100 text-neutral-900 transition-all duration-300 group-hover:bg-[#FF5252] group-hover:text-white group-hover:translate-x-1">
                                            →
                                        </span>
                                    </a>
                                </div>

                            </article>

                        @endforeach

                    </div>

                @else

                    <div class="rounded-[1.75rem] border border-dashed border-neutral-300 bg-white/50 px-6 py-16 text-center">
                        <p class="text-sm text-neutral-500">
                            No treatments available in this category.
                        </p>
                    </div>

                @endif

            </div>

        @empty

            <div class="py-20 text-center">
                <p class="text-neutral-500">
                    No treatment categories available.
                </p>
            </div>

        @endforelse

    </div>

</section>
@include('public.components.news', [
    'news' => $news,
])
@include('public.components.footer')
@endsection