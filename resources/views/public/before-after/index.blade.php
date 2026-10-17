@extends('layouts.public')

@section('title', 'Before & After - WFSC Clinic')
@section('body_class', 'public-page-light')

@section('content')

<main class="bg-white">

    {{-- Title / Hero --}}
    @if ($desktopBanner || $mobileBanner)
        <section class="public-responsive-banner relative isolate overflow-hidden bg-neutral-900 text-white">
            <div class="absolute inset-0 -z-20">
                <picture>
                    @if ($mobileBanner)
                        <source media="(max-width: 639px)" srcset="{{ Storage::url($mobileBanner->image) }}">
                    @endif
                    @if ($desktopBanner)
                        <img src="{{ Storage::url($desktopBanner->image) }}" alt="{{ $desktopBanner->title }}" class="h-full w-full object-cover">
                    @else
                        <img src="{{ Storage::url($mobileBanner->image) }}" alt="{{ $mobileBanner->title }}" class="h-full w-full object-cover">
                    @endif
                </picture>
            </div>

            <div class="absolute inset-0 -z-10 bg-black/50" aria-hidden="true"></div>

            <div class="relative mx-auto flex h-full max-w-7xl items-center px-6 sm:px-8 lg:px-12 lg:pt-20">
                <div class="max-w-4xl">
                    <h1 data-reveal="left" data-delay="100" class="reveal-hidden text-4xl font-black leading-tight tracking-tight sm:text-5xl lg:text-6xl">
                        {{ ($desktopBanner ?? $mobileBanner)->title }}
                    </h1>

                    @if (($desktopBanner ?? $mobileBanner)->subtitle)
                        <p data-reveal="left" data-delay="200" class="reveal-hidden mt-6 line-clamp-2 max-w-2xl text-base leading-relaxed text-white/85">
                            {{ ($desktopBanner ?? $mobileBanner)->subtitle }}
                        </p>
                    @endif
                </div>
            </div>
        </section>
    @else
        <section class="public-responsive-banner relative isolate overflow-hidden bg-wfsc-coral text-white">

        <div
            class="absolute -right-32 -top-32 h-96 w-96 rounded-full bg-white/10 blur-3xl"
            aria-hidden="true"
        ></div>

        <div
            class="absolute -bottom-40 -left-32 h-96 w-96 rounded-full bg-white/10 blur-3xl"
            aria-hidden="true"
        ></div>

        <div
            class="relative mx-auto flex h-full max-w-7xl items-center px-6 sm:px-8 lg:px-12 lg:pt-20"
        >

            <div class="max-w-4xl">


                <h1
                    data-reveal="left"
                    data-delay="100"
                    class="reveal-hidden text-4xl font-black leading-tight tracking-tight sm:text-5xl lg:text-6xl"
                >
                    Lihat Hasil Perawatan Kami
                </h1>

                <p
                    data-reveal="left"
                    data-delay="200"
                    class="reveal-hidden mt-6 line-clamp-2 max-w-2xl text-base leading-relaxed text-white/85"
                >
                    Lihat berbagai hasil perawatan berdasarkan treatment
                    yang tersedia di WFSC Clinic.
                </p>

            </div>

        </div>

        </section>
    @endif


    {{-- Treatment Filters --}}
    @include('public.before-after.sections.filters')


    {{-- Treatment Sections --}}
    <div>
        @foreach ($treatments as $treatment)
            @include('public.before-after.sections.treatment', [
                'treatment' => $treatment,
            ])
        @endforeach
    </div>


    {{-- Lightbox --}}
    @include('public.before-after.sections.modal')

</main>
    @include('public.components.footer')
@endsection
