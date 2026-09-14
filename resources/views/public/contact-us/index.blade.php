@extends('layouts.public')

@section('title', 'Contact Us - WFSC Clinic')
@section('body_class', 'public-page-light')

@section('content')

    @include('public.contact-us.sections.hero', [
        'banner' => $banner,
    ])

    @include('public.contact-us.sections.branches', [
        'branches' => $branches,
    ])

    @include('public.contact-us.sections.map', [
        'branches' => $branches,
    ])

    @include('public.components.footer')

@endsection