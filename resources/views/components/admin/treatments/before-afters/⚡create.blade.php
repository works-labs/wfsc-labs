<?php

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use App\Models\Treatment;
use App\Models\TreatmentBeforeAfter;
use Illuminate\Support\Facades\Storage;

new #[Layout('layouts.admin')] class extends Component
{
    use WithFileUploads;

    public Treatment $treatment;

    public $before_media;
    public $after_media;

    public string $caption = '';
    public int $sort_order = 0;
    public bool $is_active = true;

    public function mount(Treatment $treatment): void
    {
        $this->treatment = $treatment;
    }

    public function save(): void
    {
        $validated = $this->validate([
            'before_media' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,webp,mp4,webm,mov',
                'max:51200',
            ],

            'after_media' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,webp,mp4,webm,mov',
                'max:51200',
            ],

            'caption' => [
                'nullable',
                'string',
            ],

            'sort_order' => [
                'required',
                'integer',
                'min:0',
            ],

            'is_active' => [
                'boolean',
            ],
        ]);

        $beforePath = $this->before_media->store(
            'treatments/before-after',
            'public'
        );

        $afterPath = $this->after_media->store(
            'treatments/before-after',
            'public'
        );

        TreatmentBeforeAfter::create([
            'treatment_id' => $this->treatment->id,
            'before_media' => $beforePath,
            'after_media' => $afterPath,
            'caption' => $validated['caption'],
            'sort_order' => $validated['sort_order'],
            'is_active' => $validated['is_active'],
        ]);

        session()->flash(
            'success',
            'Before & After berhasil ditambahkan.'
        );

        $this->redirect(
            route(
                'admin.treatments.before-afters.index',
                $this->treatment
            ),
            navigate: true
        );
    }
};
?>

{{-- Pembungkus utama tunggal (Root Element) --}}
<div>
    <form wire:submit="save">
        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Before Media
                </label>

                <input
                    type="file"
                    wire:model="before_media"
                    accept="image/*,video/*"
                    class="mt-2 block w-full rounded-lg border-gray-300"
                >

                @error('before_media')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <div wire:loading wire:target="before_media" class="mt-2 text-sm text-gray-500">
                    Uploading...
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    After Media
                </label>

                <input
                    type="file"
                    wire:model="after_media"
                    accept="image/*,video/*"
                    class="mt-2 block w-full rounded-lg border-gray-300"
                >

                @error('after_media')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <div wire:loading wire:target="after_media" class="mt-2 text-sm text-gray-500">
                    Uploading...
                </div>
            </div>
        </div>

        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-700">
                Caption
            </label>

            <textarea
                wire:model="caption"
                rows="4"
                class="mt-2 block w-full rounded-lg border-gray-300"
                placeholder="Deskripsi atau keterangan Before & After..."
            ></textarea>

            @error('caption')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-6 grid gap-6 md:grid-cols-2">
            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Sort Order
                </label>

                <input
                    type="number"
                    wire:model="sort_order"
                    min="0"
                    class="mt-2 block w-full rounded-lg border-gray-300"
                >

                @error('sort_order')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center pt-8">
                <label class="flex items-center gap-2">
                    <input
                        type="checkbox"
                        wire:model="is_active"
                        class="rounded border-gray-300"
                    >

                    <span class="text-sm text-gray-700">
                        Active
                    </span>
                </label>
            </div>
        </div>

        {{-- Tombol Submit --}}
        <div class="mt-6 flex justify-end">
            <button
                type="submit"
                class="rounded-lg bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700 disabled:opacity-50"
                wire:loading.attr="disabled"
            >
                Simpan
            </button>
        </div>
    </form>
</div>