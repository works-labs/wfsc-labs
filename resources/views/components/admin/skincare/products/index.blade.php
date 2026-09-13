<?php

use App\Models\SkincareProduct;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.admin')] class extends Component
{
    public string $search = '';

    public function delete(SkincareProduct $product): void
    {
        if ($product->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->image)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        session()->flash('success', 'Produk berhasil dihapus.');
    }

    public function with(): array
    {
        return [
            'products' => SkincareProduct::query()
                ->with(['categories', 'attributes'])
                ->when($this->search, function ($query) {
                    $query->where(function ($query) {
                        $query
                            ->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('slug', 'like', '%' . $this->search . '%');
                    });
                })
                ->orderBy('sort_order')
                ->orderByDesc('id')
                ->paginate(10),
        ];
    }
};
?>

<div class="mx-auto max-w-7xl space-y-6">

    {{-- Header Card --}}
    <div class="flex flex-col gap-4 rounded-2xl border border-gray-100/50 bg-white p-6 elegant-shadow sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-4">
            <div class="hidden sm:flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            </div>
            <div>
                <h1 class="text-2xl font-black tracking-tight text-[var(--color-wfsc-dark)]">
                    Skincare Products
                </h1>
                <p class="mt-1 text-sm font-medium text-gray-500">
                    Kelola produk skincare dan hubungkan dengan kategori serta atribut.
                </p>
            </div>
        </div>

        <a href="{{ route('admin.skincare.products.create') }}" wire:navigate
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[var(--color-wfsc-coral)] to-[#ff7676] px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-[var(--color-wfsc-coral)]/30 transition-all duration-300 hover:scale-[1.02] hover:shadow-xl hover:shadow-[var(--color-wfsc-coral)]/40"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Produk
        </a>
    </div>

    {{-- Alert Notification --}}
    @if (session('success'))
        <div class="flex items-center gap-3 rounded-2xl border border-emerald-100 bg-emerald-50 px-6 py-4 text-sm font-bold text-emerald-700 shadow-sm">
            <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Search Bar Card --}}
    <div class="rounded-2xl border border-gray-100/50 bg-white p-4 elegant-shadow">
        <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </span>
            <input type="search" wire:model.live.debounce.300ms="search" placeholder="Cari nama atau slug produk..."
                class="w-full rounded-xl border-gray-200 bg-gray-50/50 pl-11 pr-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
            >
        </div>
    </div>

    {{-- Table Card --}}
    <div class="overflow-hidden rounded-2xl border border-gray-100/50 bg-white elegant-shadow">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-[#F4F6F9]">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Produk</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Kategori</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Atribut</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Harga</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-gray-500">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-50">
                    @forelse ($products as $product)
                        <tr class="transition-colors hover:bg-rose-50/30">
                            {{-- Produk Info --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-14 w-14 rounded-2xl object-cover shadow-sm ring-2 ring-white">
                                    @else
                                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 text-[10px] font-bold text-emerald-600 ring-2 ring-white">
                                            No Image
                                        </div>
                                    @endif

                                    <div>
                                        <div class="font-bold text-[var(--color-wfsc-dark)]">
                                            {{ $product->name }}
                                        </div>
                                        <div class="text-xs font-mono font-medium text-gray-400">
                                            {{ $product->slug }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Kategori --}}
                            <td class="px-6 py-4">
                                <div class="flex max-w-xs flex-wrap gap-1.5">
                                    @forelse ($product->categories as $category)
                                        <span class="inline-flex items-center rounded-lg bg-blue-50 px-2.5 py-1 text-xs font-bold text-blue-600">
                                            {{ $category->name }}
                                        </span>
                                    @empty
                                        <span class="text-xs font-medium text-gray-300">Belum ada</span>
                                    @endforelse
                                </div>
                            </td>

                            {{-- Atribut --}}
                            <td class="px-6 py-4">
                                <div class="flex max-w-xs flex-wrap gap-1.5">
                                    @forelse ($product->attributes as $attribute)
                                        <span class="inline-flex items-center rounded-lg bg-purple-50 px-2.5 py-1 text-xs font-bold text-purple-600">
                                            {{ $attribute->name }}
                                        </span>
                                    @empty
                                        <span class="text-xs font-medium text-gray-300">Belum ada</span>
                                    @endforelse
                                </div>
                            </td>

                            {{-- Harga --}}
                            <td class="whitespace-nowrap px-6 py-4 text-xs font-bold text-[var(--color-wfsc-dark)]">
                                @if ($product->price !== null)
                                    Rp {{ number_format((float) $product->price, 0, ',', '.') }}
                                @else
                                    <span class="text-gray-300">-</span>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td class="whitespace-nowrap px-6 py-4">
                                @if ($product->is_active)
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
                                    <a href="{{ route('admin.skincare.products.edit', $product) }}" wire:navigate
                                        class="inline-flex items-center gap-1.5 rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-bold text-blue-600 transition-colors hover:bg-blue-100 hover:text-blue-700"
                                    >
                                        Edit
                                    </a>

                                    <button type="button" wire:click="delete({{ $product->id }})" wire:confirm="Yakin ingin menghapus produk {{ $product->name }}?"
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
                                    <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                </div>
                                <p class="mt-4 text-sm font-medium text-gray-900">Belum ada produk skincare</p>
                                <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan produk baru.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($products->hasPages())
            <div class="border-t border-gray-100 px-6 py-4">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>