@extends('layouts.public')

@section('title', 'Skincare - WFSC Clinic')
@section('body_class', 'public-page-light')

@section('content')

{{-- Hero --}}
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

                <p class="mx-auto mt-5 max-w-2xl text-base leading-relaxed text-neutral-600 sm:text-lg">
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

        <div class="flex gap-2 overflow-x-auto scrollbar-hide py-4">

            {{-- All --}}
            <a
                href="{{ route('skincare.index') }}"
                class="shrink-0 rounded-full border px-5 py-2.5 text-sm font-semibold transition-all duration-300
                    {{ !$activeCategory
                        ? 'border-[#FF5252] bg-[#FF5252] text-white'
                        : 'border-neutral-200 bg-white text-neutral-500 hover:border-[#FF5252]/30 hover:text-[#FF5252]' }}"
            >
                Semua Produk
            </a>

            @foreach ($categories as $category)

                <a
                    href="{{ route('skincare.index', ['category' => $category->slug]) }}"
                    class="shrink-0 rounded-full border px-5 py-2.5 text-sm font-semibold transition-all duration-300
                        {{ $activeCategory === $category->slug
                            ? 'border-[#FF5252] bg-[#FF5252] text-white'
                            : 'border-neutral-200 bg-white text-neutral-500 hover:border-[#FF5252]/30 hover:text-[#FF5252]' }}"
                >
                    {{ $category->name }}
                </a>

            @endforeach

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

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

                @foreach ($products as $index => $product)

                    <article
                        data-reveal="up"
                        data-delay="{{ ($index + 1) * 100 }}"
                        class="reveal-hidden group flex flex-col overflow-hidden rounded-[1.75rem] border border-neutral-200/80 bg-white p-4 shadow-[0_4px_20px_rgba(0,0,0,0.03)] transition-all duration-500 hover:-translate-y-2 hover:border-[#FF5252]/30 hover:shadow-[0_12px_30px_rgba(255,82,82,0.12)]"
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
                                    class="aspect-square w-full object-cover transition duration-700 ease-out group-hover:scale-105"
                                >

                            @else

                                <div class="flex aspect-square items-center justify-center bg-neutral-100">
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
                        <div class="flex flex-1 flex-col px-2 pt-5">

                            {{-- Attributes --}}
                            @if ($product->attributes->isNotEmpty())

                                <div class="mb-3 flex flex-wrap gap-1.5">

                                    @foreach ($product->attributes->take(3) as $attribute)

                                        <span class="rounded-full border border-[#FF5252]/15 bg-[#FF5252]/5 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-[#FF5252]">
                                            {{ $attribute->name }}
                                        </span>

                                    @endforeach

                                </div>

                            @endif


                            {{-- Name --}}
                            <h3 class="text-xl font-bold tracking-tight text-neutral-900 transition-colors duration-300 group-hover:text-[#FF5252]">
                                {{ $product->name }}
                            </h3>


                            {{-- Description --}}
                            @if ($product->description)

                                <p class="mt-2 line-clamp-3 text-sm leading-relaxed text-neutral-500">
                                    {{ $product->description }}
                                </p>

                            @endif


                            {{-- Categories --}}
                            @if ($product->categories->isNotEmpty())

                                <div class="mt-4 flex flex-wrap gap-1.5">

                                    @foreach ($product->categories as $category)

                                        <span class="text-xs font-medium text-neutral-400">
                                            {{ $category->name }}@if (!$loop->last),@endif
                                        </span>

                                    @endforeach

                                </div>

                            @endif


                            {{-- Bottom --}}
                            <div class="mt-auto pt-6">

                                <div class="flex items-center justify-between border-t border-neutral-100 pt-4">

                                    @if ($product->price !== null)
                                        <div>

                                            <p class="text-xs font-medium uppercase tracking-wider text-neutral-400">
                                                Price
                                            </p>

                                            <p class="mt-0.5 text-lg font-black text-neutral-900">
                                                Rp {{ number_format((float) $product->price, 0, ',', '.') }}
                                            </p>

                                        </div>
                                    @endif


                                    <a
                                        href="{{ route('skincare.show', $product->slug) }}"
                                        class="ml-auto flex h-9 w-9 items-center justify-center rounded-full bg-neutral-100 text-neutral-900 transition-all duration-300 group-hover:translate-x-1 group-hover:bg-[#FF5252] group-hover:text-white"
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
