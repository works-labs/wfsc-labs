<?php

use App\Models\Treatment;
use App\Models\TreatmentProduct;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;

new #[Layout('layouts.admin')] class extends Component
{
    use WithFileUploads;

    public Treatment $treatment;

    public string $name = '';
    public string $description = '';
    public $image = null;
    public int $sort_order = 1;
    public bool $is_active = true;

    public function save(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        if ($this->image) {
            $validated['image'] = $this->image->store('treatment-products', 'public');
        }

        TreatmentProduct::create([
            'treatment_id' => $this->treatment->id,
            ...$validated,
        ]);

        session()->flash('success', 'Treatment product created successfully.');

        $this->redirect(
            route('admin.treatments.products.index', $this->treatment),
            navigate: true
        );
    }
};
?>

<div>
    <div class="mb-8">
        <h1 class="text-2xl font-bold">
            Add Product
        </h1>

        <p class="mt-1 text-gray-600">
            Add a product for {{ $treatment->name }}.
        </p>
    </div>

    <form wire:submit="save" class="max-w-3xl space-y-6">

        <div>
            <label class="block text-sm font-medium">
                Product Name
            </label>

            <input
                type="text"
                wire:model="name"
                class="mt-2 w-full rounded-lg border px-4 py-2"
            >

            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">
                Description
            </label>

            <textarea
                wire:model="description"
                rows="5"
                class="mt-2 w-full rounded-lg border px-4 py-2"
            ></textarea>

            @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">
                Image
            </label>

            <input
                type="file"
                wire:model="image"
                accept="image/*"
                class="mt-2 block w-full"
            >

            @error('image')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">
                Sort Order
            </label>

            <input
                type="number"
                wire:model="sort_order"
                min="0"
                class="mt-2 w-full rounded-lg border px-4 py-2"
            >

            @error('sort_order')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <label class="flex items-center gap-2">
            <input
                type="checkbox"
                wire:model="is_active"
            >

            <span class="text-sm">
                Active
            </span>
        </label>

        <div class="flex gap-3">
            <a
                href="{{ route('admin.treatments.products.index', $treatment) }}"
                class="rounded-lg border px-4 py-2 text-sm font-medium"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="rounded-lg bg-black px-4 py-2 text-sm font-semibold text-white hover:bg-gray-800"
            >
                Save Product
            </button>
        </div>

    </form>
</div>