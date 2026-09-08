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

<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                Skincare Products
            </h1>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Kelola produk skincare dan hubungkan dengan kategori serta atribut.
            </p>
        </div>

        <a
            href="{{ route('admin.skincare.products.create') }}"
            wire:navigate
            class="inline-flex items-center justify-center rounded-lg bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-primary-700"
        >
            + Tambah Produk
        </a>
    </div>

    @if (session('success'))
        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-800 dark:bg-green-900/20 dark:text-green-400">
            {{ session('success') }}
        </div>
    @endif

    <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <input
            type="search"
            wire:model.live.debounce.300ms="search"
            placeholder="Cari nama atau slug produk..."
            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
        >
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-xs uppercase text-gray-500 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-4">Produk</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Atribut</th>
                        <th class="px-6 py-4">Harga</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($products as $product)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if ($product->image)
                                        <img
                                            src="{{ asset('storage/' . $product->image) }}"
                                            alt="{{ $product->name }}"
                                            class="h-14 w-14 rounded-lg object-cover"
                                        >
                                    @else
                                        <div class="flex h-14 w-14 items-center justify-center rounded-lg bg-gray-100 text-xs text-gray-400 dark:bg-gray-700">
                                            No Image
                                        </div>
                                    @endif

                                    <div>
                                        <div class="font-semibold text-gray-900 dark:text-white">
                                            {{ $product->name }}
                                        </div>

                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $product->slug }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex max-w-xs flex-wrap gap-1">
                                    @forelse ($product->categories as $category)
                                        <span class="rounded-full bg-blue-100 px-2.5 py-1 text-xs font-medium text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                                            {{ $category->name }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-gray-400">
                                            Belum ada
                                        </span>
                                    @endforelse
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex max-w-xs flex-wrap gap-1">
                                    @forelse ($product->attributes as $attribute)
                                        <span class="rounded-full bg-purple-100 px-2.5 py-1 text-xs font-medium text-purple-700 dark:bg-purple-900/30 dark:text-purple-400">
                                            {{ $attribute->name }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-gray-400">
                                            Belum ada
                                        </span>
                                    @endforelse
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
                                @if ($product->price !== null)
                                    Rp {{ number_format((float) $product->price, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                @if ($product->is_active)
                                    <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                        Aktif
                                    </span>
                                @else
                                    <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600 dark:bg-gray-700 dark:text-gray-400">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <a
                                        href="{{ route('admin.skincare.products.edit', $product) }}"
                                        wire:navigate
                                        class="rounded-lg border border-gray-300 px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700"
                                    >
                                        Edit
                                    </a>

                                    <button
                                        type="button"
                                        wire:click="delete({{ $product->id }})"
                                        wire:confirm="Yakin ingin menghapus produk {{ $product->name }}?"
                                        class="rounded-lg bg-red-600 px-3 py-2 text-xs font-medium text-white hover:bg-red-700"
                                    >
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    Belum ada produk skincare.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($products->hasPages())
            <div class="border-t border-gray-200 px-6 py-4 dark:border-gray-700">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>