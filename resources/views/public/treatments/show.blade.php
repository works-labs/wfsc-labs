@extends('layouts.public')

@section('title', $treatment->name . ' - WFSC Clinic')

@section('content')

<main class="bg-white">

    {{-- =========================================================
        1. HERO
    ========================================================== --}}
    @include('public.treatments.sections.hero')


    {{-- =========================================================
        2. TREATMENT DESCRIPTION + PROCEDURE VIDEOS
    ========================================================== --}}
    @include('public.treatments.sections.treatment-description')


    {{-- =========================================================
        3. BEFORE & AFTER
    ========================================================== --}}
    @include('public.treatments.sections.before-after')


    {{-- =========================================================
        4. RECOMMENDED PRODUCTS
    ========================================================== --}}
    @include('public.treatments.sections.products-used')

    @include('public.treatments.sections.related-treatments')

    {{-- Back Button at bottom --}}
    <div class="border-t border-neutral-100 bg-neutral-50 py-8">
        <div class="mx-auto max-w-7xl px-6 text-center lg:px-12">
            <a
                href="{{ route('treatments.index') }}{{ $treatment->category_id ? '#category-' . $treatment->category_id : '' }}"
                class="inline-flex items-center gap-2 rounded-full border border-neutral-300 bg-white px-6 py-3 text-sm font-semibold text-neutral-700 shadow-sm transition hover:border-[#FF5252] hover:bg-[#FF5252] hover:text-white"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 19l-7-7 7-7"
                    />
                </svg>

                Kembali ke Treatments
            </a>
        </div>
    </div>

</main>
    @include('public.components.footer')
@endsection