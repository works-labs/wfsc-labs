<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Branch;

new #[Layout('layouts.admin')] class extends Component
{
    public function delete(int $branchId): void
    {
        Branch::findOrFail($branchId)->delete();

        session()->flash(
            'success',
            'Branch deleted successfully.'
        );
    }

    public function with(): array
    {
        return [
            'branches' => Branch::orderBy('name')->get(),
        ];
    }
};

?>

<div>
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold">
                Branches
            </h1>

            <p class="mt-2 text-gray-600">
                Manage clinic branches and contact information.
            </p>
        </div>

        <a
            href="{{ route('admin.branches.create') }}"
            wire:navigate
            class="rounded-lg bg-black px-5 py-2 font-semibold text-white"
        >
            Add Branch
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
                            Branch
                        </th>

                        <th class="px-6 py-4 text-sm font-semibold">
                            Contact
                        </th>

                        <th class="px-6 py-4 text-sm font-semibold">
                            Location
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
                    @forelse ($branches as $branch)
                        <tr>
                            {{-- Branch --}}
                            <td class="px-6 py-4">
                                <div class="font-medium">
                                    {{ $branch->name }}
                                </div>

                                <div class="mt-1 max-w-sm text-sm text-gray-500">
                                    {{ $branch->address }}
                                </div>
                            </td>

                            {{-- Contact --}}
                            <td class="px-6 py-4">
                                <div class="space-y-1 text-sm">
                                    @if ($branch->phone)
                                        <div>
                                            📞 {{ $branch->phone }}
                                        </div>
                                    @endif

                                    @if ($branch->whatsapp)
                                        <div>
                                            WhatsApp: {{ $branch->whatsapp }}
                                        </div>
                                    @endif

                                    @if ($branch->email)
                                        <div>
                                            ✉ {{ $branch->email }}
                                        </div>
                                    @endif
                                </div>
                            </td>

                            {{-- Location --}}
                            <td class="px-6 py-4">
                                @if ($branch->google_maps_url)
                                    <a
                                        href="{{ $branch->google_maps_url }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="text-sm font-medium text-blue-600 hover:underline"
                                    >
                                        Google Maps
                                    </a>
                                @elseif ($branch->latitude && $branch->longitude)
                                    <span class="text-sm text-gray-500">
                                        {{ $branch->latitude }},
                                        {{ $branch->longitude }}
                                    </span>
                                @else
                                    <span class="text-sm text-gray-400">
                                        Not set
                                    </span>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-4">
                                @if ($branch->is_active)
                                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                        Active
                                    </span>
                                @else
                                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <a
                                        href="{{ route('admin.branches.edit', $branch) }}"
                                        wire:navigate
                                        class="text-sm font-medium text-blue-600 hover:underline"
                                    >
                                        Edit
                                    </a>

                                    <button
                                        type="button"
                                        wire:click="delete({{ $branch->id }})"
                                        wire:confirm="Are you sure you want to delete this branch?"
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
                                colspan="5"
                                class="px-6 py-12 text-center text-gray-500"
                            >
                                No branches found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>