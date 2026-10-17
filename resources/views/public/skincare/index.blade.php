@extends('layouts.public')

@section('title', 'Skincare - WFSC Clinic')
@section('body_class', 'public-page-light')

@section('content')

{{-- Hero --}}
@if ($desktopBanner || $mobileBanner)
    <section class="public-responsive-banner relative isolate overflow-hidden bg-neutral-900 text-white">
        {{-- Background Image --}}
        <div class="absolute inset-0 -z-20">
            <picture>
                @if ($mobileBanner)
                    <source media="(max-width: 639px)" srcset="{{ \Illuminate\Support\Facades\Storage::url($mobileBanner->image) }}">
                @endif
                @if ($desktopBanner)
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($desktopBanner->image) }}" alt="{{ $desktopBanner->title }}" class="h-full w-full object-cover">
                @else
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($mobileBanner->image) }}" alt="{{ $mobileBanner->title }}" class="h-full w-full object-cover">
                @endif
            </picture>
        </div>

        {{-- Overlay --}}
        <div class="absolute inset-0 -z-10 bg-black/50" aria-hidden="true"></div>

        {{-- Decorative Glow --}}
        <div class="absolute -right-32 -top-32 h-96 w-96 rounded-full bg-white/10 blur-3xl" aria-hidden="true"></div>
        <div class="absolute -bottom-40 -left-32 h-96 w-96 rounded-full bg-white/10 blur-3xl" aria-hidden="true"></div>

        {{-- Hero Content --}}
        <div class="relative mx-auto flex h-full max-w-7xl items-center px-6 sm:px-8 lg:px-12 lg:pt-20">
            <div class="max-w-3xl">
                <h1 class="mt-4 text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl">
                    {{ ($desktopBanner ?? $mobileBanner)->title }}
                </h1>
                @if (($desktopBanner ?? $mobileBanner)->subtitle)
                    <p class="mt-4 line-clamp-2 text-base leading-relaxed text-white/85">
                    {{ ($desktopBanner ?? $mobileBanner)->subtitle }}
                    </p>
                @endif
            </div>
        </div>
    </section>
@else
    <section class="relative overflow-hidden bg-[#FAF9F6] pt-32 pb-14 lg:pt-40 lg:pb-20">

        {{-- Decorative Glow --}}
        <div class="pointer-events-none absolute -left-32 top-20 h-96 w-96 rounded-full bg-[#FF5252]/5 blur-3xl"></div>
        <div class="pointer-events-none absolute -right-32 bottom-0 h-96 w-96 rounded-full bg-[#FF5252]/5 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-6 lg:px-12">

            <div
                data-reveal="up"
                data-delay="0"
                class="reveal-hidden mx-auto max-w-3xl text-center"
            >

                <span class="text-sm font-semibold uppercase tracking-[0.2em] text-wfsc-coral">
                    Skincare
                </span>

                <h1 class="mt-3 text-4xl font-black tracking-tight text-neutral-900 sm:text-5xl lg:text-6xl">
                    Perawatan Untuk Kulitmu
                </h1>

                <p class="mx-auto mt-5 max-w-2xl text-base leading-relaxed text-neutral-600">
                    Temukan berbagai produk skincare pilihan untuk membantu
                    merawat dan menjaga kesehatan kulitmu.
                </p>

            </div>

        </div>
    </section>
@endif


{{-- Category Navigation --}}
<section class="border-y border-neutral-200/80 bg-[#FAF9F6]">

    <div class="mx-auto max-w-7xl px-6 lg:px-12">

        <div class="py-2.5 sm:py-3" data-chip-scroll-container>
            <div
                class="flex gap-2 overflow-x-auto scrollbar-hide"
                style="scrollbar-width: none;"
                data-chip-scroll-track
            >

            {{-- All --}}
            <a
                href="{{ route('skincare.index') }}"
                class="inline-flex h-9 shrink-0 items-center rounded-full border px-4 text-xs font-semibold leading-5 transition-all duration-300 sm:h-10 sm:px-5 sm:text-sm
                    {{ !$activeCategory
                        ? 'border-[#FF5252] bg-[#FF5252] text-white'
                        : 'border-neutral-200 bg-white text-neutral-500 hover:border-[#FF5252]/30 hover:text-[#FF5252]' }}"
            >
                Semua Produk
            </a>

            @foreach ($categories as $category)

                <a
                    href="{{ route('skincare.index', ['category' => $category->slug]) }}"
                        class="inline-flex h-9 shrink-0 items-center rounded-full border px-4 text-xs font-semibold leading-5 transition-all duration-300 sm:h-10 sm:px-5 sm:text-sm
                        {{ $activeCategory === $category->slug
                            ? 'border-[#FF5252] bg-[#FF5252] text-white'
                            : 'border-neutral-200 bg-white text-neutral-500 hover:border-[#FF5252]/30 hover:text-[#FF5252]' }}"
                >
                    {{ $category->name }}
                </a>

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


