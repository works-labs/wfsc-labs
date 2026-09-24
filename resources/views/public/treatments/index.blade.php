@extends('layouts.public')

@section('title', 'Treatments - WFSC Clinic')
@section('body_class', 'public-page-light')

@section('content')

{{-- Banner Hero Section (Jika diset di Admin Banners placement: treatments) --}}
@if (isset($banner) && $banner)
    <section class="relative isolate overflow-hidden text-white">
        {{-- Background Image --}}
        <div class="absolute inset-0 -z-20">
            <img
                src="{{ \Illuminate\Support\Facades\Storage::url($banner->image) }}"
                alt="{{ $banner->title }}"
                class="h-full w-full object-cover"
            >
        </div>

        {{-- Overlay --}}
        <div class="absolute inset-0 -z-10 bg-black/50" aria-hidden="true"></div>

        {{-- Decorative Glow --}}
        <div class="absolute -right-32 -top-32 h-96 w-96 rounded-full bg-white/10 blur-3xl" aria-hidden="true"></div>
        <div class="absolute -bottom-40 -left-32 h-96 w-96 rounded-full bg-white/10 blur-3xl" aria-hidden="true"></div>

        {{-- Hero Content --}}
        <div class="relative mx-auto max-w-7xl px-6 pb-20 pt-36 sm:px-8 lg:px-12 lg:pb-24 lg:pt-44">
            <div class="max-w-3xl">
                <h1 class="mt-4 text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl">
                    {{ $banner->title }}
                </h1>
                @if ($banner->subtitle)
                    <p class="mt-4 text-base leading-relaxed text-white/85 sm:text-lg">
                        {{ $banner->subtitle }}
                    </p>
                @endif

                {{-- Action Buttons (Konsultasi Gratis & Book Now) --}}
                <div class="mt-8 flex flex-wrap items-center gap-3 sm:gap-4">
                    {{-- Konsultasi Gratis (WhatsApp) --}}
                    @if (isset($whatsappUrl) && $whatsappUrl)
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
                </div>
            </div>
        </div>
    </section>
@endif

{{-- Sticky Category Navigation Chips --}}
<section class="sticky top-0 z-40 border-y border-neutral-200/70 bg-white/90 backdrop-blur-xl sm:top-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-8 lg:px-12">
        <div class="py-2.5 sm:py-3" data-chip-scroll-container>
            <div
                class="flex items-center gap-2 overflow-x-auto scrollbar-hide"
                style="scrollbar-width: none;"
                data-treatment-tabs
                data-chip-scroll-track
            >
                @foreach ($categories as $index => $category)
                    <button
                        type="button"
                        data-treatment-tab="{{ $category->id }}"
                        class="treatment-chip shrink-0 rounded-full border px-4 py-2 text-xs font-semibold transition-colors duration-300 sm:px-5 sm:py-2.5 sm:text-sm focus:outline-none
                            {{ $index === 0
                                ? 'bg-[#FF5252] text-white border-[#FF5252] hover:border-[#FF5252] hover:text-white'
                                : 'bg-white text-neutral-600 border-neutral-200 hover:border-[#FF5252] hover:text-[#FF5252]' }}"
                    >
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>

            {{-- Scroll Indicator Dots --}}
            <div class="mt-2 flex items-center justify-center gap-1.5 opacity-60">
                <span data-chip-dot class="h-1.5 w-1.5 rounded-full bg-[#FF5252] transition-colors duration-300"></span>
                <span data-chip-dot class="h-1.5 w-1.5 rounded-full bg-neutral-300 transition-colors duration-300"></span>
                <span data-chip-dot class="h-1.5 w-1.5 rounded-full bg-neutral-300 transition-colors duration-300"></span>
            </div>
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

                    <h2 class="text-3xl font-bold tracking-tight text-neutral-900 sm:text-4xl lg:text-5xl">
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
