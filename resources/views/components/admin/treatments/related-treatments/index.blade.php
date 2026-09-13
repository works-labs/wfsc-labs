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

<div class="mx-auto max-w-4xl space-y-8 pb-10">

    {{-- Top Navigation & Header Card --}}
    <div class="flex flex-col gap-4 rounded-2xl border border-gray-100/50 bg-white p-6 elegant-shadow sm:flex-row sm:items-center sm:justify-between">
        <div>
            <a href="{{ route('admin.treatments.index') }}" wire:navigate 
                class="inline-flex items-center gap-2 text-xs font-bold text-gray-400 transition-colors hover:text-[var(--color-wfsc-coral)]">
                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to Treatments
            </a>
            
            <div class="mt-3 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                </div>
                <div>
                    <h1 class="text-2xl font-black tracking-tight text-[var(--color-wfsc-dark)]">
                        Related Treatments
                    </h1>
                    <p class="text-xs font-medium text-gray-500">
                        Manage treatments related to <span class="font-bold text-[var(--color-wfsc-coral)]">{{ $treatment->name }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Alert Notification --}}
    @if (session('success'))
        <div class="flex items-center gap-3 rounded-2xl border border-emerald-100 bg-emerald-50 px-6 py-4 text-sm font-bold text-emerald-700 shadow-sm">
            <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Selection List Card --}}
    <div class="relative overflow-hidden rounded-2xl border border-gray-100/50 bg-white p-8 elegant-shadow">
        <div class="absolute left-0 top-0 h-full w-1 bg-indigo-400"></div>

        <div class="space-y-3">
            @forelse ($treatments as $relatedTreatment)
                <label class="flex cursor-pointer items-center justify-between rounded-xl border border-gray-100 bg-gray-50/50 p-4 transition-all duration-200 hover:bg-rose-50/30 hover:border-rose-100">
                    <div class="flex items-center gap-4">
                        <input type="checkbox" wire:model="selectedTreatments" value="{{ $relatedTreatment->id }}"
                            class="h-5 w-5 rounded-md border-gray-300 text-[var(--color-wfsc-coral)] focus:ring-[var(--color-wfsc-coral)]">

                        <div>
                            <p class="text-sm font-bold text-[var(--color-wfsc-dark)]">
                                {{ $relatedTreatment->name }}
                            </p>
                            @if ($relatedTreatment->category)
                                <p class="mt-0.5 text-xs font-medium text-gray-400">
                                    {{ $relatedTreatment->category->name }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <span class="inline-flex items-center justify-center rounded-lg bg-gray-100 px-2.5 py-1 text-xs font-mono font-bold text-gray-400">
                        #{{ $relatedTreatment->id }}
                    </span>
                </label>
            @empty
                <div class="py-12 text-center text-sm font-medium text-gray-400">
                    No other active treatments available.
                </div>
            @endforelse
        </div>
    </div>

    {{-- Actions --}}
    <div class="flex items-center justify-end gap-4">
        <a href="{{ route('admin.treatments.index') }}" wire:navigate 
            class="rounded-xl px-5 py-3 text-sm font-bold text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-800">
            Cancel
        </a>

        <button type="button" wire:click="save" wire:loading.attr="disabled"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[var(--color-wfsc-coral)] to-[#ff7676] px-8 py-3 text-sm font-bold text-white shadow-lg shadow-[var(--color-wfsc-coral)]/30 transition-all duration-300 hover:scale-[1.02] hover:shadow-xl hover:shadow-[var(--color-wfsc-coral)]/40 disabled:opacity-70 disabled:hover:scale-100">
            <span wire:loading.remove wire:target="save">Save Related Treatments</span>
            <span wire:loading wire:target="save">
                <svg class="h-4 w-4 animate-spin text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                Saving...
            </span>
        </button>
    </div>

</div>