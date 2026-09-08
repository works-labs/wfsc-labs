<?php

use App\Models\Treatment;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.admin')] class extends Component
{
    public Treatment $treatment;

    public array $selectedTreatments = [];

    public function mount(Treatment $treatment): void
    {
        $this->treatment = $treatment;

        $this->selectedTreatments = $treatment
            ->relatedTreatments()
            ->pluck('treatments.id')
            ->map(fn ($id) => (int) $id)
            ->toArray();
    }

    public function save(): void
    {
        $this->validate([
            'selectedTreatments' => ['array'],
            'selectedTreatments.*' => [
                'integer',
                'exists:treatments,id',
            ],
        ]);

        $selected = collect($this->selectedTreatments)
            ->filter(fn ($id) => (int) $id !== (int) $this->treatment->id)
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values()
            ->toArray();

        $this->treatment
            ->relatedTreatments()
            ->sync($selected);

        session()->flash(
            'success',
            'Related treatments berhasil diperbarui.'
        );
    }

    public function with(): array
    {
        return [
            'treatments' => Treatment::query()
                ->whereKeyNot($this->treatment->id)
                ->where('is_active', true)
                ->with('category')
                ->orderBy('name')
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
            Related Treatments
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Manage treatments related to
            <span class="font-medium text-gray-700">
                {{ $treatment->name }}
            </span>.
        </p>
    </div>


    @if (session('success'))
        <div class="rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif


    <div class="rounded-xl border bg-white p-6 shadow-sm">

        <div class="space-y-3">

            @forelse ($treatments as $relatedTreatment)

                <label
                    class="flex cursor-pointer items-center justify-between rounded-lg border p-4 transition hover:bg-gray-50"
                >

                    <div class="flex items-center gap-3">

                        <input
                            type="checkbox"
                            wire:model="selectedTreatments"
                            value="{{ $relatedTreatment->id }}"
                            class="rounded"
                        >

                        <div>
                            <p class="font-medium text-gray-900">
                                {{ $relatedTreatment->name }}
                            </p>

                            @if ($relatedTreatment->category)
                                <p class="text-sm text-gray-500">
                                    {{ $relatedTreatment->category->name }}
                                </p>
                            @endif
                        </div>

                    </div>

                    <span class="text-xs text-gray-400">
                        #{{ $relatedTreatment->id }}
                    </span>

                </label>

            @empty

                <div class="py-10 text-center text-sm text-gray-500">
                    No other active treatments available.
                </div>

            @endforelse

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
            type="button"
            wire:click="save"
            wire:loading.attr="disabled"
            class="rounded-lg bg-black px-5 py-2.5 text-sm font-semibold text-white hover:bg-gray-800 disabled:opacity-50"
        >
            <span wire:loading.remove wire:target="save">
                Save Related Treatments
            </span>

            <span wire:loading wire:target="save">
                Saving...
            </span>
        </button>

    </div>

</div>