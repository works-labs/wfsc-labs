<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use App\Models\Facility;
use Illuminate\Support\Facades\Storage;

new #[Layout('layouts.admin')] class extends Component
{
    use WithFileUploads;

    public Facility $facility;

    public string $name = '';
    public string $description = '';
    public $image = null;
    public int $sort_order = 0;
    public bool $is_active = true;

    public function mount(Facility $facility): void
    {
        $this->facility = $facility;

        $this->name = $facility->name;
        $this->description = $facility->description ?? '';
        $this->sort_order = $facility->sort_order;
        $this->is_active = (bool) $facility->is_active;
    }

    public function update(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        if ($this->image) {
            $oldImage = $this->facility->image;

            $newImage = $this->image->store('facilities', 'public');

            $validated['image'] = $newImage;

            if ($oldImage) {
                Storage::disk('public')->delete($oldImage);
            }
        } else {
            unset($validated['image']);
        }

        $this->facility->update($validated);

        session()->flash('success', 'Facility updated successfully.');

        $this->redirect(
            route('admin.facilities.index'),
            navigate: true
        );
    }
};

?>

<div>
    <div class="mb-8">
        <h1 class="text-2xl font-bold">
            Edit Facility
        </h1>

        <p class="mt-2 text-gray-600">
            Update facility information displayed on the WFSC website.
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
                class="w-full rounded-lg border px-4 py-2"
            >

            @error('name')
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
                class="w-full rounded-lg border px-4 py-2"
            ></textarea>

            @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium">
                Image
            </label>

            @if ($facility->image)
                <div class="mb-4">
                    <p class="mb-2 text-sm text-gray-500">
                        Current Image
                    </p>

                    <img
                        src="{{ Storage::url($facility->image) }}"
                        alt="{{ $facility->name }}"
                        class="h-48 w-72 rounded-lg object-cover"
                    >
                </div>
            @endif

            <input
                type="file"
                wire:model="image"
                accept="image/*"
                class="w-full rounded-lg border px-4 py-2"
            >

            @error('image')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror

            @if ($image)
                <div class="mt-4">
                    <p class="mb-2 text-sm text-gray-500">
                        New Image Preview
                    </p>

                    <img
                        src="{{ $image->temporaryUrl() }}"
                        class="h-48 w-72 rounded-lg object-cover"
                        alt="New image preview"
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
                class="w-full rounded-lg border px-4 py-2"
            >

            @error('sort_order')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-3">
            <input
                type="checkbox"
                wire:model="is_active"
                id="is_active"
                class="rounded"
            >

            <label for="is_active" class="text-sm font-medium">
                Active
            </label>
        </div>

        <div class="flex items-center gap-3 pt-4">
            <button
                type="submit"
                class="rounded-lg bg-black px-5 py-2 font-semibold text-white"
            >
                Update Facility
            </button>

            <a
                href="{{ route('admin.facilities.index') }}"
                wire:navigate
                class="rounded-lg border px-5 py-2 font-medium"
            >
                Cancel
            </a>
        </div>

    </form>
</div>