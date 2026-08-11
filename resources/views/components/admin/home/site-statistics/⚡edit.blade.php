<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\SiteStatistic;

new #[Layout('layouts.admin')] class extends Component
{
    public SiteStatistic $statistic;

    public string $label = '';
    public string $value = '';
    public string $suffix = '';
    public string $icon = '';
    public int $sort_order = 0;
    public bool $is_active = true;

    public function mount(SiteStatistic $statistic): void
    {
        $this->statistic = $statistic;

        $this->label = $statistic->label;
        $this->value = $statistic->value;
        $this->suffix = $statistic->suffix ?? '';
        $this->icon = $statistic->icon ?? '';
        $this->sort_order = $statistic->sort_order;
        $this->is_active = (bool) $statistic->is_active;
    }

    public function update(): void
    {
        $validated = $this->validate([
            'label' => ['required', 'string', 'max:255'],
            'value' => ['required', 'string', 'max:255'],
            'suffix' => ['nullable', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        $this->statistic->update($validated);

        session()->flash(
            'success',
            'Statistic updated successfully.'
        );

        $this->redirect(
            route('admin.home.site-statistics.index'),
            navigate: true
        );
    }
};

?>

<div>
    <div class="mb-8">
        <h1 class="text-2xl font-bold">
            Edit Statistic
        </h1>

        <p class="mt-2 text-gray-600">
            Update the statistic displayed on the WFSC website.
        </p>
    </div>

    <form wire:submit="update" class="max-w-3xl space-y-6">

        <div>
            <label class="mb-2 block text-sm font-medium">
                Label
            </label>

            <input
                type="text"
                wire:model="label"
                class="w-full rounded-lg border px-4 py-2"
            >

            @error('label')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium">
                Value
            </label>

            <input
                type="text"
                wire:model="value"
                class="w-full rounded-lg border px-4 py-2"
            >

            @error('value')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium">
                Suffix
            </label>

            <input
                type="text"
                wire:model="suffix"
                class="w-full rounded-lg border px-4 py-2"
            >

            @error('suffix')
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
                Update Statistic
            </button>

            <a
                href="{{ route('admin.home.site-statistics.index') }}"
                wire:navigate
                class="rounded-lg border px-5 py-2 font-medium"
            >
                Cancel
            </a>
        </div>

    </form>
</div>