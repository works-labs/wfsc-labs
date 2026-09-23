<?php

use App\Models\Banner;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Attributes\Layout;

new
#[Layout('layouts.admin')]
class extends Component
{
    public function delete(Banner $banner): void
    {
        if ($banner->image && Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();

        session()->flash('success', 'Banner berhasil dihapus.');
    }

    public function toggleStatus(Banner $banner): void
    {
        $banner->update([
            'is_active' => ! $banner->is_active,
        ]);
    }

    public function render()
    {
        return view('components.admin.banners.index', [
            'banners' => Banner::query()
                ->orderBy('placement')
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get(),
        ]);
    }
};
?>

<div class="mx-auto max-w-7xl space-y-6">

    {{-- Header Card --}}
    <div class="flex flex-col gap-4 rounded-2xl border border-gray-100/50 bg-white p-6 elegant-shadow sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-4">
            <div class="hidden sm:flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <h1 class="text-2xl font-black tracking-tight text-[var(--color-wfsc-dark)]">
                    Banner Manager
                </h1>
                <p class="mt-1 text-sm font-medium text-gray-500">
                    Kelola banner berdasarkan posisi halaman website.
                </p>
            </div>
        </div>

        <a href="{{ route('admin.banners.create') }}" wire:navigate
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[var(--color-wfsc-coral)] to-[#ff7676] px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-[var(--color-wfsc-coral)]/30 transition-all duration-300 hover:scale-[1.02] hover:shadow-xl hover:shadow-[var(--color-wfsc-coral)]/40"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Banner
        </a>
    </div>

    {{-- Flash Message --}}
    @if (session('success'))
        <div class="flex items-center gap-3 rounded-2xl border border-emerald-100 bg-emerald-50 px-6 py-4 text-sm font-bold text-emerald-700 shadow-sm">
            <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Banner Table Card --}}
    <div class="overflow-hidden rounded-2xl border border-gray-100/50 bg-white elegant-shadow">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-[#F4F6F9]">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Banner</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Placement</th>
                        <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-500">Urutan</th>
                        <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-500">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-gray-500">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-50">
                    @forelse ($banners as $banner)
                        <tr class="transition-colors hover:bg-rose-50/30">
                            {{-- Banner --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="h-14 w-24 shrink-0 overflow-hidden rounded-xl bg-gray-100 shadow-sm ring-2 ring-white">
                                        <img
                                            src="{{ asset('storage/' . $banner->image) }}"
                                            alt="{{ $banner->title }}"
                                            class="h-full w-full object-cover"
                                        >
                                    </div>

                                    <div class="min-w-0">
                                        <div class="font-bold text-[var(--color-wfsc-dark)]">
                                            {{ $banner->title }}
                                        </div>

                                        @if ($banner->subtitle)
                                            <div class="mt-0.5 max-w-md truncate text-xs font-medium text-gray-400">
                                                {{ $banner->subtitle }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- Placement --}}
                            <td class="whitespace-nowrap px-6 py-4">
                                <span class="inline-flex items-center rounded-lg bg-blue-50 px-3 py-1 text-xs font-bold text-blue-600">
                                    {{ ucwords(str_replace('-', ' ', $banner->placement)) }}
                                </span>
                            </td>

                            {{-- Sort --}}
                            <td class="whitespace-nowrap px-6 py-4 text-center">
                                <span class="inline-flex items-center justify-center rounded-lg bg-gray-100 px-2.5 py-1 text-xs font-bold text-gray-600">
                                    #{{ $banner->sort_order }}
                                </span>
                            </td>

                            {{-- Status --}}
                            <td class="whitespace-nowrap px-6 py-4 text-center">
                                <button
                                    type="button"
                                    wire:click="toggleStatus({{ $banner->id }})"
                                    class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-bold transition-all
                                        {{ $banner->is_active
                                            ? 'bg-emerald-50 text-emerald-600 ring-1 ring-inset ring-emerald-600/20'
                                            : 'bg-gray-50 text-gray-500 ring-1 ring-inset ring-gray-500/20' }}"
                                >
                                    <span class="h-1.5 w-1.5 rounded-full {{ $banner->is_active ? 'bg-emerald-600' : 'bg-gray-400' }}"></span>
                                    {{ $banner->is_active ? 'Aktif' : 'Nonaktif' }}
                                </button>
                            </td>

                            {{-- Aksi --}}
                            <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
                                <div class="flex items-center justify-end gap-2">
                                    <a
                                        href="{{ route('admin.banners.edit', $banner) }}"
                                        wire:navigate
                                        class="inline-flex items-center gap-1.5 rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-bold text-blue-600 transition-colors hover:bg-blue-100 hover:text-blue-700"
                                    >
                                        Edit
                                    </a>

                                    <button
                                        type="button"
                                        wire:click="delete({{ $banner->id }})"
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
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-50">
                                    <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <p class="mt-4 text-sm font-medium text-gray-900">Belum ada banner</p>
                                <p class="mt-1 text-sm text-gray-500">Tambahkan banner pertama untuk mulai mengatur tampilan halaman website.</p>
                                
                                <a
                                    href="{{ route('admin.banners.create') }}"
                                    wire:navigate
                                    class="mt-5 inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-[var(--color-wfsc-coral)] to-[#ff7676] px-5 py-2.5 text-sm font-bold text-white shadow-md shadow-[var(--color-wfsc-coral)]/30"
                                >
                                    Tambah Banner
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>