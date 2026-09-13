<?php

use App\Models\Treatment;
use Livewire\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.admin')] class extends Component
{
    public function delete(int $treatmentId): void
    {
        $treatment = Treatment::findOrFail($treatmentId);

        if ($treatment->cover_image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($treatment->cover_image);
        }

        $treatment->delete();
    }

    public function with(): array
    {
        return [
            'treatments' => Treatment::with('category')
                ->orderBy('category_id')
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
            <div class="hidden sm:flex h-12 w-12 items-center justify-center rounded-2xl bg-rose-50 text-[var(--color-wfsc-coral)]">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
            </div>
            <div>
                <h1 class="text-2xl font-black tracking-tight text-[var(--color-wfsc-dark)]">
                    Treatments
                </h1>
                <p class="mt-1 text-sm font-medium text-gray-500">
                    Manage treatments displayed on the WFSC website.
                </p>
            </div>
        </div>

        <a href="{{ route('admin.treatments.create') }}" wire:navigate
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[var(--color-wfsc-coral)] to-[#ff7676] px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-[var(--color-wfsc-coral)]/30 transition-all duration-300 hover:scale-[1.02] hover:shadow-xl hover:shadow-[var(--color-wfsc-coral)]/40"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Treatment
        </a>
    </div>

    {{-- Table Card --}}
    <div class="overflow-hidden rounded-2xl border border-gray-100/50 bg-white elegant-shadow">
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-[#F4F6F9]">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Treatment</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Category</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Slug</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Featured</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-gray-500">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-50">
                    @forelse ($treatments as $treatment)
                        <tr class="transition-colors hover:bg-rose-50/30">
                            
                            {{-- Treatment Info --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    @if ($treatment->cover_image)
                                        <img src="{{ Storage::url($treatment->cover_image) }}" alt="{{ $treatment->name }}" class="h-14 w-14 rounded-2xl object-cover shadow-sm ring-2 ring-white">
                                    @else
                                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-rose-50 text-xs font-bold text-[var(--color-wfsc-coral)] ring-2 ring-white">
                                            No Image
                                        </div>
                                    @endif

                                    <div class="min-w-0">
                                        <p class="font-bold text-[var(--color-wfsc-dark)]">
                                            {{ $treatment->name }}
                                        </p>
                                        @if ($treatment->short_description)
                                            <p class="mt-0.5 max-w-xs truncate text-xs font-medium text-gray-400">
                                                {{ $treatment->short_description }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- Category --}}
                            <td class="whitespace-nowrap px-6 py-4">
                                <span class="inline-flex items-center rounded-lg bg-gray-100 px-2.5 py-1 text-xs font-bold text-gray-600">
                                    {{ $treatment->category?->name ?? '-' }}
                                </span>
                            </td>

                            {{-- Slug --}}
                            <td class="whitespace-nowrap px-6 py-4 text-xs font-mono font-medium text-gray-500">
                                {{ $treatment->slug }}
                            </td>

                            {{-- Featured Badge --}}
                            <td class="whitespace-nowrap px-6 py-4">
                                @if ($treatment->is_featured)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-3 py-1 text-xs font-bold text-amber-600 ring-1 ring-inset ring-amber-600/20">
                                        ★ Featured
                                    </span>
                                @else
                                    <span class="text-xs font-medium text-gray-300">—</span>
                                @endif
                            </td>

                            {{-- Status Badge --}}
                            <td class="whitespace-nowrap px-6 py-4">
                                @if ($treatment->is_active)
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-600 ring-1 ring-inset ring-emerald-600/20">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span> Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-3 py-1 text-xs font-bold text-red-600 ring-1 ring-inset ring-red-600/20">
                                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span> Inactive
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="whitespace-nowrap px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">

                                    <a href="{{ route('admin.treatments.videos.index', $treatment) }}" wire:navigate
                                        title="Procedure Videos"
                                        class="inline-flex items-center gap-1 rounded-lg bg-blue-50 px-2.5 py-1.5 text-xs font-bold text-blue-600 hover:bg-blue-100">
                                        <span>Videos</span>
                                    </a>

                                    <a href="{{ route('admin.treatments.before-afters.index', $treatment) }}" wire:navigate
                                        title="Before & After"
                                        class="inline-flex items-center gap-1 rounded-lg bg-purple-50 px-2.5 py-1.5 text-xs font-bold text-purple-600 hover:bg-purple-100">
                                        <span>B&A</span>
                                    </a>

                                    <a href="{{ route('admin.treatments.related-treatments.index', $treatment) }}" wire:navigate
                                        title="Related Treatments"
                                        class="inline-flex items-center gap-1 rounded-lg bg-indigo-50 px-2.5 py-1.5 text-xs font-bold text-indigo-600 hover:bg-indigo-100">
                                        <span>Related</span>
                                    </a>

                                    <a href="{{ route('admin.treatments.products.index', $treatment) }}" wire:navigate
                                        title="Related Skincare Products"
                                        class="inline-flex items-center gap-1 rounded-lg bg-emerald-50 px-2.5 py-1.5 text-xs font-bold text-emerald-600 hover:bg-emerald-100">
                                        <span>Products</span>
                                    </a>

                                    <a href="{{ route('admin.treatments.edit', $treatment) }}" wire:navigate
                                        class="inline-flex items-center rounded-lg bg-gray-100 px-2.5 py-1.5 text-xs font-bold text-gray-700 hover:bg-gray-200">
                                        Edit
                                    </a>

                                    <button type="button" wire:click="delete({{ $treatment->id }})" wire:confirm="Delete this treatment?"
                                        class="inline-flex items-center rounded-lg bg-red-50 px-2.5 py-1.5 text-xs font-bold text-red-600 hover:bg-red-100">
                                        Delete
                                    </button>

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-50">
                                    <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                </div>
                                <p class="mt-4 text-sm font-medium text-gray-900">No treatments found</p>
                                <p class="mt-1 text-sm text-gray-500">Get started by adding a new treatment.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

