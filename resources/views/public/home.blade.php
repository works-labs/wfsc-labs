@extends('layouts.public')

@section('title', 'WFSC Clinic')

@section('content')
    @include('public.components.hero')
    @include('public.components.treatments-list')
    @include('public.components.before-after')
    @include('public.components.why-choose')
    @include('public.components.doctors')
    @include('public.components.promos')
    @include('public.components.news')
    @include('public.components.footer')
@endsection