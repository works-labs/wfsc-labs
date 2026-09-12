<?php

use App\Models\NewsCategory;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.admin')] class extends Component
{
    public function delete(int $id): void
    {
        $category = NewsCategory::findOrFail($id);

        $category->delete();

        session()->flash(
            'success',
            'News category berhasil dihapus.'
        );
    }

    public function with(): array
    {
        return [
            'categories' => NewsCategory::query()
                ->withCount('news')
                ->orderBy('name')
                ->get(),
        ];
    }
};
?>

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-neutral-900">
                News Categories
            </h1>

            <p class="mt-1 text-sm text-neutral-500">
                Kelola kategori untuk artikel berita.
            </p>
        </div>

        <a
            href="{{ route('admin.news.categories.create') }}"
            wire:navigate
            class="inline-flex items-center justify-center rounded-lg bg-neutral-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-neutral-800"
        >
            + Add Category
        </a>
    </div>

    {{-- Flash Message --}}
    @if (session()->has('success'))
        <div
            class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700"
        >
            {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[700px] text-left text-sm">

                <thead class="border-b border-neutral-200 bg-neutral-50">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-neutral-700">
                            Name
                        </th>

                        <th class="px-6 py-4 font-semibold text-neutral-700">
                            Slug
                        </th>

                        <th class="px-6 py-4 font-semibold text-neutral-700">
                            News
                        </th>

                        <th class="px-6 py-4 font-semibold text-neutral-700">
                            Status
                        </th>

                        <th class="px-6 py-4 text-right font-semibold text-neutral-700">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-neutral-100">

                    @forelse ($categories as $category)

                        <tr wire:key="category-{{ $category->id }}">

                            {{-- Name --}}
                            <td class="px-6 py-4">
                                <div class="font-medium text-neutral-900">
                                    {{ $category->name }}
                                </div>

                                @if ($category->description)
                                    <div class="mt-1 max-w-md truncate text-xs text-neutral-500">
                                        {{ $category->description }}
                                    </div>
                                @endif
                            </td>

                            {{-- Slug --}}
                            <td class="px-6 py-4">
                                <code class="rounded bg-neutral-100 px-2 py-1 text-xs text-neutral-600">
                                    {{ $category->slug }}
                                </code>
                            </td>

                            {{-- News count --}}
                            <td class="px-6 py-4 text-neutral-600">
                                {{ $category->news_count }}
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-4">

                                @if ($category->is_active)
                                    <span class="inline-flex rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex rounded-full bg-neutral-100 px-2.5 py-1 text-xs font-medium text-neutral-500">
                                        Inactive
                                    </span>
                                @endif

                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">

                                    <a
                                        href="{{ route('admin.news.categories.edit', $category) }}"
                                        wire:navigate
                                        class="rounded-lg border border-neutral-200 px-3 py-2 text-xs font-medium text-neutral-700 transition hover:bg-neutral-50"
                                    >
                                        Edit
                                    </a>

                                    <button
                                        type="button"
                                        wire:click="delete({{ $category->id }})"
                                        wire:confirm="Yakin ingin menghapus category ini?"
                                        class="rounded-lg border border-red-200 px-3 py-2 text-xs font-medium text-red-600 transition hover:bg-red-50"
                                    >
                                        Delete
                                    </button>

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td
                                colspan="5"
                                class="px-6 py-12 text-center text-sm text-neutral-500"
                            >
                                Belum ada news category.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>
        </div>
    </div>

</div>