{{-- Products --}}
<section class="relative overflow-hidden bg-[#FAF9F6] px-6 py-16 lg:px-12 lg:py-24">

    <div class="pointer-events-none absolute -left-20 top-1/3 h-96 w-96 rounded-full bg-[#FF5252]/5 blur-3xl"></div>
    <div class="pointer-events-none absolute -right-20 top-2/3 h-96 w-96 rounded-full bg-[#FF5252]/5 blur-3xl"></div>

    <div class="relative mx-auto max-w-7xl">

        {{-- Section Header --}}
        <div
            data-reveal="up"
            data-delay="0"
            class="reveal-hidden mb-10 flex items-end justify-between gap-6 sm:mb-14"
        >

            <div>

                <span class="text-sm font-semibold uppercase tracking-[0.2em] text-wfsc-coral">
                    Our Products
                </span>

                <h2 class="mt-2 text-3xl font-black tracking-tight text-neutral-900 sm:text-4xl">
                    Pilihan Skincare
                </h2>

            </div>

            @if ($products->isNotEmpty())
                <p class="hidden text-sm text-neutral-500 sm:block">
                    {{ $products->count() }}
                    {{ $products->count() === 1 ? 'produk' : 'produk' }}
                </p>
            @endif

        </div>


        @if ($products->isNotEmpty())

            <div data-skincare-pagination class="grid grid-cols-2 gap-3 sm:gap-6 lg:grid-cols-6">

                @foreach ($products as $index => $product)

                    <article
                        data-reveal="up"
                        data-delay="{{ ($index + 1) * 100 }}"
                        data-skincare-card
                        class="reveal-hidden group flex flex-col overflow-hidden rounded-2xl border border-neutral-200/80 bg-white p-3 shadow-[0_4px_20px_rgba(0,0,0,0.03)] transition-all duration-500 hover:-translate-y-2 hover:border-[#FF5252]/30 hover:shadow-[0_12px_30px_rgba(255,82,82,0.12)] sm:rounded-[1.75rem] sm:p-4 lg:col-span-2 {{ $index % 5 === 3 ? 'lg:col-start-2' : ($index % 5 === 4 ? 'lg:col-start-4' : '') }}"
                    >

                        {{-- Product Image --}}
                        <a
                            href="{{ route('skincare.show', $product->slug) }}"
                            class="relative block overflow-hidden rounded-[1.25rem] bg-neutral-100"
                        >

                            @if ($product->image)

                                <img
                                    src="{{ Storage::url($product->image) }}"
                                    alt="{{ $product->name }}"
                                    loading="lazy"
                                    class="aspect-[4/5] w-full object-cover transition duration-700 ease-out group-hover:scale-105"
                                >

                            @else

                                <div class="flex aspect-[4/5] items-center justify-center bg-neutral-100">
                                    <span class="text-sm text-neutral-400">
                                        {{ $product->name }}
                                    </span>
                                </div>

                            @endif

                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                            ></div>

                        </a>


                        {{-- Product Content --}}
                        <div class="flex flex-1 flex-col px-2 pt-4 pb-1">

                            {{-- Name --}}
                            <h3 class="text-sm font-bold leading-snug tracking-tight text-neutral-900 transition-colors duration-300 group-hover:text-[#FF5252] sm:text-xl">
                                {{ $product->name }}
                            </h3>

                            {{-- Categories --}}
                            @if ($product->categories->isNotEmpty())

                                <div class="mt-2 flex flex-wrap gap-1.5">

                                    @foreach ($product->categories as $category)

                                        <span class="text-[10px] font-medium leading-tight text-neutral-400 sm:text-xs">
                                            {{ $category->name }}@if (!$loop->last),@endif
                                        </span>

                                    @endforeach

                                </div>

                            @endif


                            {{-- Bottom --}}
                            <div class="mt-auto pt-4">

                                <div class="flex items-center justify-between border-t border-neutral-100 pt-4">

                                    @if ($product->price !== null)
                                        <div>

                                            <p class="text-[9px] font-medium uppercase tracking-wider text-neutral-400 sm:text-xs">
                                                Price
                                            </p>

                                            <p class="mt-0.5 text-sm font-black text-neutral-900 sm:text-lg">
                                                Rp {{ number_format((float) $product->price, 0, ',', '.') }}
                                            </p>

                                        </div>
                                    @endif


                                    <a
                                        href="{{ route('skincare.show', $product->slug) }}"
                                        class="ml-auto flex h-8 w-8 items-center justify-center rounded-full bg-neutral-100 text-sm text-neutral-900 transition-all duration-300 group-hover:translate-x-1 group-hover:bg-[#FF5252] group-hover:text-white sm:h-9 sm:w-9 sm:text-base"
                                        aria-label="Lihat {{ $product->name }}"
                                    >
                                        →
                                    </a>

                                </div>

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>

            <div data-skincare-pagination-controls class="mt-10"></div>

        @else

            <div class="rounded-[1.75rem] border border-dashed border-neutral-300 bg-white/50 px-6 py-20 text-center">

                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-[#FF5252]/5 text-[#FF5252]">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0l-2 7H6l-2-7m16 0H4"
                        />
                    </svg>
                </div>

                <h3 class="mt-5 text-lg font-bold text-neutral-900">
                    Produk Belum Tersedia
                </h3>

                <p class="mt-2 text-sm text-neutral-500">
                    Belum ada produk skincare yang tersedia untuk kategori ini.
                </p>

                @if ($activeCategory)

                    <a
                        href="{{ route('skincare.index') }}"
                        class="mt-6 inline-flex items-center gap-2 text-sm font-bold text-[#FF5252] transition hover:gap-3"
                    >
                        Lihat semua produk
                        <span>→</span>
                    </a>

                @endif

            </div>

        @endif

    </div>

</section>


@include('public.components.footer')

@endsection
