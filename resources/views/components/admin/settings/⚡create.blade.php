<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\SiteSetting;

new #[Layout('layouts.admin')] class extends Component
{
    public string $key = '';
    public string $value = '';

    public function save(): void
    {
        $validated = $this->validate([
            'key' => [
                'required',
                'string',
                'max:255',
                'unique:site_settings,key',
            ],

            'value' => [
                'nullable',
                'string',
            ],
        ]);

        SiteSetting::create($validated);

        session()->flash(
            'success',
            'Site setting berhasil ditambahkan.'
        );

        $this->redirectRoute(
            'admin.settings.index',
            navigate: true
        );
    }
};
?>

<div>

    <div class="mb-6">
        <a
            href="{{ route('admin.settings.index') }}"
            wire:navigate
            class="text-sm text-gray-500 hover:text-gray-900"
        >
            ← Back to Site Settings
        </a>

        <h1 class="mt-3 text-2xl font-bold">
            Add Site Setting
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Add a new global website setting.
        </p>
    </div>

    <form
        wire:submit="save"
        class="max-w-2xl rounded-xl bg-white p-6 shadow-sm"
    >

        <div class="space-y-6">

            {{-- Key --}}
            <div>

                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Key
                </label>

                <input
                    type="text"
                    wire:model="key"
                    placeholder="e.g. whatsapp_number"
                    class="w-full rounded-lg border-gray-300 px-4 py-2.5 text-sm focus:border-gray-900 focus:ring-gray-900"
                >

                @error('key')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- Value --}}
            <div>

                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Value
                </label>

                <textarea
                    wire:model="value"
                    rows="5"
                    placeholder="Enter setting value..."
                    class="w-full rounded-lg border-gray-300 px-4 py-2.5 text-sm focus:border-gray-900 focus:ring-gray-900"
                ></textarea>

                @error('value')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

        </div>

        <div class="mt-8 flex justify-end gap-3">

            <a
                href="{{ route('admin.settings.index') }}"
                wire:navigate
                class="rounded-lg border px-4 py-2 text-sm font-medium hover:bg-gray-50"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800"
            >
                Save Setting
            </button>

        </div>

    </form>

</div>