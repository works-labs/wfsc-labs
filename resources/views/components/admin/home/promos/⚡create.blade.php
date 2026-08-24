<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Livewire\WithFileUploads;
use App\Models\Promo;
use App\Models\TreatmentProduct;
use App\Models\Treatment;
use App\Models\Doctor;
use App\Models\News;
use Illuminate\Support\Str;

new #[Layout('layouts.admin')] class extends Component
{
    use WithFileUploads;

    public ?int $treatment_product_id = null;
    public string $title = '';
    public string $slug = '';
    public string $description = '';
    public $image = null;
    
    // Dynamic CTA Properties
    public string $cta_text = 'Book Appointment';
    public string $cta_type = 'internal';
    public string $cta_target = '';
    
    public string $start_date = '';
    public string $end_date = '';
    public int $sort_order = 0;
    public bool $is_active = true;

    // Trigger saat Treatment Product dipilih
    public function updatedTreatmentProductId($value): void
    {
        if (! $value) return;

        $product = TreatmentProduct::with('treatment')->find($value);
        if ($product) {
            if (empty($this->title)) {
                $this->title = 'Promo ' . $product->name;
                $this->slug = Str::slug($this->title);
            }
            if (empty($this->description)) {
                $this->description = $product->description ?? '';
            }

            // Otomatis mengarahkan CTA ke Treatment terkait produk jika CTA belum diisi
            if ($product->treatment) {
                $this->cta_type = 'treatment';
                $this->cta_target = $product->treatment->slug;
            }
        }
    }

    // Auto update slug dari title
    public function updatedTitle($value): void
    {
        $this->slug = Str::slug($value);
    }

    // Reset cta_target ketika cta_type berubah
    public function updatedCtaType(): void
    {
        $this->cta_target = '';
    }

    #[Computed]
    public function products()
    {
        return TreatmentProduct::with('treatment')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
    }

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
            'treatment_product_id' => ['nullable', 'exists:treatment_products,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:promos,slug'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:4096'],
            'cta_text' => ['nullable', 'string', 'max:255'],
            'cta_type' => [
                'required',
                'in:internal,treatment,doctor,news,whatsapp,external',
            ],
            'cta_target' => ['nullable', 'string', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        if ($this->image) {
            $validated['image'] = $this->image->store('promos', 'public');
        }

        Promo::create($validated);

        session()->flash('success', 'Promo created successfully.');

        $this->redirect(
            route('admin.home.promos.index'),
            navigate: true
        );
    }
};
?>

<div>
    <div class="mb-8">
        <h1 class="text-2xl font-bold">Add Promo</h1>
        <p class="mt-2 text-gray-600">Add promotional content displayed on the WFSC website.</p>
    </div>

    <form wire:submit="save" class="max-w-4xl space-y-6">

        {{-- Select Treatment Product --}}
        <div class="rounded-xl border border-blue-100 bg-blue-50/50 p-4">
            <label class="mb-2 block text-sm font-semibold text-blue-900">
                Link to Treatment Product (Optional)
            </label>

            <select
                wire:model.live="treatment_product_id"
                class="w-full rounded-lg border bg-white px-4 py-2 text-sm"
            >
                <option value="">-- Manual Promo (No Product Linked) --</option>
                @foreach ($this->products as $product)
                    <option value="{{ $product->id }}">
                        {{ $product->name }} (Treatment: {{ $product->treatment?->name }})
                    </option>
                @endforeach
            </select>
            <p class="mt-1 text-xs text-blue-700">
                Pilih produk untuk mengisi judul, deskripsi, dan CTA ke treatment terkait secara otomatis.
            </p>
        </div>

        {{-- Title --}}
        <div>
            <label class="mb-2 block text-sm font-medium">Title</label>
            <input
                type="text"
                wire:model.live="title"
                class="w-full rounded-lg border px-4 py-2"
                placeholder="Special Skin Treatment"
            >
            @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Slug (Readonly / Disabled) --}}
        <div>
            <label class="mb-2 block text-sm font-medium">Slug (Auto-generated)</label>
            <input
                type="text"
                wire:model="slug"
                readonly
                tabindex="-1"
                class="w-full cursor-not-allowed rounded-lg border bg-gray-100 px-4 py-2 text-gray-500 font-mono text-sm"
                placeholder="promo-special-skin-treatment"
            >
            @error('slug') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Description --}}
        <div>
            <label class="mb-2 block text-sm font-medium">Description</label>
            <textarea
                wire:model="description"
                rows="4"
                class="w-full rounded-lg border px-4 py-2"
            ></textarea>
            @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Image --}}
        <div>
            <label class="mb-2 block text-sm font-medium">Promo Image</label>
            <input
                type="file"
                wire:model="image"
                accept="image/*"
                class="w-full rounded-lg border px-4 py-2"
            >
            @error('image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror

            @if ($image)
                <div class="mt-4">
                    <p class="mb-2 text-sm text-gray-500">Preview</p>
                    <img
                        src="{{ $image->temporaryUrl() }}"
                        alt="Promo preview"
                        class="h-64 w-full rounded-xl object-cover"
                    >
                </div>
            @endif
        </div>

        {{-- Dynamic CTA Section --}}
        <div class="rounded-xl border bg-gray-50/50 p-4 space-y-4">
            <h2 class="font-semibold text-gray-800 text-sm">Call To Action (CTA) Configuration</h2>
            
            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-medium">CTA Text</label>
                    <input
                        type="text"
                        wire:model="cta_text"
                        class="w-full rounded-lg border bg-white px-4 py-2"
                        placeholder="Book Appointment"
                    >
                    @error('cta_text') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium">CTA Type</label>
                    <select
                        wire:model.live="cta_type"
                        class="w-full rounded-lg border bg-white px-4 py-2"
                    >
                        <option value="internal">Internal Page</option>
                        <option value="treatment">Treatment</option>
                        <option value="doctor">Doctor</option>
                        <option value="news">News</option>
                        <option value="whatsapp">WhatsApp</option>
                        <option value="external">External URL</option>
                    </select>
                    @error('cta_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Target selection based on cta_type --}}
            @if ($cta_type === 'internal')
                <div>
                    <label class="mb-2 block text-sm font-medium">CTA Target</label>
                    <select wire:model="cta_target" class="w-full rounded-lg border bg-white px-4 py-2">
                        <option value="">-- Pilih halaman --</option>
                        <option value="home">Home</option>
                        <option value="treatments">Treatments</option>
                        <option value="doctors">Doctors</option>
                        <option value="news">News</option>
                    </select>
                    @error('cta_target') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

            @elseif ($cta_type === 'treatment')
                <div>
                    <label class="mb-2 block text-sm font-medium">Treatment</label>
                    <select wire:model="cta_target" class="w-full rounded-lg border bg-white px-4 py-2">
                        <option value="">-- Pilih treatment --</option>
                        @foreach ($this->treatments as $treatment)
                            <option value="{{ $treatment->slug }}">{{ $treatment->name }}</option>
                        @endforeach
                    </select>
                    @error('cta_target') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

            @elseif ($cta_type === 'doctor')
                <div>
                    <label class="mb-2 block text-sm font-medium">Doctor</label>
                    <select wire:model="cta_target" class="w-full rounded-lg border bg-white px-4 py-2">
                        <option value="">-- Pilih doctor --</option>
                        @foreach ($this->doctors as $doctor)
                            <option value="{{ $doctor->slug }}">{{ $doctor->name }}</option>
                        @endforeach
                    </select>
                    @error('cta_target') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

            @elseif ($cta_type === 'news')
                <div>
                    <label class="mb-2 block text-sm font-medium">News</label>
                    <select wire:model="cta_target" class="w-full rounded-lg border bg-white px-4 py-2">
                        <option value="">-- Pilih news --</option>
                        @foreach ($this->news as $item)
                            <option value="{{ $item->slug }}">{{ $item->title }}</option>
                        @endforeach
                    </select>
                    @error('cta_target') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

            @elseif ($cta_type === 'whatsapp')
                <div class="rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700">
                    CTA akan diarahkan ke WhatsApp perusahaan berdasarkan nomor pada Site Settings.
                </div>

            @elseif ($cta_type === 'external')
                <div>
                    <label class="mb-2 block text-sm font-medium">External URL</label>
                    <input
                        type="url"
                        wire:model="cta_target"
                        class="w-full rounded-lg border bg-white px-4 py-2"
                        placeholder="https://example.com"
                    >
                    @error('cta_target') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            @endif
        </div>

        {{-- Dates --}}
        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-medium">Start Date</label>
                <input type="date" wire:model="start_date" class="w-full rounded-lg border px-4 py-2">
                @error('start_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium">End Date</label>
                <input type="date" wire:model="end_date" class="w-full rounded-lg border px-4 py-2">
                @error('end_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Sort Order & Status --}}
        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-medium">Sort Order</label>
                <input type="number" wire:model="sort_order" min="0" class="w-full rounded-lg border px-4 py-2">
                @error('sort_order') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center pt-6">
                <label class="flex items-center gap-3">
                    <input type="checkbox" wire:model="is_active" class="rounded">
                    <span class="text-sm font-medium">Active</span>
                </label>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-3 pt-4">
            <button type="submit" class="rounded-lg bg-black px-5 py-2 font-semibold text-white hover:bg-gray-800">
                Save Promo
            </button>
            <a href="{{ route('admin.home.promos.index') }}" wire:navigate class="rounded-lg border px-5 py-2 font-medium">
                Cancel
            </a>
        </div>

    </form>
</div>