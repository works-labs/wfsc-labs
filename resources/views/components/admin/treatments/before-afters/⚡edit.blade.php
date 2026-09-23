<?php

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use App\Models\Treatment;
use App\Models\TreatmentBeforeAfter;
use Illuminate\Support\Facades\Storage;

new #[Layout('layouts.admin')] class extends Component
{
    use WithFileUploads;

    public Treatment $treatment;
    public TreatmentBeforeAfter $beforeAfter;

    public $before_media = null;
    public $after_media = null;

    public string $caption = '';
    public int $sort_order = 0;
    public bool $is_active = true;

    public function mount(
        Treatment $treatment,
        TreatmentBeforeAfter $beforeAfter
    ): void {
        $this->treatment = $treatment;
        $this->beforeAfter = $beforeAfter;

        $this->caption = $beforeAfter->caption ?? '';
        $this->sort_order = (int) $beforeAfter->sort_order;
        $this->is_active = (bool) $beforeAfter->is_active;
    }

    public function update(): void
    {
        $validated = $this->validate([
            'before_media' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,webp,avif,mp4,webm,mov',
                'max:51200',
            ],

            'after_media' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,webp,avif,mp4,webm,mov',
                'max:51200',
            ],

            'caption' => ['nullable', 'string'],

            'sort_order' => [
                'required',
                'integer',
                'min:0',
            ],

            'is_active' => ['boolean'],
        ]);

        if ($this->before_media) {
            if (
                $this->beforeAfter->before_media &&
                Storage::disk('public')->exists(
                    $this->beforeAfter->before_media
                )
            ) {
                Storage::disk('public')->delete(
                    $this->beforeAfter->before_media
                );
            }

            $validated['before_media'] = $this->before_media->store(
                'treatments/before-after',
                'public'
            );
        }

        if ($this->after_media) {
            if (
                $this->beforeAfter->after_media &&
                Storage::disk('public')->exists(
                    $this->beforeAfter->after_media
                )
            ) {
                Storage::disk('public')->delete(
                    $this->beforeAfter->after_media
                );
            }

            $validated['after_media'] = $this->after_media->store(
                'treatments/before-after',
                'public'
            );
        }

        $this->beforeAfter->update([
            'before_media' =>
                $validated['before_media']
                ?? $this->beforeAfter->before_media,

            'after_media' =>
                $validated['after_media']
                ?? $this->beforeAfter->after_media,

            'caption' => $validated['caption'],
            'sort_order' => $validated['sort_order'],
            'is_active' => $validated['is_active'],
        ]);

        session()->flash(
            'success',
            'Before & After berhasil diperbarui.'
        );

        $this->redirect(
            route(
                'admin.treatments.before-afters.index',
                $this->treatment
            ),
            navigate: true
        );
    }
};
?>

