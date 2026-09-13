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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

new #[Layout('layouts.admin')] class extends Component
{
    use WithFileUploads;

    public Promo $promo;

    public ?int $treatment_product_id = null;
    public string $title = '';
    public string $slug = '';
    public string $description = '';
    public $image = null;
    public ?string $existingImage = null;
    
    // Dynamic CTA Properties
    public string $cta_text = '';
    public string $cta_type = 'internal';
    public string $cta_target = '';

    public string $start_date = '';
    public string $end_date = '';
    public int $sort_order = 0;
    public bool $is_active = true;

    public function mount(Promo $promo): void
    {
        $this->promo = $promo;

        $this->treatment_product_id = $promo->treatment_product_id;
        $this->title = $promo->title;
        $this->slug = $promo->slug;
        $this->description = $promo->description ?? '';
        $this->existingImage = $promo->image;
        $this->cta_text = $promo->cta_text ?? '';
        $this->cta_type = $promo->cta_type ?? 'internal';
        $this->cta_target = $promo->cta_target ?? '';
        $this->start_date = $promo->start_date?->format('Y-m-d') ?? '';
        $this->end_date = $promo->end_date?->format('Y-m-d') ?? '';
        $this->sort_order = $promo->sort_order;
        $this->is_active = (bool) $promo->is_active;
    }

    // Trigger saat Treatment Product diubah
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

            if ($product->treatment && empty($this->cta_target)) {
                $this->cta_type = 'treatment';
                $this->cta_target = $product->treatment->slug;
            }
        }
    }

    public function updatedTitle($value): void
    {
        $this->slug = Str::slug($value);
    }

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

    public function update(): void
    {
        $validated = $this->validate([
            'treatment_product_id' => ['nullable', 'exists:treatment_products,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                'unique:promos,slug,' . $this->promo->id,
            ],
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
            $oldImage = $this->promo->image;
            $newImage = $this->image->store('promos', 'public');
            $validated['image'] = $newImage;

            if ($oldImage) {
                Storage::disk('public')->delete($oldImage);
            }
        } else {
            unset($validated['image']);
        }

        $this->promo->update($validated);

        session()->flash('success', 'Promo updated successfully.');

        $this->redirect(
            route('admin.home.promos.index'),
            navigate: true
        );
    }
};

?>

