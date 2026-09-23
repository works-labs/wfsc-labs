<?php

use App\Models\SkincareAttribute;
use App\Models\SkincareCategory;
use App\Models\SkincareProduct;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Livewire\Component;

new
#[Layout('layouts.admin')]
class extends Component
{
    use WithFileUploads;

    public string $name = '';
    public string $slug = '';
    public string $description = '';
    public $image;
    public $price = null;
    public ?string $shopee_url = '';
    public int $sort_order = 0;
    public bool $is_active = true;

    public array $category_ids = [];
    public array $attribute_ids = [];

    public function updatedName(string $value): void
    {
        $this->slug = Str::slug($value);
    }

    public function save()
    {
        $this->slug = Str::slug($this->name);
        $this->price = $this->price !== '' ? $this->price : null;
        $this->shopee_url = $this->shopee_url !== '' ? $this->shopee_url : null;

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:skincare_products,slug'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'shopee_url' => ['nullable', 'url', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['boolean'],
            'category_ids' => ['array'],
            'category_ids.*' => ['integer', 'exists:skincare_categories,id'],
            'attribute_ids' => ['array'],
            'attribute_ids.*' => ['integer', 'exists:skincare_attributes,id'],
        ]);

        if ($this->image) {
            $validated['image'] = $this->image->store('skincare/products', 'public');
        }

        $validated['price'] = $validated['price'] !== '' ? $validated['price'] : null;
        $validated['shopee_url'] = $validated['shopee_url'] !== '' ? $validated['shopee_url'] : null;

        unset(
            $validated['category_ids'],
            $validated['attribute_ids']
        );

        $product = SkincareProduct::create($validated);

        $product->categories()->sync($this->category_ids);
        $product->attributes()->sync($this->attribute_ids);

        session()->flash('success', 'Produk berhasil ditambahkan.');

        return $this->redirect(
            route('admin.skincare.products.index'),
            navigate: true
        );
    }

    public function with(): array
    {
        return [
            'categories' => SkincareCategory::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get(),

            'attributes' => SkincareAttribute::query()
                ->where('is_active', true)
                ->orderBy('name')
                ->get(),
        ];
    }
};
?>

