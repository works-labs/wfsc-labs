<?php

use App\Models\Treatment;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;

new #[Layout('layouts.admin')] class extends Component
{
    public Treatment $treatment;

    public function delete(int $productId): void
    {
        $product = $this->treatment->products()
            ->findOrFail($productId);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
    }
};
?>

<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold">
                {{ $treatment->name }} Products
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Manage products for {{ $treatment->name }}.
            </p>
        </div>

        <a
            href="{{ route('admin.treatments.products.create', $treatment) }}"
            wire:navigate
            class="rounded-lg bg-black px-4 py-2 text-sm font-semibold text-white hover:bg-gray-800"
        >
            + Add Product
        </a>
    </div>

    <div class="overflow-hidden rounded-xl border bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Product</th>
                        <th class="px-6 py-4 font-semibold">Description</th>
                        <th class="px-6 py-4 font-semibold">Sort Order</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse ($treatment->products()->orderBy('sort_order')->get() as $product)
                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    @if ($product->image)
                                        <img
                                            src="{{ Storage::url($product->image) }}"
                                            alt="{{ $product->name }}"
                                            class="h-14 w-14 rounded-lg object-cover"
                                        >
                                    @else
                                        <div class="flex h-14 w-14 items-center justify-center rounded-lg bg-gray-100 text-xs text-gray-400">
                                            No Image
                                        </div>
                                    @endif

                                    <div>
                                        <p class="font-semibold text-gray-900">
                                            {{ $product->name }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-gray-500">
                                <p class="max-w-xs truncate">
                                    {{ $product->description ?: '-' }}
                                </p>
                            </td>

                            <td class="px-6 py-4 font-medium text-gray-700">
                                {{ $product->sort_order }}
                            </td>

                            <td class="px-6 py-4">
                                @if ($product->is_active)
                                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                        Active
                                    </span>
                                @else
                                    <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <a
                                        href="{{ route('admin.treatments.products.edit', [$treatment, $product]) }}"
                                        wire:navigate
                                        class="rounded-lg border px-3 py-2 text-xs font-medium hover:bg-gray-50"
                                    >
                                        Edit
                                    </a>

                                    <button
                                        type="button"
                                        wire:click="delete({{ $product->id }})"
                                        wire:confirm="Delete this product?"
                                        class="rounded-lg bg-red-600 px-3 py-2 text-xs font-medium text-white hover:bg-red-700"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td
                                colspan="5"
                                class="px-6 py-12 text-center text-gray-500"
                            >
                                No products found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>