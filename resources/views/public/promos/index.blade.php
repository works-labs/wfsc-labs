@extends('layouts.public')

@section('title', 'Promo - WFSC Clinic')

@section('content')

<main class="bg-white">

    {{-- Promo Hero --}}
    @include('public.promos.sections.hero')


    {{-- Promo Cards --}}
    @include('public.promos.sections.promos')


    {{-- Promo Lightbox --}}
    @include('public.promos.sections.modal')

</main>
    @include('public.components.footer')
@endsection