<?php

use App\Models\Treatment;
use App\Models\TreatmentCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

new #[Layout('layouts.admin')] class extends Component
{
    use WithFileUploads;

    public Treatment $treatment;

    public string $name = '';
    public string $slug = '';
    public ?int $category_id = null;
    public string $short_description = '';
    public string $description = '';
    public $cover_image = null;
    public bool $is_featured = false;
    public bool $is_active = true;

    public function mount(Treatment $treatment): void
    {
        $this->treatment = $treatment;

        $this->name = $treatment->name;
        $this->slug = $treatment->slug;
        $this->category_id = $treatment->category_id;
        $this->short_description = $treatment->short_description ?? '';
        $this->description = $treatment->description ?? '';
        $this->is_featured = (bool) $treatment->is_featured;
        $this->is_active = (bool) $treatment->is_active;
    }

    // Mengubah slug otomatis saat name diedit (menggunakan underscore)
    public function updatedName(string $value): void
    {
        $this->slug = Str::slug($value, '-');
    }

    public function update(): void
    {
        $this->slug = Str::slug($this->name, '-');

        $validated = $this->validate([
            'category_id' => ['required', 'exists:treatment_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                'unique:treatments,slug,' . $this->treatment->id,
            ],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'image', 'max:2048'],
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
        ]);

        if ($this->cover_image) {
            $oldImage = $this->treatment->cover_image;

            $newImage = $this->cover_image->store('treatments', 'public');

            $validated['cover_image'] = $newImage;

            if ($oldImage) {
                Storage::disk('public')->delete($oldImage);
            }
        } else {
            unset($validated['cover_image']);
        }

        $this->treatment->update($validated);

        session()->flash('success', 'Treatment updated successfully.');

        $this->redirect(
            route('admin.treatments.index'),
            navigate: true
        );
    }

    public function with(): array
    {
        return [
            'categories' => TreatmentCategory::where('is_active', true)
                ->orderBy('sort_order')
                ->get(),
        ];
    }
};
?>

