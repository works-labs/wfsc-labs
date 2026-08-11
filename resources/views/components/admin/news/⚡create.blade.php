<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use App\Models\News;
use Illuminate\Support\Str;

new #[Layout('layouts.admin')] class extends Component
{
    use WithFileUploads;

    public string $title = '';
    public string $slug = '';
    public string $excerpt = '';
    public string $content = '';
    public $thumbnail = null;
    public $published_at = null;
    public bool $is_featured = false;
    public bool $is_active = true;

    public function updatedTitle(): void
    {
        $this->slug = Str::slug($this->title);
    }

    public function save(): void
    {
        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:news,slug'],
            'excerpt' => ['nullable', 'string'],
            'content' => ['required', 'string'],
            'thumbnail' => ['nullable', 'image', 'max:2048'],
            'published_at' => ['nullable', 'date'],
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
        ]);

        if ($this->thumbnail) {
            $validated['thumbnail'] = $this->thumbnail->store('news', 'public');
        }

        $validated['author_id'] = auth()->id();

        News::create($validated);

        session()->flash('success', 'News created successfully.');

        $this->redirect(
            route('admin.news.index'),
            navigate: true
        );
    }
};
?>

<div>
    <div class="mb-8">
        <h1 class="text-2xl font-bold">
            Create News
        </h1>

        <p class="mt-2 text-gray-600">
            Add a new news article to the WFSC website.
        </p>
    </div>

    <form wire:submit="save" class="space-y-6">

        <div>
            <label class="block text-sm font-medium">
                Title
            </label>

            <input
                type="text"
                wire:model.live="title"
                class="mt-2 w-full rounded-lg border px-4 py-2"
                placeholder="News title"
            >

            @error('title')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">
                Slug
            </label>

            <input
                type="text"
                wire:model="slug"
                class="mt-2 w-full rounded-lg border px-4 py-2"
            >

            @error('slug')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">
                Excerpt
            </label>

            <textarea
                wire:model="excerpt"
                rows="3"
                class="mt-2 w-full rounded-lg border px-4 py-2"
                placeholder="Short description..."
            ></textarea>

            @error('excerpt')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">
                Content
            </label>

            <textarea
                wire:model="content"
                rows="10"
                class="mt-2 w-full rounded-lg border px-4 py-2"
                placeholder="Write the news content..."
            ></textarea>

            @error('content')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">
                Thumbnail
            </label>

            <input
                type="file"
                wire:model="thumbnail"
                accept="image/*"
                class="mt-2 block w-full"
            >

            @error('thumbnail')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror

            @if ($thumbnail)
                <div class="mt-4">
                    <p class="mb-2 text-sm text-gray-500">
                        Preview
                    </p>

                    <img
                        src="{{ $thumbnail->temporaryUrl() }}"
                        class="h-48 w-80 rounded-xl object-cover"
                        alt="Thumbnail preview"
                    >
                </div>
            @endif
        </div>

        <div>
            <label class="block text-sm font-medium">
                Published At
            </label>

            <input
                type="datetime-local"
                wire:model="published_at"
                class="mt-2 rounded-lg border px-4 py-2"
            >

            @error('published_at')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-6">
            <label class="flex items-center gap-2">
                <input
                    type="checkbox"
                    wire:model="is_featured"
                >
                <span class="text-sm">Featured</span>
            </label>

            <label class="flex items-center gap-2">
                <input
                    type="checkbox"
                    wire:model="is_active"
                >
                <span class="text-sm">Active</span>
            </label>
        </div>

        <div class="flex gap-3">
            <a
                href="{{ route('admin.news.index') }}"
                wire:navigate
                class="rounded-lg border px-5 py-2"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="rounded-lg bg-black px-5 py-2 font-semibold text-white"
            >
                Save News
            </button>
        </div>

    </form>
</div>