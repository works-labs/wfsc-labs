<?php

use App\Models\SkincareAttribute;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.admin')] class extends Component
{
    public function delete(int $id): void
    {
        $attribute = SkincareAttribute::findOrFail($id);

        $attribute->delete();

        session()->flash(
            'success',
            'Skincare attribute deleted successfully.'
        );
    }

    public function toggleStatus(int $id): void
    {
        $attribute = SkincareAttribute::findOrFail($id);

        $attribute->update([
            'is_active' => ! $attribute->is_active,
        ]);
    }

    public function with(): array
    {
        return [
            'attributes' => SkincareAttribute::query()
                ->orderBy('name')
                ->get(),
        ];
    }
};
?>

<div class="mx-auto max-w-7xl space-y-6">

    {{-- Header Card --}}
    <div class="flex flex-col gap-4 rounded-2xl border border-gray-100/50 bg-white p-6 elegant-shadow sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-4">
            <div class="hidden sm:flex h-12 w-12 items-center justify-center rounded-2xl bg-purple-50 text-purple-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 73.857l-1.043 1.043M15 11h1"/></svg>
            </div>
            <div>
                <h1 class="text-2xl font-black tracking-tight text-[var(--color-wfsc-dark)]">
                    Skincare Attributes
                </h1>
                <p class="mt-1 text-sm font-medium text-gray-500">
                    Manage attributes for skincare products.
                </p>
            </div>
        </div>

        <a href="{{ route('admin.skincare.attributes.create') }}" wire:navigate
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[var(--color-wfsc-coral)] to-[#ff7676] px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-[var(--color-wfsc-coral)]/30 transition-all duration-300 hover:scale-[1.02] hover:shadow-xl hover:shadow-[var(--color-wfsc-coral)]/40"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Attribute
        </a>
    </div>

    {{-- Alert Notification --}}
    @if (session('success'))
        <div class="flex items-center gap-3 rounded-2xl border border-emerald-100 bg-emerald-50 px-6 py-4 text-sm font-bold text-emerald-700 shadow-sm">
            <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Table Card --}}
    <div class="overflow-hidden rounded-2xl border border-gray-100/50 bg-white elegant-shadow">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-[#F4F6F9]">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                            Attribute
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                            Slug
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                            Description
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-500">
                            Status
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-gray-500">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-50">
                    @forelse ($attributes as $attribute)
                        <tr class="transition-colors hover:bg-rose-50/30">

                            {{-- Name --}}
                            <td class="px-6 py-4">
                                <div class="font-bold text-[var(--color-wfsc-dark)]">
                                    {{ $attribute->name }}
                                </div>
                            </td>

                            {{-- Slug --}}
                            <td class="whitespace-nowrap px-6 py-4">
                                <code class="rounded-lg bg-gray-100 px-2.5 py-1 text-xs font-mono font-bold text-gray-600">
                                    {{ $attribute->slug }}
                                </code>
                            </td>

                            {{-- Description --}}
                            <td class="px-6 py-4">
                                @if ($attribute->description)
                                    <div class="max-w-md truncate text-xs font-medium text-gray-400">
                                        {{ $attribute->description }}
                                    </div>
                                @else
                                    <span class="text-xs font-medium text-gray-300">
                                        No description
                                    </span>
                                @endif
                            </td>

                            {{-- Status Toggle --}}
                            <td class="whitespace-nowrap px-6 py-4 text-center">
                                <button type="button" wire:click="toggleStatus({{ $attribute->id }})"
                                    class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-bold transition-all
                                        {{ $attribute->is_active
                                            ? 'bg-emerald-50 text-emerald-600 ring-1 ring-inset ring-emerald-600/20'
                                            : 'bg-gray-50 text-gray-500 ring-1 ring-inset ring-gray-500/20' }}"
                                >
                                    <span class="h-1.5 w-1.5 rounded-full {{ $attribute->is_active ? 'bg-emerald-600' : 'bg-gray-400' }}"></span>
                                    {{ $attribute->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </td>

                            {{-- Actions --}}
                            <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.skincare.attributes.edit', $attribute) }}" wire:navigate
                                        class="inline-flex items-center gap-1.5 rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-bold text-blue-600 transition-colors hover:bg-blue-100 hover:text-blue-700"
                                    >
                                        Edit
                                    </a>

                                    <button type="button" wire:click="delete({{ $attribute->id }})" wire:confirm="Are you sure you want to delete this attribute?"
                                        class="inline-flex items-center gap-1.5 rounded-lg bg-red-50 px-3 py-1.5 text-xs font-bold text-red-600 transition-colors hover:bg-red-100 hover:text-red-700"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-50">
                                    <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 73.857l-1.043 1.043M15 11h1"/></svg>
                                </div>
                                <p class="mt-4 text-sm font-medium text-gray-900">No skincare attributes found</p>
                                <p class="mt-1 text-sm text-gray-500">Get started by creating a new attribute.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>