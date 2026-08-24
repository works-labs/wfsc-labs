<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\DB;
use App\Models\HeroBanner;
use App\Models\Treatment;
use App\Models\Doctor;
use App\Models\News;

new #[Layout('layouts.admin')] class extends Component
{
    use WithFileUploads;

    public HeroBanner $heroBanner;

    public string $title = '';
    public string $subtitle = '';
    public $background_image = null;
    public string $cta_text = '';
    public string $cta_type = 'internal';
    public string $cta_target = '';
    public int $sort_order = 0;
    public bool $is_active = true;

    #[Computed]
    public function treatments()
    {
        return Treatment::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    #[Computed]
    public function doctors()
    {
        return Doctor::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    #[Computed]
    public function news()
    {
        return News::query()
            ->where('is_active', true)
            ->orderByDesc('published_at')
            ->get();
    }

    public function mount(HeroBanner $heroBanner): void
    {
        $this->heroBanner = $heroBanner;

        $this->title = $heroBanner->title;
        $this->subtitle = $heroBanner->subtitle ?? '';
        $this->cta_text = $heroBanner->cta_text ?? '';
        $this->cta_type = $heroBanner->cta_type ?? 'internal';
        $this->cta_target = $heroBanner->cta_target ?? '';
        $this->sort_order = $heroBanner->sort_order;
        $this->is_active = (bool) $heroBanner->is_active;
    }

    public function update(): void
    {
        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string'],
            'background_image' => ['nullable', 'image', 'max:4096'],
            'cta_text' => ['nullable', 'string', 'max:255'],
            'cta_type' => [
                'required',
                'in:internal,treatment,doctor,news,whatsapp,external',
            ],
            'cta_target' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        DB::transaction(function () use ($validated) {

            $oldPosition = $this->heroBanner->sort_order;
            $newPosition = $validated['sort_order'];

            /*
            * Atur ulang posisi banner
            */
            if ($oldPosition !== $newPosition) {

                // Pindah ke posisi lebih awal
                if ($newPosition < $oldPosition) {

                    HeroBanner::query()
                        ->where('id', '!=', $this->heroBanner->id)
                        ->whereBetween('sort_order', [
                            $newPosition,
                            $oldPosition - 1,
                        ])
                        ->increment('sort_order');

                // Pindah ke posisi lebih akhir
                } else {

                    HeroBanner::query()
                        ->where('id', '!=', $this->heroBanner->id)
                        ->whereBetween('sort_order', [
                            $oldPosition + 1,
                            $newPosition,
                        ])
                        ->decrement('sort_order');
                }
            }

            /*
            * Upload gambar baru jika ada
            */
            if ($this->background_image) {

                $oldImage = $this->heroBanner->background_image;

                $newImage = $this->background_image
                    ->store('hero-banners', 'public');

                $validated['background_image'] = $newImage;

                if ($oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }

            } else {
                unset($validated['background_image']);
            }

            /*
            * Simpan perubahan banner
            */
            $this->heroBanner->update($validated);
        });

        session()->flash(
            'success',
            'Hero banner updated successfully.'
        );

        $this->redirect(
            route('admin.home.hero-banners.index'),
            navigate: true
        );
    }
};

?>

<div>
    <div class="mb-8">
        <h1 class="text-2xl font-bold">
            Edit Hero Banner
        </h1>

        <p class="mt-2 text-gray-600">
            Update hero banner displayed on the WFSC website.
        </p>
    </div>

    <form wire:submit="update" class="max-w-4xl space-y-6">

        {{-- Title --}}
        <div>
            <label class="mb-2 block text-sm font-medium">
                Title
            </label>

            <input
                type="text"
                wire:model="title"
                class="w-full rounded-lg border px-4 py-2"
            >

            @error('title')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Subtitle --}}
        <div>
            <label class="mb-2 block text-sm font-medium">
                Subtitle
            </label>

            <textarea
                wire:model="subtitle"
                rows="4"
                class="w-full rounded-lg border px-4 py-2"
            ></textarea>

            @error('subtitle')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Background Image --}}
        <div>
            <label class="mb-2 block text-sm font-medium">
                Background Image
            </label>

            @if ($heroBanner->background_image)
                <div class="mb-4">
                    <p class="mb-2 text-sm text-gray-500">
                        Current Image
                    </p>

                    <img
                        src="{{ Storage::url($heroBanner->background_image) }}"
                        alt="{{ $heroBanner->title }}"
                        class="h-64 w-full rounded-xl object-cover"
                    >
                </div>
            @endif

            <input
                type="file"
                wire:model="background_image"
                accept="image/*"
                class="w-full rounded-lg border px-4 py-2"
            >

            <p class="mt-1 text-xs text-gray-500">
                Leave empty to keep the current image.
            </p>

            @error('background_image')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror

            @if ($background_image)
                <div class="mt-4">
                    <p class="mb-2 text-sm text-gray-500">
                        New Image Preview
                    </p>

                    <img
                        src="{{ $background_image->temporaryUrl() }}"
                        alt="New hero banner preview"
                        class="h-64 w-full rounded-xl object-cover"
                    >
                </div>
            @endif
        </div>

        {{-- CTA --}}
        <div class="grid gap-6 md:grid-cols-2">

            <div>
                <label class="mb-2 block text-sm font-medium">
                    CTA Text
                </label>

                <input
                    type="text"
                    wire:model="cta_text"
                    class="w-full rounded-lg border px-4 py-2"
                >

                @error('cta_text')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium">
                    CTA Type
                </label>

                <select
                    wire:model.live="cta_type"
                    class="w-full rounded-lg border px-4 py-2"
                >
                    <option value="internal">Internal Page</option>
                    <option value="treatment">Treatment</option>
                    <option value="doctor">Doctor</option>
                    <option value="news">News</option>
                    <option value="whatsapp">WhatsApp</option>
                    <option value="external">External URL</option>
                </select>

                @error('cta_type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            @if ($cta_type === 'internal')
                <div>
                    <label class="mb-2 block text-sm font-medium">
                        CTA Target
                    </label>

                    <select
                        wire:model="cta_target"
                        class="w-full rounded-lg border px-4 py-2"
                    >
                        <option value="">-- Pilih halaman --</option>
                        <option value="home">Home</option>
                        <option value="treatments">Treatments</option>
                        <option value="doctors">Doctors</option>
                        <option value="news">News</option>
                    </select>

                    @error('cta_target')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            @elseif ($cta_type === 'treatment')
                <div>
                    <label class="mb-2 block text-sm font-medium">
                        Treatment
                    </label>

                    <select
                        wire:model="cta_target"
                        class="w-full rounded-lg border px-4 py-2"
                    >
                        <option value="">-- Pilih treatment --</option>

                        @foreach ($this->treatments as $treatment)
                            <option value="{{ $treatment->slug }}">
                                {{ $treatment->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('cta_target')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            @elseif ($cta_type === 'doctor')
                <div>
                    <label class="mb-2 block text-sm font-medium">
                        Doctor
                    </label>

                    <select
                        wire:model="cta_target"
                        class="w-full rounded-lg border px-4 py-2"
                    >
                        <option value="">-- Pilih doctor --</option>

                        @foreach ($this->doctors as $doctor)
                            <option value="{{ $doctor->slug }}">
                                {{ $doctor->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('cta_target')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            @elseif ($cta_type === 'news')
                <div>
                    <label class="mb-2 block text-sm font-medium">
                        News
                    </label>

                    <select
                        wire:model="cta_target"
                        class="w-full rounded-lg border px-4 py-2"
                    >
                        <option value="">-- Pilih news --</option>

                        @foreach ($this->news as $item)
                            <option value="{{ $item->slug }}">
                                {{ $item->title }}
                            </option>
                        @endforeach
                    </select>

                    @error('cta_target')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            @elseif ($cta_type === 'whatsapp')
                <div class="rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700">
                    CTA akan diarahkan ke WhatsApp perusahaan
                    berdasarkan nomor pada Site Settings.
                </div>

            @elseif ($cta_type === 'external')
                <div>
                    <label class="mb-2 block text-sm font-medium">
                        External URL
                    </label>

                    <input
                        type="url"
                        wire:model="cta_target"
                        class="w-full rounded-lg border px-4 py-2"
                        placeholder="https://example.com"
                    >

                    @error('cta_target')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            @endif

        </div>

        {{-- Sort Order --}}
        <div>
            <label class="mb-2 block text-sm font-medium">
                Sort Order
            </label>

            <input
                type="number"
                wire:model="sort_order"
                min="0"
                class="w-full rounded-lg border px-4 py-2"
            >

            @error('sort_order')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Status --}}
        <div class="flex items-center gap-3">
            <input
                type="checkbox"
                wire:model="is_active"
                id="is_active"
                class="rounded"
            >

            <label
                for="is_active"
                class="text-sm font-medium"
            >
                Active
            </label>
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-3 pt-4">

            <button
                type="submit"
                class="rounded-lg bg-black px-5 py-2 font-semibold text-white"
            >
                Update Hero Banner
            </button>

            <a
                href="{{ route('admin.home.hero-banners.index') }}"
                wire:navigate
                class="rounded-lg border px-5 py-2 font-medium"
            >
                Cancel
            </a>

        </div>

    </form>
</div>