<div class="mx-auto max-w-4xl space-y-8 pb-10">

    {{-- Top Navigation & Header --}}
    <div>
        <a href="{{ route('admin.skincare.products.index') }}" wire:navigate 
            class="inline-flex items-center gap-2 text-sm font-bold text-gray-400 transition-colors hover:text-[var(--color-wfsc-coral)]">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Produk Skincare
        </a>
        <div class="mt-4 flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-rose-50 text-[var(--color-wfsc-coral)] shadow-sm">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </div>
            <div>
                <h1 class="text-2xl font-black tracking-tight text-[var(--color-wfsc-dark)]">Tambah Produk Skincare</h1>
                <p class="text-sm font-medium text-gray-500">Tambahkan produk dan hubungkan dengan kategori serta atribut.</p>
            </div>
        </div>
    </div>

    <form wire:submit="save" class="space-y-8">

        {{-- Informasi Produk Card --}}
        <div class="relative overflow-hidden rounded-2xl border border-gray-100/50 bg-white p-8 elegant-shadow">
            <div class="absolute left-0 top-0 h-full w-1 bg-emerald-400"></div>
            
            <div class="mb-6 flex items-center gap-3">
                <div class="rounded-lg bg-emerald-50 p-2 text-emerald-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <h2 class="text-lg font-bold text-[var(--color-wfsc-dark)]">Informasi Produk</h2>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-bold text-gray-600">Nama Produk <span class="text-[var(--color-wfsc-coral)]">*</span></label>
                    <input type="text" wire:model.live="name" placeholder="Contoh: WFSC Sunscreen Brightener Acne" 
                        class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]">
                    @error('name') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Slug</label>
                    <input type="text" wire:model="slug" readonly tabindex="-1" placeholder="wfsc-sunscreen-brightener-acne"
                        class="w-full cursor-not-allowed rounded-xl border-gray-200 bg-gray-100 px-4 py-3 font-mono text-sm text-gray-500">
                    @error('slug') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Harga <span class="text-xs font-medium text-gray-400">(opsional)</span></label>
                    <input type="number" wire:model="price" min="0" step="100" placeholder="50000" 
                        class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]">
                    @error('price') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-bold text-gray-600">Deskripsi</label>
                    <textarea wire:model="description" rows="5" placeholder="Deskripsi produk..." 
                        class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"></textarea>
                    @error('description') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Link Shopee <span class="text-xs font-medium text-gray-400">(opsional)</span></label>
                    <input type="url" wire:model="shopee_url" placeholder="https://shopee.co.id/..." 
                        class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]">
                    @error('shopee_url') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Urutan</label>
                    <input type="number" wire:model="sort_order" min="0" placeholder="0" 
                        class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]">
                    @error('sort_order') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Gambar Produk Card --}}
        <div class="relative overflow-hidden rounded-2xl border border-gray-100/50 bg-white p-8 elegant-shadow">
            <div class="absolute left-0 top-0 h-full w-1 bg-purple-400"></div>
            
            <div class="mb-6 flex items-center gap-3">
                <div class="rounded-lg bg-purple-50 p-2 text-purple-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h2 class="text-lg font-bold text-[var(--color-wfsc-dark)]">Gambar Produk</h2>
            </div>

            <div class="flex items-start gap-6">
                @if ($image)
                    <div class="shrink-0">
                        <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="h-28 w-28 rounded-2xl object-cover shadow-sm ring-4 ring-gray-50">
                    </div>
                @endif
                <div class="w-full">
                    <input type="file" wire:model="image" accept="image/jpeg,image/png,image/webp" 
                        class="block w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-2.5 text-sm text-gray-600 transition-colors file:mr-4 file:rounded-lg file:border-0 file:bg-white file:px-4 file:py-2 file:text-sm file:font-bold file:text-[var(--color-wfsc-coral)] file:shadow-sm hover:file:bg-rose-50 focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]">
                    <div wire:loading wire:target="image" class="mt-2 text-xs font-bold text-[var(--color-wfsc-coral)] flex items-center gap-1.5">
                        <svg class="h-3.5 w-3.5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Mengunggah gambar...
                    </div>
                    @error('image') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Kategori & Atribut Grid Card --}}
        <div class="grid gap-6 md:grid-cols-2">
            {{-- Kategori --}}
            <div class="relative overflow-hidden rounded-2xl border border-gray-100/50 bg-white p-8 elegant-shadow">
                <div class="absolute left-0 top-0 h-full w-1 bg-blue-400"></div>
                <h2 class="mb-5 text-lg font-bold text-[var(--color-wfsc-dark)]">Kategori</h2>

                <div class="space-y-3">
                    @forelse ($categories as $category)
                        <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-gray-100 bg-gray-50/50 p-3 transition-colors hover:bg-rose-50/30">
                            <input type="checkbox" wire:model="category_ids" value="{{ $category->id }}"
                                class="h-5 w-5 rounded-md border-gray-300 text-[var(--color-wfsc-coral)] focus:ring-[var(--color-wfsc-coral)]">
                            <span class="text-sm font-bold text-gray-700">{{ $category->name }}</span>
                        </label>
                    @empty
                        <p class="text-xs font-medium text-gray-400">Belum ada kategori aktif.</p>
                    @endforelse
                </div>
                @error('category_ids.*') <p class="mt-2 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
            </div>

            {{-- Atribut --}}
            <div class="relative overflow-hidden rounded-2xl border border-gray-100/50 bg-white p-8 elegant-shadow">
                <div class="absolute left-0 top-0 h-full w-1 bg-indigo-400"></div>
                <h2 class="mb-5 text-lg font-bold text-[var(--color-wfsc-dark)]">Atribut</h2>

                <div class="space-y-3">
                    @forelse ($attributes as $attribute)
                        <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-gray-100 bg-gray-50/50 p-3 transition-colors hover:bg-rose-50/30">
                            <input type="checkbox" wire:model="attribute_ids" value="{{ $attribute->id }}"
                                class="h-5 w-5 rounded-md border-gray-300 text-[var(--color-wfsc-coral)] focus:ring-[var(--color-wfsc-coral)]">
                            <span class="text-sm font-bold text-gray-700">{{ $attribute->name }}</span>
                        </label>
                    @empty
                        <p class="text-xs font-medium text-gray-400">Belum ada atribut aktif.</p>
                    @endforelse
                </div>
                @error('attribute_ids.*') <p class="mt-2 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Status Aktif Card --}}
        <div class="relative overflow-hidden rounded-2xl border border-gray-100/50 bg-white p-6 elegant-shadow">
            <label class="inline-flex cursor-pointer items-center gap-3">
                <input type="checkbox" wire:model="is_active" class="h-5 w-5 rounded-md border-gray-300 text-[var(--color-wfsc-coral)] focus:ring-[var(--color-wfsc-coral)]">
                <div>
                    <span class="block text-sm font-bold text-gray-800">Produk Aktif</span>
                    <span class="block text-xs font-medium text-gray-500">Tampilkan produk ini di katalog website publik.</span>
                </div>
            </label>
        </div>

        {{-- Aksi --}}
        <div class="flex items-center justify-end gap-4 pt-4">
            <a href="{{ route('admin.skincare.products.index') }}" wire:navigate 
                class="rounded-xl px-5 py-3 text-sm font-bold text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-800">
                Batal
            </a>

            <button type="submit" wire:loading.attr="disabled" 
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[var(--color-wfsc-coral)] to-[#ff7676] px-8 py-3 text-sm font-bold text-white shadow-lg shadow-[var(--color-wfsc-coral)]/30 transition-all duration-300 hover:scale-[1.02] hover:shadow-xl hover:shadow-[var(--color-wfsc-coral)]/40 disabled:opacity-70 disabled:hover:scale-100">
                <span wire:loading.remove wire:target="save">Simpan Produk</span>
                <span wire:loading wire:target="save">
                    <svg class="h-4 w-4 animate-spin text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Menyimpan...
                </span>
            </button>
        </div>
    </form>
</div>
