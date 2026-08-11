<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Branch;

new #[Layout('layouts.admin')] class extends Component
{
    public string $name = '';
    public string $address = '';
    public string $phone = '';
    public string $whatsapp = '';
    public string $email = '';
    public string $google_maps_url = '';
    public string $latitude = '';
    public string $longitude = '';
    public bool $is_active = true;

    public function save(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'phone' => ['nullable', 'string', 'max:255'],
            'whatsapp' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'google_maps_url' => ['nullable', 'url', 'max:2000'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'is_active' => ['boolean'],
        ]);

        Branch::create($validated);

        session()->flash(
            'success',
            'Branch created successfully.'
        );

        $this->redirect(
            route('admin.branches.index'),
            navigate: true
        );
    }
};

?>

<div>
    <div class="mb-8">
        <h1 class="text-2xl font-bold">
            Add Branch
        </h1>

        <p class="mt-2 text-gray-600">
            Add a new clinic branch and its contact information.
        </p>
    </div>

    <form wire:submit="save" class="max-w-4xl space-y-6">

        {{-- Name --}}
        <div>
            <label class="mb-2 block text-sm font-medium">
                Branch Name
            </label>

            <input
                type="text"
                wire:model="name"
                class="w-full rounded-lg border px-4 py-2"
                placeholder="WFSC Surabaya"
            >

            @error('name')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Address --}}
        <div>
            <label class="mb-2 block text-sm font-medium">
                Address
            </label>

            <textarea
                wire:model="address"
                rows="4"
                class="w-full rounded-lg border px-4 py-2"
                placeholder="Full branch address"
            ></textarea>

            @error('address')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Contact --}}
        <div class="grid gap-6 md:grid-cols-3">

            <div>
                <label class="mb-2 block text-sm font-medium">
                    Phone
                </label>

                <input
                    type="text"
                    wire:model="phone"
                    class="w-full rounded-lg border px-4 py-2"
                    placeholder="031-xxxxxxx"
                >

                @error('phone')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium">
                    WhatsApp
                </label>

                <input
                    type="text"
                    wire:model="whatsapp"
                    class="w-full rounded-lg border px-4 py-2"
                    placeholder="628xxxxxxxxxx"
                >

                @error('whatsapp')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium">
                    Email
                </label>

                <input
                    type="email"
                    wire:model="email"
                    class="w-full rounded-lg border px-4 py-2"
                    placeholder="branch@example.com"
                >

                @error('email')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

        </div>

        {{-- Google Maps --}}
        <div>
            <label class="mb-2 block text-sm font-medium">
                Google Maps URL
            </label>

            <input
                type="url"
                wire:model="google_maps_url"
                class="w-full rounded-lg border px-4 py-2"
                placeholder="https://maps.google.com/..."
            >

            @error('google_maps_url')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Coordinates --}}
        <div class="grid gap-6 md:grid-cols-2">

            <div>
                <label class="mb-2 block text-sm font-medium">
                    Latitude
                </label>

                <input
                    type="number"
                    step="0.0000001"
                    wire:model="latitude"
                    class="w-full rounded-lg border px-4 py-2"
                    placeholder="-7.2575"
                >

                @error('latitude')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium">
                    Longitude
                </label>

                <input
                    type="number"
                    step="0.0000001"
                    wire:model="longitude"
                    class="w-full rounded-lg border px-4 py-2"
                    placeholder="112.7521"
                >

                @error('longitude')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

        </div>

        {{-- Active --}}
        <div class="flex items-center gap-3">
            <input
                type="checkbox"
                wire:model="is_active"
                id="is_active"
                class="rounded"
            >

            <label
                for="is_active"
                class="text-sm font-medium"
            >
                Active
            </label>
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-3 pt-4">

            <button
                type="submit"
                class="rounded-lg bg-black px-5 py-2 font-semibold text-white"
            >
                Save Branch
            </button>

            <a
                href="{{ route('admin.branches.index') }}"
                wire:navigate
                class="rounded-lg border px-5 py-2 font-medium"
            >
                Cancel
            </a>

        </div>

    </form>
</div>