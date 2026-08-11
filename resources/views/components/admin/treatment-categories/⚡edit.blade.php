<?php

use App\Models\TreatmentCategory;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

new #[Layout('layouts.admin')] class extends Component
{
    use WithFileUploads;

    public TreatmentCategory $category;

    public string $name = '';
    public string $slug = '';
    public string $description = '';
    public $image = null;
    public ?string $currentImage = null;
    public int $sort_order = 0;
    public bool $is_active = true;

    public function mount(TreatmentCategory $category): void
    {
        $this->category = $category;

        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->description = $category->description ?? '';
        $this->currentImage = $category->image;
        $this->sort_order = $category->sort_order;
        $this->is_active = (bool) $category->is_active;
    }

    public function update(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                'unique:treatment_categories,slug,' . $this->category->id,
            ],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        if ($this->image) {
            $oldImage = $this->category->image;

            $newImage = $this->image->store(
                'treatment-categories',
                'public'
            );

            $validated['image'] = $newImage;

            if (
                $oldImage &&
                Storage::disk('public')->exists($oldImage)
            ) {
                Storage::disk('public')->delete($oldImage);
            }
        } else {
            unset($validated['image']);
        }

        $this->category->update($validated);

        session()->flash(
            'success',
            'Treatment category updated successfully.'
        );

        $this->redirect(
            route('admin.treatment-categories.index'),
            navigate: true
        );
    }
};

?>

<div>
    <div class="mb-8">
        <h1 class="text-2xl font-bold">Edit Treatment Category</h1>

        <p class="mt-1 text-sm text-gray-500">
            Update treatment category information.
        </p>
    </div>

    <form wire:submit="update" class="max-w-3xl space-y-6">

        <div>
            <label class="mb-2 block text-sm font-medium">
                Name
            </label>

            <input
                type="text"
                wire:model="name"
                class="w-full rounded-lg border border-gray-300 px-4 py-2.5"
            >

            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium">
                Slug
            </label>

            <input
                type="text"
                wire:model="slug"
                class="w-full rounded-lg border border-gray-300 px-4 py-2.5"
            >

            @error('slug')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium">
                Description
            </label>

            <textarea
                wire:model="description"
                rows="5"
                class="w-full rounded-lg border border-gray-300 px-4 py-2.5"
            ></textarea>

            @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        @if ($currentImage)
            <div>
                <label class="mb-2 block text-sm font-medium">
                    Current Image
                </label>

                <img
                    src="{{ Storage::url($currentImage) }}"
                    class="h-40 w-40 rounded-xl object-cover"
                >
            </div>
        @endif

        <div>
            <label class="mb-2 block text-sm font-medium">
                Replace Image
            </label>

            <input
                type="file"
                wire:model="image"
                accept="image/*"
                class="block w-full rounded-lg border border-gray-300 px-4 py-2.5"
            >

            @error('image')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror

            @if ($image)
                <div class="mt-4">
                    <img
                        src="{{ $image->temporaryUrl() }}"
                        class="h-40 w-40 rounded-xl object-cover"
                    >
                </div>
            @endif
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium">
                Sort Order
            </label>

            <input
                type="number"
                wire:model="sort_order"
                min="0"
                class="w-full rounded-lg border border-gray-300 px-4 py-2.5"
            >

            @error('sort_order')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <label class="flex items-center gap-3">
            <input
                type="checkbox"
                wire:model="is_active"
                class="rounded border-gray-300"
            >

            <span class="text-sm font-medium">
                Active
            </span>
        </label>

        <div class="flex gap-3 pt-4">
            <a
                href="{{ route('admin.treatment-categories.index') }}"
                wire:navigate
                class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium hover:bg-gray-50"
            >
                Cancel
            </a>

            <button
                type="submit"
                wire:loading.attr="disabled"
                class="rounded-lg bg-black px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-800 disabled:opacity-50"
            >
                <span wire:loading.remove>Update Category</span>
                <span wire:loading>Updating...</span>
            </button>
        </div>

    </form>
</div>