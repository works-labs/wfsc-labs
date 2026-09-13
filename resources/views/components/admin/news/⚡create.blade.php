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

<div class="mx-auto max-w-4xl space-y-8 pb-10">

    {{-- Top Navigation & Header --}}
    <div>
        <a href="{{ route('admin.news.index') }}" wire:navigate 
            class="inline-flex items-center gap-2 text-sm font-bold text-gray-400 transition-colors hover:text-[var(--color-wfsc-coral)]">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Berita
        </a>
        <div class="mt-4 flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-rose-50 text-[var(--color-wfsc-coral)] shadow-sm">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </div>
            <div>
                <h1 class="text-2xl font-black tracking-tight text-[var(--color-wfsc-dark)]">Create News</h1>
                <p class="text-sm font-medium text-gray-500">Tambahkan artikel berita baru ke website WFSC.</p>
            </div>
        </div>
    </div>

    {{-- FORM --}}
    <form wire:submit="save" class="space-y-8">

        {{-- INFORMASI UTAMA --}}
        <div class="relative overflow-hidden rounded-2xl border border-gray-100/50 bg-white p-8 elegant-shadow">
            <div class="absolute left-0 top-0 h-full w-1 bg-blue-400"></div>
            
            <div class="mb-6 flex items-center gap-3">
                <div class="rounded-lg bg-blue-50 p-2 text-blue-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-[var(--color-wfsc-dark)]">Informasi Artikel</h2>
                    <p class="text-xs font-medium text-gray-400">Judul, kategori, dan ringkasan berita.</p>
                </div>
            </div>

            <div class="space-y-6">
                {{-- Title --}}
                <div>
                    <label for="title" class="mb-2 block text-sm font-bold text-gray-600">
                        Judul <span class="text-[var(--color-wfsc-coral)]">*</span>
                    </label>
                    <input
                        id="title"
                        type="text"
                        wire:model.live="title"
                        class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                        placeholder="Masukkan judul artikel"
                    >
                    @error('title')
                        <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Slug --}}
                <div>
                    <label for="slug" class="mb-2 block text-sm font-bold text-gray-600">Slug</label>
                    <input
                        id="slug"
                        type="text"
                        wire:model="slug"
                        class="w-full rounded-xl border-gray-200 bg-gray-100 px-4 py-3 font-mono text-sm text-gray-500"
                        placeholder="slug-artikel"
                    >
                    @error('slug')
                        <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Category & Baca Juga --}}
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label for="category_id" class="mb-2 block text-sm font-bold text-gray-600">
                            Kategori <span class="text-[var(--color-wfsc-coral)]">*</span>
                        </label>
                        <select
                            id="category_id"
                            wire:model="category_id"
                            class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                        >
                            <option value="">Pilih Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="baca_juga_id" class="mb-2 block text-sm font-bold text-gray-600">Baca Juga</label>
                        <select
                            id="baca_juga_id"
                            wire:model="baca_juga_id"
                            class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                        >
                            <option value="">Tidak ada</option>
                            @foreach ($newsList as $item)
                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                            @endforeach
                        </select>
                        <p class="mt-1.5 text-xs font-medium text-gray-400">
                            Pilih satu artikel untuk disisipkan sebagai "Baca Juga".
                        </p>
                        @error('baca_juga_id')
                            <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Excerpt --}}
                <div>
                    <label for="excerpt" class="mb-2 block text-sm font-bold text-gray-600">Ringkasan (Excerpt)</label>
                    <textarea
                        id="excerpt"
                        wire:model="excerpt"
                        rows="3"
                        class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                        placeholder="Tulis ringkasan singkat artikel..."
                    ></textarea>
                    @error('excerpt')
                        <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- ISI ARTIKEL --}}
        <div class="relative overflow-hidden rounded-2xl border border-gray-100/50 bg-white p-8 elegant-shadow">
            <div class="absolute left-0 top-0 h-full w-1 bg-emerald-400"></div>
            
            <div class="mb-6 flex items-center gap-3">
                <div class="rounded-lg bg-emerald-50 p-2 text-emerald-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-[var(--color-wfsc-dark)]">Isi Artikel</h2>
                    <p class="text-xs font-medium text-gray-400">Gunakan toolbar untuk mengatur format tulisan.</p>
                </div>
            </div>

            <div class="space-y-3">
                <x-admin.rich-text-editor
                    wire:model="content"
                    placeholder="Tulis isi artikel di sini..."
                />

                @error('content')
                    <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                @enderror

                <p class="text-xs font-medium text-gray-400">
                    Gunakan Enter untuk membuat paragraf baru. Paste dari web otomatis dibersihkan.
                </p>
            </div>
        </div>

        {{-- THUMBNAIL --}}
        <div class="relative overflow-hidden rounded-2xl border border-gray-100/50 bg-white p-8 elegant-shadow">
            <div class="absolute left-0 top-0 h-full w-1 bg-purple-400"></div>
            
            <div class="mb-6 flex items-center gap-3">
                <div class="rounded-lg bg-purple-50 p-2 text-purple-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-[var(--color-wfsc-dark)]">Thumbnail</h2>
                    <p class="text-xs font-medium text-gray-400">Gambar utama artikel (Maks. 2 MB).</p>
                </div>
            </div>

            <div class="space-y-4">
                <input
                    id="thumbnail"
                    type="file"
                    wire:model="thumbnail"
                    accept="image/*"
                    class="block w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-2.5 text-sm text-gray-600 transition-colors file:mr-4 file:rounded-lg file:border-0 file:bg-white file:px-4 file:py-2 file:text-sm file:font-bold file:text-[var(--color-wfsc-coral)] file:shadow-sm hover:file:bg-rose-50 focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                >
                @error('thumbnail')
                    <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                @enderror

                <div wire:loading wire:target="thumbnail" class="text-xs font-bold text-[var(--color-wfsc-coral)] flex items-center gap-1.5">
                    <svg class="h-3.5 w-3.5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Mengupload gambar...
                </div>

                @if ($thumbnail)
                    <div>
                        <p class="mb-2 text-xs font-bold text-gray-600">Preview:</p>
                        <img
                            src="{{ $thumbnail->temporaryUrl() }}"
                            alt="Thumbnail preview"
                            class="max-h-72 rounded-2xl border border-gray-100 object-cover shadow-sm ring-4 ring-gray-50"
                        >
                    </div>
                @endif
            </div>
        </div>

        {{-- STATUS & PUBLISH --}}
        <div class="relative overflow-hidden rounded-2xl border border-gray-100/50 bg-white p-8 elegant-shadow">
            <div class="absolute left-0 top-0 h-full w-1 bg-amber-400"></div>
            
            <div class="mb-6 flex items-center gap-3">
                <div class="rounded-lg bg-amber-50 p-2 text-amber-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-[var(--color-wfsc-dark)]">Pengaturan Publikasi</h2>
                    <p class="text-xs font-medium text-gray-400">Atur jadwal rilis dan status aktif artikel.</p>
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <label for="published_at" class="mb-2 block text-sm font-bold text-gray-600">Tanggal Publikasi</label>
                    <input
                        id="published_at"
                        type="datetime-local"
                        wire:model="published_at"
                        class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                    >
                    @error('published_at')
                        <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-gray-100 bg-gray-50 p-4 transition-colors hover:bg-gray-100">
                        <input
                            type="checkbox"
                            wire:model="is_featured"
                            class="mt-1 h-5 w-5 rounded-md border-gray-300 text-[var(--color-wfsc-coral)] focus:ring-[var(--color-wfsc-coral)]"
                        >
                        <div>
                            <span class="block text-sm font-bold text-gray-800">Featured</span>
                            <span class="mt-0.5 block text-xs font-medium text-gray-500">Tandai sebagai artikel unggulan.</span>
                        </div>
                    </label>

                    <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-gray-100 bg-gray-50 p-4 transition-colors hover:bg-gray-100">
                        <input
                            type="checkbox"
                            wire:model="is_active"
                            class="mt-1 h-5 w-5 rounded-md border-gray-300 text-[var(--color-wfsc-coral)] focus:ring-[var(--color-wfsc-coral)]"
                        >
                        <div>
                            <span class="block text-sm font-bold text-gray-800">Aktif</span>
                            <span class="mt-0.5 block text-xs font-medium text-gray-500">Tampilkan di website publik.</span>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        {{-- ACTIONS --}}
        <div class="flex items-center justify-end gap-4 pt-4">
            <a
                href="{{ route('admin.news.index') }}"
                wire:navigate
                class="rounded-xl px-5 py-3 text-sm font-bold text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-800"
            >
                Batal
            </a>

            <button
                type="submit"
                wire:loading.attr="disabled"
                wire:target="save"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[var(--color-wfsc-coral)] to-[#ff7676] px-8 py-3 text-sm font-bold text-white shadow-lg shadow-[var(--color-wfsc-coral)]/30 transition-all duration-300 hover:scale-[1.02] hover:shadow-xl hover:shadow-[var(--color-wfsc-coral)]/40 disabled:opacity-70 disabled:hover:scale-100"
            >
                <span wire:loading.remove wire:target="save">Simpan Berita</span>
                <span wire:loading wire:target="save">
                    <svg class="h-4 w-4 animate-spin text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Menyimpan...
                </span>
            </button>
        </div>

    </form>

</div>