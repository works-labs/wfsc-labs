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

<div class="p-6 lg:p-8">

    {{-- Header --}}
    <div class="mb-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

            <div>
                <a
                    href="{{ route('admin.news.index') }}"
                    wire:navigate
                    class="text-sm font-medium text-neutral-500 transition hover:text-neutral-900"
                >
                    ← Back to News
                </a>

                <h1 class="mt-3 text-2xl font-semibold tracking-tight text-neutral-900">
                    Related News
                </h1>

                <p class="mt-1 text-sm text-neutral-500">
                    Pilih berita yang berkaitan dengan artikel:
                </p>

                <p class="mt-2 font-medium text-neutral-900">
                    {{ $news->title }}
                </p>
            </div>

            <a
                href="{{ route('admin.news.edit', $news) }}"
                wire:navigate
                class="inline-flex items-center justify-center rounded-lg border border-neutral-200 bg-white px-4 py-2 text-sm font-medium text-neutral-700 transition hover:bg-neutral-50"
            >
                Edit News
            </a>

        </div>
    </div>

    {{-- Flash message --}}
    @if (session()->has('success'))
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    {{-- Related news --}}
    <div class="rounded-xl border border-neutral-200 bg-white">

        <div class="border-b border-neutral-200 px-6 py-4">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h2 class="font-semibold text-neutral-900">
                        Choose Related News
                    </h2>

                    <p class="mt-1 text-sm text-neutral-500">
                        Berita yang dipilih dapat digunakan sebagai artikel terkait.
                    </p>
                </div>

                <span class="rounded-full bg-neutral-100 px-3 py-1 text-xs font-medium text-neutral-600">
                    {{ count($selectedNews) }} selected
                </span>
            </div>
        </div>

        <div class="divide-y divide-neutral-100">

            @forelse ($newsList as $item)

                <label
                    wire:key="related-news-{{ $item->id }}"
                    class="flex cursor-pointer gap-4 px-6 py-4 transition hover:bg-neutral-50"
                >

                    <div class="pt-1">
                        <input
                            type="checkbox"
                            value="{{ $item->id }}"
                            wire:model="selectedNews"
                            class="h-4 w-4 rounded border-neutral-300 text-neutral-900 focus:ring-neutral-900"
                        >
                    </div>

                    <div class="min-w-0 flex-1">

                        <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">

                            <div class="min-w-0">
                                <h3 class="font-medium text-neutral-900">
                                    {{ $item->title }}
                                </h3>

                                @if ($item->excerpt)
                                    <p class="mt-1 line-clamp-2 text-sm text-neutral-500">
                                        {{ $item->excerpt }}
                                    </p>
                                @endif
                            </div>

                            <div class="flex shrink-0 items-center gap-2">

                                @if ($item->category)
                                    <span class="rounded-full bg-neutral-100 px-2.5 py-1 text-xs font-medium text-neutral-600">
                                        {{ $item->category->name }}
                                    </span>
                                @endif

                                @if ($item->is_active)
                                    <span class="rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700">
                                        Active
                                    </span>
                                @else
                                    <span class="rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-600">
                                        Inactive
                                    </span>
                                @endif

                            </div>

                        </div>

                        @if ($item->published_at)
                            <p class="mt-2 text-xs text-neutral-400">
                                {{ $item->published_at->format('d M Y') }}
                            </p>
                        @endif

                    </div>

                </label>

            @empty

                <div class="px-6 py-12 text-center">
                    <p class="text-sm text-neutral-500">
                        Belum ada berita lain yang tersedia.
                    </p>
                </div>

            @endforelse

        </div>

        {{-- Footer --}}
        <div class="flex items-center justify-between border-t border-neutral-200 px-6 py-4">

            <p class="text-sm text-neutral-500">
                {{ count($selectedNews) }} berita dipilih
            </p>

            <button
                type="button"
                wire:click="save"
                wire:loading.attr="disabled"
                class="rounded-lg bg-neutral-900 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-neutral-800 disabled:cursor-not-allowed disabled:opacity-50"
            >
                <span wire:loading.remove wire:target="save">
                    Save Related News
                </span>

                <span wire:loading wire:target="save">
                    Saving...
                </span>
            </button>

        </div>

    </div>

</div>