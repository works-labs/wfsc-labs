<?php

use App\Models\SkincareCategory;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.admin')] class extends Component
{
    public function delete(int $id): void
    {
        $category = SkincareCategory::findOrFail($id);

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        session()->flash(
            'success',
            'Skincare category deleted successfully.'
        );
    }

    public function toggleStatus(int $id): void
    {
        $category = SkincareCategory::findOrFail($id);

        $category->update([
            'is_active' => ! $category->is_active,
        ]);
    }

    public function with(): array
    {
        return [
            'categories' => SkincareCategory::query()
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get(),
        ];
    }
};
?>

<div class="space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">
                Skincare Categories
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Manage skincare product categories.
            </p>
        </div>

        <a
            href="{{ route('admin.skincare.categories.create') }}"
            wire:navigate
            class="inline-flex items-center rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800"
        >
            + Add Category
        </a>
    </div>

    @if (session('success'))
        <div class="rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Category
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Slug
                        </th>

                        <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Order
                        </th>

                        <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Status
                        </th>

                        <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">

                    @forelse ($categories as $category)
                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">

                                    @if ($category->image)
                                        <img
                                            src="{{ Storage::url($category->image) }}"
                                            alt="{{ $category->name }}"
                                            class="h-12 w-12 rounded-lg object-cover"
                                        >
                                    @else
                                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-gray-100 text-xs text-gray-400">
                                            No Image
                                        </div>
                                    @endif

                                    <div>
                                        <div class="font-medium text-gray-900">
                                            {{ $category->name }}
                                        </div>

                                        @if ($category->description)
                                            <div class="mt-1 max-w-md truncate text-sm text-gray-500">
                                                {{ $category->description }}
                                            </div>
                                        @endif
                                    </div>

                                </div>
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $category->slug }}
                            </td>

                            <td class="px-6 py-4 text-center text-sm text-gray-500">
                                {{ $category->sort_order }}
                            </td>

                            <td class="px-6 py-4 text-center">

                                <button
                                    type="button"
                                    wire:click="toggleStatus({{ $category->id }})"
                                    class="inline-flex rounded-full px-3 py-1 text-xs font-medium
                                        {{ $category->is_active
                                            ? 'bg-green-100 text-green-700'
                                            : 'bg-gray-100 text-gray-600' }}"
                                >
                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                </button>

                            </td>

                            <td class="px-6 py-4 text-right">

                                <div class="flex justify-end gap-2">

                                    <a
                                        href="{{ route('admin.skincare.categories.edit', $category) }}"
                                        wire:navigate
                                        class="rounded-lg border border-gray-200 px-3 py-1.5 text-sm text-gray-700 hover:bg-gray-50"
                                    >
                                        Edit
                                    </a>

                                    <button
                                        type="button"
                                        wire:click="delete({{ $category->id }})"
                                        wire:confirm="Are you sure you want to delete this category?"
                                        class="rounded-lg border border-red-200 px-3 py-1.5 text-sm text-red-600 hover:bg-red-50"
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
                                class="px-6 py-12 text-center text-sm text-gray-500"
                            >
                                No skincare categories found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>