<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\SiteSetting;

new #[Layout('layouts.admin')] class extends Component
{
    public function delete(int $id): void
    {
        SiteSetting::findOrFail($id)->delete();

        session()->flash(
            'success',
            'Site setting berhasil dihapus.'
        );
    }
};
?>

<div>

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold">
                Site Settings
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Manage global website settings.
            </p>
        </div>

        <a
            href="{{ route('admin.settings.create') }}"
            wire:navigate
            class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800"
        >
            + Add Setting
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @php
        $settings = SiteSetting::query()
            ->orderBy('key')
            ->get();
    @endphp

    @if ($settings->isEmpty())

        <div class="rounded-xl bg-white p-10 text-center shadow-sm">
            <p class="text-sm text-gray-500">
                Belum ada site setting.
            </p>

            <a
                href="{{ route('admin.settings.create') }}"
                wire:navigate
                class="mt-4 inline-block text-sm font-medium text-blue-600 hover:underline"
            >
                Tambahkan setting pertama
            </a>
        </div>

    @else

        <div class="overflow-hidden rounded-xl bg-white shadow-sm">

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Key
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Value
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Actions
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-200">

                        @foreach ($settings as $setting)

                            <tr>

                                <td class="px-6 py-4">
                                    <code class="rounded bg-gray-100 px-2 py-1 text-sm font-medium text-gray-800">
                                        {{ $setting->key }}
                                    </code>
                                </td>

                                <td class="max-w-xl px-6 py-4">
                                    <div class="truncate text-sm text-gray-700">
                                        {{ $setting->value ?: '-' }}
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex justify-end gap-2">

                                        <a
                                            href="{{ route('admin.settings.edit', $setting) }}"
                                            wire:navigate
                                            class="rounded-lg border px-3 py-2 text-xs font-medium hover:bg-gray-50"
                                        >
                                            Edit
                                        </a>

                                        <button
                                            type="button"
                                            wire:click="delete({{ $setting->id }})"
                                            wire:confirm="Yakin ingin menghapus setting ini?"
                                            class="rounded-lg border border-red-200 px-3 py-2 text-xs font-medium text-red-600 hover:bg-red-50"
                                        >
                                            Delete
                                        </button>

                                    </div>
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    @endif

</div>