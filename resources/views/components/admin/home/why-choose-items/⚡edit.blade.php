<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\WhyChooseItem;

new #[Layout('layouts.admin')] class extends Component
{
    public WhyChooseItem $item;

    public string $title = '';
    public string $description = '';
    public string $icon = '';
    public int $sort_order = 0;
    public bool $is_active = true;

    public function mount(WhyChooseItem $item): void
    {
        $this->item = $item;

        $this->title = $item->title;
        $this->description = $item->description ?? '';
        $this->icon = $item->icon ?? '';
        $this->sort_order = $item->sort_order;
        $this->is_active = (bool) $item->is_active;
    }

    public function update(): void
    {
        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        $this->item->update($validated);

        session()->flash(
            'success',
            'Why Choose item updated successfully.'
        );

        $this->redirect(
            route('admin.home.why-choose-items.index'),
            navigate: true
        );
    }
};

?>

<div>
    <div class="mb-8">
        <h1 class="text-2xl font-bold">
            Edit Why Choose Item
        </h1>

        <p class="mt-2 text-gray-600">
            Update this reason displayed on the WFSC website.
        </p>
    </div>

    <form wire:submit="update" class="max-w-3xl space-y-6">

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
                Icon
            </label>

            <input
                type="text"
                wire:model="icon"
                class="w-full rounded-lg border px-4 py-2"
            >

            @error('icon')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
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

            <label
                for="is_active"
                class="text-sm font-medium"
            >
                Active
            </label>
        </div>

        <div class="flex items-center gap-3 pt-4">
            <button
                type="submit"
                class="rounded-lg bg-black px-5 py-2 font-semibold text-white"
            >
                Update Item
            </button>

            <a
                href="{{ route('admin.home.why-choose-items.index') }}"
                wire:navigate
                class="rounded-lg border px-5 py-2 font-medium"
            >
                Cancel
            </a>
        </div>

    </form>
</div>