<div class="mx-auto max-w-4xl space-y-8 pb-10">

    {{-- Top Navigation & Header --}}
    <div>
        <a href="{{ route('admin.treatments.before-afters.index', $treatment) }}" wire:navigate 
            class="inline-flex items-center gap-2 text-sm font-bold text-gray-400 transition-colors hover:text-[var(--color-wfsc-coral)]">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to Before & After
        </a>
        <div class="mt-4 flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-500 shadow-sm">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
            </div>
            <div>
                <h1 class="text-2xl font-black tracking-tight text-[var(--color-wfsc-dark)]">Edit Before & After</h1>
                <p class="text-sm font-medium text-gray-500">
                    Update comparison media for <span class="font-bold text-[var(--color-wfsc-coral)]">{{ $treatment->name }}</span>
                </p>
            </div>
        </div>
    </div>

    <form wire:submit="update" class="space-y-8">

        {{-- Media Upload & Preview Card --}}
        <div class="relative overflow-hidden rounded-2xl border border-gray-100/50 bg-white p-8 elegant-shadow">
            <div class="absolute left-0 top-0 h-full w-1 bg-purple-400"></div>
            
            <div class="mb-2 flex items-center gap-3">
                <div class="rounded-lg bg-purple-50 p-2 text-purple-500">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h2 class="text-lg font-bold text-[var(--color-wfsc-dark)]">Media Files</h2>
            </div>
            <p class="mb-6 text-xs font-medium text-gray-400">Pilih file baru hanya jika ingin mengganti media saat ini.</p>

            <div class="grid gap-8 md:grid-cols-2">

                {{-- BEFORE --}}
                <div class="space-y-3">
                    <label class="block text-sm font-bold text-gray-600">Before Media</label>

                    {{-- Current Media --}}
                    <div class="overflow-hidden rounded-2xl bg-gray-50 shadow-sm ring-2 ring-gray-100">
                        @php
                            $url = Storage::url($beforeAfter->before_media);
                            $extension = strtolower(pathinfo($beforeAfter->before_media, PATHINFO_EXTENSION));
                        @endphp

                        @if (in_array($extension, ['mp4', 'webm', 'mov']))
                            <video controls class="h-48 w-full bg-black object-contain">
                                <source src="{{ $url }}">
                            </video>
                        @else
                            <img src="{{ $url }}" alt="Before" class="h-48 w-full object-cover">
                        @endif
                    </div>

                    <p class="text-xs font-medium text-gray-400 truncate">
                        Current: {{ basename($beforeAfter->before_media) }}
                    </p>

                    {{-- New File --}}
                    <input type="file" wire:model="before_media" accept="image/*,video/*" 
                        class="block w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-2 text-sm text-gray-600 transition-colors file:mr-4 file:rounded-lg file:border-0 file:bg-white file:px-4 file:py-1.5 file:text-xs file:font-bold file:text-[var(--color-wfsc-coral)] file:shadow-sm hover:file:bg-rose-50 focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]">

                    @if ($before_media)
                        <p class="text-xs font-bold text-[var(--color-wfsc-coral)]">
                            File baru: {{ $before_media->getClientOriginalName() }}
                        </p>
                    @endif

                    <div wire:loading wire:target="before_media" class="text-xs font-bold text-[var(--color-wfsc-coral)] flex items-center gap-1.5">
                        <svg class="h-3.5 w-3.5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Uploading preview...
                    </div>

                    @error('before_media') <p class="text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- AFTER --}}
                <div class="space-y-3">
                    <label class="block text-sm font-bold text-gray-600">After Media</label>

                    {{-- Current Media --}}
                    <div class="overflow-hidden rounded-2xl bg-gray-50 shadow-sm ring-2 ring-gray-100">
                        @php
                            $url = Storage::url($beforeAfter->after_media);
                            $extension = strtolower(pathinfo($beforeAfter->after_media, PATHINFO_EXTENSION));
                        @endphp

                        @if (in_array($extension, ['mp4', 'webm', 'mov']))
                            <video controls class="h-48 w-full bg-black object-contain">
                                <source src="{{ $url }}">
                            </video>
                        @else
                            <img src="{{ $url }}" alt="After" class="h-48 w-full object-cover">
                        @endif
                    </div>

                    <p class="text-xs font-medium text-gray-400 truncate">
                        Current: {{ basename($beforeAfter->after_media) }}
                    </p>

                    {{-- New File --}}
                    <input type="file" wire:model="after_media" accept="image/*,video/*" 
                        class="block w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-2 text-sm text-gray-600 transition-colors file:mr-4 file:rounded-lg file:border-0 file:bg-white file:px-4 file:py-1.5 file:text-xs file:font-bold file:text-emerald-600 file:shadow-sm hover:file:bg-emerald-50 focus:bg-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">

                    @if ($after_media)
                        <p class="text-xs font-bold text-emerald-600">
                            File baru: {{ $after_media->getClientOriginalName() }}
                        </p>
                    @endif

                    <div wire:loading wire:target="after_media" class="text-xs font-bold text-emerald-600 flex items-center gap-1.5">
                        <svg class="h-3.5 w-3.5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Uploading preview...
                    </div>

                    @error('after_media') <p class="text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                </div>

            </div>
        </div>

        {{-- Information & Settings Card --}}
        <div class="relative overflow-hidden rounded-2xl border border-gray-100/50 bg-white p-8 elegant-shadow">
            <div class="absolute left-0 top-0 h-full w-1 bg-blue-400"></div>
            
            <div class="mb-6 flex items-center gap-3">
                <div class="rounded-lg bg-blue-50 p-2 text-blue-500">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h2 class="text-lg font-bold text-[var(--color-wfsc-dark)]">Information & Settings</h2>
            </div>

            <div class="space-y-6">
                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Caption</label>
                    <textarea wire:model="caption" rows="4" placeholder="Deskripsi atau keterangan Before & After..." 
                        class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"></textarea>
                    @error('caption') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Sort Order</label>
                    <input type="number" wire:model="sort_order" min="0" 
                        class="w-full max-w-xs rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]">
                    @error('sort_order') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                </div>

                <label class="inline-flex items-center gap-3 rounded-xl border border-gray-100 bg-gray-50 p-4 transition-colors hover:bg-gray-100">
                    <input type="checkbox" wire:model="is_active" class="h-5 w-5 rounded-md border-gray-300 text-[var(--color-wfsc-coral)] focus:ring-[var(--color-wfsc-coral)]">
                    <div>
                        <span class="block text-sm font-bold text-gray-800">Set as Aktif Comparison</span>
                        <span class="block text-xs font-medium text-gray-500">Media will be visible in the treatment showcase.</span>
                    </div>
                </label>
            </div>
        </div>

        {{-- Aksi --}}
        <div class="flex items-center justify-end gap-4 pt-4">
            <a href="{{ route('admin.treatments.before-afters.index', $treatment) }}" wire:navigate 
                class="rounded-xl px-5 py-3 text-sm font-bold text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-800">
                Batal
            </a>

            <button type="submit" wire:loading.attr="disabled" 
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[var(--color-wfsc-coral)] to-[#ff7676] px-8 py-3 text-sm font-bold text-white shadow-lg shadow-[var(--color-wfsc-coral)]/30 transition-all duration-300 hover:scale-[1.02] hover:shadow-xl hover:shadow-[var(--color-wfsc-coral)]/40 disabled:opacity-70 disabled:hover:scale-100">
                <span wire:loading.remove>Update</span>
                <span wire:loading>
                    <svg class="h-4 w-4 animate-spin text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Updating...
                </span>
            </button>
        </div>

    </form>
</div>