<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use App\Models\Promo;

new #[Layout('layouts.admin')] class extends Component
{
    use WithFileUploads;

    public string $title = '';
    public string $slug = '';
    public string $description = '';
    public $image = null;
    public string $cta_text = '';
    public string $cta_url = '';
    public string $start_date = '';
    public string $end_date = '';
    public int $sort_order = 0;
    public bool $is_active = true;

    public function save(): void
    {
        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:promos,slug'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:4096'],
            'cta_text' => ['nullable', 'string', 'max:255'],
            'cta_url' => ['nullable', 'string', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        if ($this->image) {
            $validated['image'] = $this->image->store('promos', 'public');
        }

        $this->image = null;

        Promo::create($validated);

        session()->flash(
            'success',
            'Promo created successfully.'
        );

        $this->redirect(
            route('admin.home.promos.index'),
            navigate: true
        );
    }
};

?>

<div>
    <div class="mb-8">
        <h1 class="text-2xl font-bold">
            Add Promo
        </h1>

        <p class="mt-2 text-gray-600">
            Add promotional content displayed on the WFSC website.
        </p>
    </div>

    <form wire:submit="save" class="max-w-4xl space-y-6">

        {{-- Title --}}
        <div>
            <label class="mb-2 block text-sm font-medium">
                Title
            </label>

            <input
                type="text"
                wire:model="title"
                class="w-full rounded-lg border px-4 py-2"
                placeholder="Special Skin Treatment"
            >

            @error('title')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Slug --}}
        <div>
            <label class="mb-2 block text-sm font-medium">
                Slug
            </label>

            <input
                type="text"
                wire:model="slug"
                class="w-full rounded-lg border px-4 py-2"
                placeholder="special-skin-treatment"
            >

            @error('slug')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Description --}}
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

        {{-- Image --}}
        <div>
            <label class="mb-2 block text-sm font-medium">
                Promo Image
            </label>

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
                        Preview
                    </p>

                    <img
                        src="{{ $image->temporaryUrl() }}"
                        alt="Promo preview"
                        class="h-64 w-full rounded-xl object-cover"
                    >
                </div>
            @endif
        </div>

        {{-- CTA --}}
        <div class="grid gap-6 md:grid-cols-2">

            <div>
                <label class="mb-2 block text-sm font-medium">
                    CTA Text
                </label>

                <input
                    type="text"
                    wire:model="cta_text"
                    class="w-full rounded-lg border px-4 py-2"
                    placeholder="Book Now"
                >

                @error('cta_text')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium">
                    CTA URL
                </label>

                <input
                    type="text"
                    wire:model="cta_url"
                    class="w-full rounded-lg border px-4 py-2"
                    placeholder="/booking"
                >

                @error('cta_url')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

        </div>

        {{-- Dates --}}
        <div class="grid gap-6 md:grid-cols-2">

            <div>
                <label class="mb-2 block text-sm font-medium">
                    Start Date
                </label>

                <input
                    type="date"
                    wire:model="start_date"
                    class="w-full rounded-lg border px-4 py-2"
                >

                @error('start_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium">
                    End Date
                </label>

                <input
                    type="date"
                    wire:model="end_date"
                    class="w-full rounded-lg border px-4 py-2"
                >

                @error('end_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

        </div>

        {{-- Sort Order --}}
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

        {{-- Status --}}
        <div class="flex items-center gap-3">
            <input
                type="checkbox"
                wire:model="is_active"
                id="is_active"
                class="rounded"
            >

            <label
                for="is_active"
                class="text-sm font-medium"
            >
                Active
            </label>
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-3 pt-4">

            <button
                type="submit"
                class="rounded-lg bg-black px-5 py-2 font-semibold text-white"
            >
                Save Promo
            </button>

            <a
                href="{{ route('admin.home.promos.index') }}"
                wire:navigate
                class="rounded-lg border px-5 py-2 font-medium"
            >
                Cancel
            </a>

        </div>

    </form>
</div>