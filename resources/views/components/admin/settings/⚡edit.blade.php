<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\SiteSetting;

new #[Layout('layouts.admin')] class extends Component
{
    public SiteSetting $setting;

    public string $key = '';
    public string $value = '';

    public function mount(SiteSetting $setting): void
    {
        $this->setting = $setting;

        $this->key = $setting->key;
        $this->value = $setting->value ?? '';
    }

    public function update(): void
    {
        $validated = $this->validate([
            'key' => [
                'required',
                'string',
                'max:255',
                'unique:site_settings,key,' . $this->setting->id,
            ],
            'value' => [
                'nullable',
                'string',
            ],
        ]);

        $this->setting->update($validated);

        session()->flash(
            'success',
            'Site setting berhasil diperbarui.'
        );

        $this->redirectRoute(
            'admin.settings.index',
            navigate: true
        );
    }
};
?>

<div class="mx-auto max-w-4xl space-y-8 pb-10">

    {{-- Top Navigation & Header --}}
    <div>
        <a
            href="{{ route('admin.settings.index') }}"
            wire:navigate
            class="inline-flex items-center gap-2 text-sm font-bold text-gray-400 transition-colors hover:text-[var(--color-wfsc-coral)]"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Pengaturan Situs
        </a>
        <div class="mt-4 flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-500 shadow-sm">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
            </div>
            <div>
                <h1 class="text-2xl font-black tracking-tight text-[var(--color-wfsc-dark)]">
                    Edit Pengaturan Situs
                </h1>
                <p class="mt-1 text-sm font-medium text-gray-500">
                    Update this website setting.
                </p>
            </div>
        </div>
    </div>

    <form wire:submit="update" class="space-y-8">

        {{-- Form Card --}}
        <div class="relative overflow-hidden rounded-2xl border border-gray-100/50 bg-white p-8 elegant-shadow">
            <div class="absolute left-0 top-0 h-full w-1 bg-blue-400"></div>

            <div class="mb-6 flex items-center gap-3">
                <div class="rounded-lg bg-blue-50 p-2 text-blue-500">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
                </div>
                <h2 class="text-lg font-bold text-[var(--color-wfsc-dark)]">Setting Configuration</h2>
            </div>

            <div class="space-y-6">
                {{-- Key --}}
                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">
                        Key
                    </label>

                    <input
                        type="text"
                        wire:model="key"
                        class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                    >

                    @error('key')
                        <p class="mt-1.5 text-xs font-bold text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Value --}}
                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">
                        Value
                    </label>

                    <textarea
                        wire:model="value"
                        rows="5"
                        class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                    ></textarea>

                    @error('value')
                        <p class="mt-1.5 text-xs font-bold text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Aksi --}}
        <div class="flex items-center justify-end gap-4 pt-4">
            <a
                href="{{ route('admin.settings.index') }}"
                wire:navigate
                class="rounded-xl px-5 py-3 text-sm font-bold text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-800"
            >
                Batal
            </a>

            <button
                type="submit"
                wire:loading.attr="disabled"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[var(--color-wfsc-coral)] to-[#ff7676] px-8 py-3 text-sm font-bold text-white shadow-lg shadow-[var(--color-wfsc-coral)]/30 transition-all duration-300 hover:scale-[1.02] hover:shadow-xl hover:shadow-[var(--color-wfsc-coral)]/40 disabled:opacity-70 disabled:hover:scale-100"
            >
                <span wire:loading.remove>Update Setting</span>
                <span wire:loading>
                    <svg class="h-4 w-4 animate-spin text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Updating...
                </span>
            </button>
        </div>

    </form>

</div>