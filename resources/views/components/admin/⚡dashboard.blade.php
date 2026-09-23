<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Doctor;
use App\Models\Treatment;
use App\Models\Facility;
use App\Models\Branch;
use App\Models\News;
use App\Models\Promo;

new #[Layout('layouts.admin')] class extends Component
{
    public function with(): array
    {
        return [
            'doctorsCount' => Doctor::count(),
            'treatmentsCount' => Treatment::count(),
            'facilitiesCount' => Facility::count(),
            'branchesCount' => Branch::count(),
            'newsCount' => News::count(),
            'promosCount' => Promo::count(),
        ];
    }
};
?>

<div class="mx-auto max-w-7xl">
    
    {{-- Header --}}
    <div class="mb-10 flex items-center justify-between bg-white p-8 rounded-2xl elegant-shadow border border-gray-100/50">
        <div>
            <h1 class="text-3xl font-black tracking-tight text-[var(--color-wfsc-dark)]">
                Ringkasan
            </h1>
            <p class="mt-2 text-sm font-medium text-gray-500">
                Selamat datang kembali, <span class="text-[var(--color-wfsc-coral)]">{{ auth()->user()->name }}</span>. Berikut ringkasan aktivitas WFSC hari ini.
            </p>
        </div>
        <div class="hidden sm:block">
            <div class="p-3 bg-rose-50 rounded-xl text-[var(--color-wfsc-coral)]">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
        </div>
    </div>

    {{-- Content Statistics --}}
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

        {{-- Doctors (Biru Lembut) --}}
        <a href="{{ route('admin.doctors.index') }}" wire:navigate
            class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-50/80 to-white p-8 elegant-shadow border border-blue-100/50 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-blue-900/5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-bold tracking-wider text-blue-500/70 uppercase">
                        Dokter
                    </p>
                    <p class="mt-4 text-5xl font-black text-blue-950">
                        {{ $doctorsCount }}
                    </p>
                </div>
                <div class="rounded-2xl bg-white shadow-sm p-3 text-blue-500 group-hover:scale-110 transition-transform duration-300">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
            </div>
        </a>

        {{-- Treatments (Coral Khas) --}}
        <a href="{{ route('admin.treatments.index') }}" wire:navigate
            class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-rose-50/80 to-white p-8 elegant-shadow border border-rose-100/50 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-rose-900/5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-bold tracking-wider text-[var(--color-wfsc-coral)]/70 uppercase">
                        Perawatan
                    </p>
                    <p class="mt-4 text-5xl font-black text-rose-950">
                        {{ $treatmentsCount }}
                    </p>
                </div>
                <div class="rounded-2xl bg-white shadow-sm p-3 text-[var(--color-wfsc-coral)] group-hover:scale-110 transition-transform duration-300">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                </div>
            </div>
        </a>

        {{-- Facilities (Emerald Lembut) --}}
        <a href="{{ route('admin.facilities.index') }}" wire:navigate
            class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-50/80 to-white p-8 elegant-shadow border border-emerald-100/50 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-emerald-900/5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-bold tracking-wider text-emerald-500/70 uppercase">
                        Fasilitas
                    </p>
                    <p class="mt-4 text-5xl font-black text-emerald-950">
                        {{ $facilitiesCount }}
                    </p>
                </div>
                <div class="rounded-2xl bg-white shadow-sm p-3 text-emerald-500 group-hover:scale-110 transition-transform duration-300">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
            </div>
        </a>

        {{-- Branches (Amber Lembut) --}}
        <a href="{{ route('admin.branches.index') }}" wire:navigate
            class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-amber-50/80 to-white p-8 elegant-shadow border border-amber-100/50 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-amber-900/5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-bold tracking-wider text-amber-500/70 uppercase">
                        Cabang
                    </p>
                    <p class="mt-4 text-5xl font-black text-amber-950">
                        {{ $branchesCount }}
                    </p>
                </div>
                <div class="rounded-2xl bg-white shadow-sm p-3 text-amber-500 group-hover:scale-110 transition-transform duration-300">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
            </div>
        </a>

        {{-- News (Ungu Lembut) --}}
        <a href="{{ route('admin.news.index') }}" wire:navigate
            class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-purple-50/80 to-white p-8 elegant-shadow border border-purple-100/50 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-purple-900/5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-bold tracking-wider text-purple-500/70 uppercase">
                        Berita & Artikel
                    </p>
                    <p class="mt-4 text-5xl font-black text-purple-950">
                        {{ $newsCount }}
                    </p>
                </div>
                <div class="rounded-2xl bg-white shadow-sm p-3 text-purple-500 group-hover:scale-110 transition-transform duration-300">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11l3 3m0 0l3-3m-3 3V8"/></svg>
                </div>
            </div>
        </a>

        {{-- Promos (Pink Lembut) --}}
        <a href="{{ route('admin.home.promos.index') }}" wire:navigate
            class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-pink-50/80 to-white p-8 elegant-shadow border border-pink-100/50 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-pink-900/5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-bold tracking-wider text-pink-500/70 uppercase">
                        Promo Aktif
                    </p>
                    <p class="mt-4 text-5xl font-black text-pink-950">
                        {{ $promosCount }}
                    </p>
                </div>
                <div class="rounded-2xl bg-white shadow-sm p-3 text-pink-500 group-hover:scale-110 transition-transform duration-300">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/></svg>
                </div>
            </div>
        </a>

    </div>
</div>