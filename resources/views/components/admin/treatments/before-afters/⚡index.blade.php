<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use App\Models\Treatment;
use App\Models\TreatmentBeforeAfter;
use Illuminate\Support\Facades\Storage;


new #[Layout('layouts.admin')] class extends Component
{
    public Treatment $treatment;

    public function mount(Treatment $treatment): void
    {
        $this->treatment = $treatment;
    }

    #[Computed]
    public function beforeAfters()
    {
        return TreatmentBeforeAfter::query()
            ->where('treatment_id', $this->treatment->id)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
    }

    public function delete(int $id): void
    {
        $beforeAfter = TreatmentBeforeAfter::query()
            ->where('treatment_id', $this->treatment->id)
            ->findOrFail($id);

        if ($beforeAfter->before_media) {
            Storage::disk('public')->delete($beforeAfter->before_media);
        }

        if ($beforeAfter->after_media) {
            Storage::disk('public')->delete($beforeAfter->after_media);
        }

        $beforeAfter->delete();

        session()->flash(
            'success',
            'Before & After berhasil dihapus.'
        );
    }
};
?>

<div class="mx-auto max-w-6xl space-y-6">

    {{-- Header Card --}}
    <div class="flex flex-col gap-4 rounded-2xl border border-gray-100/50 bg-white p-6 elegant-shadow sm:flex-row sm:items-center sm:justify-between">
        <div>
            <a href="{{ route('admin.treatments.index') }}" wire:navigate 
                class="inline-flex items-center gap-2 text-xs font-bold text-gray-400 transition-colors hover:text-[var(--color-wfsc-coral)]">
                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar Perawatan
            </a>
            
            <div class="mt-3 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-purple-50 text-purple-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                </div>
                <div>
                    <h1 class="text-2xl font-black tracking-tight text-[var(--color-wfsc-dark)]">
                        Before & After
                    </h1>
                    <p class="text-xs font-medium text-gray-500">
                        Manage results for <span class="font-bold text-[var(--color-wfsc-coral)]">{{ $treatment->name }}</span>
                    </p>
                </div>
            </div>
        </div>

        <a href="{{ route('admin.treatments.before-afters.create', $treatment) }}" wire:navigate
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[var(--color-wfsc-coral)] to-[#ff7676] px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-[var(--color-wfsc-coral)]/30 transition-all duration-300 hover:scale-[1.02] hover:shadow-xl hover:shadow-[var(--color-wfsc-coral)]/40">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Sebelum & Sesudah
        </a>
    </div>

    {{-- Alert Notification --}}
    @if (session('success'))
        <div class="flex items-center gap-3 rounded-2xl border border-emerald-100 bg-emerald-50 px-6 py-4 text-sm font-bold text-emerald-700 shadow-sm">
            <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- List Cards --}}
    @if ($this->beforeAfters->isEmpty())
        <div class="overflow-hidden rounded-2xl border border-gray-100/50 bg-white p-16 text-center elegant-shadow">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-purple-50 text-purple-600">
                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <h3 class="mt-4 text-base font-bold text-[var(--color-wfsc-dark)]">Belum ada Before & After</h3>
            <p class="mt-1 text-xs font-medium text-gray-400">Tambahkan hasil komparasi treatment untuk ditampilkan pada website.</p>
            <a href="{{ route('admin.treatments.before-afters.create', $treatment) }}" wire:navigate
                class="mt-6 inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-[var(--color-wfsc-coral)] to-[#ff7676] px-5 py-2.5 text-xs font-bold text-white shadow-md shadow-[var(--color-wfsc-coral)]/30 transition-all hover:scale-105">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambahkan Before & After
            </a>
        </div>
    @else
        <div class="space-y-6">
            @foreach ($this->beforeAfters as $beforeAfter)
                <div class="overflow-hidden rounded-2xl border border-gray-100/50 bg-white elegant-shadow">
                    <div class="grid gap-6 p-6 md:grid-cols-2">

                        {{-- Before --}}
                        <div>
                            <span class="mb-3 inline-block rounded-lg bg-rose-50 px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-[var(--color-wfsc-coral)]">
                                Before
                            </span>

                            @php
                                $beforeUrl = Storage::url($beforeAfter->before_media);
                                $beforeExtension = strtolower(pathinfo($beforeAfter->before_media, PATHINFO_EXTENSION));
                            @endphp

                            @if (in_array($beforeExtension, ['mp4', 'webm', 'mov']))
                                <video controls class="h-56 w-full rounded-2xl bg-black object-contain shadow-sm ring-2 ring-gray-50">
                                    <source src="{{ $beforeUrl }}" type="video/{{ $beforeExtension === 'mov' ? 'quicktime' : $beforeExtension }}">
                                    Browser kamu tidak mendukung video.
                                </video>
                            @else
                                <img src="{{ $beforeUrl }}" alt="Before" class="h-56 w-full rounded-2xl object-cover shadow-sm ring-2 ring-gray-50">
                            @endif
                        </div>

                        {{-- After --}}
                        <div>
                            <span class="mb-3 inline-block rounded-lg bg-emerald-50 px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-emerald-600">
                                After
                            </span>

                            @php
                                $afterUrl = Storage::url($beforeAfter->after_media);
                                $afterExtension = strtolower(pathinfo($beforeAfter->after_media, PATHINFO_EXTENSION));
                            @endphp

                            @if (in_array($afterExtension, ['mp4', 'webm', 'mov']))
                                <video controls class="h-56 w-full rounded-2xl bg-black object-contain shadow-sm ring-2 ring-gray-50">
                                    <source src="{{ $afterUrl }}" type="video/{{ $afterExtension === 'mov' ? 'quicktime' : $afterExtension }}">
                                    Browser kamu tidak mendukung video.
                                </video>
                            @else
                                <img src="{{ $afterUrl }}" alt="After" class="h-56 w-full rounded-2xl object-cover shadow-sm ring-2 ring-gray-50">
                            @endif
                        </div>
                    </div>

                    {{-- Card Footer & Aksi --}}
                    <div class="border-t border-gray-100 bg-gray-50/50 px-6 py-4">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                            <div>
                                @if ($beforeAfter->caption)
                                    <p class="text-xs font-bold text-[var(--color-wfsc-dark)] leading-relaxed">
                                        {{ $beforeAfter->caption }}
                                    </p>
                                @endif

                                <div class="mt-1 flex items-center gap-3 text-xs font-medium text-gray-400">
                                    <span>Sort Order: #{{ $beforeAfter->sort_order }}</span>
                                    <span>•</span>
                                    @if ($beforeAfter->is_active)
                                        <span class="inline-flex items-center gap-1.5 font-bold text-emerald-600">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span> Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 font-bold text-gray-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span> Nonaktif
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.treatments.before-afters.edit', [$treatment, $beforeAfter]) }}" wire:navigate
                                    class="inline-flex items-center gap-1.5 rounded-xl bg-blue-50 px-3.5 py-2 text-xs font-bold text-blue-600 transition-colors hover:bg-blue-100 hover:text-blue-700">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    Edit
                                </a>

                                <button type="button" wire:click="delete({{ $beforeAfter->id }})" wire:confirm="Apakah Anda yakin ingin menghapus data ini?"
                                    class="inline-flex items-center gap-1.5 rounded-xl bg-red-50 px-3.5 py-2 text-xs font-bold text-red-600 transition-colors hover:bg-red-100 hover:text-red-700">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>