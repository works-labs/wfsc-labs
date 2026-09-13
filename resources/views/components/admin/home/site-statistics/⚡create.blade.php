<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\SiteStatistic;

new #[Layout('layouts.admin')] class extends Component
{
    public string $label = '';
    public string $value = '';
    public string $suffix = '';
    public string $icon = '';
    public int $sort_order = 0;
    public bool $is_active = true;

    public function save(): void
    {
        $validated = $this->validate([
            'label' => ['required', 'string', 'max:255'],
            'value' => ['required', 'string', 'max:255'],
            'suffix' => ['nullable', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        SiteStatistic::create($validated);

        session()->flash(
            'success',
            'Statistic created successfully.'
        );

        $this->redirect(
            route('admin.home.site-statistics.index'),
            navigate: true
        );
    }
};

?>

<div class="mx-auto max-w-4xl space-y-8 pb-10">

    {{-- Top Navigation & Header --}}
    <div>
        <a href="{{ route('admin.home.site-statistics.index') }}" wire:navigate 
            class="inline-flex items-center gap-2 text-sm font-bold text-gray-400 transition-colors hover:text-[var(--color-wfsc-coral)]">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to Site Statistics
        </a>
        <div class="mt-4 flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-rose-50 text-[var(--color-wfsc-coral)] shadow-sm">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </div>
            <div>
                <h1 class="text-2xl font-black tracking-tight text-[var(--color-wfsc-dark)]">Add Statistic</h1>
                <p class="text-sm font-medium text-gray-500">Add a statistic displayed on the WFSC website.</p>
            </div>
        </div>
    </div>

    <form wire:submit="save" class="space-y-8">

        {{-- Statistic Form Card --}}
        <div class="relative overflow-hidden rounded-2xl border border-gray-100/50 bg-white p-8 elegant-shadow">
            <div class="absolute left-0 top-0 h-full w-1 bg-blue-400"></div>
            
            <div class="mb-6 flex items-center gap-3">
                <div class="rounded-lg bg-blue-50 p-2 text-blue-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                <h2 class="text-lg font-bold text-[var(--color-wfsc-dark)]">Statistic Details</h2>
            </div>

            <div class="space-y-6">
                {{-- Label --}}
                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Label <span class="text-[var(--color-wfsc-coral)]">*</span></label>
                    <input
                        type="text"
                        wire:model="label"
                        placeholder="Years of Experience"
                        class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                    >
                    @error('label')
                        <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Value & Suffix --}}
                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-bold text-gray-600">Value <span class="text-[var(--color-wfsc-coral)]">*</span></label>
                        <input
                            type="text"
                            wire:model="value"
                            placeholder="10"
                            class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                        >
                        @error('value')
                            <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-gray-600">Suffix</label>
                        <input
                            type="text"
                            wire:model="suffix"
                            placeholder="+"
                            class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                        >
                        <p class="mt-1.5 text-xs font-medium text-gray-400">
                            Optional. Example: +, %, K, etc.
                        </p>
                        @error('suffix')
                            <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Icon --}}
                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Icon</label>
                    <input
                        type="text"
                        wire:model="icon"
                        placeholder="users"
                        class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                    >
                    <p class="mt-1.5 text-xs font-medium text-gray-400">
                        Optional. Enter the icon identifier used by the frontend.
                    </p>
                    @error('icon')
                        <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Sort Order & Status --}}
                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-bold text-gray-600">Sort Order</label>
                        <input
                            type="number"
                            wire:model="sort_order"
                            min="0"
                            placeholder="0"
                            class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                        >
                        @error('sort_order')
                            <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center pt-8">
                        <label class="inline-flex items-center gap-3 rounded-xl border border-gray-100 bg-gray-50 p-4 w-full transition-colors hover:bg-gray-100 cursor-pointer">
                            <input
                                type="checkbox"
                                wire:model="is_active"
                                id="is_active"
                                class="h-5 w-5 rounded-md border-gray-300 text-[var(--color-wfsc-coral)] focus:ring-[var(--color-wfsc-coral)]"
                            >
                            <div>
                                <span class="block text-sm font-bold text-gray-800">Active</span>
                                <span class="block text-xs font-medium text-gray-500">Visible on the website.</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-4 pt-4">
            <a
                href="{{ route('admin.home.site-statistics.index') }}"
                wire:navigate
                class="rounded-xl px-5 py-3 text-sm font-bold text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-800"
            >
                Cancel
            </a>

            <button
                type="submit"
                wire:loading.attr="disabled"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[var(--color-wfsc-coral)] to-[#ff7676] px-8 py-3 text-sm font-bold text-white shadow-lg shadow-[var(--color-wfsc-coral)]/30 transition-all duration-300 hover:scale-[1.02] hover:shadow-xl hover:shadow-[var(--color-wfsc-coral)]/40 disabled:opacity-70 disabled:hover:scale-100"
            >
                <span wire:loading.remove>Save Statistic</span>
                <span wire:loading>
                    <svg class="h-4 w-4 animate-spin text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Saving...
                </span>
            </button>
        </div>

    </form>
</div>