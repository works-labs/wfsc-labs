<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Doctor;
use App\Models\DoctorHomeSection;

new #[Layout('layouts.admin')] class extends Component
{
    public DoctorHomeSection $doctorHomeSection;

    public ?int $doctor_id = null;
    public string $section = 'doctors';
    public int $sort_order = 0;
    public bool $is_active = true;

    public function mount(DoctorHomeSection $doctorHomeSection): void
    {
        $this->doctorHomeSection = $doctorHomeSection;

        $this->doctor_id = $doctorHomeSection->doctor_id;
        $this->section = $doctorHomeSection->section;
        $this->sort_order = $doctorHomeSection->sort_order;
        $this->is_active = (bool) $doctorHomeSection->is_active;
    }

    public function update(): void
{
    $validated = $this->validate([
        'doctor_id' => ['required', 'exists:doctors,id'],
        'section' => ['required', 'in:hero,doctors'],
        'sort_order' => ['required', 'integer', 'min:0'],
        'is_active' => ['boolean'],
    ]);

    $currentDoctor = $this->doctorHomeSection->doctor;

    /*
    |--------------------------------------------------------------------------
    | Founder Protection
    |--------------------------------------------------------------------------
    */

    if ($currentDoctor?->isFounder()) {

        // Founder tidak boleh dipindahkan dari Doctors section
        if ($this->section !== 'doctors') {
            $this->addError(
                'section',
                'Founder doctor must remain in the Doctors section.'
            );

            return;
        }

        // Founder harus selalu active
        $validated['is_active'] = true;

        // Founder tidak boleh diganti menjadi doctor lain
        $validated['doctor_id'] = $currentDoctor->id;
    }

    /*
    |--------------------------------------------------------------------------
    | Prevent duplicate assignment
    |--------------------------------------------------------------------------
    */

    $exists = DoctorHomeSection::where('doctor_id', $validated['doctor_id'])
        ->where('section', $validated['section'])
        ->where('id', '!=', $this->doctorHomeSection->id)
        ->exists();

    if ($exists) {
        $this->addError(
            'doctor_id',
            'This doctor is already assigned to this section.'
        );

        return;
    }

    $this->doctorHomeSection->update($validated);

    session()->flash(
        'success',
        'Doctor home section updated successfully.'
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
            Edit Doctor Home Section
        </h1>

        <p class="mt-2 text-gray-600">
            Update the doctor's Home page assignment.
        </p>
    </div>

    <form wire:submit="update" class="max-w-3xl space-y-6">

        {{-- Doctor --}}
        <div>
            <label class="mb-2 block text-sm font-medium">
                Doctor
            </label>

            @if ($doctorHomeSection->doctor?->isFounder())

    <div>
        <label class="mb-2 block text-sm font-medium">
            Doctor
        </label>

        <div class="flex items-center justify-between rounded-lg border border-amber-200 bg-amber-50 px-4 py-3">
            <div>
                <div class="font-medium text-gray-900">
                    {{ $doctorHomeSection->doctor->title }}
                    {{ $doctorHomeSection->doctor->name }}
                </div>

                <div class="mt-1 text-xs text-amber-700">
                    ♛ Protected Founder
                </div>
            </div>

            <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                Founder
            </span>
        </div>

        <p class="mt-2 text-xs text-gray-500">
            Founder doctor cannot be replaced.
        </p>
    </div>

@else

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

@endif
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

            @if ($doctorHomeSection->doctor?->isFounder())

    <div>
        <label class="mb-2 block text-sm font-medium">
            Section
        </label>

        <div class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3">
            <div class="font-medium text-gray-900">
                Doctors
            </div>

            <div class="mt-1 text-xs text-amber-700">
                Founder must remain in the Doctors section.
            </div>
        </div>
    </div>

@else

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

@endif

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
        @if ($doctorHomeSection->doctor?->isFounder())

    <div>
        <label class="mb-2 block text-sm font-medium">
            Status
        </label>

        <div class="flex items-center gap-3 rounded-lg border border-green-200 bg-green-50 px-4 py-3">
            <span class="h-2.5 w-2.5 rounded-full bg-green-500"></span>

            <div>
                <div class="text-sm font-semibold text-green-700">
                    Active
                </div>

                <div class="text-xs text-green-600">
                    Founder is always visible on the Home page.
                </div>
            </div>
        </div>
    </div>

@else

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

@endif

        {{-- Actions --}}
        <div class="flex items-center gap-3 pt-4">
            <button
                type="submit"
                class="rounded-lg bg-black px-5 py-2 font-semibold text-white"
            >
                Update
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