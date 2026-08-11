@extends('layouts.public')

@section('title', 'WFSC Clinic')

@section('content')
    @include('public.components.hero')
    @include('public.components.treatments')
    @include('public.components.before-after')
@endsection