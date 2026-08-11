<?php

use App\Models\Treatment;
use App\Models\TreatmentVideo;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

new #[Layout('layouts.admin')] class extends Component
{
    use WithFileUploads;

    public Treatment $treatment;

    public string $title = '';
    public string $description = '';
    public $video = null;
    public int $sort_order = 0;
    public bool $is_active = true;

    public function mount(Treatment $treatment): void
    {
        $this->treatment = $treatment;
    }

    public function save(): void
    {
        $validated = $this->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'video' => [
                'required',
                'file',
                'mimetypes:video/mp4,video/webm,video/quicktime',
                'max:51200',
            ],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        $videoPath = $this->video->store('treatment-videos', 'public');

        TreatmentVideo::create([
            'treatment_id' => $this->treatment->id,
            'title' => $validated['title'],
            'video_path' => $videoPath,
            'description' => $validated['description'],
            'sort_order' => $validated['sort_order'],
            'is_active' => $validated['is_active'],
        ]);

        session()->flash(
            'success',
            'Procedure video added successfully.'
        );

        $this->redirect(
            route('admin.treatments.videos.index', $this->treatment),
            navigate: true
        );
    }
};
?>

<div class="mx-auto max-w-4xl space-y-6">

    {{-- Header --}}
    <div>

        <a
            href="{{ route('admin.treatments.videos.index', $treatment) }}"
            wire:navigate
            class="text-sm text-gray-500 hover:text-gray-900"
        >
            ← Back to Procedure Videos
        </a>

        <h1 class="mt-2 text-2xl font-bold">
            Add Procedure Video
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Add a procedure video for
            <span class="font-medium text-gray-700">
                {{ $treatment->name }}
            </span>
        </p>

    </div>


    {{-- Form --}}
    <form
        wire:submit="save"
        class="space-y-6"
    >

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
                    placeholder="Procedure video title"
                >

                @error('title')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Description --}}
            <div>

                <label class="block text-sm font-medium">
                    Description
                </label>

                <textarea
                    wire:model="description"
                    rows="4"
                    class="mt-1 w-full rounded-lg border-gray-300"
                    placeholder="Describe this procedure video..."
                ></textarea>

                @error('description')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Video --}}
            <div>

                <label class="block text-sm font-medium">
                    Procedure Video
                </label>

                <input
                    type="file"
                    wire:model="video"
                    accept="video/mp4,video/webm,video/quicktime"
                    class="mt-1 block w-full text-sm"
                >

                <p class="mt-1 text-xs text-gray-500">
                    Supported formats: MP4, WebM, MOV. Maximum size: 50 MB.
                </p>

                @error('video')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror


                {{-- Loading --}}
                <div
                    wire:loading
                    wire:target="video"
                    class="mt-3 text-sm text-gray-500"
                >
                    Uploading video...
                </div>


                {{-- Preview --}}
                @if ($video)

                    <div class="mt-4">

                        <p class="mb-2 text-sm text-gray-500">
                            Preview
                        </p>

                        <video
                            src="{{ $video->temporaryUrl() }}"
                            controls
                            class="max-h-96 w-full rounded-xl bg-black object-contain"
                        ></video>

                    </div>

                @endif

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

                <p class="mt-1 text-xs text-gray-500">
                    Lower numbers appear first.
                </p>

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

                <p class="mt-1 text-xs text-gray-500">
                    Only active videos will be displayed on the public website.
                </p>

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
                wire:target="save"
                class="rounded-lg bg-black px-5 py-2.5 text-sm font-semibold text-white hover:bg-gray-800 disabled:cursor-not-allowed disabled:opacity-50"
            >
                <span wire:loading.remove wire:target="save">
                    Save Video
                </span>

                <span wire:loading wire:target="save">
                    Saving...
                </span>
            </button>

        </div>

    </form>

</div>