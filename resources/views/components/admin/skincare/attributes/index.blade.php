<?php

use App\Models\SkincareAttribute;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.admin')] class extends Component
{
    public function delete(int $id): void
    {
        $attribute = SkincareAttribute::findOrFail($id);

        $attribute->delete();

        session()->flash(
            'success',
            'Skincare attribute deleted successfully.'
        );
    }

    public function toggleStatus(int $id): void
    {
        $attribute = SkincareAttribute::findOrFail($id);

        $attribute->update([
            'is_active' => ! $attribute->is_active,
        ]);
    }

    public function with(): array
    {
        return [
            'attributes' => SkincareAttribute::query()
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
                Skincare Attributes
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Manage attributes for skincare products.
            </p>
        </div>

        <a
            href="{{ route('admin.skincare.attributes.create') }}"
            wire:navigate
            class="inline-flex items-center rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800"
        >
            + Add Attribute
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
                            Attribute
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Slug
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Description
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

                    @forelse ($attributes as $attribute)

                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-4">

                                <div class="font-medium text-gray-900">
                                    {{ $attribute->name }}
                                </div>

                            </td>

                            <td class="px-6 py-4">

                                <code class="rounded bg-gray-100 px-2 py-1 text-xs text-gray-600">
                                    {{ $attribute->slug }}
                                </code>

                            </td>

                            <td class="px-6 py-4">

                                @if ($attribute->description)

                                    <div class="max-w-md truncate text-sm text-gray-500">
                                        {{ $attribute->description }}
                                    </div>

                                @else

                                    <span class="text-sm text-gray-400">
                                        No description
                                    </span>

                                @endif

                            </td>

                            <td class="px-6 py-4 text-center">

                                <button
                                    type="button"
                                    wire:click="toggleStatus({{ $attribute->id }})"
                                    class="inline-flex rounded-full px-3 py-1 text-xs font-medium
                                        {{ $attribute->is_active
                                            ? 'bg-green-100 text-green-700'
                                            : 'bg-gray-100 text-gray-600' }}"
                                >
                                    {{ $attribute->is_active ? 'Active' : 'Inactive' }}
                                </button>

                            </td>

                            <td class="px-6 py-4 text-right">

                                <div class="flex justify-end gap-2">

                                    <a
                                        href="{{ route('admin.skincare.attributes.edit', $attribute) }}"
                                        wire:navigate
                                        class="rounded-lg border border-gray-200 px-3 py-1.5 text-sm text-gray-700 hover:bg-gray-50"
                                    >
                                        Edit
                                    </a>

                                    <button
                                        type="button"
                                        wire:click="delete({{ $attribute->id }})"
                                        wire:confirm="Are you sure you want to delete this attribute?"
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
                                No skincare attributes found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>