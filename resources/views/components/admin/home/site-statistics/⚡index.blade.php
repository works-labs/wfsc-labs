<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\SiteStatistic;

new #[Layout('layouts.admin')] class extends Component
{
    public function delete(int $statisticId): void
    {
        SiteStatistic::findOrFail($statisticId)->delete();

        session()->flash(
            'success',
            'Statistic deleted successfully.'
        );
    }

    public function with(): array
    {
        return [
            'statistics' => SiteStatistic::orderBy('sort_order')
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
                Site Statistics
            </h1>

            <p class="mt-2 text-gray-600">
                Manage statistics displayed on the WFSC website.
            </p>
        </div>

        <a
            href="{{ route('admin.home.site-statistics.create') }}"
            wire:navigate
            class="rounded-lg bg-black px-5 py-2 font-semibold text-white"
        >
            Add Statistic
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
                            Label
                        </th>

                        <th class="px-6 py-4 text-sm font-semibold">
                            Value
                        </th>

                        <th class="px-6 py-4 text-sm font-semibold">
                            Suffix
                        </th>

                        <th class="px-6 py-4 text-sm font-semibold">
                            Icon
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
                    @forelse ($statistics as $statistic)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="font-medium">
                                    {{ $statistic->label }}
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <span class="font-semibold">
                                    {{ $statistic->value }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                {{ $statistic->suffix ?: '-' }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $statistic->icon ?: '-' }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $statistic->sort_order }}
                            </td>

                            <td class="px-6 py-4">
                                @if ($statistic->is_active)
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
                                        href="{{ route('admin.home.site-statistics.edit', $statistic) }}"
                                        wire:navigate
                                        class="text-sm font-medium text-blue-600 hover:underline"
                                    >
                                        Edit
                                    </a>

                                    <button
                                        type="button"
                                        wire:click="delete({{ $statistic->id }})"
                                        wire:confirm="Are you sure you want to delete this statistic?"
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
                                colspan="7"
                                class="px-6 py-12 text-center text-gray-500"
                            >
                                No statistics found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>