<?php

use App\Models\Doctor;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

new #[Layout('layouts.admin')] class extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function delete(int $doctorId): void
    {
        $doctor = Doctor::findOrFail($doctorId);

        if ($doctor->isFounder()) {
            session()->flash(
                'error',
                'Founder doctor cannot be deleted.'
            );

            return;
        }

        $photo = $doctor->photo;

        $doctor->delete();

        if ($photo && Storage::disk('public')->exists($photo)) {
            Storage::disk('public')->delete($photo);
        }

        $this->resetPage();
    }

    public function with(): array
    {
        return [
            'doctors' => Doctor::query()
                ->when(
                    $this->search,
                    fn ($query) => $query->where(function ($query) {
                        $query
                            ->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('specialization', 'like', '%' . $this->search . '%');
                    })
                )
                ->latest()
                ->paginate(10),
        ];
    }
};
?>

<div class="mx-auto max-w-7xl space-y-6">

    {{-- Header Card --}}
    <div class="flex flex-col gap-4 rounded-2xl border border-gray-100/50 bg-white p-6 elegant-shadow sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-4">
            <div class="hidden sm:flex h-12 w-12 items-center justify-center rounded-full bg-rose-50 text-[var(--color-wfsc-coral)]">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <div>
                <h1 class="text-2xl font-black tracking-tight text-[var(--color-wfsc-dark)]">
                    Doctors
                </h1>
                <p class="mt-1 text-sm font-medium text-gray-500">
                    Manage doctors displayed on the WFSC website.
                </p>
            </div>
        </div>

        <a href="{{ route('admin.doctors.create') }}" wire:navigate
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[var(--color-wfsc-coral)] to-[#ff7676] px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-[var(--color-wfsc-coral)]/30 transition-all duration-300 hover:scale-[1.02] hover:shadow-xl hover:shadow-[var(--color-wfsc-coral)]/40"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Doctor
        </a>
    </div>

    {{-- Search Bar --}}
    <div class="relative max-w-md">
        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
        <input
            type="search"
            wire:model.live.debounce.300ms="search"
            placeholder="Search doctors by name or specialization..."
            class="w-full rounded-xl border border-gray-200 bg-white py-3 pl-11 pr-4 text-sm elegant-shadow transition-all focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
        >
    </div>

    {{-- Table Card --}}
    <div class="overflow-hidden rounded-2xl border border-gray-100/50 bg-white elegant-shadow">
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-[#F4F6F9]">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Doctor</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Specialization</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Experience</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-gray-500">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-50">
                    @forelse ($doctors as $doctor)
                        <tr class="transition-colors hover:bg-rose-50/30">
                            
                            {{-- Profile Info --}}
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center gap-4">
                                    @if ($doctor->photo)
                                        <img src="{{ asset('storage/' . $doctor->photo) }}" alt="{{ $doctor->name }}" class="h-11 w-11 rounded-full object-cover shadow-sm ring-2 ring-white">
                                    @else
                                        <div class="flex h-11 w-11 items-center justify-center rounded-full bg-rose-100 text-sm font-bold text-[var(--color-wfsc-coral)] ring-2 ring-white">
                                            {{ strtoupper(substr($doctor->name, 0, 1)) }}
                                        </div>
                                    @endif

                                    <div>
                                        <div class="font-bold text-[var(--color-wfsc-dark)]">
                                            {{ $doctor->title }} {{ $doctor->name }}
                                        </div>
                                        <div class="mt-1 flex items-center gap-2">
                                            @if ($doctor->isFounder())
                                                <span class="inline-flex items-center gap-1 rounded-md bg-amber-100/80 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide text-amber-700">
                                                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.715-5.349L11 6.477V16h2a1 1 0 110 2H7a1 1 0 110-2h2V6.477L6.237 7.582l1.715 5.349a1 1 0 01-.285 1.05A3.989 3.989 0 015 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.617a1 1 0 01.894-1.788l1.599.799L9 4.323V3a1 1 0 011-1z" clip-rule="evenodd"/></svg>
                                                    Founder
                                                </span>
                                            @endif
                                            <div class="text-xs font-medium text-gray-400">
                                                {{ $doctor->slug }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-600">
                                {{ $doctor->specialization ?? '-' }}
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-600">
                                {{ $doctor->experience ?? '-' }}
                            </td>

                            <td class="whitespace-nowrap px-6 py-4">
                                @if ($doctor->is_active)
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-600 ring-1 ring-inset ring-emerald-600/20">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span> Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-50 px-3 py-1 text-xs font-bold text-gray-500 ring-1 ring-inset ring-gray-500/20">
                                        <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span> Inactive
                                    </span>
                                @endif
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.doctors.edit', $doctor) }}" wire:navigate
                                        class="inline-flex items-center gap-1.5 rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-bold text-blue-600 transition-colors hover:bg-blue-100 hover:text-blue-700">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        Edit
                                    </a>

                                    @if ($doctor->isFounder())
                                        <span class="inline-flex items-center gap-1 rounded-lg bg-amber-50 px-3 py-1.5 text-xs font-bold text-amber-700 opacity-70">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                            Protected
                                        </span>
                                    @else
                                        <button type="button" wire:click="delete({{ $doctor->id }})" wire:confirm="Are you sure you want to delete this doctor?"
                                            class="inline-flex items-center gap-1.5 rounded-lg bg-red-50 px-3 py-1.5 text-xs font-bold text-red-600 transition-colors hover:bg-red-100 hover:text-red-700">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
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
                                    <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                </div>
                                <p class="mt-4 text-sm font-medium text-gray-900">No doctors found</p>
                                <p class="mt-1 text-sm text-gray-500">Get started by creating a new doctor profile.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($doctors->hasPages())
            <div class="border-t border-gray-100 bg-gray-50/50 px-6 py-4">
                {{ $doctors->links() }}
            </div>
        @endif
    </div>
</div>