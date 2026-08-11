<?php

use App\Models\Treatment;
use App\Models\TreatmentVideo;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.admin')] class extends Component
{
    public Treatment $treatment;

    public function mount(Treatment $treatment): void
    {
        $this->treatment = $treatment;
    }

    public function delete(TreatmentVideo $video): void
    {
        abort_unless($video->treatment_id === $this->treatment->id, 404);

        if ($video->video_path) {
            Storage::disk('public')->delete($video->video_path);
        }

        $video->delete();

        session()->flash('success', 'Procedure video deleted successfully.');
    }

    public function with(): array
    {
        return [
            'videos' => $this->treatment
                ->procedureVideos()
                ->get(),
        ];
    }
};
?>

<div class="mx-auto max-w-6xl space-y-6">

    {{-- Header --}}
    <div class="flex items-start justify-between gap-4">

        <div>
            <a
                href="{{ route('admin.treatments.index') }}"
                wire:navigate
                class="text-sm text-gray-500 hover:text-gray-900"
            >
                ← Back to Treatments
            </a>

            <h1 class="mt-2 text-2xl font-bold">
                Procedure Videos
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Manage procedure videos for
                <span class="font-medium text-gray-700">
                    {{ $treatment->name }}
                </span>
            </p>
        </div>

        <a
            href="{{ route('admin.treatments.videos.create', $treatment) }}"
            wire:navigate
            class="rounded-lg bg-black px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-800"
        >
            + Add Video
        </a>

    </div>


    {{-- Success --}}
    @if (session('success'))
        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif


    {{-- Videos --}}
    <div class="rounded-xl border bg-white shadow-sm">

        @if ($videos->isEmpty())

            <div class="px-6 py-12 text-center">

                <p class="text-sm text-gray-500">
                    No procedure videos yet.
                </p>

                <a
                    href="{{ route('admin.treatments.videos.create', $treatment) }}"
                    wire:navigate
                    class="mt-4 inline-flex rounded-lg bg-black px-4 py-2 text-sm font-semibold text-white hover:bg-gray-800"
                >
                    Add First Video
                </a>

            </div>

        @else

            <div class="divide-y">

                @foreach ($videos as $video)

                    <div class="flex items-center gap-5 px-6 py-5">

                        {{-- Video Preview --}}
                        <div class="h-28 w-44 shrink-0 overflow-hidden rounded-xl bg-black">

                            <video
                                src="{{ Storage::url($video->video_path) }}"
                                class="h-full w-full object-cover"
                                controls
                                preload="metadata"
                            ></video>

                        </div>


                        {{-- Information --}}
                        <div class="min-w-0 flex-1">

                            <div class="flex items-center gap-3">

                                <h2 class="truncate text-sm font-semibold text-gray-900">
                                    {{ $video->title ?: 'Untitled Video' }}
                                </h2>

                                @if ($video->is_active)
                                    <span class="rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-700">
                                        Active
                                    </span>
                                @else
                                    <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-500">
                                        Inactive
                                    </span>
                                @endif

                            </div>

                            @if ($video->description)
                                <p class="mt-2 line-clamp-2 text-sm text-gray-500">
                                    {{ $video->description }}
                                </p>
                            @endif

                            <p class="mt-2 text-xs text-gray-400">
                                Order: {{ $video->sort_order }}
                            </p>

                        </div>


                        {{-- Actions --}}
                        <div class="flex shrink-0 gap-2">

                            <a
                                href="{{ route('admin.treatments.videos.edit', [$treatment, $video]) }}"
                                wire:navigate
                                class="rounded-lg border px-3 py-2 text-xs font-medium hover:bg-gray-50"
                            >
                                Edit
                            </a>

                            <button
                                type="button"
                                wire:click="delete({{ $video->id }})"
                                wire:confirm="Delete this procedure video?"
                                class="rounded-lg bg-red-600 px-3 py-2 text-xs font-medium text-white hover:bg-red-700"
                            >
                                Delete
                            </button>

                        </div>

                    </div>

                @endforeach

            </div>

        @endif

    </div>

</div>