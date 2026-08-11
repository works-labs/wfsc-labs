<?php

use App\Models\TreatmentCategory;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

new #[Layout('layouts.admin')] class extends Component
{
    use WithPagination;

    public function delete(int $categoryId): void
    {
        $category = TreatmentCategory::findOrFail($categoryId);

        if (
            $category->image &&
            Storage::disk('public')->exists($category->image)
        ) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        $this->resetPage();
    }

    public function with(): array
    {
        return [
            'categories' => TreatmentCategory::orderBy('sort_order')->paginate(10),
        ];
    }
};

?>

<div>
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold">Treatment Categories</h1>

            <p class="mt-1 text-sm text-gray-500">
                Manage treatment categories displayed on the WFSC website.
            </p>
        </div>

        <a
            href="{{ route('admin.treatment-categories.create') }}"
            wire:navigate
            class="rounded-lg bg-black px-4 py-2 text-sm font-medium text-white hover:bg-gray-800"
        >
            + Add Category
        </a>
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Category</th>
                        <th class="px-6 py-4 font-semibold">Slug</th>
                        <th class="px-6 py-4 font-semibold">Sort Order</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 text-right font-semibold">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse ($categories as $category)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">
                                    {{ $category->name }}
                                </div>

                                @if ($category->description)
                                    <div class="mt-1 max-w-md truncate text-xs text-gray-500">
                                        {{ $category->description }}
                                    </div>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ $category->slug }}
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ $category->sort_order }}
                            </td>

                            <td class="px-6 py-4">
                                @if ($category->is_active)
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
                                <div class="flex justify-end gap-2">
                                    <a
                                        href="{{ route('admin.treatment-categories.edit', $category) }}"
                                        wire:navigate
                                        class="rounded-lg border px-3 py-2 text-sm hover:bg-gray-50"
                                    >
                                        Edit
                                    </a>

                                    <button
                                        type="button"
                                        wire:click="delete({{ $category->id }})"
                                        wire:confirm="Delete this treatment category?"
                                        class="rounded-lg border border-red-200 px-3 py-2 text-sm text-red-600 hover:bg-red-50"
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
                                No treatment categories found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($categories->hasPages())
            <div class="border-t px-6 py-4">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
</div>