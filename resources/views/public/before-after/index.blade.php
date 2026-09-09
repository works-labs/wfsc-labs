@extends('layouts.public')

@section('title', 'Before & After - WFSC Clinic')

@section('content')

<main class="bg-white">

    {{-- Title / Hero --}}
    <section class="relative isolate overflow-hidden bg-wfsc-coral text-white">

        <div
            class="absolute -right-32 -top-32 h-96 w-96 rounded-full bg-white/10 blur-3xl"
            aria-hidden="true"
        ></div>

        <div
            class="absolute -bottom-40 -left-32 h-96 w-96 rounded-full bg-white/10 blur-3xl"
            aria-hidden="true"
        ></div>

        <div
            class="relative mx-auto max-w-7xl px-6 pb-20 pt-36 sm:px-8 lg:px-12 lg:pb-24 lg:pt-44"
        >

            <div class="max-w-4xl">

                <div
                    data-reveal="left"
                    data-delay="0"
                    class="reveal-hidden mb-6"
                >
                    <span
                        class="inline-flex items-center rounded-full border border-white/30 bg-white/10 px-4 py-2 text-sm font-medium backdrop-blur-sm"
                    >
                        Before & After
                    </span>
                </div>

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
                    class="reveal-hidden mt-6 max-w-2xl text-base leading-relaxed text-white/85 sm:text-lg"
                >
                    Lihat berbagai hasil perawatan berdasarkan treatment
                    yang tersedia di WFSC Clinic.
                </p>

            </div>

        </div>

    </section>


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