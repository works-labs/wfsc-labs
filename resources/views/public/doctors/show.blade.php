@extends('layouts.public')

@section('title', $doctor->name . ' — WFSC Clinic')

@section('content')
    <main class="min-h-screen bg-white pt-32">
        <div class="mx-auto max-w-6xl px-6 lg:px-12">

            <a
                href="{{ route('home') }}"
                class="mb-10 inline-flex text-sm font-medium text-neutral-500 hover:text-neutral-900"
            >
                ← Back to Home
            </a>

            <div class="grid items-center gap-12 lg:grid-cols-2">

                <div>
                    @if ($doctor->photo)
                        <img
                            src="{{ asset('storage/' . $doctor->photo) }}"
                            alt="{{ $doctor->name }}"
                            class="max-h-[700px] w-full object-contain"
                        >
                    @endif
                </div>

                <div>
                    <p class="mb-3 text-sm uppercase tracking-[0.25em] text-neutral-500">
                        {{ $doctor->specialization }}
                    </p>

                    <h1 class="text-5xl font-bold tracking-tight">
                        {{ $doctor->title }}
                        {{ $doctor->name }}
                    </h1>

                    @if ($doctor->short_bio)
                        <p class="mt-6 text-lg leading-relaxed text-neutral-600">
                            {{ $doctor->short_bio }}
                        </p>
                    @endif

                    <div class="mt-10 space-y-6">

                        @if ($doctor->education)
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-wider text-neutral-400">
                                    Education
                                </p>

                                <p class="mt-1 text-lg">
                                    {{ $doctor->education }}
                                </p>
                            </div>
                        @endif

                        @if ($doctor->certifications)
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-wider text-neutral-400">
                                    Certifications
                                </p>

                                <p class="mt-1 text-lg">
                                    {{ $doctor->certifications }}
                                </p>
                            </div>
                        @endif

                        @if ($doctor->experience)
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-wider text-neutral-400">
                                    Experience
                                </p>

                                <p class="mt-1 text-lg">
                                    {{ $doctor->experience }}
                                </p>
                            </div>
                        @endif

                    </div>

                    @if ($doctor->bio)
                        <div class="mt-10 border-t border-neutral-200 pt-8">
                            <p class="leading-relaxed text-neutral-600">
                                {{ $doctor->bio }}
                            </p>
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </main>
@endsection