<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Livewire\Attributes\Computed;

use App\Models\HeroBanner;
use App\Models\Treatment;
use App\Models\Doctor;
use App\Models\News;

new #[Layout('layouts.admin')] class extends Component
{
    use WithFileUploads;

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

    public function save(): void
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

        if ($this->background_image) {
            $validated['background_image'] = $this->background_image
                ->store('hero-banners', 'public');
        }

        $position = $validated['sort_order'];

        HeroBanner::where('sort_order', '>=', $position)
            ->increment('sort_order');

        HeroBanner::create($validated);

        session()->flash('success', 'Hero banner created successfully.');

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
            Add Hero Banner
        </h1>

        <p class="mt-2 text-gray-600">
            Create a hero banner displayed on the WFSC website.
        </p>
    </div>

    <form wire:submit="save" class="max-w-4xl space-y-6">

        {{-- Title --}}
        <div>
            <label class="mb-2 block text-sm font-medium">
                Title
            </label>

            <input
                type="text"
                wire:model="title"
                class="w-full rounded-lg border px-4 py-2"
                placeholder="Example: Your Skin, Our Passion"
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
                placeholder="Short description for the hero section..."
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

            <input
                type="file"
                wire:model="background_image"
                accept="image/*"
                class="w-full rounded-lg border px-4 py-2"
            >

            <p class="mt-1 text-xs text-gray-500">
                Recommended: large landscape image. Maximum 4 MB.
            </p>

            @error('background_image')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror

            @if ($background_image)
                <div class="mt-4">
                    <p class="mb-2 text-sm text-gray-500">
                        Preview
                    </p>

                    <img
                        src="{{ $background_image->temporaryUrl() }}"
                        alt="Hero banner preview"
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
                    placeholder="Book Appointment"
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
                Save Hero Banner
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