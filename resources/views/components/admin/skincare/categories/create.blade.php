<?php

use App\Models\SkincareCategory;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

new #[Layout('layouts.admin')] class extends Component
{
    use WithFileUploads;

    public string $name = '';

    public string $slug = '';

    public string $description = '';

    public $image = null;

    public int $sort_order = 0;

    public bool $is_active = true;

    // Mengubah slug otomatis saat mengetik Name
    public function updatedName(string $value): void
    {
        $this->slug = Str::slug($value);
    }

    public function save(): void
    {
        // Memastikan slug selalu tersinkronisasi saat tombol submit ditekan
        $this->slug = Str::slug($this->name);

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:skincare_categories,slug'],
            'description' => ['nullable', 'string'],
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        $imagePath = null;

        if ($this->image) {
            $imagePath = $this->image->store(
                'skincare/categories',
                'public'
            );
        }

        SkincareCategory::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'],
            'image' => $imagePath,
            'sort_order' => $validated['sort_order'],
            'is_active' => $validated['is_active'],
        ]);

        session()->flash(
            'success',
            'Skincare category created successfully.'
        );

        $this->redirect(
            route('admin.skincare.categories.index'),
            navigate: true
        );
    }
};
?>

<div class="mx-auto max-w-3xl space-y-6">

    <div>
        <a
            href="{{ route('admin.skincare.categories.index') }}"
            wire:navigate
            class="text-sm text-gray-500 hover:text-gray-700"
        >
            ← Back to Categories
        </a>

        <h1 class="mt-2 text-2xl font-semibold text-gray-900">
            Add Skincare Category
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Create a new category for skincare products.
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
                placeholder="Face Care"
            >

            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">
                Slug (Auto-generated)
            </label>

            <input
                type="text"
                wire:model="slug"
                readonly
                class="mt-2 w-full cursor-not-allowed rounded-lg border border-gray-300 bg-gray-100 px-4 py-2.5 text-sm text-gray-500 focus:outline-none"
                placeholder="face-care"
            >

            @error('slug')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
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
                placeholder="Description for this skincare category..."
            ></textarea>

            @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">
                Image
            </label>

            <input
                type="file"
                wire:model="image"
                accept="image/jpeg,image/png,image/webp"
                class="mt-2 block w-full text-sm text-gray-600"
            >

            <p class="mt-1 text-xs text-gray-500">
                JPG, JPEG, PNG or WebP. Maximum 2 MB.
            </p>

            @error('image')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror

            @if ($image)
                <div class="mt-4">
                    <img
                        src="{{ $image->temporaryUrl() }}"
                        alt="Preview"
                        class="h-32 w-32 rounded-lg object-cover"
                    >
                </div>
            @endif
        </div>

        <div class="grid gap-6 sm:grid-cols-2">

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Sort Order
                </label>

                <input
                    type="number"
                    wire:model="sort_order"
                    min="0"
                    class="mt-2 w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900"
                >

                @error('sort_order')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center pt-8">
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
            </div>

        </div>

        <div class="flex justify-end gap-3 border-t border-gray-100 pt-6">

            <a
                href="{{ route('admin.skincare.categories.index') }}"
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
                    Create Category
                </span>

                <span wire:loading>
                    Saving...
                </span>
            </button>
        </div>
    </form>
</div>