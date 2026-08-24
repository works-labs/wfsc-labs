<?php

use App\Models\Treatment;
use App\Models\TreatmentCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

new #[Layout('layouts.admin')] class extends Component
{
    use WithFileUploads;

    public Treatment $treatment;

    public string $name = '';
    public string $slug = '';
    public ?int $category_id = null;
    public string $short_description = '';
    public string $description = '';
    public $cover_image = null;
    public bool $is_featured = false;
    public bool $is_active = true;

    public function mount(Treatment $treatment): void
    {
        $this->treatment = $treatment;

        $this->name = $treatment->name;
        $this->slug = $treatment->slug;
        $this->category_id = $treatment->category_id;
        $this->short_description = $treatment->short_description ?? '';
        $this->description = $treatment->description ?? '';
        $this->is_featured = (bool) $treatment->is_featured;
        $this->is_active = (bool) $treatment->is_active;
    }

    // Mengubah slug otomatis saat name diedit (menggunakan underscore)
    public function updatedName(string $value): void
    {
        $this->slug = Str::slug($value, '-');
    }

    public function update(): void
    {
        $validated = $this->validate([
            'category_id' => ['required', 'exists:treatment_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                'unique:treatments,slug,' . $this->treatment->id,
            ],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'image', 'max:2048'],
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
        ]);

        if ($this->cover_image) {
            $oldImage = $this->treatment->cover_image;

            $newImage = $this->cover_image->store('treatments', 'public');

            $validated['cover_image'] = $newImage;

            if ($oldImage) {
                Storage::disk('public')->delete($oldImage);
            }
        } else {
            unset($validated['cover_image']);
        }

        $this->treatment->update($validated);

        session()->flash('success', 'Treatment updated successfully.');

        $this->redirect(
            route('admin.treatments.index'),
            navigate: true
        );
    }

    public function with(): array
    {
        return [
            'categories' => TreatmentCategory::where('is_active', true)
                ->orderBy('sort_order')
                ->get(),
        ];
    }
};
?>

<div class="mx-auto max-w-4xl space-y-6">

    <div>
        <a
            href="{{ route('admin.treatments.index') }}"
            wire:navigate
            class="text-sm text-gray-500 hover:text-gray-900"
        >
            ← Back to Treatments
        </a>

        <h1 class="mt-2 text-2xl font-bold">
            Edit Treatment
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Update treatment information.
        </p>
    </div>

    <form wire:submit="update" class="space-y-6">

        <div class="rounded-xl border bg-white p-6 shadow-sm space-y-5">

            <div>
                <label class="block text-sm font-medium">Category</label>

                <select
                    wire:model="category_id"
                    class="mt-1 w-full rounded-lg border-gray-300"
                >
                    <option value="">Select category</option>

                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                @error('category_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Name</label>

                <input
                    type="text"
                    wire:model.live="name"
                    class="mt-1 w-full rounded-lg border-gray-300"
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
                    tabindex="-1"
                    class="mt-1 w-full cursor-not-allowed rounded-lg border border-gray-300 bg-gray-100 px-4 py-2.5 font-mono text-sm text-gray-500"
                    placeholder="hydrafacial_facial"
                >

                @error('slug')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Short Description</label>

                <textarea
                    wire:model="short_description"
                    rows="3"
                    class="mt-1 w-full rounded-lg border-gray-300"
                ></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium">Description</label>

                <textarea
                    wire:model="description"
                    rows="6"
                    class="mt-1 w-full rounded-lg border-gray-300"
                ></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium">Cover Image</label>

                @if ($treatment->cover_image && !$cover_image)
                    <div class="mt-3">
                        <p class="mb-2 text-sm text-gray-500">Current image</p>

                        <img
                            src="{{ Storage::url($treatment->cover_image) }}"
                            alt="{{ $treatment->name }}"
                            class="h-48 w-64 rounded-xl object-cover"
                        >
                    </div>
                @endif

                <input
                    type="file"
                    wire:model="cover_image"
                    accept="image/*"
                    class="mt-4 block w-full text-sm"
                >

                @if ($cover_image)
                    <div class="mt-4">
                        <p class="mb-2 text-sm text-gray-500">New image preview</p>

                        <img
                            src="{{ $cover_image->temporaryUrl() }}"
                            class="h-48 w-64 rounded-xl object-cover"
                            alt="New preview"
                        >
                    </div>
                @endif

                @error('cover_image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-6">

                <label class="flex items-center gap-2">
                    <input
                        type="checkbox"
                        wire:model="is_featured"
                        class="rounded"
                    >
                    <span class="text-sm">Featured</span>
                </label>

                <label class="flex items-center gap-2">
                    <input
                        type="checkbox"
                        wire:model="is_active"
                        class="rounded"
                    >
                    <span class="text-sm">Active</span>
                </label>

            </div>

        </div>

        <div class="flex justify-end gap-3">

            <a
                href="{{ route('admin.treatments.index') }}"
                wire:navigate
                class="rounded-lg border px-5 py-2.5 text-sm font-medium hover:bg-gray-50"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="rounded-lg bg-black px-5 py-2.5 text-sm font-semibold text-white hover:bg-gray-800"
            >
                Update Treatment
            </button>

        </div>

    </form>

</div>