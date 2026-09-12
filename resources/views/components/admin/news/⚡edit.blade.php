<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

new #[Layout('layouts.admin')] class extends Component
{
    use WithFileUploads;

    public News $news;

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

    public function mount(News $news): void
    {
        $this->news = $news;

        $this->title = $news->title;
        $this->slug = $news->slug;
        $this->excerpt = $news->excerpt ?? '';
        $this->content = $news->content ?? '';

        $this->published_at = $news->published_at
            ? $news->published_at->format('Y-m-d\TH:i')
            : null;

        $this->is_featured = (bool) $news->is_featured;
        $this->is_active = (bool) $news->is_active;

        $this->category_id = $news->category_id;
        $this->baca_juga_id = $news->baca_juga_id;
    }

    public function updatedTitle(): void
    {
        $this->slug = Str::slug($this->title);
    }

    public function update(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Normalize select values
        |--------------------------------------------------------------------------
        |
        | HTML <select> mengirim value="" ketika memilih option kosong.
        | Database nullable integer membutuhkan NULL, bukan string kosong.
        |
        */

        $this->category_id = $this->category_id ?: null;
        $this->baca_juga_id = $this->baca_juga_id ?: null;

        $validated = $this->validate([
            'category_id' => [
                'nullable',
                'integer',
                'exists:news_categories,id',
            ],

            'baca_juga_id' => [
                'nullable',
                'integer',
                'exists:news,id',
                Rule::notIn([
                    $this->news->id,
                ]),
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('news', 'slug')
                    ->ignore($this->news->id),
            ],

            'excerpt' => [
                'nullable',
                'string',
            ],

            'content' => [
                'required',
                'string',
            ],

            'thumbnail' => [
                'nullable',
                'image',
                'max:2048',
            ],

            'published_at' => [
                'nullable',
                'date',
            ],

            'is_featured' => [
                'boolean',
            ],

            'is_active' => [
                'boolean',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Thumbnail
        |--------------------------------------------------------------------------
        */

        if ($this->thumbnail) {
            if (
                $this->news->thumbnail &&
                Storage::disk('public')->exists($this->news->thumbnail)
            ) {
                Storage::disk('public')->delete(
                    $this->news->thumbnail
                );
            }

            $validated['thumbnail'] = $this->thumbnail->store(
                'news',
                'public'
            );
        } else {
            /*
             * Tidak upload gambar baru.
             * Pertahankan thumbnail lama.
             */
            $validated['thumbnail'] = $this->news->thumbnail;
        }

        /*
        |--------------------------------------------------------------------------
        | Update author
        |--------------------------------------------------------------------------
        |
        | Author tidak diubah ketika artikel diedit.
        | Yang dicatat tetap pembuat artikel awal.
        |
        */

        unset($validated['thumbnail']);

        if ($this->thumbnail) {
            $validated['thumbnail'] = $this->thumbnail->store(
                'news',
                'public'
            );
        }

        $this->news->update($validated);

        session()->flash(
            'success',
            'News berhasil diperbarui.'
        );

        $this->redirect(
            route('admin.news.index'),
            navigate: true
        );
    }

    public function with(): array
    {
        return [
            'categories' => NewsCategory::query()
                ->where('is_active', true)
                ->orderBy('name')
                ->get(),

            'newsList' => News::query()
                ->whereKeyNot($this->news->id)
                ->orderByDesc('published_at')
                ->orderByDesc('created_at')
                ->get(),
        ];
    }
};
?>

<div class="space-y-6">

    {{-- ============================================================
         HEADER
    ============================================================= --}}

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-semibold text-neutral-900">
                Edit News
            </h1>

            <p class="mt-1 text-sm text-neutral-500">
                Perbarui informasi dan isi artikel.
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


    {{-- ============================================================
         FLASH MESSAGE
    ============================================================= --}}

    @if (session('success'))
        <div
            class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700"
        >
            {{ session('success') }}
        </div>
    @endif


    {{-- ============================================================
         VALIDATION ERROR
    ============================================================= --}}

    @if ($errors->any())
        <div
            class="rounded-xl border border-red-200 bg-red-50 px-4 py-3"
        >
            <p class="text-sm font-semibold text-red-700">
                Ada beberapa data yang perlu diperbaiki:
            </p>

            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- ============================================================
         FORM
    ============================================================= --}}

    <form
        wire:submit="update"
        class="space-y-6"
    >

        {{-- ========================================================
             BASIC INFORMATION
        ========================================================= --}}

        <div class="rounded-2xl border border-neutral-200 bg-white p-6">

            <div class="mb-6">
                <h2 class="text-lg font-semibold text-neutral-900">
                    Informasi Artikel
                </h2>

                <p class="mt-1 text-sm text-neutral-500">
                    Informasi utama yang akan ditampilkan pada halaman berita.
                </p>
            </div>


            {{-- TITLE --}}

            <div>
                <label
                    for="title"
                    class="mb-2 block text-sm font-medium text-neutral-700"
                >
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
                    <p class="mt-2 text-sm text-red-500">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- SLUG --}}

            <div class="mt-5">
                <label
                    for="slug"
                    class="mb-2 block text-sm font-medium text-neutral-700"
                >
                    Slug
                </label>

                <input
                    id="slug"
                    type="text"
                    wire:model="slug"
                    class="w-full rounded-xl border border-neutral-200 bg-neutral-50 px-4 py-3 text-sm text-neutral-700 outline-none transition focus:border-neutral-400 focus:ring-2 focus:ring-neutral-100"
                    placeholder="slug-artikel"
                >

                <p class="mt-2 text-xs text-neutral-400">
                    Slug otomatis mengikuti judul, tetapi masih dapat disesuaikan.
                </p>

                @error('slug')
                    <p class="mt-2 text-sm text-red-500">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- CATEGORY + BACA JUGA --}}

            <div class="mt-5 grid grid-cols-1 gap-5 md:grid-cols-2">

                {{-- CATEGORY --}}

                <div>
                    <label
                        for="category_id"
                        class="mb-2 block text-sm font-medium text-neutral-700"
                    >
                        Kategori
                    </label>

                    <select
                        id="category_id"
                        wire:model="category_id"
                        class="w-full rounded-xl border border-neutral-200 bg-white px-4 py-3 text-sm text-neutral-900 outline-none transition focus:border-neutral-400 focus:ring-2 focus:ring-neutral-100"
                    >
                        <option value="">
                            Tanpa kategori
                        </option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('category_id')
                        <p class="mt-2 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- BACA JUGA --}}

                <div>
                    <label
                        for="baca_juga_id"
                        class="mb-2 block text-sm font-medium text-neutral-700"
                    >
                        Baca Juga
                    </label>

                    <select
                        id="baca_juga_id"
                        wire:model="baca_juga_id"
                        class="w-full rounded-xl border border-neutral-200 bg-white px-4 py-3 text-sm text-neutral-900 outline-none transition focus:border-neutral-400 focus:ring-2 focus:ring-neutral-100"
                    >
                        <option value="">
                            Tidak ada
                        </option>

                        @foreach ($newsList as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->title }}
                            </option>
                        @endforeach
                    </select>

                    <p class="mt-2 text-xs text-neutral-400">
                        Pilih satu artikel yang akan ditampilkan sebagai
                        <strong>Baca Juga</strong> di tengah artikel.
                    </p>

                    @error('baca_juga_id')
                        <p class="mt-2 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>


            {{-- EXCERPT --}}

            <div class="mt-5">
                <label
                    for="excerpt"
                    class="mb-2 block text-sm font-medium text-neutral-700"
                >
                    Ringkasan
                </label>

                <textarea
                    id="excerpt"
                    wire:model="excerpt"
                    rows="4"
                    class="w-full resize-y rounded-xl border border-neutral-200 bg-white px-4 py-3 text-sm text-neutral-900 outline-none transition placeholder:text-neutral-400 focus:border-neutral-400 focus:ring-2 focus:ring-neutral-100"
                    placeholder="Tulis ringkasan singkat artikel..."
                ></textarea>

                @error('excerpt')
                    <p class="mt-2 text-sm text-red-500">
                        {{ $message }}
                    </p>
                @enderror
            </div>

        </div>


        {{-- ========================================================
             CONTENT EDITOR
        ========================================================= --}}

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

            <p class="mt-3 text-xs text-neutral-400">
                Gunakan Enter untuk membuat paragraf baru.
                Tombol <strong>P</strong> mengubah blok aktif menjadi paragraf.
            </p>

            @error('content')
                <p class="mt-2 text-sm text-red-500">
                    {{ $message }}
                </p>
            @enderror

        </div>


        {{-- ========================================================
             THUMBNAIL
        ========================================================= --}}

        <div class="rounded-2xl border border-neutral-200 bg-white p-6">

            <div class="mb-6">
                <h2 class="text-lg font-semibold text-neutral-900">
                    Thumbnail
                </h2>

                <p class="mt-1 text-sm text-neutral-500">
                    Gambar utama yang digunakan pada kartu dan halaman artikel.
                </p>
            </div>


            {{-- CURRENT THUMBNAIL --}}

            @if ($news->thumbnail)

                <div class="mb-5">

                    <p class="mb-2 text-sm font-medium text-neutral-700">
                        Thumbnail saat ini
                    </p>

                    <div class="overflow-hidden rounded-xl border border-neutral-200">
                        <img
                            src="{{ Storage::url($news->thumbnail) }}"
                            alt="{{ $news->title }}"
                            class="max-h-72 w-full object-cover"
                        >
                    </div>

                </div>

            @endif


            {{-- NEW THUMBNAIL --}}

            <div>

                <label
                    for="thumbnail"
                    class="mb-2 block text-sm font-medium text-neutral-700"
                >
                    Ganti Thumbnail
                </label>

                <input
                    id="thumbnail"
                    type="file"
                    wire:model="thumbnail"
                    accept="image/*"
                    class="block w-full rounded-xl border border-neutral-200 bg-white text-sm text-neutral-700 file:mr-4 file:border-0 file:bg-neutral-100 file:px-4 file:py-3 file:text-sm file:font-medium file:text-neutral-700 hover:file:bg-neutral-200"
                >

                <p class="mt-2 text-xs text-neutral-400">
                    Kosongkan jika ingin mempertahankan thumbnail saat ini.
                    Maksimal 2 MB.
                </p>

                @error('thumbnail')
                    <p class="mt-2 text-sm text-red-500">
                        {{ $message }}
                    </p>
                @enderror

                <div
                    wire:loading
                    wire:target="thumbnail"
                    class="mt-2 text-sm text-neutral-500"
                >
                    Mengupload gambar...
                </div>

            </div>


            {{-- NEW IMAGE PREVIEW --}}

            @if ($thumbnail)

                <div class="mt-5">

                    <p class="mb-2 text-sm font-medium text-neutral-700">
                        Preview thumbnail baru
                    </p>

                    <img
                        src="{{ $thumbnail->temporaryUrl() }}"
                        alt="Preview thumbnail"
                        class="max-h-72 rounded-xl border border-neutral-200 object-cover"
                    >

                </div>

            @endif

        </div>


        {{-- ========================================================
             PUBLISH SETTINGS
        ========================================================= --}}

        <div class="rounded-2xl border border-neutral-200 bg-white p-6">

            <div class="mb-6">
                <h2 class="text-lg font-semibold text-neutral-900">
                    Pengaturan Publikasi
                </h2>

                <p class="mt-1 text-sm text-neutral-500">
                    Atur status dan waktu publikasi artikel.
                </p>
            </div>


            {{-- PUBLISHED AT --}}

            <div>

                <label
                    for="published_at"
                    class="mb-2 block text-sm font-medium text-neutral-700"
                >
                    Tanggal Publikasi
                </label>

                <input
                    id="published_at"
                    type="datetime-local"
                    wire:model="published_at"
                    class="w-full rounded-xl border border-neutral-200 bg-white px-4 py-3 text-sm text-neutral-900 outline-none transition focus:border-neutral-400 focus:ring-2 focus:ring-neutral-100"
                >

                @error('published_at')
                    <p class="mt-2 text-sm text-red-500">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- FEATURED + ACTIVE --}}

            <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-2">

                {{-- FEATURED --}}

                <label
                    class="flex cursor-pointer items-start gap-3 rounded-xl border border-neutral-200 p-4 transition hover:bg-neutral-50"
                >

                    <input
                        type="checkbox"
                        wire:model="is_featured"
                        class="mt-1 h-4 w-4 rounded border-neutral-300 text-neutral-900 focus:ring-neutral-300"
                    >

                    <span>
                        <span class="block text-sm font-medium text-neutral-800">
                            Featured
                        </span>

                        <span class="mt-1 block text-xs text-neutral-500">
                            Tandai artikel sebagai artikel unggulan.
                        </span>
                    </span>

                </label>


                {{-- ACTIVE --}}

                <label
                    class="flex cursor-pointer items-start gap-3 rounded-xl border border-neutral-200 p-4 transition hover:bg-neutral-50"
                >

                    <input
                        type="checkbox"
                        wire:model="is_active"
                        class="mt-1 h-4 w-4 rounded border-neutral-300 text-neutral-900 focus:ring-neutral-300"
                    >

                    <span>
                        <span class="block text-sm font-medium text-neutral-800">
                            Aktif
                        </span>

                        <span class="mt-1 block text-xs text-neutral-500">
                            Artikel dapat ditampilkan di halaman publik.
                        </span>
                    </span>

                </label>

            </div>

        </div>


        {{-- ========================================================
             ACTIONS
        ========================================================= --}}

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
                wire:target="update"
                class="inline-flex items-center justify-center rounded-xl bg-neutral-900 px-5 py-3 text-sm font-medium text-white transition hover:bg-neutral-800 disabled:cursor-not-allowed disabled:opacity-60"
            >
                <span wire:loading.remove wire:target="update">
                    Simpan Perubahan
                </span>

                <span wire:loading wire:target="update">
                    Menyimpan...
                </span>
            </button>

        </div>

    </form>

</div>