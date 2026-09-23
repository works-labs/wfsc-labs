```php
<?php

use App\Models\Treatment;
use App\Models\TreatmentProduct;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

new #[Layout('layouts.admin')] class extends Component
{
    use WithFileUploads;

    public Treatment $treatment;
    public TreatmentProduct $product;

    public string $name = '';
    public string $description = '';
    public int $sort_order = 0;
    public bool $is_active = true;

    public $image = null;

    public function mount(Treatment $treatment, TreatmentProduct $product): void
    {
        $this->treatment = $treatment;
        $this->product = $product;

        $this->name = $product->name;
        $this->description = $product->description ?? '';
        $this->sort_order = $product->sort_order;
        $this->is_active = (bool) $product->is_active;
    }

    public function update(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['boolean'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $oldImage = $this->product->image;

        if ($this->image) {
            $newImage = $this->image->store(
                'treatment-products',
                'public'
            );

            $validated['image'] = $newImage;
        }

        unset($validated['image']);

        $this->product->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'sort_order' => $validated['sort_order'],
            'is_active' => $validated['is_active'],
            ...(
                $this->image
                    ? ['image' => $newImage]
                    : []
            ),
        ]);

        if ($this->image && $oldImage) {
            Storage::disk('public')->delete($oldImage);
        }

        session()->flash(
            'success',
            'Treatment product updated successfully.'
        );

        $this->redirect(
            route(
                'admin.treatments.products.index',
                $this->treatment
            ),
            navigate: true
        );
    }
};
?>

<div class="mx-auto max-w-4xl space-y-8 pb-10">

    {{-- Top Navigation & Header --}}
    <div>
        <a href="{{ route('admin.treatments.products.index', $treatment) }}" wire:navigate 
            class="inline-flex items-center gap-2 text-sm font-bold text-gray-400 transition-colors hover:text-[var(--color-wfsc-coral)]">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Produk
        </a>
        <div class="mt-4 flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-500 shadow-sm">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
            </div>
            <div>
                <h1 class="text-2xl font-black tracking-tight text-[var(--color-wfsc-dark)]">Edit Produk</h1>
                <p class="text-sm font-medium text-gray-500">
                    Update product details for <span class="font-bold text-[var(--color-wfsc-coral)]">{{ $treatment->name }}</span>
                </p>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="flex items-center gap-3 rounded-2xl border border-emerald-100 bg-emerald-50 px-6 py-4 text-sm font-bold text-emerald-700 shadow-sm">
            <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit="update" class="space-y-8">

        {{-- Product Details Card --}}
        <div class="relative overflow-hidden rounded-2xl border border-gray-100/50 bg-white p-8 elegant-shadow">
            <div class="absolute left-0 top-0 h-full w-1 bg-blue-400"></div>
            
            <div class="mb-6 flex items-center gap-3">
                <div class="rounded-lg bg-blue-50 p-2 text-blue-500">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                </div>
                <h2 class="text-lg font-bold text-[var(--color-wfsc-dark)]">Product Details</h2>
            </div>

            <div class="space-y-6">
                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Product Name</label>
                    <input type="text" wire:model="name" 
                        class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]">
                    @error('name') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Description</label>
                    <textarea wire:model="description" rows="5" 
                        class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"></textarea>
                    @error('description') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Image & Settings Card --}}
        <div class="relative overflow-hidden rounded-2xl border border-gray-100/50 bg-white p-8 elegant-shadow">
            <div class="absolute left-0 top-0 h-full w-1 bg-purple-400"></div>
            
            <div class="mb-6 flex items-center gap-3">
                <div class="rounded-lg bg-purple-50 p-2 text-purple-500">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h2 class="text-lg font-bold text-[var(--color-wfsc-dark)]">Media & Settings</h2>
            </div>

            <div class="space-y-6">
                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Product Image</label>
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                        @if ($image)
                            <div class="shrink-0 relative">
                                <span class="absolute -top-2 -right-2 bg-[var(--color-wfsc-coral)] text-white text-[10px] font-bold px-2 py-0.5 rounded-full z-10">New</span>
                                <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="h-24 w-24 rounded-2xl object-cover shadow-sm ring-4 ring-gray-50">
                            </div>
                        @elseif ($product->image)
                            <div class="shrink-0">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-24 w-24 rounded-2xl object-cover shadow-sm ring-4 ring-gray-50">
                            </div>
                        @endif

                        <div class="w-full">
                            <input type="file" wire:model="image" accept="image/*" 
                                class="block w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-2.5 text-sm text-gray-600 transition-colors file:mr-4 file:rounded-lg file:border-0 file:bg-white file:px-4 file:py-2 file:text-sm file:font-bold file:text-[var(--color-wfsc-coral)] file:shadow-sm hover:file:bg-rose-50 focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]">
                            <div wire:loading wire:target="image" class="mt-2 text-xs font-bold text-[var(--color-wfsc-coral)] flex items-center gap-1.5">
                                <svg class="h-3.5 w-3.5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Uploading preview...
                            </div>
                            @error('image') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Sort Order</label>
                    <input type="number" wire:model="sort_order" min="0" 
                        class="w-full max-w-xs rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]">
                    @error('sort_order') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                </div>

                <label class="inline-flex items-center gap-3 rounded-xl border border-gray-100 bg-gray-50 p-4 transition-colors hover:bg-gray-100">
                    <input type="checkbox" wire:model="is_active" class="h-5 w-5 rounded-md border-gray-300 text-[var(--color-wfsc-coral)] focus:ring-[var(--color-wfsc-coral)]">
                    <div>
                        <span class="block text-sm font-bold text-gray-800">Set as Aktif Product</span>
                        <span class="block text-xs font-medium text-gray-500">Product will be visible in the treatment details.</span>
                    </div>
                </label>
            </div>
        </div>

        {{-- Aksi --}}
        <div class="flex items-center justify-end gap-4 pt-4">
            <a href="{{ route('admin.treatments.products.index', $treatment) }}" wire:navigate 
                class="rounded-xl px-5 py-3 text-sm font-bold text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-800">
                Batal
            </a>

            <button type="submit" wire:loading.attr="disabled" 
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[var(--color-wfsc-coral)] to-[#ff7676] px-8 py-3 text-sm font-bold text-white shadow-lg shadow-[var(--color-wfsc-coral)]/30 transition-all duration-300 hover:scale-[1.02] hover:shadow-xl hover:shadow-[var(--color-wfsc-coral)]/40 disabled:opacity-70 disabled:hover:scale-100">
                <span wire:loading.remove wire:target="update">Update Product</span>
                <span wire:loading wire:target="update">
                    <svg class="h-4 w-4 animate-spin text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Updating...
                </span>
            </button>
        </div>

    </form>
</div>
