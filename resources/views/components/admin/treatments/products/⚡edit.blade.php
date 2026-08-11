```php
<?php

use App\Models\Treatment;
use App\Models\TreatmentProduct;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

new #[Layout('layouts.admin')] class extends Component
{
    use WithFileUploads;

    public Treatment $treatment;
    public TreatmentProduct $product;

    public string $name = '';
    public string $description = '';
    public int $sort_order = 0;
    public bool $is_active = true;

    public $image = null;

    public function mount(Treatment $treatment, TreatmentProduct $product): void
    {
        $this->treatment = $treatment;
        $this->product = $product;

        $this->name = $product->name;
        $this->description = $product->description ?? '';
        $this->sort_order = $product->sort_order;
        $this->is_active = (bool) $product->is_active;
    }

    public function update(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['boolean'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $oldImage = $this->product->image;

        if ($this->image) {
            $newImage = $this->image->store(
                'treatment-products',
                'public'
            );

            $validated['image'] = $newImage;
        }

        unset($validated['image']);

        $this->product->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'sort_order' => $validated['sort_order'],
            'is_active' => $validated['is_active'],
            ...(
                $this->image
                    ? ['image' => $newImage]
                    : []
            ),
        ]);

        if ($this->image && $oldImage) {
            Storage::disk('public')->delete($oldImage);
        }

        session()->flash(
            'success',
            'Treatment product updated successfully.'
        );

        $this->redirect(
            route(
                'admin.treatments.products.index',
                $this->treatment
            ),
            navigate: true
        );
    }
};
?>

<div class="space-y-6">

    <div>
        <h1 class="text-2xl font-bold">
            Edit Product
        </h1>

        <p class="mt-1 text-sm text-gray-600">
            Update product for {{ $treatment->name }}.
        </p>
    </div>

    @if (session('success'))
        <div class="rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit="update" class="space-y-6">

        <div class="rounded-xl bg-white p-6 shadow-sm">

            <div class="grid gap-6 md:grid-cols-2">

                {{-- Name --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">
                        Product Name
                    </label>

                    <input
                        type="text"
                        wire:model="name"
                        class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >

                    @error('name')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">
                        Description
                    </label>

                    <textarea
                        wire:model="description"
                        rows="5"
                        class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    ></textarea>

                    @error('description')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Sort Order --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Sort Order
                    </label>

                    <input
                        type="number"
                        wire:model="sort_order"
                        min="0"
                        class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >

                    @error('sort_order')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="flex items-center gap-3 pt-7">
                    <input
                        type="checkbox"
                        wire:model="is_active"
                        class="rounded border-gray-300"
                    >

                    <label class="text-sm font-medium text-gray-700">
                        Active
                    </label>
                </div>

                {{-- Image --}}
                <div class="md:col-span-2">

                    <label class="block text-sm font-medium text-gray-700">
                        Product Image
                    </label>

                    {{-- Current image --}}
                    @if ($product->image && !$image)
                        <div class="mt-3">
                            <p class="mb-2 text-xs text-gray-500">
                                Current image
                            </p>

                            <img
                                src="{{ asset('storage/' . $product->image) }}"
                                alt="{{ $product->name }}"
                                class="h-40 w-40 rounded-xl object-cover shadow-sm"
                            >
                        </div>
                    @endif

                    {{-- New image preview --}}
                    @if ($image)
                        <div class="mt-3">
                            <p class="mb-2 text-xs text-gray-500">
                                New image preview
                            </p>

                            <img
                                src="{{ $image->temporaryUrl() }}"
                                alt="New image preview"
                                class="h-40 w-40 rounded-xl object-cover shadow-sm"
                            >
                        </div>
                    @endif

                    <input
                        type="file"
                        wire:model="image"
                        accept="image/*"
                        class="mt-4 block w-full text-sm text-gray-600"
                    >

                    <div wire:loading wire:target="image" class="mt-2 text-sm text-gray-500">
                        Uploading preview...
                    </div>

                    @error('image')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>

        </div>

        <div class="flex items-center justify-end gap-3">

            <a
                href="{{ route('admin.treatments.products.index', $treatment) }}"
                class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
                Cancel
            </a>

            <button
                type="submit"
                wire:loading.attr="disabled"
                class="rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-indigo-700 disabled:opacity-50"
            >
                <span wire:loading.remove wire:target="update">
                    Update Product
                </span>

                <span wire:loading wire:target="update">
                    Updating...
                </span>
            </button>

        </div>

    </form>

</div>
```
