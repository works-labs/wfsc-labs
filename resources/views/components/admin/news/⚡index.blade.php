<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\News;
use Illuminate\Support\Facades\Storage;

new #[Layout('layouts.admin')] class extends Component
{
    public function delete(int $newsId): void
{
    $news = News::findOrFail($newsId);

    if ($news->thumbnail) {
        Storage::disk('public')->delete($news->thumbnail);
    }

    $news->delete();

    session()->flash('success', 'News deleted successfully.');
}
};
?>

<div>
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold">News</h1>

            <p class="mt-2 text-gray-600">
                Manage news articles published on the WFSC website.
            </p>
        </div>

        <a
            href="{{ route('admin.news.create') }}"
            wire:navigate
            class="rounded-lg bg-black px-4 py-2 text-sm font-semibold text-white hover:bg-gray-800"
        >
            + Add News
        </a>
    </div>

    <div class="mt-8 overflow-hidden rounded-xl border bg-white">
        <table class="w-full text-left">
            <thead class="border-b bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-sm font-semibold">News</th>
                    <th class="px-6 py-4 text-sm font-semibold">Author</th>
                    <th class="px-6 py-4 text-sm font-semibold">Published</th>
                    <th class="px-6 py-4 text-sm font-semibold">Featured</th>
                    <th class="px-6 py-4 text-sm font-semibold">Status</th>
                    <th class="px-6 py-4 text-sm font-semibold">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse (News::with('author')->latest()->get() as $news)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                @if ($news->thumbnail)
                                    <img
                                        src="{{ Storage::url($news->thumbnail) }}"
                                        alt="{{ $news->title }}"
                                        class="h-16 w-24 rounded-lg object-cover"
                                    >
                                @else
                                    <div class="flex h-16 w-24 items-center justify-center rounded-lg bg-gray-100 text-xs text-gray-400">
                                        No Image
                                    </div>
                                @endif

                                <div>
                                    <p class="font-semibold">
                                        {{ $news->title }}
                                    </p>

                                    <p class="text-sm text-gray-500">
                                        {{ $news->slug }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 text-sm">
                            {{ $news->author?->name ?? 'Unknown' }}
                        </td>

                        <td class="px-6 py-4 text-sm">
                            {{ $news->published_at?->format('d M Y') ?? 'Draft' }}
                        </td>

                        <td class="px-6 py-4 text-sm">
                            {{ $news->is_featured ? 'Yes' : 'No' }}
                        </td>

                        <td class="px-6 py-4">
                            @if ($news->is_active)
                                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                    Active
                                </span>
                            @else
                                <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
                                    Inactive
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            <a
                                href="{{ route('admin.news.edit', $news) }}"
                                wire:navigate
                                class="text-sm font-medium text-blue-600 hover:underline"
                            >
                                Edit
                            </a>
                            <button
                                type="button"
                                wire:click="delete({{ $news->id }})"
                                wire:confirm="Are you sure you want to delete this news?"
                                class="text-sm font-medium text-red-600 hover:underline"
                            >
                                Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td
                            colspan="6"
                            class="px-6 py-12 text-center text-gray-500"
                        >
                            No news articles yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>