<?php

use App\Models\Doctor;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;

new #[Layout('layouts.admin')] class extends Component
{
    use WithFileUploads;

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('nullable|string|max:50')]
    public string $title = '';

    #[Validate('nullable|string|max:255')]
    public string $specialization = '';

    #[Validate('nullable|string|max:255')]
    public string $experience = '';

    #[Validate('nullable|string|max:1000')]
    public string $short_bio = '';

    #[Validate('nullable|string')]
    public string $bio = '';

    #[Validate('nullable|string')]
    public string $education = '';

    #[Validate('nullable|string')]
    public string $certifications = '';

    #[Validate('nullable|image|max:5120')]
    public $photo = null;

    public bool $is_active = true;

    public function save(): void
    {
        $this->validate();

        $slug = Str::slug($this->name);

        $originalSlug = $slug;
        $counter = 1;

        while (Doctor::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $photoPath = null;

        if ($this->photo) {
            $photoPath = $this->photo->store('doctors', 'public');
        }

        Doctor::create([
            'name' => $this->name,
            'slug' => $slug,
            'title' => $this->title ?: null,
            'photo' => $photoPath,
            'short_bio' => $this->short_bio ?: null,
            'bio' => $this->bio ?: null,
            'specialization' => $this->specialization ?: null,
            'education' => $this->education ?: null,
            'certifications' => $this->certifications ?: null,
            'experience' => $this->experience ?: null,
            'is_active' => $this->is_active,
        ]);

        session()->flash('success', 'Doctor created successfully.');

        $this->redirectRoute('admin.doctors.index', navigate: true);
    }
};
?>

<div class="mx-auto max-w-4xl">

    <div class="mb-8">
        <a
            href="{{ route('admin.doctors.index') }}"
            wire:navigate
            class="text-sm text-gray-500 hover:text-gray-900"
        >
            ← Back to Doctors
        </a>

        <h1 class="mt-3 text-2xl font-bold text-gray-900">
            Add Doctor
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Add a doctor to the WFSC medical team.
        </p>
    </div>

    <form wire:submit="save" class="space-y-8">

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

            <h2 class="text-lg font-semibold text-gray-900">
                Basic Information
            </h2>

            <div class="mt-6 grid gap-6 md:grid-cols-2">

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Name <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="text"
                        wire:model="name"
                        placeholder="e.g. Amelia Putri"
                        class="w-full rounded-lg border-gray-300 px-4 py-2.5 shadow-sm focus:border-gray-900 focus:ring-gray-900"
                    >

                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Title
                    </label>

                    <input
                        type="text"
                        wire:model="title"
                        placeholder="e.g. dr."
                        class="w-full rounded-lg border-gray-300 px-4 py-2.5 shadow-sm focus:border-gray-900 focus:ring-gray-900"
                    >

                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Specialization
                    </label>

                    <input
                        type="text"
                        wire:model="specialization"
                        placeholder="e.g. Aesthetic Medicine"
                        class="w-full rounded-lg border-gray-300 px-4 py-2.5 shadow-sm focus:border-gray-900 focus:ring-gray-900"
                    >

                    @error('specialization')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Experience
                    </label>

                    <input
                        type="text"
                        wire:model="experience"
                        placeholder="e.g. 8 tahun"
                        class="w-full rounded-lg border-gray-300 px-4 py-2.5 shadow-sm focus:border-gray-900 focus:ring-gray-900"
                    >

                    @error('experience')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

            <h2 class="text-lg font-semibold text-gray-900">
                Biography
            </h2>

            <div class="mt-6 space-y-6">

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Short Bio
                    </label>

                    <textarea
                        wire:model="short_bio"
                        rows="3"
                        placeholder="Short description displayed on doctor cards..."
                        class="w-full rounded-lg border-gray-300 px-4 py-2.5 shadow-sm focus:border-gray-900 focus:ring-gray-900"
                    ></textarea>

                    @error('short_bio')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Biography
                    </label>

                    <textarea
                        wire:model="bio"
                        rows="6"
                        placeholder="Full doctor biography..."
                        class="w-full rounded-lg border-gray-300 px-4 py-2.5 shadow-sm focus:border-gray-900 focus:ring-gray-900"
                    ></textarea>

                    @error('bio')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

            <h2 class="text-lg font-semibold text-gray-900">
                Education & Certifications
            </h2>

            <div class="mt-6 grid gap-6 md:grid-cols-2">

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Education
                    </label>

                    <textarea
                        wire:model="education"
                        rows="5"
                        placeholder="University, medical education, etc."
                        class="w-full rounded-lg border-gray-300 px-4 py-2.5 shadow-sm focus:border-gray-900 focus:ring-gray-900"
                    ></textarea>

                    @error('education')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Certifications
                    </label>

                    <textarea
                        wire:model="certifications"
                        rows="5"
                        placeholder="Professional certifications..."
                        class="w-full rounded-lg border-gray-300 px-4 py-2.5 shadow-sm focus:border-gray-900 focus:ring-gray-900"
                    ></textarea>

                    @error('certifications')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

            <h2 class="text-lg font-semibold text-gray-900">
                Photo & Status
            </h2>

            <div class="mt-6 space-y-6">

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Doctor Photo
                    </label>

                    <input
                        type="file"
                        wire:model="photo"
                        accept="image/jpeg,image/png,image/webp"
                        class="block w-full text-sm text-gray-600"
                    >

                    <p class="mt-2 text-xs text-gray-500">
                        JPG, PNG, or WebP. Maximum 5MB.
                    </p>

                    @error('photo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    @if ($photo)
                        <div class="mt-4">
                            <p class="mb-2 text-sm font-medium text-gray-700">
                                Preview
                            </p>

                            <img
                                src="{{ $photo->temporaryUrl() }}"
                                alt="Preview"
                                class="h-32 w-32 rounded-xl object-cover"
                            >
                        </div>
                    @endif
                </div>

                <label class="flex items-center gap-3">
                    <input
                        type="checkbox"
                        wire:model="is_active"
                        class="rounded border-gray-300 text-gray-900 focus:ring-gray-900"
                    >

                    <span class="text-sm font-medium text-gray-700">
                        Active
                    </span>
                </label>

            </div>
        </div>

        <div class="flex items-center justify-end gap-3">

            <a
                href="{{ route('admin.doctors.index') }}"
                wire:navigate
                class="rounded-lg border border-gray-200 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
                Cancel
            </a>

            <button
                type="submit"
                wire:loading.attr="disabled"
                class="rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-800 disabled:opacity-50"
            >
                <span wire:loading.remove>
                    Save Doctor
                </span>

                <span wire:loading>
                    Saving...
                </span>
            </button>

        </div>

    </form>
</div>
EOF