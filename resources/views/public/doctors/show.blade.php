@extends('layouts.public')

@section('title', $doctor->name . ' — WFSC Clinic')

@section('content')
    <main class="relative min-h-screen bg-[#FAF9F6] pt-32 pb-24 overflow-hidden">
        
        {{-- Ambient Glow Background --}}
        <div class="pointer-events-none absolute -left-20 top-1/3 h-96 w-96 rounded-full bg-[#FF5252]/5 blur-3xl"></div>
        <div class="pointer-events-none absolute -right-20 top-1/2 h-96 w-96 rounded-full bg-[#FF5252]/5 blur-3xl"></div>

        <div class="relative mx-auto max-w-6xl px-6 lg:px-12">

            {{-- Back Button --}}
            <a
                href="{{ route('home') }}"
                class="group mb-10 inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-neutral-500 transition-colors duration-300 hover:text-[#FF5252]"
            >
                <span class="transition-transform duration-300 group-hover:-translate-x-1">←</span>
                <span>Back to Home</span>
            </a>

            {{-- Doctor Profile Grid --}}
            <div class="grid items-start gap-12 lg:grid-cols-12 lg:gap-16">

                {{-- Left: Doctor Photo Card --}}
                <div class="lg:col-span-5">
                    <div class="relative overflow-hidden rounded-[2.5rem] border border-neutral-200/80 bg-white p-3 shadow-xl shadow-neutral-200/50">
                        <div class="relative overflow-hidden rounded-[2rem] bg-neutral-100">
                            @if ($doctor->photo)
                                <img
                                    src="{{ asset('storage/' . $doctor->photo) }}"
                                    alt="{{ $doctor->name }}"
                                    class="max-h-[600px] w-full object-cover object-top transition duration-700 hover:scale-105"
                                >
                            @else
                                <div class="flex h-[450px] w-full items-center justify-center bg-neutral-100 text-xs text-neutral-400">
                                    (Doctor Photo)
                                </div>
                            @endif

                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent"></div>
                        </div>
                    </div>
                </div>

                {{-- Right: Doctor Information --}}
                <div class="lg:col-span-7">

                    {{-- Specialization Badge --}}
                    @if ($doctor->specialization)
                        <div class="inline-flex items-center gap-2 rounded-full border border-[#FF5252]/20 bg-[#FF5252]/5 px-3.5 py-1">
                            <span class="h-1.5 w-1.5 rounded-full bg-[#FF5252]"></span>
                            <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#FF5252]">
                                {{ $doctor->specialization }}
                            </span>
                        </div>
                    @endif

                    {{-- Name & Title --}}
                    <h1 class="mt-4 text-4xl font-bold tracking-tight text-neutral-900 lg:text-5xl">
                        @if ($doctor->title)
                            <span class="font-normal text-neutral-500">{{ $doctor->title }}</span>
                        @endif
                        {{ $doctor->name }}
                    </h1>

                    {{-- Short Bio --}}
                    @if ($doctor->short_bio)
                        <p class="mt-6 text-base leading-relaxed text-neutral-600">
                            {{ $doctor->short_bio }}
                        </p>
                    @endif

                    {{-- Highlighted Credentials Grid --}}
                    <div class="mt-10 grid gap-4 sm:grid-cols-2">

                        @if ($doctor->education)
                            <div class="rounded-2xl border border-neutral-200/80 bg-white p-5 shadow-sm">
                                <span class="text-[11px] font-bold uppercase tracking-wider text-[#FF5252]">
                                    Education
                                </span>
                                <p class="mt-1.5 text-sm font-semibold leading-normal text-neutral-800">
                                    {{ $doctor->education }}
                                </p>
                            </div>
                        @endif

                        @if ($doctor->certifications)
                            <div class="rounded-2xl border border-neutral-200/80 bg-white p-5 shadow-sm">
                                <span class="text-[11px] font-bold uppercase tracking-wider text-[#FF5252]">
                                    Certifications
                                </span>
                                <p class="mt-1.5 text-sm font-semibold leading-normal text-neutral-800">
                                    {{ $doctor->certifications }}
                                </p>
                            </div>
                        @endif

                        @if ($doctor->experience)
                            <div class="rounded-2xl border border-neutral-200/80 bg-white p-5 shadow-sm sm:col-span-2">
                                <span class="text-[11px] font-bold uppercase tracking-wider text-[#FF5252]">
                                    Experience
                                </span>
                                <p class="mt-1.5 text-sm font-semibold leading-normal text-neutral-800">
                                    {{ $doctor->experience }}
                                </p>
                            </div>
                        @endif

                    </div>

                    {{-- Long Bio --}}
                    @if ($doctor->bio)
                        <div class="mt-10 border-t border-neutral-200/80 pt-8">
                            <h3 class="text-sm font-bold uppercase tracking-wider text-neutral-900 mb-3">
                                About {{ $doctor->name }}
                            </h3>
                            <p class="text-sm leading-relaxed text-neutral-600">
                                {{ $doctor->bio }}
                            </p>
                        </div>
                    @endif

                    {{-- Optional CTA --}}
                    <div class="mt-10 pt-4">
                        <a 
                            href="{{ route('home') }}#contact" 
                            class="inline-flex items-center gap-2 rounded-full bg-[#FF5252] px-8 py-3.5 text-xs font-bold uppercase tracking-wider text-white shadow-lg shadow-[#FF5252]/25 transition-all duration-300 hover:bg-[#e04545] hover:shadow-xl"
                        >
                            <span>Book Consultation</span>
                            <span>→</span>
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </main>
@endsection