<div class="mx-auto max-w-4xl space-y-8 pb-10">

    {{-- Top Navigation & Header --}}
    <div>
        <a href="{{ route('admin.home.promos.index') }}" wire:navigate 
            class="inline-flex items-center gap-2 text-sm font-bold text-gray-400 transition-colors hover:text-[var(--color-wfsc-coral)]">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to Promos
        </a>
        <div class="mt-4 flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-500 shadow-sm">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
            </div>
            <div>
                <h1 class="text-2xl font-black tracking-tight text-[var(--color-wfsc-dark)]">Edit Promo</h1>
                <p class="text-sm font-medium text-gray-500">Update promotional content displayed on the WFSC website.</p>
            </div>
        </div>
    </div>

    <form wire:submit="update" class="space-y-8">

        {{-- Select Treatment Product Card --}}
        <div class="relative overflow-hidden rounded-2xl border border-blue-100 bg-blue-50/40 p-8 elegant-shadow">
            <div class="absolute left-0 top-0 h-full w-1 bg-blue-500"></div>
            
            <label class="mb-2 block text-sm font-bold text-blue-900">
                Link to Treatment Product (Optional)
            </label>

            <select
                wire:model.live="treatment_product_id"
                class="w-full rounded-xl border-blue-200 bg-white px-4 py-3 text-sm transition-colors focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
            >
                <option value="">-- Manual Promo (No Product Linked) --</option>
                @foreach ($this->products as $product)
                    <option value="{{ $product->id }}">
                        {{ $product->name }} (Treatment: {{ $product->treatment?->name }})
                    </option>
                @endforeach
            </select>
            <p class="mt-2 text-xs font-medium text-blue-700">
                Hubungkan promo ini dengan produk perawatan tertentu jika diperlukan.
            </p>
        </div>

        {{-- Promo Information Card --}}
        <div class="relative overflow-hidden rounded-2xl border border-gray-100/50 bg-white p-8 elegant-shadow">
            <div class="absolute left-0 top-0 h-full w-1 bg-emerald-400"></div>
            
            <div class="mb-6 flex items-center gap-3">
                <div class="rounded-lg bg-emerald-50 p-2 text-emerald-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </div>
                <h2 class="text-lg font-bold text-[var(--color-wfsc-dark)]">Promo Details</h2>
            </div>

            <div class="space-y-6">
                {{-- Title --}}
                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Title</label>
                    <input
                        type="text"
                        wire:model.live="title"
                        class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                    >
                    @error('title') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Slug --}}
                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Slug (Auto-generated)</label>
                    <input
                        type="text"
                        wire:model="slug"
                        readonly
                        tabindex="-1"
                        class="w-full cursor-not-allowed rounded-xl border-gray-200 bg-gray-100 px-4 py-3 font-mono text-sm text-gray-500"
                    >
                    @error('slug') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Description</label>
                    <textarea
                        wire:model="description"
                        rows="5"
                        class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                    ></textarea>
                    @error('description') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Existing / New Image Card --}}
        <div class="relative overflow-hidden rounded-2xl border border-gray-100/50 bg-white p-8 elegant-shadow">
            <div class="absolute left-0 top-0 h-full w-1 bg-purple-400"></div>
            
            <div class="mb-6 flex items-center gap-3">
                <div class="rounded-lg bg-purple-50 p-2 text-purple-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h2 class="text-lg font-bold text-[var(--color-wfsc-dark)]">Promo Image</h2>
            </div>

            <div class="space-y-6">
                @if ($existingImage && !$image)
                    <div>
                        <p class="mb-2 text-xs font-bold text-gray-600">Current Image</p>
                        <div class="overflow-hidden rounded-2xl border border-gray-100 shadow-sm ring-4 ring-gray-50">
                            <img
                                src="{{ Storage::url($existingImage) }}"
                                alt="{{ $title }}"
                                class="h-64 w-full object-cover"
                            >
                        </div>
                    </div>
                @endif

                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Upload New Image</label>
                    <input
                        type="file"
                        wire:model="image"
                        accept="image/*"
                        class="block w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-2.5 text-sm text-gray-600 transition-colors file:mr-4 file:rounded-lg file:border-0 file:bg-white file:px-4 file:py-2 file:text-sm file:font-bold file:text-[var(--color-wfsc-coral)] file:shadow-sm hover:file:bg-rose-50 focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                    >
                    @error('image') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror

                    <div wire:loading wire:target="image" class="mt-2 text-xs font-bold text-[var(--color-wfsc-coral)] flex items-center gap-1.5">
                        <svg class="h-3.5 w-3.5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Uploading preview...
                    </div>
                </div>

                @if ($image)
                    <div>
                        <p class="mb-2 text-xs font-bold text-gray-600">New Image Preview</p>
                        <img
                            src="{{ $image->temporaryUrl() }}"
                            alt="New promo preview"
                            class="h-64 w-full rounded-2xl border border-gray-100 object-cover shadow-sm ring-4 ring-gray-50"
                        >
                    </div>
                @endif
            </div>
        </div>

        {{-- Dynamic CTA Section Card --}}
        <div class="relative overflow-hidden rounded-2xl border border-gray-100/50 bg-white p-8 elegant-shadow">
            <div class="absolute left-0 top-0 h-full w-1 bg-amber-400"></div>
            
            <div class="mb-6 flex items-center gap-3">
                <div class="rounded-lg bg-amber-50 p-2 text-amber-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h2 class="text-lg font-bold text-[var(--color-wfsc-dark)]">Call To Action (CTA) Configuration</h2>
            </div>
            
            <div class="space-y-6">
                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-bold text-gray-600">CTA Text</label>
                        <input
                            type="text"
                            wire:model="cta_text"
                            placeholder="Book Appointment"
                            class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                        >
                        @error('cta_text') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-gray-600">CTA Type</label>
                        <select
                            wire:model.live="cta_type"
                            class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                        >
                            <option value="internal">Internal Page</option>
                            <option value="treatment">Treatment</option>
                            <option value="doctor">Doctor</option>
                            <option value="news">News</option>
                            <option value="whatsapp">WhatsApp</option>
                            <option value="external">External URL</option>
                        </select>
                        @error('cta_type') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Target selection based on cta_type --}}
                @if ($cta_type === 'internal')
                    <div>
                        <label class="mb-2 block text-sm font-bold text-gray-600">CTA Target</label>
                        <select wire:model="cta_target" class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]">
                            <option value="">-- Pilih halaman --</option>
                            <option value="home">Home</option>
                            <option value="treatments">Treatments</option>
                            <option value="doctors">Doctors</option>
                            <option value="news">News</option>
                        </select>
                        @error('cta_target') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                    </div>

                @elseif ($cta_type === 'treatment')
                    <div>
                        <label class="mb-2 block text-sm font-bold text-gray-600">Treatment</label>
                        <select wire:model="cta_target" class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]">
                            <option value="">-- Pilih treatment --</option>
                            @foreach ($this->treatments as $treatment)
                                <option value="{{ $treatment->slug }}">{{ $treatment->name }}</option>
                            @endforeach
                        </select>
                        @error('cta_target') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                    </div>

                @elseif ($cta_type === 'doctor')
                    <div>
                        <label class="mb-2 block text-sm font-bold text-gray-600">Doctor</label>
                        <select wire:model="cta_target" class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]">
                            <option value="">-- Pilih doctor --</option>
                            @foreach ($this->doctors as $doctor)
                                <option value="{{ $doctor->slug }}">{{ $doctor->name }}</option>
                            @endforeach
                        </select>
                        @error('cta_target') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                    </div>

                @elseif ($cta_type === 'news')
                    <div>
                        <label class="mb-2 block text-sm font-bold text-gray-600">News</label>
                        <select wire:model="cta_target" class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]">
                            <option value="">-- Pilih news --</option>
                            @foreach ($this->news as $item)
                                <option value="{{ $item->slug }}">{{ $item->title }}</option>
                            @endforeach
                        </select>
                        @error('cta_target') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                    </div>

                @elseif ($cta_type === 'whatsapp')
                    <div class="rounded-xl border border-emerald-100 bg-emerald-50 px-5 py-4 text-sm font-bold text-emerald-700">
                        CTA akan diarahkan ke WhatsApp perusahaan berdasarkan nomor pada Site Settings.
                    </div>

                @elseif ($cta_type === 'external')
                    <div>
                        <label class="mb-2 block text-sm font-bold text-gray-600">External URL</label>
                        <input
                            type="url"
                            wire:model="cta_target"
                            placeholder="https://example.com"
                            class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                        >
                        @error('cta_target') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                    </div>
                @endif
            </div>
        </div>

        {{-- Schedule & Sorting Card --}}
        <div class="relative overflow-hidden rounded-2xl border border-gray-100/50 bg-white p-8 elegant-shadow">
            <div class="absolute left-0 top-0 h-full w-1 bg-indigo-400"></div>
            
            <div class="mb-6 flex items-center gap-3">
                <div class="rounded-lg bg-indigo-50 p-2 text-indigo-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h2 class="text-lg font-bold text-[var(--color-wfsc-dark)]">Schedule & Status</h2>
            </div>

            <div class="space-y-6">
                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-bold text-gray-600">Start Date</label>
                        <input
                            type="date"
                            wire:model="start_date"
                            class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                        >
                        @error('start_date') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-gray-600">End Date</label>
                        <input
                            type="date"
                            wire:model="end_date"
                            class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                        >
                        @error('end_date') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-bold text-gray-600">Sort Order</label>
                        <input
                            type="number"
                            wire:model="sort_order"
                            min="0"
                            class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                        >
                        @error('sort_order') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center pt-8">
                        <label class="inline-flex items-center gap-3 rounded-xl border border-gray-100 bg-gray-50 p-4 w-full transition-colors hover:bg-gray-100">
                            <input
                                type="checkbox"
                                wire:model="is_active"
                                class="h-5 w-5 rounded-md border-gray-300 text-[var(--color-wfsc-coral)] focus:ring-[var(--color-wfsc-coral)]"
                            >
                            <div>
                                <span class="block text-sm font-bold text-gray-800">Active Promo</span>
                                <span class="block text-xs font-medium text-gray-500">Visible on the website.</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-4 pt-4">
            <a
                href="{{ route('admin.home.promos.index') }}"
                wire:navigate
                class="rounded-xl px-5 py-3 text-sm font-bold text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-800"
            >
                Cancel
            </a>

            <button
                type="submit"
                wire:loading.attr="disabled"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[var(--color-wfsc-coral)] to-[#ff7676] px-8 py-3 text-sm font-bold text-white shadow-lg shadow-[var(--color-wfsc-coral)]/30 transition-all duration-300 hover:scale-[1.02] hover:shadow-xl hover:shadow-[var(--color-wfsc-coral)]/40 disabled:opacity-70 disabled:hover:scale-100"
            >
                <span wire:loading.remove>Update Promo</span>
                <span wire:loading>
                    <svg class="h-4 w-4 animate-spin text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Updating...
                </span>
            </button>
        </div>

    </form>
</div>