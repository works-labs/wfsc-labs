@extends('layouts.public')

@section('title', 'Berita & Artikel - WFSC Clinic')

@section('content')

<main class="bg-white">

    {{-- =========================================================
        HERO
    ========================================================== --}}
    @include('public.news.sections.hero', [
        'featuredNews' => $featuredNews,
    ])


    {{-- =========================================================
        LATEST NEWS
    ========================================================== --}}
    @include('public.news.sections.latest', [
        'news' => $news,
    ])

</main>

@endsection