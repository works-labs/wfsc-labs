<?php

use App\Models\Treatment;
use App\Models\TreatmentVideo;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.admin')] class extends Component
{
    public Treatment $treatment;
    public TreatmentVideo $video;

    public string $title = '';
    public string $video_path = '';
    public string $description = '';
    public int $sort_order = 0;
    public bool $is_active = true;

    public function mount(
        Treatment $treatment,
        TreatmentVideo $video
    ): void {
        $this->treatment = $treatment;
        $this->video = $video;

        $this->title = $video->title ?? '';
        $this->video_path = $video->video_path ?? '';
        $this->description = $video->description ?? '';
        $this->sort_order = $video->sort_order ?? 0;
        $this->is_active = (bool) $video->is_active;
    }

    public function update(): void
    {
        $validated = $this->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'video_path' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        $this->video->update($validated);

        session()->flash('success', 'Treatment video updated successfully.');

        $this->redirect(
            route(
                'admin.treatments.videos.index',
                $this->treatment
            ),
            navigate: true
        );
    }
};
?>

<div class="mx-auto max-w-4xl space-y-6">

    <div>
        <a
            href="{{ route('admin.treatments.videos.index', $treatment) }}"
            wire:navigate
            class="text-sm text-gray-500 hover:text-gray-900"
        >
            ← Back to Treatment Videos
        </a>

        <h1 class="mt-2 text-2xl font-bold">
            Edit Treatment Video
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Update the procedure video for
            <span class="font-medium text-gray-700">
                {{ $treatment->name }}
            </span>.
        </p>
    </div>

    <form wire:submit="update" class="space-y-6">

        <div class="space-y-5 rounded-xl border bg-white p-6 shadow-sm">

            {{-- Title --}}
            <div>
                <label class="block text-sm font-medium">
                    Title
                </label>

                <input
                    type="text"
                    wire:model="title"
                    class="mt-1 w-full rounded-lg border-gray-300"
                    placeholder="Procedure Video"
                >

                @error('title')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- YouTube Shorts Link --}}
            <div>
                <label class="block text-sm font-medium">
                    YouTube Shorts URL / Path
                </label>

                <input
                    type="text"
                    wire:model.live="video_path"
                    class="mt-1 w-full rounded-lg border-gray-300"
                    placeholder="https://www.youtube.com/shorts/VIDEO_ID atau VIDEO_ID"
                >

                <p class="mt-1 text-xs text-gray-500">
                    Masukkan URL penuh YouTube Shorts atau ID videonya saja.
                </p>

                @error('video_path')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

                {{-- Preview --}}
                @if ($video_path)
                    <div class="mt-4">
                        <p class="mb-2 text-sm text-gray-500">
                            Video Preview
                        </p>

                        <div class="aspect-[9/16] max-w-xs overflow-hidden rounded-xl bg-black">
                            <iframe
                                class="h-full w-full"
                                src="https://www.youtube.com/embed/{{ Str::afterLast($video_path, '/') }}"
                                title="YouTube Shorts Preview"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen
                            ></iframe>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-sm font-medium">
                    Description
                </label>

                <textarea
                    wire:model="description"
                    rows="5"
                    class="mt-1 w-full rounded-lg border-gray-300"
                    placeholder="Describe the procedure shown in this video..."
                ></textarea>

                @error('description')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Sort Order --}}
            <div>
                <label class="block text-sm font-medium">
                    Sort Order
                </label>

                <input
                    type="number"
                    min="0"
                    wire:model="sort_order"
                    class="mt-1 w-full rounded-lg border-gray-300"
                >

                @error('sort_order')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Active --}}
            <div>
                <label class="flex items-center gap-2">
                    <input
                        type="checkbox"
                        wire:model="is_active"
                        class="rounded"
                    >

                    <span class="text-sm">
                        Active
                    </span>
                </label>
            </div>

        </div>

        {{-- Actions --}}
        <div class="flex justify-end gap-3">

            <a
                href="{{ route('admin.treatments.videos.index', $treatment) }}"
                wire:navigate
                class="rounded-lg border px-5 py-2.5 text-sm font-medium hover:bg-gray-50"
            >
                Cancel
            </a>

            <button
                type="submit"
                wire:loading.attr="disabled"
                class="rounded-lg bg-black px-5 py-2.5 text-sm font-semibold text-white hover:bg-gray-800 disabled:opacity-50"
            >
                <span wire:loading.remove>
                    Update Video
                </span>

                <span wire:loading>
                    Updating...
                </span>
            </button>

        </div>

    </form>

</div>