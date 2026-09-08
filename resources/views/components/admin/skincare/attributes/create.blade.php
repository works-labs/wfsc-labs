<?php

use App\Models\SkincareAttribute;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.admin')] class extends Component
{
    public string $name = '';

    public string $slug = '';

    public string $description = '';

    public bool $is_active = true;

    public function updatedName(string $value): void
    {
        $this->slug = Str::slug($value);
    }

    public function save(): void
    {
        $validated = $this->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'required',
                'string',
                'max:255',
                'unique:skincare_attributes,slug',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'is_active' => [
                'boolean',
            ],
        ]);

        SkincareAttribute::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'],
            'is_active' => $validated['is_active'],
        ]);

        session()->flash(
            'success',
            'Skincare attribute created successfully.'
        );

        $this->redirect(
            route('admin.skincare.attributes.index'),
            navigate: true
        );
    }
};
?>

<div class="mx-auto max-w-3xl space-y-6">

    <div>

        <a
            href="{{ route('admin.skincare.attributes.index') }}"
            wire:navigate
            class="text-sm text-gray-500 hover:text-gray-700"
        >
            ← Back to Attributes
        </a>

        <h1 class="mt-2 text-2xl font-semibold text-gray-900">
            Add Skincare Attribute
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Create a new attribute for skincare products.
        </p>

    </div>

    <form
        wire:submit="save"
        class="space-y-6 rounded-xl border border-gray-200 bg-white p-6"
    >

        <div>

            <label class="block text-sm font-medium text-gray-700">
                Name
            </label>

            <input
                type="text"
                wire:model.live="name"
                class="mt-2 w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900"
                placeholder="Sunscreen"
            >

            @error('name')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror

        </div>

        <div>

            <label class="block text-sm font-medium text-gray-700">
                Slug
            </label>

            <input
                type="text"
                wire:model="slug"
                class="mt-2 w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900"
                placeholder="sunscreen"
            >

            <p class="mt-1 text-xs text-gray-500">
                Used for filtering products and public URLs.
            </p>

            @error('slug')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror

        </div>

        <div>

            <label class="block text-sm font-medium text-gray-700">
                Description
            </label>

            <textarea
                wire:model="description"
                rows="4"
                class="mt-2 w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900"
                placeholder="Products that provide sun protection..."
            ></textarea>

            @error('description')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror

        </div>

        <div>

            <label class="inline-flex items-center gap-3">

                <input
                    type="checkbox"
                    wire:model="is_active"
                    class="h-4 w-4 rounded border-gray-300"
                >

                <span class="text-sm font-medium text-gray-700">
                    Active
                </span>

            </label>

            <p class="mt-1 text-xs text-gray-500">
                Inactive attributes won't be available for product assignment.
            </p>

        </div>

        <div class="flex justify-end gap-3 border-t border-gray-100 pt-6">

            <a
                href="{{ route('admin.skincare.attributes.index') }}"
                wire:navigate
                class="rounded-lg border border-gray-200 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
                Cancel
            </a>

            <button
                type="submit"
                wire:loading.attr="disabled"
                class="rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-gray-800 disabled:opacity-50"
            >

                <span wire:loading.remove>
                    Create Attribute
                </span>

                <span wire:loading>
                    Saving...
                </span>

            </button>

        </div>

    </form>

</div>