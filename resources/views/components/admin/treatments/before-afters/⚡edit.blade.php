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
    public TreatmentBeforeAfter $beforeAfter;

    public $before_media = null;
    public $after_media = null;

    public string $caption = '';
    public int $sort_order = 0;
    public bool $is_active = true;

    public function mount(
        Treatment $treatment,
        TreatmentBeforeAfter $beforeAfter
    ): void {
        $this->treatment = $treatment;
        $this->beforeAfter = $beforeAfter;

        $this->caption = $beforeAfter->caption ?? '';
        $this->sort_order = (int) $beforeAfter->sort_order;
        $this->is_active = (bool) $beforeAfter->is_active;
    }

    public function update(): void
    {
        $validated = $this->validate([
            'before_media' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,webp,avif,mp4,webm,mov',
                'max:51200',
            ],

            'after_media' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,webp,avif,mp4,webm,mov',
                'max:51200',
            ],

            'caption' => ['nullable', 'string'],

            'sort_order' => [
                'required',
                'integer',
                'min:0',
            ],

            'is_active' => ['boolean'],
        ]);

        if ($this->before_media) {
            if (
                $this->beforeAfter->before_media &&
                Storage::disk('public')->exists(
                    $this->beforeAfter->before_media
                )
            ) {
                Storage::disk('public')->delete(
                    $this->beforeAfter->before_media
                );
            }

            $validated['before_media'] = $this->before_media->store(
                'treatments/before-after',
                'public'
            );
        }

        if ($this->after_media) {
            if (
                $this->beforeAfter->after_media &&
                Storage::disk('public')->exists(
                    $this->beforeAfter->after_media
                )
            ) {
                Storage::disk('public')->delete(
                    $this->beforeAfter->after_media
                );
            }

            $validated['after_media'] = $this->after_media->store(
                'treatments/before-after',
                'public'
            );
        }

        $this->beforeAfter->update([
            'before_media' =>
                $validated['before_media']
                ?? $this->beforeAfter->before_media,

            'after_media' =>
                $validated['after_media']
                ?? $this->beforeAfter->after_media,

            'caption' => $validated['caption'],
            'sort_order' => $validated['sort_order'],
            'is_active' => $validated['is_active'],
        ]);

        session()->flash(
            'success',
            'Before & After berhasil diperbarui.'
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

<div>

    {{-- Header --}}
    <div class="mb-6">
        <a
            href="{{ route('admin.treatments.before-afters.index', $treatment) }}"
            wire:navigate
            class="text-sm text-gray-500 hover:text-gray-700"
        >
            ← Back to Before & After
        </a>

        <h1 class="mt-3 text-2xl font-bold text-gray-900">
            Edit Before & After
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            {{ $treatment->name }}
        </p>
    </div>

    <form wire:submit="update">

        {{-- Media --}}
        <div class="rounded-xl bg-white p-6 shadow-sm">

            <h2 class="text-lg font-semibold text-gray-900">
                Media
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Pilih file baru hanya jika ingin mengganti media.
            </p>

            <div class="mt-6 grid gap-6 md:grid-cols-2">

                {{-- BEFORE --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Before
                    </label>

                    {{-- Current Media --}}
                    <div class="mt-2 overflow-hidden rounded-lg bg-gray-100">

                        @php
                            $url = Storage::url($beforeAfter->before_media);

                            $extension = strtolower(
                                pathinfo(
                                    $beforeAfter->before_media,
                                    PATHINFO_EXTENSION
                                )
                            );
                        @endphp

                        @if (in_array($extension, ['mp4', 'webm', 'mov']))
                            <video
                                controls
                                class="h-48 w-full bg-black object-contain"
                            >
                                <source src="{{ $url }}">
                            </video>
                        @else
                            <img
                                src="{{ $url }}"
                                alt="Before"
                                class="h-48 w-full object-cover"
                            >
                        @endif

                    </div>

                    <p class="mt-2 text-xs text-gray-500">
                        Current:
                        {{ basename($beforeAfter->before_media) }}
                    </p>

                    {{-- New File --}}
                    <input
                        type="file"
                        wire:model="before_media"
                        accept="image/*,video/*"
                        class="mt-3 block w-full rounded-lg border-gray-300"
                    >

                    @if ($before_media)
                        <p class="mt-2 text-xs text-blue-600">
                            File baru:
                            {{ $before_media->getClientOriginalName() }}
                        </p>
                    @endif

                    @error('before_media')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                    <div
                        wire:loading
                        wire:target="before_media"
                        class="mt-2 text-sm text-gray-500"
                    >
                        Uploading...
                    </div>
                </div>


                {{-- AFTER --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        After
                    </label>

                    {{-- Current Media --}}
                    <div class="mt-2 overflow-hidden rounded-lg bg-gray-100">

                        @php
                            $url = Storage::url($beforeAfter->after_media);

                            $extension = strtolower(
                                pathinfo(
                                    $beforeAfter->after_media,
                                    PATHINFO_EXTENSION
                                )
                            );
                        @endphp

                        @if (in_array($extension, ['mp4', 'webm', 'mov']))
                            <video
                                controls
                                class="h-48 w-full bg-black object-contain"
                            >
                                <source src="{{ $url }}">
                            </video>
                        @else
                            <img
                                src="{{ $url }}"
                                alt="After"
                                class="h-48 w-full object-cover"
                            >
                        @endif

                    </div>

                    <p class="mt-2 text-xs text-gray-500">
                        Current:
                        {{ basename($beforeAfter->after_media) }}
                    </p>

                    {{-- New File --}}
                    <input
                        type="file"
                        wire:model="after_media"
                        accept="image/*,video/*"
                        class="mt-3 block w-full rounded-lg border-gray-300"
                    >

                    @if ($after_media)
                        <p class="mt-2 text-xs text-blue-600">
                            File baru:
                            {{ $after_media->getClientOriginalName() }}
                        </p>
                    @endif

                    @error('after_media')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                    <div
                        wire:loading
                        wire:target="after_media"
                        class="mt-2 text-sm text-gray-500"
                    >
                        Uploading...
                    </div>
                </div>

            </div>
        </div>


        {{-- Information --}}
        <div class="mt-6 rounded-xl bg-white p-6 shadow-sm">

            <h2 class="text-lg font-semibold text-gray-900">
                Information
            </h2>

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
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
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
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="flex items-center pt-7">

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

        </div>


        {{-- Actions --}}
        <div class="mt-6 flex justify-end gap-3">

            <a
                href="{{ route('admin.treatments.before-afters.index', $treatment) }}"
                wire:navigate
                class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
                Cancel
            </a>

            <button
                type="submit"
                wire:loading.attr="disabled"
                class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 disabled:opacity-50"
            >
                <span wire:loading.remove>
                    Update
                </span>

                <span wire:loading>
                    Updating...
                </span>
            </button>
        </div>
    </form>
</div>
