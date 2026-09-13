<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\DoctorHomeSection;

new #[Layout('layouts.admin')] class extends Component
{
    public function delete(int $sectionId): void
{
    $section = DoctorHomeSection::with('doctor')
        ->findOrFail($sectionId);

    if ($section->isFounder()) {
        session()->flash(
            'error',
            'Founder doctor cannot be removed from the Home page.'
        );

        return;
    }

    $section->delete();

    session()->flash(
        'success',
        'Doctor home section deleted successfully.'
    );
}

    public function with(): array
    {
        return [
            'sections' => DoctorHomeSection::with('doctor')
                ->orderBy('section')
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get(),
        ];
    }
};
?>

<div class="mx-auto max-w-7xl space-y-6">

    {{-- Header Card --}}
    <div class="flex flex-col gap-4 rounded-2xl border border-gray-100/50 bg-white p-6 elegant-shadow sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-4">
            <div class="hidden sm:flex h-12 w-12 items-center justify-center rounded-2xl bg-teal-50 text-teal-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <div>
                <h1 class="text-2xl font-black tracking-tight text-[var(--color-wfsc-dark)]">
                    Doctor Home Sections
                </h1>
                <p class="mt-1 text-sm font-medium text-gray-500">
                    Manage doctors displayed in the Home page sections.
                </p>
            </div>
        </div>

        <a href="{{ route('admin.home.doctor-home-sections.create') }}" wire:navigate
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[var(--color-wfsc-coral)] to-[#ff7676] px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-[var(--color-wfsc-coral)]/30 transition-all duration-300 hover:scale-[1.02] hover:shadow-xl hover:shadow-[var(--color-wfsc-coral)]/40"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Doctor
        </a>
    </div>

    {{-- Flash Messages --}}
    @if (session('success'))
        <div class="flex items-center gap-3 rounded-2xl border border-emerald-100 bg-emerald-50 px-6 py-4 text-sm font-bold text-emerald-700 shadow-sm">
            <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="flex items-center gap-3 rounded-2xl border border-red-100 bg-red-50 px-6 py-4 text-sm font-bold text-red-700 shadow-sm">
            <svg class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Table Card --}}
    <div class="overflow-hidden rounded-2xl border border-gray-100/50 bg-white elegant-shadow">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-[#F4F6F9]">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                            Doctor
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                            Section
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                            Sort Order
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
                    @forelse ($sections as $section)
                        <tr class="transition-colors hover:bg-rose-50/30">
                            {{-- Doctor info & Founder Badge --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-[var(--color-wfsc-dark)]">
                                                {{ $section->doctor?->title }} {{ $section->doctor?->name }}
                                            </span>

                                            @if ($section->isFounder())
                                                <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-0.5 text-[10px] font-extrabold uppercase tracking-wide text-amber-700 ring-1 ring-inset ring-amber-600/20">
                                                    ♛ Founder
                                                </span>
                                            @endif
                                        </div>

                                        @if ($section->doctor?->specialization)
                                            <div class="mt-0.5 text-xs font-medium text-gray-400">
                                                {{ $section->doctor->specialization }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- Section --}}
                            <td class="whitespace-nowrap px-6 py-4">
                                <span class="inline-flex items-center rounded-lg bg-blue-50 px-3 py-1 text-xs font-bold text-blue-600">
                                    {{ ucfirst($section->section) }}
                                </span>
                            </td>

                            {{-- Sort Order --}}
                            <td class="whitespace-nowrap px-6 py-4">
                                <span class="inline-flex items-center justify-center rounded-lg bg-gray-100 px-2.5 py-1 text-xs font-bold text-gray-600">
                                    #{{ $section->sort_order }}
                                </span>
                            </td>

                            {{-- Status --}}
                            <td class="whitespace-nowrap px-6 py-4">
                                @if ($section->is_active)
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
                                        href="{{ route('admin.home.doctor-home-sections.edit', $section) }}"
                                        wire:navigate
                                        class="inline-flex items-center gap-1.5 rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-bold text-blue-600 transition-colors hover:bg-blue-100 hover:text-blue-700"
                                    >
                                        Edit
                                    </a>

                                    @if ($section->isFounder())
                                        <span class="inline-flex items-center gap-1 rounded-lg bg-amber-50 px-3 py-1.5 text-xs font-bold text-amber-700">
                                            ♛ Protected
                                        </span>
                                    @else
                                        <button
                                            type="button"
                                            wire:click="delete({{ $section->id }})"
                                            wire:confirm="Are you sure you want to remove this doctor from the Home section?"
                                            class="inline-flex items-center gap-1.5 rounded-lg bg-red-50 px-3 py-1.5 text-xs font-bold text-red-600 transition-colors hover:bg-red-100 hover:text-red-700"
                                        >
                                            Delete
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-50">
                                    <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                </div>
                                <p class="mt-4 text-sm font-medium text-gray-900">No doctor home sections found.</p>
                                <p class="mt-1 text-sm text-gray-500">Assign a doctor to showcase them on the homepage.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>