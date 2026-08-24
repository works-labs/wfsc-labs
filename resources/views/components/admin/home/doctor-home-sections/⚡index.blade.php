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

<div>
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold">
                Doctor Home Sections
            </h1>

            <p class="mt-2 text-gray-600">
                Manage doctors displayed in the Home page sections.
            </p>
        </div>

        <a
            href="{{ route('admin.home.doctor-home-sections.create') }}"
            wire:navigate
            class="rounded-lg bg-black px-5 py-2 font-semibold text-white"
        >
            Add Doctor
        </a>
    </div>

    @if (session('success'))
    <div class="mb-6 rounded-lg bg-green-100 px-4 py-3 text-sm text-green-700">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="mb-6 rounded-lg bg-red-100 px-4 py-3 text-sm text-red-700">
        {{ session('error') }}
    </div>
@endif

    <div class="overflow-hidden rounded-xl bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="border-b bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-sm font-semibold">
                            Doctor
                        </th>

                        <th class="px-6 py-4 text-sm font-semibold">
                            Section
                        </th>

                        <th class="px-6 py-4 text-sm font-semibold">
                            Sort Order
                        </th>

                        <th class="px-6 py-4 text-sm font-semibold">
                            Status
                        </th>

                        <th class="px-6 py-4 text-sm font-semibold">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse ($sections as $section)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="font-medium">
                                    {{ $section->doctor?->title }}
                                    {{ $section->doctor?->name }}
                                </div>

                                @if ($section->isFounder())
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide text-amber-700">
                                        ♛ Founder
                                    </span>
                                @endif
                                @if ($section->doctor?->specialization)
                                    <div class="mt-1 text-sm text-gray-500">
                                        {{ $section->doctor->specialization }}
                                    </div>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700">
                                    {{ ucfirst($section->section) }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                {{ $section->sort_order }}
                            </td>

                            <td class="px-6 py-4">
                                @if ($section->is_active)
                                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                        Active
                                    </span>
                                @else
                                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <a
                                        href="{{ route('admin.home.doctor-home-sections.edit', $section) }}"
                                        wire:navigate
                                        class="text-sm font-medium text-blue-600 hover:underline"
                                    >
                                        Edit
                                    </a>

                                    @if ($section->isFounder())

                                        <span class="text-sm font-medium text-amber-600">
                                            ♛ Protected
                                        </span>

                                    @else

                                        <button
                                            type="button"
                                            wire:click="delete({{ $section->id }})"
                                            wire:confirm="Are you sure you want to remove this doctor from the Home section?"
                                            class="text-sm font-medium text-red-600 hover:underline"
                                        >
                                            Delete
                                        </button>

                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                colspan="5"
                                class="px-6 py-12 text-center text-gray-500"
                            >
                                No doctor home sections found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>