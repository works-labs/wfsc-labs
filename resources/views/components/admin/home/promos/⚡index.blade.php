<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Promo;
use Illuminate\Support\Facades\Storage;

new #[Layout('layouts.admin')] class extends Component
{
    public function delete(int $promoId): void
    {
        $promo = Promo::findOrFail($promoId);

        if ($promo->image) {
            Storage::disk('public')->delete($promo->image);
        }

        $promo->delete();

        session()->flash(
            'success',
            'Promo deleted successfully.'
        );
    }

    public function with(): array
    {
        return [
            'promos' => Promo::orderBy('sort_order')
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
            <div class="hidden sm:flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-50 text-amber-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/></svg>
            </div>
            <div>
                <h1 class="text-2xl font-black tracking-tight text-[var(--color-wfsc-dark)]">
                    Promos
                </h1>
                <p class="mt-1 text-sm font-medium text-gray-500">
                    Manage promotional content displayed on the WFSC website.
                </p>
            </div>
        </div>

        <a href="{{ route('admin.home.promos.create') }}" wire:navigate
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[var(--color-wfsc-coral)] to-[#ff7676] px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-[var(--color-wfsc-coral)]/30 transition-all duration-300 hover:scale-[1.02] hover:shadow-xl hover:shadow-[var(--color-wfsc-coral)]/40"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Promo
        </a>
    </div>

    {{-- Alert Notification --}}
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
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                            Image
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                            Title
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                            Period
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                            Sort Order
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                            Status
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-gray-500">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-50">
                    @forelse ($promos as $promo)
                        <tr class="transition-colors hover:bg-rose-50/30">
                            {{-- Image --}}
                            <td class="px-6 py-4">
                                @if ($promo->image)
                                    <img src="{{ Storage::url($promo->image) }}" alt="{{ $promo->title }}" class="h-14 w-20 rounded-xl object-cover shadow-sm ring-2 ring-white">
                                @else
                                    <div class="flex h-14 w-20 items-center justify-center rounded-xl bg-amber-50 text-[10px] font-bold text-amber-600 ring-2 ring-white">
                                        No Image
                                    </div>
                                @endif
                            </td>

                            {{-- Title & Slug --}}
                            <td class="px-6 py-4">
                                <div class="font-bold text-[var(--color-wfsc-dark)]">
                                    {{ $promo->title }}
                                </div>
                                <div class="text-xs font-mono font-medium text-gray-400">
                                    {{ $promo->slug }}
                                </div>
                            </td>

                            {{-- Period --}}
                            <td class="whitespace-nowrap px-6 py-4 text-xs font-medium text-gray-600">
                                <div class="font-bold text-gray-700">
                                    {{ $promo->start_date?->format('d M Y') ?? '-' }}
                                </div>
                                <div class="text-gray-400">
                                    → {{ $promo->end_date?->format('d M Y') ?? '-' }}
                                </div>
                            </td>

                            {{-- Sort Order --}}
                            <td class="whitespace-nowrap px-6 py-4">
                                <span class="inline-flex items-center justify-center rounded-lg bg-gray-100 px-2.5 py-1 text-xs font-bold text-gray-600">
                                    #{{ $promo->sort_order }}
                                </span>
                            </td>

                            {{-- Status --}}
                            <td class="whitespace-nowrap px-6 py-4">
                                @if ($promo->is_active)
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
                                    <a href="{{ route('admin.home.promos.edit', $promo) }}" wire:navigate
                                        class="inline-flex items-center gap-1.5 rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-bold text-blue-600 transition-colors hover:bg-blue-100 hover:text-blue-700"
                                    >
                                        Edit
                                    </a>

                                    <button type="button" wire:click="delete({{ $promo->id }})" wire:confirm="Apakah Anda yakin ingin menghapus data ini?"
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
                                    <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/></svg>
                                </div>
                                <p class="mt-4 text-sm font-medium text-gray-900">No promos found</p>
                                <p class="mt-1 text-sm text-gray-500">Get started by creating a new promotional item.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>