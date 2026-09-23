<?php

use App\Models\News;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.admin')] class extends Component
{
    public News $news;

    public array $selectedNews = [];

    public function mount(News $news): void
    {
        $this->news = $news;

        $this->selectedNews = $news
            ->relatedNews()
            ->pluck('news.id')
            ->map(fn ($id) => (int) $id)
            ->toArray();
    }

    public function save(): void
    {
        $this->validate([
            'selectedNews' => ['array'],
            'selectedNews.*' => [
                'integer',
                'exists:news,id',
            ],
        ]);

        $selected = collect($this->selectedNews)
            ->filter(fn ($id) => (int) $id !== (int) $this->news->id)
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values()
            ->toArray();

        $this->news
            ->relatedNews()
            ->sync($selected);

        session()->flash(
            'success',
            'Related news berhasil diperbarui.'
        );
    }

    public function with(): array
    {
        return [
            'newsList' => News::query()
                ->whereKeyNot($this->news->id)
                ->with('category')
                ->orderByDesc('published_at')
                ->orderBy('title')
                ->get(),
        ];
    }
};
?>

<div class="mx-auto max-w-4xl space-y-8 pb-10">

    {{-- Header --}}
    <div>
        <a
            href="{{ route('admin.news.index') }}"
            wire:navigate
            class="inline-flex items-center gap-2 text-sm font-bold text-gray-400 transition-colors hover:text-[var(--color-wfsc-coral)]"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Berita
        </a>

        <div class="mt-4 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 shadow-sm">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                </div>
                <div>
                    <h1 class="text-2xl font-black tracking-tight text-[var(--color-wfsc-dark)]">
                        Related News
                    </h1>
                    <p class="mt-1 text-sm font-medium text-gray-500">
                        Pilih berita yang berkaitan dengan artikel:
                    </p>
                    <p class="mt-1 text-sm font-bold text-[var(--color-wfsc-dark)]">
                        "{{ $news->title }}"
                    </p>
                </div>
            </div>

            <a
                href="{{ route('admin.news.edit', $news) }}"
                wire:navigate
                class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-bold text-gray-700 shadow-sm transition-all hover:bg-gray-50"
            >
                Edit Berita
            </a>
        </div>
    </div>

    {{-- Flash message --}}
    @if (session()->has('success'))
        <div class="flex items-center gap-3 rounded-2xl border border-emerald-100 bg-emerald-50 px-6 py-4 text-sm font-bold text-emerald-700 shadow-sm">
            <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Related news Card --}}
    <div class="relative overflow-hidden rounded-2xl border border-gray-100/50 bg-white elegant-shadow">
        <div class="absolute left-0 top-0 h-full w-1 bg-indigo-400"></div>

        <div class="border-b border-gray-100 px-8 py-6">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-bold text-[var(--color-wfsc-dark)]">
                        Choose Related News
                    </h2>

                    <p class="mt-0.5 text-xs font-medium text-gray-400">
                        Berita yang dipilih dapat digunakan sebagai artikel terkait.
                    </p>
                </div>

                <span class="inline-flex items-center gap-1.5 rounded-full bg-indigo-50 px-3.5 py-1 text-xs font-bold text-indigo-600 ring-1 ring-inset ring-indigo-600/20">
                    {{ count($selectedNews) }} selected
                </span>
            </div>
        </div>

        <div class="divide-y divide-gray-50">

            @forelse ($newsList as $item)

                <label
                    wire:key="related-news-{{ $item->id }}"
                    class="flex cursor-pointer gap-4 px-8 py-5 transition-colors hover:bg-rose-50/20"
                >

                    <div class="pt-0.5">
                        <input
                            type="checkbox"
                            value="{{ $item->id }}"
                            wire:model="selectedNews"
                            class="h-5 w-5 rounded-md border-gray-300 text-[var(--color-wfsc-coral)] focus:ring-[var(--color-wfsc-coral)]"
                        >
                    </div>

                    <div class="min-w-0 flex-1">

                        <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">

                            <div class="min-w-0">
                                <h3 class="font-bold text-[var(--color-wfsc-dark)]">
                                    {{ $item->title }}
                                </h3>

                                @if ($item->excerpt)
                                    <p class="mt-1 line-clamp-2 text-xs font-medium text-gray-500 leading-relaxed">
                                        {{ $item->excerpt }}
                                    </p>
                                @endif
                            </div>

                            <div class="flex shrink-0 items-center gap-2">

                                @if ($item->category)
                                    <span class="inline-flex items-center rounded-lg bg-blue-50 px-2.5 py-1 text-xs font-bold text-blue-600">
                                        {{ $item->category->name }}
                                    </span>
                                @endif

                                @if ($item->is_active)
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-600 ring-1 ring-inset ring-emerald-600/20">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span> Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-3 py-1 text-xs font-bold text-red-600 ring-1 ring-inset ring-red-600/20">
                                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span> Nonaktif
                                    </span>
                                @endif

                            </div>

                        </div>

                        @if ($item->published_at)
                            <p class="mt-2 text-xs font-mono font-medium text-gray-400">
                                {{ $item->published_at->format('d M Y') }}
                            </p>
                        @endif

                    </div>

                </label>

            @empty

                <div class="px-8 py-12 text-center">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-50">
                        <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    </div>
                    <p class="mt-4 text-sm font-medium text-gray-900">Belum ada berita lain yang tersedia</p>
                    <p class="mt-1 text-sm text-gray-500">Buat artikel berita lain untuk dihubungkan sebagai artikel terkait.</p>
                </div>

            @endforelse

        </div>

        {{-- Footer --}}
        <div class="flex items-center justify-between border-t border-gray-100 bg-gray-50/50 px-8 py-4">

            <p class="text-xs font-bold text-gray-500">
                {{ count($selectedNews) }} berita dipilih
            </p>

            <button
                type="button"
                wire:click="save"
                wire:loading.attr="disabled"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[var(--color-wfsc-coral)] to-[#ff7676] px-8 py-3 text-sm font-bold text-white shadow-lg shadow-[var(--color-wfsc-coral)]/30 transition-all duration-300 hover:scale-[1.02] hover:shadow-xl hover:shadow-[var(--color-wfsc-coral)]/40 disabled:cursor-not-allowed disabled:opacity-70 disabled:hover:scale-100"
            >
                <span wire:loading.remove wire:target="save">
                    Save Related News
                </span>

                <span wire:loading wire:target="save">
                    <svg class="h-4 w-4 animate-spin text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Saving...
                </span>
            </button>

        </div>

    </div>

</div>