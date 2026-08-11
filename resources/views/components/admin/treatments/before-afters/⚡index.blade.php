<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use App\Models\Treatment;
use App\Models\TreatmentBeforeAfter;
use Illuminate\Support\Facades\Storage;


new #[Layout('layouts.admin')] class extends Component
{
    public Treatment $treatment;

    public function mount(Treatment $treatment): void
    {
        $this->treatment = $treatment;
    }

    #[Computed]
    public function beforeAfters()
    {
        return TreatmentBeforeAfter::query()
            ->where('treatment_id', $this->treatment->id)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
    }

    public function delete(int $id): void
    {
        $beforeAfter = TreatmentBeforeAfter::query()
            ->where('treatment_id', $this->treatment->id)
            ->findOrFail($id);

        if ($beforeAfter->before_media) {
            Storage::disk('public')->delete($beforeAfter->before_media);
        }

        if ($beforeAfter->after_media) {
            Storage::disk('public')->delete($beforeAfter->after_media);
        }

        $beforeAfter->delete();

        session()->flash(
            'success',
            'Before & After berhasil dihapus.'
        );
    }
};
?>

<div>
    <div class="mb-6 flex items-center justify-between">
        <div>
            <div class="mb-1">
                <a
                    href="{{ route('admin.treatments.index') }}"
                    wire:navigate
                    class="text-sm text-gray-500 hover:text-gray-700"
                >
                    ← Back to Treatments
                </a>
            </div>

            <h1 class="text-2xl font-bold text-gray-900">
                Before & After
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                {{ $treatment->name }}
            </p>
        </div>

        <a
            href="{{ route('admin.treatments.before-afters.create', $treatment) }}"
            wire:navigate
            class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800"
        >
            + Add Before & After
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if ($this->beforeAfters->isEmpty())
        <div class="rounded-xl bg-white p-10 text-center shadow-sm">
            <p class="text-sm text-gray-500">
                Belum ada Before & After untuk treatment ini.
            </p>

            <a
                href="{{ route('admin.treatments.before-afters.create', $treatment) }}"
                wire:navigate
                class="mt-4 inline-block text-sm font-medium text-blue-600 hover:underline"
            >
                Tambahkan Before & After
            </a>
        </div>
    @else
        <div class="space-y-6">
            @foreach ($this->beforeAfters as $beforeAfter)
                <div class="overflow-hidden rounded-xl bg-white shadow-sm">
                    <div class="grid gap-6 p-6 md:grid-cols-2">

                        {{-- Before --}}
                        <div>
                            <p class="mb-2 text-xs font-semibold uppercase text-gray-500">
                                Before
                            </p>

                            @php
                                $beforeUrl = Storage::url($beforeAfter->before_media);
                                $beforeExtension = strtolower(
                                    pathinfo($beforeAfter->before_media, PATHINFO_EXTENSION)
                                );
                            @endphp

                            @if (in_array($beforeExtension, ['mp4', 'webm', 'mov']))
                                <video
                                    controls
                                    class="h-48 w-full rounded-lg bg-black object-contain"
                                >
                                    <source
                                        src="{{ $beforeUrl }}"
                                        type="video/{{ $beforeExtension === 'mov' ? 'quicktime' : $beforeExtension }}"
                                    >
                                    Browser kamu tidak mendukung video.
                                </video>
                            @else
                                <img
                                    src="{{ $beforeUrl }}"
                                    alt="Before"
                                    class="h-48 w-full rounded-lg object-cover"
                                >
                            @endif
                        </div>

                        {{-- After --}}
                       <div>
                        <p class="mb-2 text-xs font-semibold uppercase text-gray-500">
                            After
                        </p>

                        @php
                            $afterUrl = Storage::url($beforeAfter->after_media);
                            $afterExtension = strtolower(
                                pathinfo($beforeAfter->after_media, PATHINFO_EXTENSION)
                            );
                        @endphp

                        @if (in_array($afterExtension, ['mp4', 'webm', 'mov']))
                            <video
                                controls
                                class="h-48 w-full rounded-lg bg-black object-contain"
                            >
                                <source
                                    src="{{ $afterUrl }}"
                                    type="video/{{ $afterExtension === 'mov' ? 'quicktime' : $afterExtension }}"
                                >
                                Browser kamu tidak mendukung video.
                            </video>
                        @else
                            <img
                                src="{{ $afterUrl }}"
                                alt="After"
                                class="h-48 w-full rounded-lg object-cover"
                            >
                        @endif
                    </div>
                    </div>

                    <div class="border-t px-6 py-4">
                        <div class="flex items-center justify-between gap-4">

                            <div>
                                @if ($beforeAfter->caption)
                                    <p class="text-sm text-gray-600">
                                        {{ $beforeAfter->caption }}
                                    </p>
                                @endif

                                <p class="mt-1 text-xs text-gray-400">
                                    Order: {{ $beforeAfter->sort_order }}
                                    ·
                                    {{ $beforeAfter->is_active ? 'Active' : 'Inactive' }}
                                </p>
                            </div>

                            <div class="flex items-center gap-4">
                                <a
                                    href="{{ route('admin.treatments.before-afters.edit', [$treatment, $beforeAfter]) }}"
                                    wire:navigate
                                    class="text-sm font-medium text-blue-600 hover:underline"
                                >
                                    Edit
                                </a>

                                <button
                                    type="button"
                                    wire:click="delete({{ $beforeAfter->id }})"
                                    wire:confirm="Hapus Before & After ini?"
                                    class="text-sm font-medium text-red-600 hover:underline"
                                >
                                    Delete
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>