<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\SiteSetting;

new #[Layout('layouts.admin')] class extends Component
{
    public function delete(int $id): void
    {
        SiteSetting::findOrFail($id)->delete();

        session()->flash(
            'success',
            'Site setting berhasil dihapus.'
        );
    }
};
?>
<div class="mx-auto max-w-7xl space-y-6">

    {{-- Header Card --}}
    <div class="flex flex-col gap-4 rounded-2xl border border-gray-100/50 bg-white p-6 elegant-shadow sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-4">
            <div class="hidden sm:flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-700">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div>
                <h1 class="text-2xl font-black tracking-tight text-[var(--color-wfsc-dark)]">
                    Site Settings
                </h1>
                <p class="mt-1 text-sm font-medium text-gray-500">
                    Manage global website settings.
                </p>
            </div>
        </div>

        <a href="{{ route('admin.settings.create') }}" wire:navigate
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[var(--color-wfsc-coral)] to-[#ff7676] px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-[var(--color-wfsc-coral)]/30 transition-all duration-300 hover:scale-[1.02] hover:shadow-xl hover:shadow-[var(--color-wfsc-coral)]/40"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Setting
        </a>
    </div>

    {{-- Flash Message --}}
    @if (session('success'))
        <div class="flex items-center gap-3 rounded-2xl border border-emerald-100 bg-emerald-50 px-6 py-4 text-sm font-bold text-emerald-700 shadow-sm">
            <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @php
        $settings = SiteSetting::query()
            ->orderBy('key')
            ->get();
    @endphp

    @if ($settings->isEmpty())
        <div class="rounded-2xl border border-gray-100/50 bg-white p-12 text-center elegant-shadow">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-50">
                <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
            </div>
            <p class="mt-4 text-sm font-medium text-gray-900">
                Belum ada site setting.
            </p>
            <a
                href="{{ route('admin.settings.create') }}"
                wire:navigate
                class="mt-2 inline-flex items-center gap-1 text-sm font-bold text-[var(--color-wfsc-coral)] hover:underline"
            >
                Tambahkan setting pertama →
            </a>
        </div>
    @else
        <div class="overflow-hidden rounded-2xl border border-gray-100/50 bg-white elegant-shadow">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-[#F4F6F9]">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                Key
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                Value
                            </th>
                            <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-gray-500">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach ($settings as $setting)
                            <tr class="transition-colors hover:bg-rose-50/30">
                                <td class="px-6 py-4">
                                    <code class="rounded-lg bg-gray-100 px-3 py-1 font-mono text-xs font-bold text-gray-800">
                                        {{ $setting->key }}
                                    </code>
                                </td>
                                <td class="max-w-xl px-6 py-4">
                                    <div class="truncate text-xs font-medium text-gray-600">
                                        {{ $setting->value ?: '-' }}
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
                                    <div class="flex items-center justify-end gap-2">
                                        <a
                                            href="{{ route('admin.settings.edit', $setting) }}"
                                            wire:navigate
                                            class="inline-flex items-center gap-1.5 rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-bold text-blue-600 transition-colors hover:bg-blue-100 hover:text-blue-700"
                                        >
                                            Edit
                                        </a>

                                        <button
                                            type="button"
                                            wire:click="delete({{ $setting->id }})"
                                            wire:confirm="Yakin ingin menghapus setting ini?"
                                            class="inline-flex items-center gap-1.5 rounded-lg bg-red-50 px-3 py-1.5 text-xs font-bold text-red-600 transition-colors hover:bg-red-100 hover:text-red-700"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>