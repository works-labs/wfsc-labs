<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Support\Str;

new #[Layout('layouts.admin')] class extends Component
{
    use WithFileUploads;

    public string $title = '';
    public string $slug = '';
    public string $excerpt = '';
    public string $content = '';
    public $thumbnail = null;
    public $published_at = null;
    public bool $is_featured = false;
    public bool $is_active = true;
    public $category_id = null;
    public $baca_juga_id = null;

    public function updatedTitle(): void
    {
        $this->slug = Str::slug($this->title);
    }

    public function save(): void
    {
        $this->category_id = $this->category_id ?: null;
        $this->baca_juga_id = $this->baca_juga_id ?: null;

        $validated = $this->validate([
            'category_id' => ['nullable', 'integer', 'exists:news_categories,id'],
            'baca_juga_id' => ['nullable', 'integer', 'exists:news,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:news,slug'],
            'excerpt' => ['nullable', 'string'],
            'content' => ['required', 'string'],
            'thumbnail' => ['nullable', 'image', 'max:2048'],
            'published_at' => ['nullable', 'date'],
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
        ]);

        if ($this->thumbnail) {
            $validated['thumbnail'] = $this->thumbnail->store('news', 'public');
        }

        $validated['author_id'] = auth()->id();

        News::create($validated);

        session()->flash('success', 'News created successfully.');

        $this->redirect(route('admin.news.index'), navigate: true);
    }

    public function with(): array
    {
        return [
            'categories' => NewsCategory::query()
                ->where('is_active', true)
                ->orderBy('name')
                ->get(),

            'newsList' => News::query()
                ->where('is_active', true)
                ->orderByDesc('published_at')
                ->orderByDesc('created_at')
                ->get(),
        ];
    }
};
?>

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-neutral-900">
                Create News
            </h1>
            <p class="mt-1 text-sm text-neutral-500">
                Tambahkan artikel berita baru ke website WFSC.
            </p>
        </div>

        <a
            href="{{ route('admin.news.index') }}"
            wire:navigate
            class="inline-flex items-center justify-center rounded-xl border border-neutral-200 bg-white px-4 py-2.5 text-sm font-medium text-neutral-700 transition hover:bg-neutral-50"
        >
            ← Kembali
        </a>
    </div>

    {{-- FORM --}}
    <form wire:submit="save" class="space-y-6">

        {{-- INFORMASI UTAMA --}}
        <div class="rounded-2xl border border-neutral-200 bg-white p-6">
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-neutral-900">
                    Informasi Artikel
                </h2>
                <p class="mt-1 text-sm text-neutral-500">
                    Judul, kategori, dan ringkasan berita.
                </p>
            </div>

            {{-- Title --}}
            <div>
                <label for="title" class="mb-2 block text-sm font-medium text-neutral-700">
                    Judul
                </label>
                <input
                    id="title"
                    type="text"
                    wire:model.live="title"
                    class="w-full rounded-xl border border-neutral-200 bg-white px-4 py-3 text-sm text-neutral-900 outline-none transition placeholder:text-neutral-400 focus:border-neutral-400 focus:ring-2 focus:ring-neutral-100"
                    placeholder="Masukkan judul artikel"
                >
                @error('title')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Slug --}}
            <div class="mt-5">
                <label for="slug" class="mb-2 block text-sm font-medium text-neutral-700">
                    Slug
                </label>
                <input
                    id="slug"
                    type="text"
                    wire:model="slug"
                    class="w-full rounded-xl border border-neutral-200 bg-neutral-50 px-4 py-3 text-sm text-neutral-700 outline-none transition focus:border-neutral-400 focus:ring-2 focus:ring-neutral-100"
                    placeholder="slug-artikel"
                >
                @error('slug')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Category & Baca Juga --}}
            <div class="mt-5 grid grid-cols-1 gap-5 md:grid-cols-2">
                <div>
                    <label for="category_id" class="mb-2 block text-sm font-medium text-neutral-700">
                        Kategori
                    </label>
                    <select
                        id="category_id"
                        wire:model="category_id"
                        class="w-full rounded-xl border border-neutral-200 bg-white px-4 py-3 text-sm text-neutral-900 outline-none transition focus:border-neutral-400 focus:ring-2 focus:ring-neutral-100"
                    >
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="baca_juga_id" class="mb-2 block text-sm font-medium text-neutral-700">
                        Baca Juga
                    </label>
                    <select
                        id="baca_juga_id"
                        wire:model="baca_juga_id"
                        class="w-full rounded-xl border border-neutral-200 bg-white px-4 py-3 text-sm text-neutral-900 outline-none transition focus:border-neutral-400 focus:ring-2 focus:ring-neutral-100"
                    >
                        <option value="">Tidak ada</option>
                        @foreach ($newsList as $item)
                            <option value="{{ $item->id }}">{{ $item->title }}</option>
                        @endforeach
                    </select>
                    <p class="mt-2 text-xs text-neutral-400">
                        Pilih satu artikel untuk disisipkan sebagai "Baca Juga".
                    </p>
                    @error('baca_juga_id')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Excerpt --}}
            <div class="mt-5">
                <label for="excerpt" class="mb-2 block text-sm font-medium text-neutral-700">
                    Ringkasan (Excerpt)
                </label>
                <textarea
                    id="excerpt"
                    wire:model="excerpt"
                    rows="3"
                    class="w-full resize-y rounded-xl border border-neutral-200 bg-white px-4 py-3 text-sm text-neutral-900 outline-none transition placeholder:text-neutral-400 focus:border-neutral-400 focus:ring-2 focus:ring-neutral-100"
                    placeholder="Tulis ringkasan singkat artikel..."
                ></textarea>
                @error('excerpt')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- ISI ARTIKEL --}}
        <div class="rounded-2xl border border-neutral-200 bg-white p-6">
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-neutral-900">
                    Isi Artikel
                </h2>
                <p class="mt-1 text-sm text-neutral-500">
                    Gunakan toolbar untuk mengatur format tulisan.
                </p>
            </div>

            <x-admin.rich-text-editor
                wire:model="content"
                placeholder="Tulis isi artikel di sini..."
            />

            @error('content')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror

            <p class="mt-3 text-xs text-neutral-400">
                Gunakan Enter untuk membuat paragraf baru. Paste dari web otomatis dibersihkan.
            </p>
        </div>

        {{-- THUMBNAIL --}}
        <div class="rounded-2xl border border-neutral-200 bg-white p-6">
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-neutral-900">
                    Thumbnail
                </h2>
                <p class="mt-1 text-sm text-neutral-500">
                    Gambar utama artikel (Maks. 2 MB).
                </p>
            </div>

            <div>
                <input
                    id="thumbnail"
                    type="file"
                    wire:model="thumbnail"
                    accept="image/*"
                    class="block w-full rounded-xl border border-neutral-200 bg-white text-sm text-neutral-700 file:mr-4 file:border-0 file:bg-neutral-100 file:px-4 file:py-3 file:text-sm file:font-medium file:text-neutral-700 hover:file:bg-neutral-200"
                >
                @error('thumbnail')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror

                <div wire:loading wire:target="thumbnail" class="mt-2 text-sm text-neutral-500">
                    Mengupload gambar...
                </div>
            </div>

            @if ($thumbnail)
                <div class="mt-5">
                    <p class="mb-2 text-sm font-medium text-neutral-700">Preview:</p>
                    <img
                        src="{{ $thumbnail->temporaryUrl() }}"
                        alt="Thumbnail preview"
                        class="max-h-72 rounded-xl border border-neutral-200 object-cover"
                    >
                </div>
            @endif
        </div>

        {{-- STATUS & PUBLISH --}}
        <div class="rounded-2xl border border-neutral-200 bg-white p-6">
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-neutral-900">
                    Pengaturan Publikasi
                </h2>
                <p class="mt-1 text-sm text-neutral-500">
                    Atur jadwal rilis dan status aktif artikel.
                </p>
            </div>

            <div>
                <label for="published_at" class="mb-2 block text-sm font-medium text-neutral-700">
                    Tanggal Publikasi
                </label>
                <input
                    id="published_at"
                    type="datetime-local"
                    wire:model="published_at"
                    class="w-full rounded-xl border border-neutral-200 bg-white px-4 py-3 text-sm text-neutral-900 outline-none transition focus:border-neutral-400 focus:ring-2 focus:ring-neutral-100"
                >
                @error('published_at')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-neutral-200 p-4 transition hover:bg-neutral-50">
                    <input
                        type="checkbox"
                        wire:model="is_featured"
                        class="mt-1 h-4 w-4 rounded border-neutral-300 text-neutral-900 focus:ring-neutral-300"
                    >
                    <span>
                        <span class="block text-sm font-medium text-neutral-800">Featured</span>
                        <span class="mt-1 block text-xs text-neutral-500">Tandai sebagai artikel unggulan.</span>
                    </span>
                </label>

                <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-neutral-200 p-4 transition hover:bg-neutral-50">
                    <input
                        type="checkbox"
                        wire:model="is_active"
                        class="mt-1 h-4 w-4 rounded border-neutral-300 text-neutral-900 focus:ring-neutral-300"
                    >
                    <span>
                        <span class="block text-sm font-medium text-neutral-800">Aktif</span>
                        <span class="mt-1 block text-xs text-neutral-500">Tampilkan di website publik.</span>
                    </span>
                </label>
            </div>
        </div>

        {{-- ACTIONS --}}
        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <a
                href="{{ route('admin.news.index') }}"
                wire:navigate
                class="inline-flex items-center justify-center rounded-xl border border-neutral-200 bg-white px-5 py-3 text-sm font-medium text-neutral-700 transition hover:bg-neutral-50"
            >
                Batal
            </a>

            <button
                type="submit"
                wire:loading.attr="disabled"
                wire:target="save"
                class="inline-flex items-center justify-center rounded-xl bg-neutral-900 px-5 py-3 text-sm font-medium text-white transition hover:bg-neutral-800 disabled:cursor-not-allowed disabled:opacity-60"
            >
                <span wire:loading.remove wire:target="save">Simpan Berita</span>
                <span wire:loading wire:target="save">Menyimpan...</span>
            </button>
        </div>

    </form>

</div>