<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\HeroBanner;
use Illuminate\Support\Facades\Storage;

new #[Layout('layouts.admin')] class extends Component
{
    public function delete(int $heroBannerId): void
    {
        $heroBanner = HeroBanner::findOrFail($heroBannerId);

        if ($heroBanner->background_image) {
            Storage::disk('public')->delete($heroBanner->background_image);
        }

        $heroBanner->delete();

        session()->flash('success', 'Hero banner deleted successfully.');
    }

    public function with(): array
    {
        return [
            'heroBanners' => HeroBanner::orderBy('sort_order')
                ->orderBy('id')
                ->get(),
        ];
    }
};
?>

<div class="mx-auto max-w-7xl space-y-6">

    {{-- Header Card --}}
    <div class="flex flex-col gap-4 rounded-2xl border border-gray-100/50 bg-white p-6 elegant-shadow sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-4">
            <div class="hidden sm:flex h-12 w-12 items-center justify-center rounded-2xl bg-purple-50 text-purple-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <h1 class="text-2xl font-black tracking-tight text-[var(--color-wfsc-dark)]">
                    Hero Banners
                </h1>
                <p class="mt-1 text-sm font-medium text-gray-500">
                    Manage hero banners displayed on the WFSC website.
                </p>
            </div>
        </div>

        <a href="{{ route('admin.home.hero-banners.create') }}" wire:navigate
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[var(--color-wfsc-coral)] to-[#ff7676] px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-[var(--color-wfsc-coral)]/30 transition-all duration-300 hover:scale-[1.02] hover:shadow-xl hover:shadow-[var(--color-wfsc-coral)]/40"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Hero Banner
        </a>
    </div>

    {{-- Flash Message --}}
    @if (session('success'))
        <div class="flex items-center gap-3 rounded-2xl border border-emerald-100 bg-emerald-50 px-6 py-4 text-sm font-bold text-emerald-700 shadow-sm">
            <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Table Card --}}
    <div class="overflow-hidden rounded-2xl border border-gray-100/50 bg-white elegant-shadow">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-[#F4F6F9]">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Preview</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Title</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">CTA</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Sort Order</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-gray-500">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-50">
                    @forelse ($heroBanners as $heroBanner)
                        <tr class="transition-colors hover:bg-rose-50/30">
                            {{-- Preview --}}
                            <td class="px-6 py-4">
                                @if ($heroBanner->background_image)
                                    <img
                                        src="{{ Storage::url($heroBanner->background_image) }}"
                                        alt="{{ $heroBanner->title }}"
                                        class="h-16 w-28 rounded-xl object-cover shadow-sm ring-2 ring-white"
                                    >
                                @else
                                    <div class="flex h-16 w-28 items-center justify-center rounded-xl bg-gray-100 text-[10px] font-bold text-gray-400 ring-2 ring-white">
                                        No image
                                    </div>
                                @endif
                            </td>

                            {{-- Title & Subtitle --}}
                            <td class="px-6 py-4">
                                <div class="font-bold text-[var(--color-wfsc-dark)]">
                                    {{ $heroBanner->title }}
                                </div>

                                @if ($heroBanner->subtitle)
                                    <div class="mt-0.5 max-w-md truncate text-xs font-medium text-gray-400">
                                        {{ $heroBanner->subtitle }}
                                    </div>
                                @endif
                            </td>

                            {{-- CTA --}}
                            <td class="px-6 py-4">
                                @if ($heroBanner->cta_text)
                                    <div class="text-xs font-bold text-gray-700">
                                        {{ $heroBanner->cta_text }}
                                    </div>

                                    @if ($heroBanner->cta_url)
                                        <div class="mt-0.5 max-w-xs truncate text-[11px] font-mono text-gray-400">
                                            {{ $heroBanner->cta_url }}
                                        </div>
                                    @endif
                                @else
                                    <span class="text-xs font-medium text-gray-400">-</span>
                                @endif
                            </td>

                            {{-- Sort Order --}}
                            <td class="whitespace-nowrap px-6 py-4">
                                <span class="inline-flex items-center justify-center rounded-lg bg-gray-100 px-2.5 py-1 text-xs font-bold text-gray-600">
                                    #{{ $heroBanner->sort_order }}
                                </span>
                            </td>

                            {{-- Status --}}
                            <td class="whitespace-nowrap px-6 py-4">
                                @if ($heroBanner->is_active)
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-600 ring-1 ring-inset ring-emerald-600/20">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span> Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-50 px-3 py-1 text-xs font-bold text-gray-500 ring-1 ring-inset ring-gray-500/20">
                                        <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span> Nonaktif
                                    </span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
                                <div class="flex items-center justify-end gap-2">
                                    <a
                                        href="{{ route('admin.home.hero-banners.edit', $heroBanner) }}"
                                        wire:navigate
                                        class="inline-flex items-center gap-1.5 rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-bold text-blue-600 transition-colors hover:bg-blue-100 hover:text-blue-700"
                                    >
                                        Edit
                                    </a>

                                    <button
                                        type="button"
                                        wire:click="delete({{ $heroBanner->id }})"
                                        wire:confirm="Apakah Anda yakin ingin menghapus data ini?"
                                        class="inline-flex items-center gap-1.5 rounded-lg bg-red-50 px-3 py-1.5 text-xs font-bold text-red-600 transition-colors hover:bg-red-100 hover:text-red-700"
                                    >
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-50">
                                    <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <p class="mt-4 text-sm font-medium text-gray-900">No hero banners found.</p>
                                <p class="mt-1 text-sm text-gray-500">Get started by creating a new hero banner item.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>