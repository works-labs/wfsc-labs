<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use App\Models\Promo;
use Illuminate\Support\Facades\Storage;

new #[Layout('layouts.admin')] class extends Component
{
    use WithFileUploads;

    public Promo $promo;

    public string $title = '';
    public string $slug = '';
    public string $description = '';
    public $image = null;
    public ?string $existingImage = null;
    public string $cta_text = '';
    public string $cta_url = '';
    public string $start_date = '';
    public string $end_date = '';
    public int $sort_order = 0;
    public bool $is_active = true;

    public function mount(Promo $promo): void
    {
        $this->promo = $promo;

        $this->title = $promo->title;
        $this->slug = $promo->slug;
        $this->description = $promo->description ?? '';
        $this->existingImage = $promo->image;
        $this->cta_text = $promo->cta_text ?? '';
        $this->cta_url = $promo->cta_url ?? '';
        $this->start_date = $promo->start_date?->format('Y-m-d') ?? '';
        $this->end_date = $promo->end_date?->format('Y-m-d') ?? '';
        $this->sort_order = $promo->sort_order;
        $this->is_active = (bool) $promo->is_active;
    }

    public function update(): void
    {
        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                'unique:promos,slug,' . $this->promo->id,
            ],
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
            $oldImage = $this->promo->image;

            $newImage = $this->image->store('promos', 'public');

            $validated['image'] = $newImage;

            if ($oldImage) {
                Storage::disk('public')->delete($oldImage);
            }
        } else {
            unset($validated['image']);
        }

        $this->promo->update($validated);

        session()->flash(
            'success',
            'Promo updated successfully.'
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
            Edit Promo
        </h1>

        <p class="mt-2 text-gray-600">
            Update promotional content displayed on the WFSC website.
        </p>
    </div>

    <form wire:submit="update" class="max-w-4xl space-y-6">

        {{-- Title --}}
        <div>
            <label class="mb-2 block text-sm font-medium">
                Title
            </label>

            <input
                type="text"
                wire:model="title"
                class="w-full rounded-lg border px-4 py-2"
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

        {{-- Existing / New Image --}}
        <div>
            <label class="mb-2 block text-sm font-medium">
                Promo Image
            </label>

            @if ($existingImage && !$image)
                <div class="mb-4">
                    <p class="mb-2 text-sm text-gray-500">
                        Current Image
                    </p>

                    <img
                        src="{{ Storage::url($existingImage) }}"
                        alt="{{ $title }}"
                        class="h-64 w-full rounded-xl object-cover"
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
                        alt="New promo preview"
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
                Update Promo
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