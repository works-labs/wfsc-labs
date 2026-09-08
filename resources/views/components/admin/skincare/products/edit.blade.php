<?php

use App\Models\SkincareAttribute;
use App\Models\SkincareCategory;
use App\Models\SkincareProduct;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Livewire\Component;

new
#[Layout('layouts.admin')]
class extends Component
{
    use WithFileUploads;

    public SkincareProduct $skincareProduct;

    public string $name = '';
    public string $slug = '';
    public string $description = '';
    public $image;
    public ?string $existingImage = null;
    public $price = null;
    public string $shopee_url = '';
    public int $sort_order = 0;
    public bool $is_active = true;

    public array $category_ids = [];
    public array $attribute_ids = [];

    public function mount(SkincareProduct $skincareProduct): void
    {
        $this->skincareProduct = $skincareProduct->load([
            'categories',
            'attributes',
        ]);

        $this->name = $skincareProduct->name;
        $this->slug = $skincareProduct->slug;
        $this->description = $skincareProduct->description ?? '';
        $this->existingImage = $skincareProduct->image;
        $this->price = $skincareProduct->price;
        $this->shopee_url = $skincareProduct->shopee_url ?? '';
        $this->sort_order = $skincareProduct->sort_order;
        $this->is_active = $skincareProduct->is_active;

        $this->category_ids = $skincareProduct->categories
            ->pluck('id')
            ->map(fn ($id) => (string) $id)
            ->toArray();

        $this->attribute_ids = $skincareProduct->attributes
            ->pluck('id')
            ->map(fn ($id) => (string) $id)
            ->toArray();
    }

    public function updatedName(string $value): void
    {
        if ($this->slug === '' || $this->slug === Str::slug($this->skincareProduct->name)) {
            $this->slug = Str::slug($value);
        }
    }

    public function update()
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('skincare_products', 'slug')
                    ->ignore($this->skincareProduct->id),
            ],
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
            if (
                $this->existingImage &&
                Storage::disk('public')->exists($this->existingImage)
            ) {
                Storage::disk('public')->delete($this->existingImage);
            }

            $validated['image'] = $this->image->store(
                'skincare/products',
                'public'
            );
        }

        unset(
            $validated['category_ids'],
            $validated['attribute_ids']
        );

        $this->skincareProduct->update($validated);

        $this->skincareProduct->categories()->sync($this->category_ids);
        $this->skincareProduct->attributes()->sync($this->attribute_ids);

        session()->flash('success', 'Produk berhasil diperbarui.');

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

<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
            Edit Produk Skincare
        </h1>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Perbarui informasi produk, kategori, atribut, dan gambar.
        </p>
    </div>

    <form wire:submit="update" class="space-y-6">
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <h2 class="mb-5 text-lg font-semibold text-gray-900 dark:text-white">
                Informasi Produk
            </h2>

            <div class="grid gap-5 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Nama Produk
                    </label>

                    <input
                        type="text"
                        wire:model.live="name"
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    >

                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Slug
                    </label>

                    <input
                        type="text"
                        wire:model="slug"
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    >

                    @error('slug')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Harga
                    </label>

                    <input
                        type="number"
                        wire:model="price"
                        min="0"
                        step="100"
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    >

                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Deskripsi
                    </label>

                    <textarea
                        wire:model="description"
                        rows="5"
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    ></textarea>

                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Link Shopee
                    </label>

                    <input
                        type="url"
                        wire:model="shopee_url"
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    >

                    @error('shopee_url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Urutan
                    </label>

                    <input
                        type="number"
                        wire:model="sort_order"
                        min="0"
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    >
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <h2 class="mb-5 text-lg font-semibold text-gray-900 dark:text-white">
                Gambar Produk
            </h2>

            @if ($existingImage && !$image)
                <div class="mb-4">
                    <img
                        src="{{ asset('storage/' . $existingImage) }}"
                        alt="{{ $name }}"
                        class="h-40 w-40 rounded-xl object-cover"
                    >
                </div>
            @endif

            @if ($image)
                <div class="mb-4">
                    <img
                        src="{{ $image->temporaryUrl() }}"
                        alt="Preview"
                        class="h-40 w-40 rounded-xl object-cover"
                    >
                </div>
            @endif

            <input
                type="file"
                wire:model="image"
                accept="image/jpeg,image/png,image/webp"
                class="block w-full text-sm text-gray-500"
            >

            @error('image')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <h2 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">
                    Kategori
                </h2>

                <div class="space-y-3">
                    @foreach ($categories as $category)
                        <label class="flex cursor-pointer items-center gap-3">
                            <input
                                type="checkbox"
                                wire:model="category_ids"
                                value="{{ $category->id }}"
                                class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500"
                            >

                            <span class="text-sm text-gray-700 dark:text-gray-300">
                                {{ $category->name }}
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <h2 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">
                    Atribut
                </h2>

                <div class="space-y-3">
                    @foreach ($attributes as $attribute)
                        <label class="flex cursor-pointer items-center gap-3">
                            <input
                                type="checkbox"
                                wire:model="attribute_ids"
                                value="{{ $attribute->id }}"
                                class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500"
                            >

                            <span class="text-sm text-gray-700 dark:text-gray-300">
                                {{ $attribute->name }}
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <label class="flex cursor-pointer items-center gap-3">
                <input
                    type="checkbox"
                    wire:model="is_active"
                    class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500"
                >

                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    Produk aktif
                </span>
            </label>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a
                href="{{ route('admin.skincare.products.index') }}"
                wire:navigate
                class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700"
            >
                Batal
            </a>

            <button
                type="submit"
                wire:loading.attr="disabled"
                class="rounded-lg bg-primary-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-primary-700 disabled:opacity-50"
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