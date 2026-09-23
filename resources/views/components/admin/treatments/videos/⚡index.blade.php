<?php

use App\Models\Treatment;
use App\Models\TreatmentVideo;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.admin')] class extends Component
{
    public Treatment $treatment;

    public function mount(Treatment $treatment): void
    {
        $this->treatment = $treatment;
    }

    public function delete(TreatmentVideo $video): void
    {
        abort_unless($video->treatment_id === $this->treatment->id, 404);

        $video->delete();

        session()->flash('success', 'Procedure video deleted successfully.');
    }

    public function with(): array
    {
        return [
            'videos' => $this->treatment
                ->procedureVideos()
                ->orderBy('sort_order')
                ->get(),
        ];
    }
};
?>

<div class="mx-auto max-w-6xl space-y-6">

    {{-- Top Navigation & Header Card --}}
    <div class="flex flex-col gap-4 rounded-2xl border border-gray-100/50 bg-white p-6 elegant-shadow sm:flex-row sm:items-center sm:justify-between">
        <div>
            <a href="{{ route('admin.treatments.index') }}" wire:navigate 
                class="inline-flex items-center gap-2 text-xs font-bold text-gray-400 transition-colors hover:text-[var(--color-wfsc-coral)]">
                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar Perawatan
            </a>
            
            <div class="mt-3 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-rose-50 text-[var(--color-wfsc-coral)]">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h1 class="text-2xl font-black tracking-tight text-[var(--color-wfsc-dark)]">
                        Procedure Videos
                    </h1>
                    <p class="text-xs font-medium text-gray-500">
                        Manage videos for <span class="font-bold text-[var(--color-wfsc-coral)]">{{ $treatment->name }}</span>
                    </p>
                </div>
            </div>
        </div>

        <a href="{{ route('admin.treatments.videos.create', $treatment) }}" wire:navigate
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[var(--color-wfsc-coral)] to-[#ff7676] px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-[var(--color-wfsc-coral)]/30 transition-all duration-300 hover:scale-[1.02] hover:shadow-xl hover:shadow-[var(--color-wfsc-coral)]/40">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Video
        </a>
    </div>

    {{-- Alert Notification --}}
    @if (session('success'))
        <div class="flex items-center gap-3 rounded-2xl border border-emerald-100 bg-emerald-50 px-6 py-4 text-sm font-bold text-emerald-700 shadow-sm">
            <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Videos List Card --}}
    <div class="overflow-hidden rounded-2xl border border-gray-100/50 bg-white elegant-shadow">

        @if ($videos->isEmpty())

            <div class="px-6 py-16 text-center">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-rose-50 text-[var(--color-wfsc-coral)]">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="mt-4 text-base font-bold text-[var(--color-wfsc-dark)]">No procedure videos yet</h3>
                <p class="mt-1 text-xs font-medium text-gray-400">Add YouTube Shorts or videos to showcase this procedure.</p>
                <a href="{{ route('admin.treatments.videos.create', $treatment) }}" wire:navigate
                    class="mt-6 inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-[var(--color-wfsc-coral)] to-[#ff7676] px-5 py-2.5 text-xs font-bold text-white shadow-md shadow-[var(--color-wfsc-coral)]/30 transition-all hover:scale-105">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Add First Video
                </a>
            </div>

        @else

            <div class="divide-y divide-gray-100">

                @foreach ($videos as $video)

                    <div class="flex flex-col gap-6 p-6 transition-colors hover:bg-rose-50/20 sm:flex-row sm:items-center">

                        {{-- YouTube Shorts Preview Thumbnail --}}
                        <div class="relative h-36 w-24 shrink-0 overflow-hidden rounded-2xl bg-black shadow-md ring-2 ring-white">
                            <iframe
                                class="h-full w-full pointer-events-none"
                                src="https://www.youtube.com/embed/{{ str($video->video_path)->afterLast('/') }}"
                                title="YouTube Shorts Preview"
                                frameborder="0"
                            ></iframe>
                            <div class="absolute inset-0 bg-black/10"></div>
                        </div>

                        {{-- Information --}}
                        <div class="min-w-0 flex-1 space-y-2">

                            <div class="flex flex-wrap items-center gap-3">
                                <h2 class="text-base font-bold text-[var(--color-wfsc-dark)]">
                                    {{ $video->title ?: 'Untitled Video' }}
                                </h2>

                                @if ($video->is_active)
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-0.5 text-xs font-bold text-emerald-600 ring-1 ring-inset ring-emerald-600/20">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span> Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-50 px-3 py-0.5 text-xs font-bold text-gray-500 ring-1 ring-inset ring-gray-500/20">
                                        <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span> Nonaktif
                                    </span>
                                @endif
                            </div>

                            @if ($video->description)
                                <p class="line-clamp-2 text-xs font-medium text-gray-500 leading-relaxed">
                                    {{ $video->description }}
                                </p>
                            @endif

                            <div class="flex items-center gap-2 pt-1">
                                <span class="inline-flex items-center justify-center rounded-lg bg-gray-100 px-2.5 py-1 text-[11px] font-bold text-gray-500">
                                    Sort Order: #{{ $video->sort_order }}
                                </span>
                            </div>

                        </div>

                        {{-- Aksi --}}
                        <div class="flex shrink-0 items-center gap-2 sm:self-center">

                            <a href="{{ route('admin.treatments.videos.edit', [$treatment, $video]) }}" wire:navigate
                                class="inline-flex items-center gap-1.5 rounded-xl bg-blue-50 px-3.5 py-2 text-xs font-bold text-blue-600 transition-colors hover:bg-blue-100 hover:text-blue-700">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                Edit
                            </a>

                            <button type="button" wire:click="delete({{ $video->id }})" wire:confirm="Apakah Anda yakin ingin menghapus data ini?"
                                class="inline-flex items-center gap-1.5 rounded-xl bg-red-50 px-3.5 py-2 text-xs font-bold text-red-600 transition-colors hover:bg-red-100 hover:text-red-700">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Hapus
                            </button>

                        </div>

                    </div>

                @endforeach

            </div>

        @endif

    </div>

</div>