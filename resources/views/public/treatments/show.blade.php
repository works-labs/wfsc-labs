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


</main>
    @include('public.components.footer')
@endsection