<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\HeroBanner;
use Illuminate\Support\Facades\Storage;

new #[Layout('layouts.admin')] class extends Component
{
    public function delete(int $heroBannerId): void
    {
        $heroBanner = HeroBanner::findOrFail($heroBannerId);

        if ($heroBanner->background_image) {
            Storage::disk('public')->delete($heroBanner->background_image);
        }

        $heroBanner->delete();

        session()->flash('success', 'Hero banner deleted successfully.');
    }

    public function with(): array
    {
        return [
            'heroBanners' => HeroBanner::orderBy('sort_order')
                ->orderBy('id')
                ->get(),
        ];
    }
};
?>

<div>
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold">
                Hero Banners
            </h1>

            <p class="mt-2 text-gray-600">
                Manage hero banners displayed on the WFSC website.
            </p>
        </div>

        <a
            href="{{ route('admin.home.hero-banners.create') }}"
            wire:navigate
            class="rounded-lg bg-black px-5 py-2 font-semibold text-white"
        >
            Add Hero Banner
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-lg bg-green-100 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-xl bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="border-b bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-sm font-semibold">Preview</th>
                        <th class="px-6 py-4 text-sm font-semibold">Title</th>
                        <th class="px-6 py-4 text-sm font-semibold">CTA</th>
                        <th class="px-6 py-4 text-sm font-semibold">Sort Order</th>
                        <th class="px-6 py-4 text-sm font-semibold">Status</th>
                        <th class="px-6 py-4 text-sm font-semibold">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse ($heroBanners as $heroBanner)
                        <tr>
                            <td class="px-6 py-4">
                                @if ($heroBanner->background_image)
                                    <img
                                        src="{{ Storage::url($heroBanner->background_image) }}"
                                        alt="{{ $heroBanner->title }}"
                                        class="h-20 w-36 rounded-lg object-cover"
                                    >
                                @else
                                    <div class="flex h-20 w-36 items-center justify-center rounded-lg bg-gray-100 text-xs text-gray-400">
                                        No image
                                    </div>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <div class="font-medium">
                                    {{ $heroBanner->title }}
                                </div>

                                @if ($heroBanner->subtitle)
                                    <div class="mt-1 max-w-md text-sm text-gray-500">
                                        {{ $heroBanner->subtitle }}
                                    </div>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                @if ($heroBanner->cta_text)
                                    <div class="text-sm font-medium">
                                        {{ $heroBanner->cta_text }}
                                    </div>

                                    @if ($heroBanner->cta_url)
                                        <div class="mt-1 max-w-xs truncate text-xs text-gray-500">
                                            {{ $heroBanner->cta_url }}
                                        </div>
                                    @endif
                                @else
                                    <span class="text-sm text-gray-400">-</span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                {{ $heroBanner->sort_order }}
                            </td>

                            <td class="px-6 py-4">
                                @if ($heroBanner->is_active)
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
                                <div class="flex items-center gap-3">
                                    <a
                                        href="{{ route('admin.home.hero-banners.edit', $heroBanner) }}"
                                        wire:navigate
                                        class="text-sm font-medium text-blue-600 hover:underline"
                                    >
                                        Edit
                                    </a>

                                    <button
                                        type="button"
                                        wire:click="delete({{ $heroBanner->id }})"
                                        wire:confirm="Are you sure you want to delete this hero banner?"
                                        class="text-sm font-medium text-red-600 hover:underline"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                No hero banners found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>