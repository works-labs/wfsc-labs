<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Doctor;
use App\Models\DoctorHomeSection;

new #[Layout('layouts.admin')] class extends Component
{
    public ?int $doctor_id = null;
    public string $section = 'doctors';
    public int $sort_order = 0;
    public bool $is_active = true;

    public function save(): void
    {
        $validated = $this->validate([
            'doctor_id' => ['required', 'exists:doctors,id'],
            'section' => ['required', 'in:hero,doctors'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        $exists = DoctorHomeSection::where('doctor_id', $this->doctor_id)
            ->where('section', $this->section)
            ->exists();

        if ($exists) {
            $this->addError(
                'doctor_id',
                'This doctor is already assigned to this section.'
            );

            return;
        }

        DoctorHomeSection::create($validated);

        session()->flash(
            'success',
            'Doctor home section created successfully.'
        );

        $this->redirect(
            route('admin.home.doctor-home-sections.index'),
            navigate: true
        );
    }

    public function with(): array
    {
        return [
            'doctors' => Doctor::orderBy('name')->get(),
        ];
    }
};

?>

<div>
    <div class="mb-8">
        <h1 class="text-2xl font-bold">
            Add Doctor Home Section
        </h1>

        <p class="mt-2 text-gray-600">
            Select a doctor and assign them to a Home section.
        </p>
    </div>

    <form wire:submit="save" class="max-w-3xl space-y-6">

        {{-- Doctor --}}
        <div>
            <label class="mb-2 block text-sm font-medium">
                Doctor
            </label>

            <select
                wire:model="doctor_id"
                class="w-full rounded-lg border px-4 py-2"
            >
                <option value="">Select doctor</option>

                @foreach ($doctors as $doctor)
                    <option value="{{ $doctor->id }}">
                        {{ $doctor->title }} {{ $doctor->name }}
                    </option>
                @endforeach
            </select>

            @error('doctor_id')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Section --}}
        <div>
            <label class="mb-2 block text-sm font-medium">
                Section
            </label>

            <select
                wire:model="section"
                class="w-full rounded-lg border px-4 py-2"
            >
                <option value="hero">Hero</option>
                <option value="doctors">Doctors</option>
            </select>

            @error('section')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Sort Order --}}
        <div>
            <label class="mb-2 block text-sm font-medium">
                Sort Order
            </label>

            <input
                type="number"
                wire:model="sort_order"
                min="0"
                class="w-full rounded-lg border px-4 py-2"
            >

            @error('sort_order')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror
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
                Save
            </button>

            <a
                href="{{ route('admin.home.doctor-home-sections.index') }}"
                wire:navigate
                class="rounded-lg border px-5 py-2 font-medium"
            >
                Cancel
            </a>
        </div>

    </form>
</div>