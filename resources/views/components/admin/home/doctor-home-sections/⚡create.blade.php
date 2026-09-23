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

    $doctor = Doctor::findOrFail($this->doctor_id);

    // Founder hanya boleh berada di Doctors section
    $allowedSections = ['doctors', 'hero'];

    if ($doctor->isFounder() && !in_array($this->section, $allowedSections)) {
        $this->addError(
            'section',
            'Founder doctor can only be assigned to Doctors or Home sections.'
        );

        return;
    }

    // Founder harus selalu active
    if ($doctor->isFounder()) {
        $validated['is_active'] = true;
    }

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

<div class="mx-auto max-w-4xl space-y-8 pb-10">

    {{-- Top Navigation & Header --}}
    <div>
        <a href="{{ route('admin.home.doctor-home-sections.index') }}" wire:navigate 
            class="inline-flex items-center gap-2 text-sm font-bold text-gray-400 transition-colors hover:text-[var(--color-wfsc-coral)]">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to Doctor Sections
        </a>
        <div class="mt-4 flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-rose-50 text-[var(--color-wfsc-coral)] shadow-sm">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </div>
            <div>
                <h1 class="text-2xl font-black tracking-tight text-[var(--color-wfsc-dark)]">Tambah Dokter Home Section</h1>
                <p class="text-sm font-medium text-gray-500">Select a doctor and assign them to a Home section.</p>
            </div>
        </div>
    </div>

    <form wire:submit="save" class="space-y-8">

        {{-- Assignment Configuration Card --}}
        <div class="relative overflow-hidden rounded-2xl border border-gray-100/50 bg-white p-8 elegant-shadow">
            <div class="absolute left-0 top-0 h-full w-1 bg-emerald-400"></div>
            
            <div class="mb-6 flex items-center gap-3">
                <div class="rounded-lg bg-emerald-50 p-2 text-emerald-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <h2 class="text-lg font-bold text-[var(--color-wfsc-dark)]">Assignment Details</h2>
            </div>

            <div class="space-y-6">
                {{-- Doctor --}}
                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Doctor <span class="text-[var(--color-wfsc-coral)]">*</span></label>
                    <select
                        wire:model="doctor_id"
                        class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                    >
                        <option value="">Select doctor</option>
                        @foreach ($doctors as $doctor)
                            <option value="{{ $doctor->id }}">
                                {{ $doctor->title }} {{ $doctor->name }}
                                @if ($doctor->isFounder())
                                    — Founder
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('doctor_id')
                        <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Section --}}
                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Section <span class="text-[var(--color-wfsc-coral)]">*</span></label>
                    <select
                        wire:model="section"
                        class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                    >
                        <option value="hero">Hero</option>
                        <option value="doctors">Doctors</option>
                    </select>
                    @error('section')
                        <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    {{-- Sort Order --}}
                    <div>
                        <label class="mb-2 block text-sm font-bold text-gray-600">Sort Order</label>
                        <input
                            type="number"
                            wire:model="sort_order"
                            min="0"
                            placeholder="0"
                            class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                        >
                        @error('sort_order')
                            <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Aktif --}}
                    <div class="flex items-center pt-8">
                        <label class="inline-flex items-center gap-3 rounded-xl border border-gray-100 bg-gray-50 p-4 w-full transition-colors hover:bg-gray-100 cursor-pointer">
                            <input
                                type="checkbox"
                                wire:model="is_active"
                                id="is_active"
                                class="h-5 w-5 rounded-md border-gray-300 text-[var(--color-wfsc-coral)] focus:ring-[var(--color-wfsc-coral)]"
                            >
                            <div>
                                <span class="block text-sm font-bold text-gray-800">Aktif</span>
                                <span class="block text-xs font-medium text-gray-500">Visible on homepage.</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        {{-- Aksi --}}
        <div class="flex items-center justify-end gap-4 pt-4">
            <a
                href="{{ route('admin.home.doctor-home-sections.index') }}"
                wire:navigate
                class="rounded-xl px-5 py-3 text-sm font-bold text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-800"
            >
                Batal
            </a>

            <button
                type="submit"
                wire:loading.attr="disabled"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[var(--color-wfsc-coral)] to-[#ff7676] px-8 py-3 text-sm font-bold text-white shadow-lg shadow-[var(--color-wfsc-coral)]/30 transition-all duration-300 hover:scale-[1.02] hover:shadow-xl hover:shadow-[var(--color-wfsc-coral)]/40 disabled:opacity-70 disabled:hover:scale-100"
            >
                <span wire:loading.remove>Save</span>
                <span wire:loading>
                    <svg class="h-4 w-4 animate-spin text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Saving...
                </span>
            </button>
        </div>

    </form>
</div>