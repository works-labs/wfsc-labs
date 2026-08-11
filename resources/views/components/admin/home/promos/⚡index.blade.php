<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Promo;
use Illuminate\Support\Facades\Storage;

new #[Layout('layouts.admin')] class extends Component
{
    public function delete(int $promoId): void
    {
        $promo = Promo::findOrFail($promoId);

        if ($promo->image) {
            Storage::disk('public')->delete($promo->image);
        }

        $promo->delete();

        session()->flash(
            'success',
            'Promo deleted successfully.'
        );
    }

    public function with(): array
    {
        return [
            'promos' => Promo::orderBy('sort_order')
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
                Promos
            </h1>

            <p class="mt-2 text-gray-600">
                Manage promotional content displayed on the WFSC website.
            </p>
        </div>

        <a
            href="{{ route('admin.home.promos.create') }}"
            wire:navigate
            class="rounded-lg bg-black px-5 py-2 font-semibold text-white"
        >
            Add Promo
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
                        <th class="px-6 py-4 text-sm font-semibold">
                            Image
                        </th>

                        <th class="px-6 py-4 text-sm font-semibold">
                            Title
                        </th>

                        <th class="px-6 py-4 text-sm font-semibold">
                            Period
                        </th>

                        <th class="px-6 py-4 text-sm font-semibold">
                            Sort Order
                        </th>

                        <th class="px-6 py-4 text-sm font-semibold">
                            Status
                        </th>

                        <th class="px-6 py-4 text-sm font-semibold">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse ($promos as $promo)
                        <tr>
                            <td class="px-6 py-4">
                                @if ($promo->image)
                                    <img
                                        src="{{ Storage::url($promo->image) }}"
                                        alt="{{ $promo->title }}"
                                        class="h-16 w-24 rounded-lg object-cover"
                                    >
                                @else
                                    <div class="flex h-16 w-24 items-center justify-center rounded-lg bg-gray-100 text-xs text-gray-500">
                                        No Image
                                    </div>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <div class="font-medium">
                                    {{ $promo->title }}
                                </div>

                                <div class="mt-1 text-xs text-gray-500">
                                    {{ $promo->slug }}
                                </div>
                            </td>

                            <td class="px-6 py-4 text-sm">
                                <div>
                                    {{ $promo->start_date?->format('d M Y') ?? '-' }}
                                </div>

                                <div class="text-gray-500">
                                    →
                                    {{ $promo->end_date?->format('d M Y') ?? '-' }}
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                {{ $promo->sort_order }}
                            </td>

                            <td class="px-6 py-4">
                                @if ($promo->is_active)
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
                                        href="{{ route('admin.home.promos.edit', $promo) }}"
                                        wire:navigate
                                        class="text-sm font-medium text-blue-600 hover:underline"
                                    >
                                        Edit
                                    </a>

                                    <button
                                        type="button"
                                        wire:click="delete({{ $promo->id }})"
                                        wire:confirm="Are you sure you want to delete this promo?"
                                        class="text-sm font-medium text-red-600 hover:underline"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                colspan="6"
                                class="px-6 py-12 text-center text-gray-500"
                            >
                                No promos found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>