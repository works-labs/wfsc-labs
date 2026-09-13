<?php

use App\Models\SkincareCategory;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

new #[Layout('layouts.admin')] class extends Component
{
    use WithFileUploads;
    public string $name = '';
    public string $slug = '';
    public string $description = '';
    public $image = null;
    public int $sort_order = 0;
    public bool $is_active = true;
    // Mengubah slug otomatis saat mengetik Name
    public function updatedName(string $value): void
    {
        $this->slug = Str::slug($value);
    }
    public function save(): void
    {
        // Memastikan slug selalu tersinkronisasi saat tombol submit ditekan
        $this->slug = Str::slug($this->name);
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:skincare_categories,slug'],
            'description' => ['nullable', 'string'],
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        $imagePath = null;

        if ($this->image) {
            $imagePath = $this->image->store(
                'skincare/categories',
                'public'
            );
        }

        SkincareCategory::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'],
            'image' => $imagePath,
            'sort_order' => $validated['sort_order'],
            'is_active' => $validated['is_active'],
        ]);

        session()->flash(
            'success',
            'Skincare category created successfully.'
        );

        $this->redirect(
            route('admin.skincare.categories.index'),
            navigate: true
        );
    }
};
?>

<div class="mx-auto max-w-4xl space-y-8 pb-10">

    {{-- Top Navigation & Header --}}
    <div>
        <a href="{{ route('admin.skincare.categories.index') }}" wire:navigate 
            class="inline-flex items-center gap-2 text-sm font-bold text-gray-400 transition-colors hover:text-[var(--color-wfsc-coral)]">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to Categories
        </a>
        <div class="mt-4 flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-rose-50 text-[var(--color-wfsc-coral)] shadow-sm">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </div>
            <div>
                <h1 class="text-2xl font-black tracking-tight text-[var(--color-wfsc-dark)]">Add Skincare Category</h1>
                <p class="text-sm font-medium text-gray-500">Create a new category for skincare products.</p>
            </div>
        </div>
    </div>

    <form wire:submit="save" class="space-y-8">

        {{-- Main Info Card --}}
        <div class="relative overflow-hidden rounded-2xl border border-gray-100/50 bg-white p-8 elegant-shadow">
            <div class="absolute left-0 top-0 h-full w-1 bg-blue-400"></div>
            
            <div class="mb-6 flex items-center gap-3">
                <div class="rounded-lg bg-blue-50 p-2 text-blue-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h2 class="text-lg font-bold text-[var(--color-wfsc-dark)]">Category Information</h2>
            </div>

            <div class="space-y-6">
                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Name <span class="text-[var(--color-wfsc-coral)]">*</span></label>
                    <input type="text" wire:model.live="name" placeholder="Face Care" 
                        class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]">
                    @error('name') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Slug (Auto-generated)</label>
                    <input type="text" wire:model="slug" readonly tabindex="-1" placeholder="face-care" 
                        class="w-full cursor-not-allowed rounded-xl border-gray-200 bg-gray-100 px-4 py-3 font-mono text-sm text-gray-500">
                    @error('slug') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Description</label>
                    <textarea wire:model="description" rows="4" placeholder="Description for this skincare category..." 
                        class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"></textarea>
                    @error('description') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Media & Settings Card --}}
        <div class="relative overflow-hidden rounded-2xl border border-gray-100/50 bg-white p-8 elegant-shadow">
            <div class="absolute left-0 top-0 h-full w-1 bg-purple-400"></div>
            
            <div class="mb-6 flex items-center gap-3">
                <div class="rounded-lg bg-purple-50 p-2 text-purple-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h2 class="text-lg font-bold text-[var(--color-wfsc-dark)]">Media & Settings</h2>
            </div>

            <div class="space-y-6">
                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Image</label>
                    <div class="flex items-start gap-6">
                        @if ($image)
                            <div class="shrink-0">
                                <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="h-28 w-28 rounded-2xl object-cover shadow-sm ring-4 ring-gray-50">
                            </div>
                        @endif
                        <div class="w-full">
                            <input type="file" wire:model="image" accept="image/jpeg,image/png,image/webp" 
                                class="block w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-2.5 text-sm text-gray-600 transition-colors file:mr-4 file:rounded-lg file:border-0 file:bg-white file:px-4 file:py-2 file:text-sm file:font-bold file:text-[var(--color-wfsc-coral)] file:shadow-sm hover:file:bg-rose-50 focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]">
                            <p class="mt-2 text-xs font-medium text-gray-400">JPG, JPEG, PNG or WebP. Maximum 2 MB.</p>
                            @error('image') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-bold text-gray-600">Sort Order</label>
                        <input type="number" wire:model="sort_order" min="0" placeholder="0" 
                            class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]">
                        @error('sort_order') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center pt-8">
                        <label class="inline-flex items-center gap-3 rounded-xl border border-gray-100 bg-gray-50 p-4 w-full transition-colors hover:bg-gray-100">
                            <input type="checkbox" wire:model="is_active" class="h-5 w-5 rounded-md border-gray-300 text-[var(--color-wfsc-coral)] focus:ring-[var(--color-wfsc-coral)]">
                            <div>
                                <span class="block text-sm font-bold text-gray-800">Active Category</span>
                                <span class="block text-xs font-medium text-gray-500">Visible on the platform.</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-4 pt-4">
            <a href="{{ route('admin.skincare.categories.index') }}" wire:navigate 
                class="rounded-xl px-5 py-3 text-sm font-bold text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-800">
                Cancel
            </a>

            <button type="submit" wire:loading.attr="disabled" 
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[var(--color-wfsc-coral)] to-[#ff7676] px-8 py-3 text-sm font-bold text-white shadow-lg shadow-[var(--color-wfsc-coral)]/30 transition-all duration-300 hover:scale-[1.02] hover:shadow-xl hover:shadow-[var(--color-wfsc-coral)]/40 disabled:opacity-70 disabled:hover:scale-100">
                <span wire:loading.remove>Create Category</span>
                <span wire:loading>
                    <svg class="h-4 w-4 animate-spin text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Saving...
                </span>
            </button>
        </div>

    </form>
</div>