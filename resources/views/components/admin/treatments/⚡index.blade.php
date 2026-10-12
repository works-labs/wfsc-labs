<?php

use App\Models\Treatment;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

new #[Layout('layouts.admin')] class extends Component
{
    use WithPagination;

    public function delete(int $treatmentId): void
    {
        $treatment = Treatment::findOrFail($treatmentId);

        if ($treatment->cover_image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($treatment->cover_image);
        }

        $treatment->delete();

        $this->resetPage();
    }

    public function with(): array
    {
        return [
            'treatments' => Treatment::with('category')
                ->orderBy('category_id')
                ->orderBy('name')
                ->paginate(10),
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
            Tambah Perawatan
        </a>
    </div>

    {{-- Table Card --}}
    <div class="overflow-hidden rounded-2xl border border-gray-100/50 bg-white elegant-shadow">
        
        <div class="overflow-x-auto">
            <table class="w-full table-fixed divide-y divide-gray-100">
                <colgroup>
                    <col class="w-[27%]">
                    <col class="w-[14%]">
                    <col class="w-[11%]">
                    <col class="w-[9%]">
                    <col class="w-[9%]">
                    <col class="w-[30%]">
                </colgroup>
                <thead class="sticky top-0 z-10 bg-[#F4F6F9] shadow-sm">
                    <tr>
                        <th class="px-3 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500 sm:px-6">Treatment</th>
                        <th class="border-l border-gray-200 px-3 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500 sm:px-6">Category</th>
                        <th class="border-l border-gray-200 px-3 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500 sm:px-6">Slug</th>
                        <th class="border-l border-gray-200 px-3 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500 sm:px-6">Featured</th>
                        <th class="border-l border-gray-200 px-3 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500 sm:px-6">Status</th>
                        <th class="border-l border-gray-200 px-3 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500 sm:px-6">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-300">
                    @forelse ($treatments as $treatment)
                        <tr class="border-b border-gray-200 even:bg-gray-100/70 transition-colors hover:bg-rose-50/70">
                            
                            {{-- Treatment Info --}}
                            <td class="align-top border-l border-gray-100 px-3 py-4 sm:px-6">
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
                                            <p class="mt-0.5 max-w-xs break-words text-xs font-medium text-gray-400">
                                                {{ $treatment->short_description }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- Category --}}
                            <td class="align-top px-3 py-4 sm:px-6">
                                <span class="inline-flex items-center rounded-lg bg-gray-100 px-2.5 py-1 text-xs font-bold text-gray-600">
                                    {{ $treatment->category?->name ?? '-' }}
                                </span>
                            </td>

                            {{-- Slug --}}
                            <td class="align-top break-words border-l border-gray-100 px-3 py-4 text-xs font-mono font-medium text-gray-500 sm:px-6">
                                {{ $treatment->slug }}
                            </td>

                            {{-- Featured Badge --}}
                            <td class="align-top border-l border-gray-100 px-3 py-4 sm:px-6">
                                @if ($treatment->is_featured)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-3 py-1 text-xs font-bold text-amber-600 ring-1 ring-inset ring-amber-600/20">
                                        ★ Featured
                                    </span>
                                @else
                                    <span class="text-xs font-medium text-gray-300">—</span>
                                @endif
                            </td>

                            {{-- Status Badge --}}
                            <td class="align-top border-l border-gray-100 px-3 py-4 sm:px-6">
                                @if ($treatment->is_active)
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-600 ring-1 ring-inset ring-emerald-600/20">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span> Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-3 py-1 text-xs font-bold text-red-600 ring-1 ring-inset ring-red-600/20">
                                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span> Nonaktif
                                    </span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="align-top border-l border-gray-100 px-3 py-4 text-left sm:px-6">
                                <div class="flex flex-wrap items-center justify-start gap-1.5">

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

                                    <button type="button" wire:click="delete({{ $treatment->id }})" wire:confirm="Apakah Anda yakin ingin menghapus data ini?"
                                        class="inline-flex items-center rounded-lg bg-red-50 px-2.5 py-1.5 text-xs font-bold text-red-600 hover:bg-red-100">
                                        Hapus
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

        @if ($treatments->hasPages())
            <div class="border-t border-gray-100 bg-gray-50/50 px-6 py-4">
                {{ $treatments->links() }}
            </div>
        @endif
    </div>

</div>
