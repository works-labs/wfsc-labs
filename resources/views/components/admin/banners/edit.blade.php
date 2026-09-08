<?php

use App\Models\Banner;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

new
#[Layout('layouts.admin')]
class extends Component
{
    use WithFileUploads;

    public Banner $banner;

    public string $title = '';
    public string $subtitle = '';
    public string $placement = '';
    public int $sort_order = 0;
    public bool $is_active = true;

    public $image;

    public array $placements = [
        'treatments' => 'Treatment',
        'treatment-detail' => 'Treatment Detail',
        'before-after' => 'Before After',
        'promos' => 'Promo',
        'news' => 'News',
        'skincare' => 'Skincare',
        'contact' => 'Contact',
    ];

    public function mount(Banner $banner): void
    {
        $this->banner = $banner;

        $this->title = $banner->title;
        $this->subtitle = $banner->subtitle ?? '';
        $this->placement = $banner->placement;
        $this->sort_order = $banner->sort_order;
        $this->is_active = $banner->is_active;
    }

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'placement' => ['required', 'in:' . implode(',', array_keys($this->placements))],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ];
    }

    public function update(): void
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'subtitle' => $this->subtitle ?: null,
            'placement' => $this->placement,
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active,
        ];

        if ($this->image) {
            if (
                $this->banner->image &&
                Storage::disk('public')->exists($this->banner->image)
            ) {
                Storage::disk('public')->delete($this->banner->image);
            }

            $data['image'] = $this->image->store('banners', 'public');
        }

        $this->banner->update($data);

        session()->flash('success', 'Banner berhasil diperbarui.');

        $this->redirectRoute('admin.banners.index', navigate: true);
    }
};
?>

<div class="space-y-6">

    {{-- Header --}}
    <div>
        <a
            href="{{ route('admin.banners.index') }}"
            wire:navigate
            class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
        >
            ← Kembali ke Banner Manager
        </a>

        <h1 class="mt-3 text-2xl font-bold text-gray-900 dark:text-white">
            Edit Banner
        </h1>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Perbarui informasi dan tampilan banner.
        </p>
    </div>


    {{-- Form --}}
    <form wire:submit="update" class="space-y-6">

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">

            <div class="grid gap-6 lg:grid-cols-2">

                {{-- Title --}}
                <div class="lg:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Judul Banner
                    </label>

                    <input
                        type="text"
                        wire:model="title"
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-primary focus:ring-1 focus:ring-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    >

                    @error('title')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Subtitle --}}
                <div class="lg:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Subtitle
                    </label>

                    <textarea
                        wire:model="subtitle"
                        rows="3"
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-primary focus:ring-1 focus:ring-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    ></textarea>

                    @error('subtitle')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Placement --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Placement
                    </label>

                    <select
                        wire:model="placement"
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-primary focus:ring-1 focus:ring-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    >
                        @foreach ($placements as $value => $label)
                            <option value="{{ $value }}">
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    @error('placement')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Sort --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Urutan
                    </label>

                    <input
                        type="number"
                        min="0"
                        wire:model="sort_order"
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-primary focus:ring-1 focus:ring-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    >

                    @error('sort_order')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Current Image --}}
                <div class="lg:col-span-2">

                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Gambar Saat Ini
                    </label>

                    <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700">
                        <img
                            src="{{ asset('storage/' . $banner->image) }}"
                            alt="{{ $banner->title }}"
                            class="max-h-80 w-full object-cover"
                        >
                    </div>

                </div>


                {{-- New Image --}}
                <div class="lg:col-span-2">

                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Ganti Gambar
                    </label>

                    <input
                        type="file"
                        wire:model="image"
                        accept="image/jpeg,image/png,image/webp"
                        class="block w-full rounded-lg border border-gray-300 bg-white text-sm text-gray-700 file:mr-4 file:border-0 file:bg-gray-100 file:px-4 file:py-2.5 file:text-sm file:font-medium dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:file:bg-gray-600"
                    >

                    <p class="mt-1 text-xs text-gray-500">
                        Kosongkan jika tidak ingin mengganti gambar. Maksimal 5 MB.
                    </p>

                    @error('image')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror


                    @if ($image)

                        <div class="mt-4 overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700">
                            <img
                                src="{{ $image->temporaryUrl() }}"
                                alt="Preview"
                                class="max-h-80 w-full object-cover"
                            >
                        </div>

                    @endif

                </div>


                {{-- Status --}}
                <div class="lg:col-span-2">
                    <label class="flex cursor-pointer items-center gap-3">

                        <input
                            type="checkbox"
                            wire:model="is_active"
                            class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary"
                        >

                        <span>
                            <span class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Banner aktif
                            </span>

                            <span class="block text-xs text-gray-500 dark:text-gray-400">
                                Banner akan ditampilkan di website jika aktif.
                            </span>
                        </span>

                    </label>
                </div>

            </div>

        </div>


        {{-- Buttons --}}
        <div class="flex justify-end gap-3">

            <a
                href="{{ route('admin.banners.index') }}"
                wire:navigate
                class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700"
            >
                Batal
            </a>

            <button
                type="submit"
                wire:loading.attr="disabled"
                class="rounded-lg bg-primary px-5 py-2.5 text-sm font-semibold text-white hover:opacity-90 disabled:opacity-50"
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