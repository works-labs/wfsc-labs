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

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                Banner Manager
            </h1>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Kelola banner berdasarkan posisi halaman website.
            </p>
        </div>

        <a
            href="{{ route('admin.banners.create') }}"
            wire:navigate
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2.5 text-sm font-semibold text-white transition hover:opacity-90"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4v16m8-8H4" />
            </svg>

            Tambah Banner
        </a>
    </div>


    {{-- Flash Message --}}
    @if (session('success'))
        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-800 dark:bg-green-900/20 dark:text-green-400">
            {{ session('success') }}
        </div>
    @endif


    {{-- Banner Table --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">

                <thead class="border-b border-gray-200 bg-gray-50 text-xs uppercase text-gray-500 dark:border-gray-700 dark:bg-gray-900/50 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-4">Banner</th>
                        <th class="px-6 py-4">Placement</th>
                        <th class="px-6 py-4 text-center">Urutan</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                    @forelse ($banners as $banner)

                        <tr class="transition hover:bg-gray-50 dark:hover:bg-gray-700/30">

                            {{-- Banner --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">

                                    <div class="h-16 w-28 shrink-0 overflow-hidden rounded-lg bg-gray-100 dark:bg-gray-700">
                                        <img
                                            src="{{ asset('storage/' . $banner->image) }}"
                                            alt="{{ $banner->title }}"
                                            class="h-full w-full object-cover"
                                        >
                                    </div>

                                    <div class="min-w-0">
                                        <div class="font-semibold text-gray-900 dark:text-white">
                                            {{ $banner->title }}
                                        </div>

                                        @if ($banner->subtitle)
                                            <div class="mt-1 max-w-md truncate text-xs text-gray-500 dark:text-gray-400">
                                                {{ $banner->subtitle }}
                                            </div>
                                        @endif
                                    </div>

                                </div>
                            </td>


                            {{-- Placement --}}
                            <td class="px-6 py-4">
                                <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                                    {{ ucwords(str_replace('-', ' ', $banner->placement)) }}
                                </span>
                            </td>


                            {{-- Sort --}}
                            <td class="px-6 py-4 text-center text-gray-700 dark:text-gray-300">
                                {{ $banner->sort_order }}
                            </td>


                            {{-- Status --}}
                            <td class="px-6 py-4 text-center">

                                <button
                                    type="button"
                                    wire:click="toggleStatus({{ $banner->id }})"
                                    class="inline-flex items-center gap-2"
                                >
                                    <span
                                        class="h-2.5 w-2.5 rounded-full
                                        {{ $banner->is_active ? 'bg-green-500' : 'bg-gray-400' }}"
                                    ></span>

                                    <span class="text-xs font-medium
                                        {{ $banner->is_active
                                            ? 'text-green-600 dark:text-green-400'
                                            : 'text-gray-500 dark:text-gray-400' }}">
                                        {{ $banner->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </button>

                            </td>


                            {{-- Actions --}}
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">

                                    <a
                                        href="{{ route('admin.banners.edit', $banner) }}"
                                        wire:navigate
                                        class="rounded-lg border border-gray-200 px-3 py-2 text-xs font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700"
                                    >
                                        Edit
                                    </a>

                                    <button
                                        type="button"
                                        wire:click="delete({{ $banner->id }})"
                                        wire:confirm="Yakin ingin menghapus banner ini?"
                                        class="rounded-lg border border-red-200 px-3 py-2 text-xs font-medium text-red-600 transition hover:bg-red-50 dark:border-red-900 dark:hover:bg-red-900/20"
                                    >
                                        Hapus
                                    </button>

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">

                                <div class="mx-auto max-w-sm">
                                    <div class="mb-3 text-4xl">
                                        🖼️
                                    </div>

                                    <h3 class="font-semibold text-gray-900 dark:text-white">
                                        Belum ada banner
                                    </h3>

                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        Tambahkan banner pertama untuk mulai mengatur tampilan halaman website.
                                    </p>

                                    <a
                                        href="{{ route('admin.banners.create') }}"
                                        wire:navigate
                                        class="mt-5 inline-flex rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white"
                                    >
                                        Tambah Banner
                                    </a>
                                </div>

                            </td>
                        </tr>

                    @endforelse

                </tbody>
            </table>
        </div>

    </div>

</div>