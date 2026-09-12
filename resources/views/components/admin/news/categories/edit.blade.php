<?php

use App\Models\NewsCategory;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.admin')] class extends Component
{
    public NewsCategory $category;

    public string $name = '';
    public string $slug = '';
    public string $description = '';
    public bool $is_active = true;

    public function mount(NewsCategory $category): void
    {
        $this->category = $category;

        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->description = $category->description ?? '';
        $this->is_active = $category->is_active;
    }

    public function updatedName(): void
    {
        $this->slug = Str::slug($this->name);
    }

    public function save(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('news_categories', 'slug')
                    ->ignore($this->category->id),
            ],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);

        $this->category->update($validated);

        session()->flash(
            'success',
            'News category berhasil diperbarui.'
        );

        $this->redirect(
            route('admin.news.categories.index'),
            navigate: true
        );
    }
};
?>

<div class="max-w-3xl space-y-6">

    {{-- Header --}}
    <div>
        <a
            href="{{ route('admin.news.categories.index') }}"
            wire:navigate
            class="text-sm text-neutral-500 transition hover:text-neutral-900"
        >
            ← Back to Categories
        </a>

        <h1 class="mt-4 text-2xl font-bold text-neutral-900">
            Edit News Category
        </h1>

        <p class="mt-1 text-sm text-neutral-500">
            Perbarui informasi category berita.
        </p>
    </div>

    {{-- Form --}}
    <form
        wire:submit="save"
        class="space-y-6 rounded-xl border border-neutral-200 bg-white p-6"
    >

        {{-- Name --}}
        <div>
            <label
                for="name"
                class="block text-sm font-medium text-neutral-700"
            >
                Name
            </label>

            <input
                id="name"
                type="text"
                wire:model.live="name"
                class="mt-2 w-full rounded-lg border border-neutral-200 px-4 py-2.5 text-sm outline-none transition focus:border-neutral-900 focus:ring-1 focus:ring-neutral-900"
            >

            @error('name')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Slug --}}
        <div>
            <label
                for="slug"
                class="block text-sm font-medium text-neutral-700"
            >
                Slug
            </label>

            <input
                id="slug"
                type="text"
                wire:model="slug"
                class="mt-2 w-full rounded-lg border border-neutral-200 bg-neutral-50 px-4 py-2.5 text-sm text-neutral-600 outline-none"
            >

            <p class="mt-1 text-xs text-neutral-500">
                Slug akan digunakan untuk URL atau filtering di kemudian hari.
            </p>

            @error('slug')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Description --}}
        <div>
            <label
                for="description"
                class="block text-sm font-medium text-neutral-700"
            >
                Description
            </label>

            <textarea
                id="description"
                wire:model="description"
                rows="4"
                class="mt-2 w-full resize-y rounded-lg border border-neutral-200 px-4 py-2.5 text-sm outline-none transition focus:border-neutral-900 focus:ring-1 focus:ring-neutral-900"
            ></textarea>

            @error('description')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Status --}}
        <div>
            <label class="flex items-center gap-3">
                <input
                    type="checkbox"
                    wire:model="is_active"
                    class="h-4 w-4 rounded border-neutral-300"
                >

                <span class="text-sm font-medium text-neutral-700">
                    Active
                </span>
            </label>
        </div>

        {{-- Actions --}}
        <div class="flex justify-end gap-3 border-t border-neutral-100 pt-6">

            <a
                href="{{ route('admin.news.categories.index') }}"
                wire:navigate
                class="rounded-lg border border-neutral-200 px-4 py-2.5 text-sm font-medium text-neutral-700 transition hover:bg-neutral-50"
            >
                Cancel
            </a>

            <button
                type="submit"
                wire:loading.attr="disabled"
                class="rounded-lg bg-neutral-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-neutral-800 disabled:cursor-not-allowed disabled:opacity-50"
            >
                <span wire:loading.remove>
                    Save Changes
                </span>

                <span wire:loading>
                    Saving...
                </span>
            </button>

        </div>

    </form>

</div>