<div class="mx-auto max-w-4xl space-y-8 pb-10">

    {{-- Top Navigation & Header --}}
    <div>
        <a href="{{ route('admin.treatments.index') }}" wire:navigate class="inline-flex items-center gap-2 text-sm font-bold text-gray-400 transition-colors hover:text-[var(--color-wfsc-coral)]">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Perawatan
        </a>
        <div class="mt-4 flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-500 shadow-sm">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
            </div>
            <div>
                <h1 class="text-2xl font-black tracking-tight text-[var(--color-wfsc-dark)]">Edit Perawatan</h1>
                <p class="text-sm font-medium text-gray-500">Update treatment details and configuration.</p>
            </div>
        </div>
    </div>

    <form wire:submit="update" class="space-y-8">

        {{-- Main Information Card --}}
        <div class="relative overflow-hidden rounded-2xl border border-gray-100/50 bg-white p-8 elegant-shadow">
            <div class="absolute left-0 top-0 h-full w-1 bg-blue-400"></div>
            
            <div class="mb-6 flex items-center gap-3">
                <div class="rounded-lg bg-blue-50 p-2 text-blue-500">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h2 class="text-lg font-bold text-[var(--color-wfsc-dark)]">Treatment Information</h2>
            </div>

            <div class="space-y-6">
                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Category</label>
                    <select wire:model="category_id" class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]">
                        <option value="">Select category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Name</label>
                    <input type="text" wire:model.live="name" class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]">
                    @error('name') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Slug (Auto-generated)</label>
                    <input type="text" wire:model="slug" readonly tabindex="-1" placeholder="hydrafacial_facial" class="w-full cursor-not-allowed rounded-xl border-gray-200 bg-gray-100 px-4 py-3 font-mono text-sm text-gray-500">
                    @error('slug') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Short Description</label>
                    <textarea wire:model="short_description" rows="3" class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"></textarea>
                    @error('short_description') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Description</label>
                    <textarea wire:model="description" rows="6" class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"></textarea>
                    @error('description') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Cover Image & Flags Card --}}
        <div class="relative overflow-hidden rounded-2xl border border-gray-100/50 bg-white p-8 elegant-shadow">
            <div class="absolute left-0 top-0 h-full w-1 bg-purple-400"></div>
            
            <div class="mb-6 flex items-center gap-3">
                <div class="rounded-lg bg-purple-50 p-2 text-purple-500">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h2 class="text-lg font-bold text-[var(--color-wfsc-dark)]">Media & Flags</h2>
            </div>

            <div class="space-y-6">
                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Cover Image</label>
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                        @if ($cover_image)
                            <div class="shrink-0 relative">
                                <span class="absolute -top-2 -right-2 bg-[var(--color-wfsc-coral)] text-white text-[10px] font-bold px-2 py-0.5 rounded-full z-10">New</span>
                                <img src="{{ $cover_image->temporaryUrl() }}" alt="Preview" class="h-24 w-36 rounded-2xl object-cover shadow-sm ring-4 ring-gray-50">
                            </div>
                        @elseif ($treatment->cover_image)
                            <div class="shrink-0">
                                <img src="{{ Storage::url($treatment->cover_image) }}" alt="{{ $treatment->name }}" class="h-24 w-36 rounded-2xl object-cover shadow-sm ring-4 ring-gray-50">
                            </div>
                        @endif

                        <div class="w-full">
                            <input type="file" wire:model="cover_image" accept="image/*" 
                                class="block w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-2.5 text-sm text-gray-600 transition-colors file:mr-4 file:rounded-lg file:border-0 file:bg-white file:px-4 file:py-2 file:text-sm file:font-bold file:text-[var(--color-wfsc-coral)] file:shadow-sm hover:file:bg-rose-50 focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]">
                            <div wire:loading wire:target="cover_image" class="mt-2 text-xs font-bold text-[var(--color-wfsc-coral)] flex items-center gap-1.5">
                                <svg class="h-3.5 w-3.5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Uploading preview...
                            </div>
                            @error('cover_image') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="inline-flex items-center gap-3 rounded-xl border border-gray-100 bg-gray-50 p-4 transition-colors hover:bg-gray-100">
                        <input type="checkbox" wire:model="is_featured" class="h-5 w-5 rounded-md border-gray-300 text-amber-500 focus:ring-amber-500">
                        <div>
                            <span class="block text-sm font-bold text-gray-800">Featured Treatment</span>
                            <span class="block text-xs font-medium text-gray-500">Highlight this treatment on the homepage.</span>
                        </div>
                    </label>

                    <label class="inline-flex items-center gap-3 rounded-xl border border-gray-100 bg-gray-50 p-4 transition-colors hover:bg-gray-100">
                        <input type="checkbox" wire:model="is_active" class="h-5 w-5 rounded-md border-gray-300 text-[var(--color-wfsc-coral)] focus:ring-[var(--color-wfsc-coral)]">
                        <div>
                            <span class="block text-sm font-bold text-gray-800">Aktif Status</span>
                            <span class="block text-xs font-medium text-gray-500">Visible on the website catalog.</span>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        {{-- Aksi --}}
        <div class="flex items-center justify-end gap-4 pt-4">
            <a href="{{ route('admin.treatments.index') }}" wire:navigate 
                class="rounded-xl px-5 py-3 text-sm font-bold text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-800">
                Batal
            </a>

            <button type="submit" wire:loading.attr="disabled" 
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[var(--color-wfsc-coral)] to-[#ff7676] px-8 py-3 text-sm font-bold text-white shadow-lg shadow-[var(--color-wfsc-coral)]/30 transition-all duration-300 hover:scale-[1.02] hover:shadow-xl hover:shadow-[var(--color-wfsc-coral)]/40 disabled:opacity-70 disabled:hover:scale-100">
                <span wire:loading.remove>Update Treatment</span>
                <span wire:loading>
                    <svg class="h-4 w-4 animate-spin text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Updating...
                </span>
            </button>
        </div>

    </form>
</div>
