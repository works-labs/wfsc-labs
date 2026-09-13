<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Branch;

new #[Layout('layouts.admin')] class extends Component
{
    public function delete(int $branchId): void
    {
        Branch::findOrFail($branchId)->delete();

        session()->flash(
            'success',
            'Branch deleted successfully.'
        );
    }

    public function with(): array
    {
        return [
            'branches' => Branch::orderBy('name')->get(),
        ];
    }
};

?>

<div class="mx-auto max-w-7xl space-y-6">

    {{-- Header Card --}}
    <div class="flex flex-col gap-4 rounded-2xl border border-gray-100/50 bg-white p-6 elegant-shadow sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-4">
            <div class="hidden sm:flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-500">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <div>
                <h1 class="text-2xl font-black tracking-tight text-[var(--color-wfsc-dark)]">
                    Branches
                </h1>
                <p class="mt-1 text-sm font-medium text-gray-500">
                    Manage clinic branches and contact information.
                </p>
            </div>
        </div>

        <a href="{{ route('admin.branches.create') }}" wire:navigate
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[var(--color-wfsc-coral)] to-[#ff7676] px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-[var(--color-wfsc-coral)]/30 transition-all duration-300 hover:scale-[1.02] hover:shadow-xl hover:shadow-[var(--color-wfsc-coral)]/40"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Branch
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
                            Branch
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                            Contact
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                            Location
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                            Status
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-gray-500">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-50">
                    @forelse ($branches as $branch)
                        <tr class="transition-colors hover:bg-rose-50/30">
                            {{-- Branch --}}
                            <td class="px-6 py-4">
                                <div class="font-bold text-[var(--color-wfsc-dark)]">
                                    {{ $branch->name }}
                                </div>

                                <div class="mt-1 max-w-sm text-xs font-medium text-gray-400 leading-relaxed">
                                    {{ $branch->address }}
                                </div>
                            </td>

                            {{-- Contact --}}
                            <td class="px-6 py-4">
                                <div class="space-y-1 text-xs font-medium text-gray-600">
                                    @if ($branch->phone)
                                        <div class="flex items-center gap-1.5">
                                            <span class="text-gray-400">📞</span> {{ $branch->phone }}
                                        </div>
                                    @endif

                                    @if ($branch->whatsapp)
                                        <div class="flex items-center gap-1.5">
                                            <span class="text-emerald-500 font-bold">WA:</span> {{ $branch->whatsapp }}
                                        </div>
                                    @endif

                                    @if ($branch->email)
                                        <div class="flex items-center gap-1.5">
                                            <span class="text-gray-400">✉</span> {{ $branch->email }}
                                        </div>
                                    @endif
                                </div>
                            </td>

                            {{-- Location --}}
                            <td class="px-6 py-4">
                                @if ($branch->google_maps_url)
                                    <a
                                        href="{{ $branch->google_maps_url }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center gap-1 rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-bold text-blue-600 transition-colors hover:bg-blue-100 hover:text-blue-700"
                                    >
                                        Google Maps ↗
                                    </a>
                                @elseif ($branch->latitude && $branch->longitude)
                                    <span class="text-xs font-mono font-medium text-gray-500">
                                        {{ $branch->latitude }},
                                        {{ $branch->longitude }}
                                    </span>
                                @else
                                    <span class="text-xs font-medium text-gray-300">
                                        Not set
                                    </span>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td class="whitespace-nowrap px-6 py-4">
                                @if ($branch->is_active)
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-600 ring-1 ring-inset ring-emerald-600/20">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span> Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-50 px-3 py-1 text-xs font-bold text-gray-500 ring-1 ring-inset ring-gray-500/20">
                                        <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span> Inactive
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
                                <div class="flex items-center justify-end gap-2">
                                    <a
                                        href="{{ route('admin.branches.edit', $branch) }}"
                                        wire:navigate
                                        class="inline-flex items-center gap-1.5 rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-bold text-blue-600 transition-colors hover:bg-blue-100 hover:text-blue-700"
                                    >
                                        Edit
                                    </a>

                                    <button
                                        type="button"
                                        wire:click="delete({{ $branch->id }})"
                                        wire:confirm="Are you sure you want to delete this branch?"
                                        class="inline-flex items-center gap-1.5 rounded-lg bg-red-50 px-3 py-1.5 text-xs font-bold text-red-600 transition-colors hover:bg-red-100 hover:text-red-700"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                colspan="5"
                                class="px-6 py-12 text-center"
                            >
                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-50">
                                    <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                </div>
                                <p class="mt-4 text-sm font-medium text-gray-900">No branches found</p>
                                <p class="mt-1 text-sm text-gray-500">Get started by creating a new clinic branch.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>