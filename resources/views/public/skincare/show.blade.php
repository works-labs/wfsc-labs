@extends('layouts.public')

@section('title', $product->name . ' - WFSC Clinic')
@section('body_class', 'public-page-light')

@section('content')

<section class="relative overflow-hidden bg-[#FAF9F6] px-6 pb-20 pt-32 lg:px-12 lg:pb-28 lg:pt-40">

    {{-- Decorative --}}
    <div class="pointer-events-none absolute -left-32 top-1/4 h-96 w-96 rounded-full bg-[#FF5252]/5 blur-3xl"></div>
    <div class="pointer-events-none absolute -right-32 bottom-0 h-96 w-96 rounded-full bg-[#FF5252]/5 blur-3xl"></div>


    <div class="relative mx-auto max-w-6xl">

        {{-- Back --}}
        <a
            href="{{ route('skincare.index') }}"
            class="mb-8 inline-flex items-center gap-2 text-sm font-semibold text-neutral-500 transition hover:gap-3 hover:text-[#FF5252]"
        >
            <span>←</span>
            Kembali ke skincare
        </a>


        <div class="grid items-center gap-10 lg:grid-cols-2 lg:gap-16">


            {{-- Image --}}
            <div
                data-reveal="up"
                class="reveal-hidden overflow-hidden rounded-[2rem] border border-neutral-200/80 bg-white p-4 shadow-[0_8px_30px_rgba(0,0,0,0.04)]"
            >

                @if ($product->image)

                    <img
                        src="{{ Storage::url($product->image) }}"
                        alt="{{ $product->name }}"
                        class="aspect-square w-full rounded-[1.5rem] object-cover"
                    >

                @else

                    <div class="flex aspect-square items-center justify-center rounded-[1.5rem] bg-neutral-100">
                        <span class="text-sm text-neutral-400">
                            {{ $product->name }}
                        </span>
                    </div>

                @endif

            </div>


            {{-- Information --}}
            <div
                data-reveal="up"
                data-delay="100"
                class="reveal-hidden"
            >

                {{-- Attributes --}}
                @if ($product->attributes->isNotEmpty())

                    <div class="mb-5 flex flex-wrap gap-2">

                        @foreach ($product->attributes as $attribute)

                            <span class="rounded-full border border-[#FF5252]/20 bg-[#FF5252]/5 px-3 py-1.5 text-[11px] font-bold uppercase tracking-wider text-[#FF5252]">
                                {{ $attribute->name }}
                            </span>

                        @endforeach

                    </div>

                @endif


                <h1 class="text-4xl font-black tracking-tight text-neutral-900 sm:text-5xl">
                    {{ $product->name }}
                </h1>


                {{-- Categories --}}
                @if ($product->categories->isNotEmpty())

                    <div class="mt-4 flex flex-wrap gap-x-2 gap-y-1 text-sm text-neutral-400">

                        @foreach ($product->categories as $category)

                            <span>
                                {{ $category->name }}
                            </span>

                            @if (!$loop->last)
                                <span>•</span>
                            @endif

                        @endforeach

                    </div>

                @endif


                @if ($product->price !== null)
                    {{-- Price --}}
                    <div class="mt-8">

                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-neutral-400">
                            Harga
                        </p>

                        <p class="mt-1 text-3xl font-black text-[#FF5252]">
                            Rp {{ number_format((float) $product->price, 0, ',', '.') }}
                        </p>

                    </div>
                @endif


                {{-- Description --}}
                @if ($product->description)

                    <div class="mt-8 border-t border-neutral-200 pt-8">

                        <h2 class="text-sm font-bold uppercase tracking-[0.15em] text-neutral-900">
                            Tentang Produk
                        </h2>

                        <p class="mt-3 text-sm leading-7 text-neutral-600 sm:text-base">
                            {{ $product->description }}
                        </p>

                    </div>

                @endif


                {{-- CTA --}}
                <div class="mt-8">

                    @if ($product->shopee_url)

                        <a
                            href="{{ $product->shopee_url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex w-full items-center justify-center gap-3 rounded-full bg-[#FF5252] px-6 py-4 text-sm font-bold text-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-[#FF5252]/20 sm:w-auto"
                        >
                            Beli Produk
                            <span>↗</span>
                        </a>

                    @else

                        <div class="rounded-2xl border border-dashed border-neutral-300 bg-white px-5 py-4 text-sm text-neutral-500">
                            Informasi pembelian produk dapat ditanyakan langsung kepada WFSC Clinic.
                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</section>


@include('public.components.footer')

@endsection
