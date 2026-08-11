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

<div>
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold">
                {{ $treatment->name }} Products
            </h1>

            <p class="mt-1 text-gray-600">
                Manage products for {{ $treatment->name }}.
            </p>
        </div>

        <a
            href="{{ route('admin.treatments.products.create', $treatment) }}"
            class="rounded-lg bg-black px-4 py-2 text-sm font-semibold text-white hover:bg-gray-800"
        >
            Add Product
        </a>
    </div>

    <div class="mt-8 overflow-hidden rounded-xl border bg-white">
        <table class="w-full text-left text-sm">
            <thead class="border-b bg-gray-50">
                <tr>
                    <th class="px-6 py-4 font-semibold">Product</th>
                    <th class="px-6 py-4 font-semibold">Description</th>
                    <th class="px-6 py-4 font-semibold">Sort Order</th>
                    <th class="px-6 py-4 font-semibold">Status</th>
                    <th class="px-6 py-4 font-semibold">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse ($treatment->products()->orderBy('sort_order')->get() as $product)
                    <tr>
                        <td class="px-6 py-4 font-medium">
                            {{ $product->name }}
                        </td>

                        <td class="px-6 py-4 text-gray-600">
                            {{ $product->description ?: '-' }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $product->sort_order }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex gap-3">
                                <a
                                    href="{{ route('admin.treatments.products.edit', [$treatment, $product]) }}"
                                    class="font-medium underline"
                                >
                                    Edit
                                </a>

                                <button
                                    type="button"
                                    wire:click="delete({{ $product->id }})"
                                    wire:confirm="Delete this product?"
                                    class="font-medium text-red-600"
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
                            class="px-6 py-10 text-center text-gray-500"
                        >
                            No products found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>