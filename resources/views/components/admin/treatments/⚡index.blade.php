<?php

use App\Models\Treatment;
use Livewire\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.admin')] class extends Component
{
    public function delete(int $treatmentId): void
    {
        $treatment = Treatment::findOrFail($treatmentId);

        if ($treatment->cover_image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($treatment->cover_image);
        }

        $treatment->delete();
    }

    public function with(): array
    {
        return [
            'treatments' => Treatment::with('category')
                ->orderBy('category_id')
                ->orderBy('name')
                ->get(),
        ];
    }
};
?>

<div class="space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold">Treatments</h1>
            <p class="mt-1 text-sm text-gray-500">
                Manage treatments displayed on the WFSC website.
            </p>
        </div>

        <a
            href="{{ route('admin.treatments.create') }}"
            wire:navigate
            class="rounded-lg bg-black px-4 py-2 text-sm font-semibold text-white hover:bg-gray-800"
        >
            + Add Treatment
        </a>
    </div>

    <div class="overflow-hidden rounded-xl border bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Treatment</th>
                        <th class="px-6 py-4 font-semibold">Category</th>
                        <th class="px-6 py-4 font-semibold">Slug</th>
                        <th class="px-6 py-4 font-semibold">Featured</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse ($treatments as $treatment)
                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">

                                    @if ($treatment->cover_image)
                                        <img
                                            src="{{ Storage::url($treatment->cover_image) }}"
                                            alt="{{ $treatment->name }}"
                                            class="h-14 w-14 rounded-lg object-cover"
                                        >
                                    @else
                                        <div class="flex h-14 w-14 items-center justify-center rounded-lg bg-gray-100 text-xs text-gray-400">
                                            No Image
                                        </div>
                                    @endif

                                    <div>
                                        <p class="font-semibold text-gray-900">
                                            {{ $treatment->name }}
                                        </p>

                                        <p class="mt-1 max-w-md text-xs text-gray-500">
                                            {{ $treatment->short_description }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium">
                                    {{ $treatment->category?->name ?? '-' }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-gray-500">
                                {{ $treatment->slug }}
                            </td>

                            <td class="px-6 py-4">
                                @if ($treatment->is_featured)
                                    <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-700">
                                        Featured
                                    </span>
                                @else
                                    <span class="text-gray-400">
                                        —
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                @if ($treatment->is_active)
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
                                        href="{{ route('admin.treatments.videos.index', $treatment) }}"
                                        wire:navigate
                                        class="text-sm font-medium text-blue-600 hover:underline"
                                    >
                                        Procedure Videos
                                    </a>

                                    <a
                                        href="{{ route('admin.treatments.before-afters.index', $treatment) }}"
                                        wire:navigate
                                        class="text-sm font-medium text-purple-600 hover:underline"
                                    >
                                        Before & After
                                    </a>

                                    <a
                                        href="{{ route('admin.treatments.edit', $treatment) }}"
                                        wire:navigate
                                        class="rounded-lg border px-3 py-2 text-xs font-medium hover:bg-gray-50"
                                    >
                                        Edit
                                    </a>

                                    <a
                                        href="{{ route('admin.treatments.products.index', $treatment) }}"
                                        wire:navigate
                                        class="rounded-lg border px-3 py-2 text-xs font-medium hover:bg-gray-50"
                                    >
                                        Products
                                    </a>

                                    <button
                                        type="button"
                                        wire:click="delete({{ $treatment->id }})"
                                        wire:confirm="Delete this treatment?"
                                        class="rounded-lg bg-red-600 px-3 py-2 text-xs font-medium text-white hover:bg-red-700"
                                    >
                                        Delete
                                    </button>

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                No treatments found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

