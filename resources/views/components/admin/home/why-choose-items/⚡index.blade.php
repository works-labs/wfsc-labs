<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\WhyChooseItem;

new #[Layout('layouts.admin')] class extends Component
{
    public function delete(int $itemId): void
    {
        WhyChooseItem::findOrFail($itemId)->delete();

        session()->flash(
            'success',
            'Why Choose item deleted successfully.'
        );
    }

    public function with(): array
    {
        return [
            'items' => WhyChooseItem::orderBy('sort_order')
                ->orderBy('id')
                ->get(),
        ];
    }
};
?>

<div>
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold">
                Why Choose Items
            </h1>

            <p class="mt-2 text-gray-600">
                Manage the reasons why visitors should choose WFSC.
            </p>
        </div>

        <a
            href="{{ route('admin.home.why-choose-items.create') }}"
            wire:navigate
            class="rounded-lg bg-black px-5 py-2 font-semibold text-white"
        >
            Add Item
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-lg bg-green-100 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-xl bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="border-b bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-sm font-semibold">
                            Title
                        </th>

                        <th class="px-6 py-4 text-sm font-semibold">
                            Description
                        </th>

                        <th class="px-6 py-4 text-sm font-semibold">
                            Icon
                        </th>

                        <th class="px-6 py-4 text-sm font-semibold">
                            Sort Order
                        </th>

                        <th class="px-6 py-4 text-sm font-semibold">
                            Status
                        </th>

                        <th class="px-6 py-4 text-sm font-semibold">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse ($items as $item)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="font-medium">
                                    {{ $item->title }}
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="max-w-md text-sm text-gray-600">
                                    {{ $item->description ?: '-' }}
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                {{ $item->icon ?: '-' }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $item->sort_order }}
                            </td>

                            <td class="px-6 py-4">
                                @if ($item->is_active)
                                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                        Active
                                    </span>
                                @else
                                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <a
                                        href="{{ route('admin.home.why-choose-items.edit', $item) }}"
                                        wire:navigate
                                        class="text-sm font-medium text-blue-600 hover:underline"
                                    >
                                        Edit
                                    </a>

                                    <button
                                        type="button"
                                        wire:click="delete({{ $item->id }})"
                                        wire:confirm="Are you sure you want to delete this item?"
                                        class="text-sm font-medium text-red-600 hover:underline"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                colspan="6"
                                class="px-6 py-12 text-center text-gray-500"
                            >
                                No Why Choose items found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>