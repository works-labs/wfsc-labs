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

<div class="mx-auto max-w-4xl space-y-8 pb-10">

    {{-- Top Navigation & Header --}}
    <div>
        <a
            href="{{ route('admin.banners.index') }}"
            wire:navigate
            class="inline-flex items-center gap-2 text-sm font-bold text-gray-400 transition-colors hover:text-[var(--color-wfsc-coral)]"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Banner Manager
        </a>

        <div class="mt-4 flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-500 shadow-sm">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
            </div>
            <div>
                <h1 class="text-2xl font-black tracking-tight text-[var(--color-wfsc-dark)]">
                    Edit Banner
                </h1>
                <p class="text-sm font-medium text-gray-500">
                    Perbarui informasi dan tampilan banner.
                </p>
            </div>
        </div>
    </div>

    {{-- Form --}}
    <form wire:submit="update" class="space-y-8">

        <div class="relative overflow-hidden rounded-2xl border border-gray-100/50 bg-white p-8 elegant-shadow">
            <div class="absolute left-0 top-0 h-full w-1 bg-blue-400"></div>

            <div class="mb-6 flex items-center gap-3">
                <div class="rounded-lg bg-blue-50 p-2 text-blue-500">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h2 class="text-lg font-bold text-[var(--color-wfsc-dark)]">Informasi Banner</h2>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">

                {{-- Title --}}
                <div class="lg:col-span-2">
                    <label class="mb-2 block text-sm font-bold text-gray-600">
                        Judul Banner
                    </label>

                    <input
                        type="text"
                        wire:model="title"
                        class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                    >

                    @error('title')
                        <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Subtitle --}}
                <div class="lg:col-span-2">
                    <label class="mb-2 block text-sm font-bold text-gray-600">
                        Subtitle
                    </label>

                    <textarea
                        wire:model="subtitle"
                        rows="3"
                        class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                    ></textarea>

                    @error('subtitle')
                        <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Placement --}}
                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">
                        Placement
                    </label>

                    <select
                        wire:model="placement"
                        class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                    >
                        @foreach ($placements as $value => $label)
                            <option value="{{ $value }}">
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    @error('placement')
                        <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Sort --}}
                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">
                        Urutan
                    </label>

                    <input
                        type="number"
                        min="0"
                        wire:model="sort_order"
                        class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                    >

                    @error('sort_order')
                        <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Current Image --}}
                <div class="lg:col-span-2">
                    <label class="mb-2 block text-sm font-bold text-gray-600">
                        Gambar Saat Ini
                    </label>

                    <div class="overflow-hidden rounded-2xl border border-gray-100 shadow-sm ring-4 ring-gray-50">
                        <img
                            src="{{ asset('storage/' . $banner->image) }}"
                            alt="{{ $banner->title }}"
                            class="max-h-80 w-full object-cover"
                        >
                    </div>
                </div>

                {{-- New Image --}}
                <div class="lg:col-span-2">
                    <label class="mb-2 block text-sm font-bold text-gray-600">
                        Ganti Gambar
                    </label>

                    <input
                        type="file"
                        wire:model="image"
                        accept="image/jpeg,image/png,image/webp"
                        class="block w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-2.5 text-sm text-gray-600 transition-colors file:mr-4 file:rounded-lg file:border-0 file:bg-white file:px-4 file:py-2 file:text-sm file:font-bold file:text-[var(--color-wfsc-coral)] file:shadow-sm hover:file:bg-rose-50 focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                    >

                    <p class="mt-1.5 text-xs font-medium text-gray-400">
                        Kosongkan jika tidak ingin mengganti gambar. Maksimal 5 MB.
                    </p>

                    @error('image')
                        <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                    @enderror

                    @if ($image)
                        <div class="mt-4 overflow-hidden rounded-2xl border border-gray-100 shadow-sm ring-4 ring-gray-50">
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
                    <label class="inline-flex cursor-pointer items-center gap-3 rounded-xl border border-gray-100 bg-gray-50 p-4 w-full transition-colors hover:bg-gray-100">
                        <input
                            type="checkbox"
                            wire:model="is_active"
                            class="h-5 w-5 rounded-md border-gray-300 text-[var(--color-wfsc-coral)] focus:ring-[var(--color-wfsc-coral)]"
                        >
                        <div>
                            <span class="block text-sm font-bold text-gray-800">
                                Banner aktif
                            </span>
                            <span class="block text-xs font-medium text-gray-500">
                                Banner akan ditampilkan di website jika aktif.
                            </span>
                        </div>
                    </label>
                </div>

            </div>
        </div>

        {{-- Buttons --}}
        <div class="flex items-center justify-end gap-4 pt-4">
            <a
                href="{{ route('admin.banners.index') }}"
                wire:navigate
                class="rounded-xl px-5 py-3 text-sm font-bold text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-800"
            >
                Batal
            </a>

            <button
                type="submit"
                wire:loading.attr="disabled"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[var(--color-wfsc-coral)] to-[#ff7676] px-8 py-3 text-sm font-bold text-white shadow-lg shadow-[var(--color-wfsc-coral)]/30 transition-all duration-300 hover:scale-[1.02] hover:shadow-xl hover:shadow-[var(--color-wfsc-coral)]/40 disabled:opacity-70 disabled:hover:scale-100"
            >
                <span wire:loading.remove wire:target="update">
                    Simpan Perubahan
                </span>

                <span wire:loading wire:target="update">
                    <svg class="h-4 w-4 animate-spin text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Menyimpan...
                </span>
            </button>
        </div>

    </form>
</div>