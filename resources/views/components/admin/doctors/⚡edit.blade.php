<?php

use App\Models\Doctor;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

new #[Layout('layouts.admin')] class extends Component
{
    use WithFileUploads;

    public Doctor $doctor;

    public string $name = '';
    public string $slug = '';
    public string $title = '';
    public string $short_bio = '';
    public string $bio = '';
    public string $specialization = '';
    public string $education = '';
    public string $certifications = '';
    public string $experience = '';
    public bool $is_active = true;

    public $photo;
    public ?string $currentPhoto = null;

    public function mount(Doctor $doctor): void
    {
        $this->doctor = $doctor;

        $this->name = $doctor->name;
        $this->slug = $doctor->slug;
        $this->title = $doctor->title ?? '';
        $this->short_bio = $doctor->short_bio ?? '';
        $this->bio = $doctor->bio ?? '';
        $this->specialization = $doctor->specialization ?? '';
        $this->education = $doctor->education ?? '';
        $this->certifications = $doctor->certifications ?? '';
        $this->experience = $doctor->experience ?? '';
        $this->is_active = (bool) $doctor->is_active;
        $this->currentPhoto = $doctor->photo;
    }

    public function updatedName(): void
    {
        $this->slug = Str::slug($this->name);
    }

    public function update(): void
{
    $validated = $this->validate([
        'name' => ['required', 'string', 'max:255'],
        'slug' => [
            'required',
            'string',
            'max:255',
            'unique:doctors,slug,' . $this->doctor->id,
        ],
        'title' => ['nullable', 'string', 'max:255'],
        'photo' => ['nullable', 'image', 'max:2048'],
        'short_bio' => ['nullable', 'string'],
        'bio' => ['nullable', 'string'],
        'specialization' => ['nullable', 'string', 'max:255'],
        'education' => ['nullable', 'string'],
        'certifications' => ['nullable', 'string'],
        'experience' => ['nullable', 'string', 'max:255'],
        'is_active' => ['boolean'],
    ]);

    if ($this->photo) {
        $oldPhoto = $this->doctor->photo;

        $newPhoto = $this->photo->store('doctors', 'public');

        $validated['photo'] = $newPhoto;

        if ($oldPhoto && Storage::disk('public')->exists($oldPhoto)) {
            Storage::disk('public')->delete($oldPhoto);
        }
    } else {
        unset($validated['photo']);
    }

    $this->doctor->update($validated);

    session()->flash('success', 'Doctor updated successfully.');

    $this->redirect(
        route('admin.doctors.index'),
        navigate: true
    );
}
};
?>

<div class="mx-auto max-w-4xl space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-gray-900">
            Edit Doctor
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Update doctor information.
        </p>
    </div>

    @if (session('success'))
        <div class="rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit="update" class="space-y-6">

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

            <div class="grid gap-6 md:grid-cols-2">

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Name
                    </label>

                    <input
                        type="text"
                        wire:model="name"
                        class="mt-1 w-full rounded-lg border-gray-300 shadow-sm"
                    >

                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Title
                    </label>

                    <input
                        type="text"
                        wire:model="title"
                        placeholder="dr."
                        class="mt-1 w-full rounded-lg border-gray-300 shadow-sm"
                    >

                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">
                        Slug
                    </label>

                    <input
                        type="text"
                        wire:model="slug"
                        class="mt-1 w-full rounded-lg border-gray-300 bg-gray-50 shadow-sm"
                    >

                    @error('slug')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Specialization
                    </label>

                    <input
                        type="text"
                        wire:model="specialization"
                        class="mt-1 w-full rounded-lg border-gray-300 shadow-sm"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Experience
                    </label>

                    <input
                        type="text"
                        wire:model="experience"
                        placeholder="8 Tahun"
                        class="mt-1 w-full rounded-lg border-gray-300 shadow-sm"
                    >
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">
                        Short Bio
                    </label>

                    <textarea
                        wire:model="short_bio"
                        rows="3"
                        class="mt-1 w-full rounded-lg border-gray-300 shadow-sm"
                    ></textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">
                        Biography
                    </label>

                    <textarea
                        wire:model="bio"
                        rows="5"
                        class="mt-1 w-full rounded-lg border-gray-300 shadow-sm"
                    ></textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">
                        Education
                    </label>

                    <textarea
                        wire:model="education"
                        rows="3"
                        class="mt-1 w-full rounded-lg border-gray-300 shadow-sm"
                    ></textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">
                        Certifications
                    </label>

                    <textarea
                        wire:model="certifications"
                        rows="3"
                        class="mt-1 w-full rounded-lg border-gray-300 shadow-sm"
                    ></textarea>
                </div>

                <div class="md:col-span-2">

                    <label class="block text-sm font-medium text-gray-700">
                        Photo
                    </label>

                    @if ($currentPhoto)
                        <div class="mb-3 mt-2">
                            <img
                                src="{{ asset('storage/' . $currentPhoto) }}"
                                alt="{{ $name }}"
                                class="h-24 w-24 rounded-xl object-cover"
                            >
                        </div>
                    @endif

                    <input
                        type="file"
                        wire:model="photo"
                        accept="image/*"
                        class="mt-1 block w-full text-sm"
                    >

                    @error('photo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <div wire:loading wire:target="photo" class="mt-2 text-sm text-gray-500">
                        Uploading...
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="inline-flex items-center gap-2">
                        <input
                            type="checkbox"
                            wire:model="is_active"
                            class="rounded border-gray-300"
                        >

                        <span class="text-sm font-medium text-gray-700">
                            Active
                        </span>
                    </label>
                </div>

            </div>

        </div>

        <div class="flex items-center justify-between">

            <a
                href="{{ route('admin.doctors.index') }}"
                wire:navigate
                class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
                Cancel
            </a>

            <button
                type="submit"
                wire:loading.attr="disabled"
                class="rounded-lg bg-gray-900 px-5 py-2 text-sm font-medium text-white hover:bg-gray-800 disabled:opacity-50"
            >
                <span wire:loading.remove wire:target="update">
                    Save Changes
                </span>

                <span wire:loading wire:target="update">
                    Saving...
                </span>
            </button>

        </div>

    </form>

</div>