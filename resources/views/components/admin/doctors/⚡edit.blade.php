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
    public bool $isFounder = false;
    public $photo;
    public ?string $currentPhoto = null;

    public function mount(Doctor $doctor): void
    {
        $this->doctor = $doctor;
        $this->isFounder = $doctor->isFounder();
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
        if ($this->isFounder) {
            return;
        }
        $this->slug = Str::slug($this->name);
    }

public function update(): void
{
    if (! $this->doctor->isFounder()) {
        $this->slug = Str::slug($this->name);
    }

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

    if ($this->doctor->isFounder()) {
    $validated['slug'] = $this->doctor->slug;
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

<div class="mx-auto max-w-4xl space-y-8 pb-10">

    {{-- Top Navigation & Header --}}
    <div>
        <a href="{{ route('admin.doctors.index') }}" wire:navigate class="inline-flex items-center gap-2 text-sm font-bold text-gray-400 transition-colors hover:text-[var(--color-wfsc-coral)]">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Dokter
        </a>
        <div class="mt-4 flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-500 shadow-sm">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
            </div>
            <div>
                <h1 class="text-2xl font-black tracking-tight text-[var(--color-wfsc-dark)]">Edit Dokter</h1>
                <p class="text-sm font-medium text-gray-500">Perbarui informasi untuk {{ $title }} {{ $name }}.</p>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="rounded-2xl border border-emerald-100 bg-emerald-50 px-6 py-4 shadow-sm flex items-center gap-3 text-sm font-bold text-emerald-700">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit="update" class="space-y-8">

        {{-- Basic Information Card --}}
        <div class="relative overflow-hidden rounded-2xl border border-gray-100/50 bg-white p-8 elegant-shadow">
            <div class="absolute left-0 top-0 h-full w-1 bg-blue-400"></div>
            
            <div class="mb-6 flex items-center gap-3">
                <div class="rounded-lg bg-blue-50 p-2 text-blue-500"><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></div>
                <h2 class="text-lg font-bold text-[var(--color-wfsc-dark)]">Informasi Dasar</h2>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Nama Dokter</label>
                    <input type="text" wire:model.live="name" class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]">
                    @error('name') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Gelar</label>
                    <input type="text" wire:model="title" placeholder="dr." class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]">
                    @error('title') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-bold text-gray-600">Slug URL</label>
                    <input type="text" wire:model="slug" readonly tabindex="-1" @disabled($isFounder) class="w-full cursor-not-allowed rounded-xl border-gray-200 bg-gray-100 px-4 py-3 font-mono text-sm text-gray-500 opacity-70">
                    
                    @if ($isFounder)
                        <div class="mt-2 flex items-center gap-2 text-xs font-bold text-amber-600">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.715-5.349L11 6.477V16h2a1 1 0 110 2H7a1 1 0 110-2h2V6.477L6.237 7.582l1.715 5.349a1 1 0 01-.285 1.05A3.989 3.989 0 015 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.617a1 1 0 01.894-1.788l1.599.799L9 4.323V3a1 1 0 011-1z" clip-rule="evenodd"/></svg>
                            Dokter ini merupakan Founder yang dilindungi. Slug URL tidak dapat diubah.
                        </div>
                    @endif
                    @error('slug') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Spesialisasi</label>
                    <input type="text" wire:model="specialization" class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Pengalaman</label>
                    <input type="text" wire:model="experience" placeholder="8 Tahun" class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]">
                </div>
            </div>
        </div>

        {{-- Biography Card --}}
        <div class="relative overflow-hidden rounded-2xl border border-gray-100/50 bg-white p-8 elegant-shadow">
            <div class="absolute left-0 top-0 h-full w-1 bg-amber-400"></div>
            
            <div class="mb-6 flex items-center gap-3">
                <div class="rounded-lg bg-amber-50 p-2 text-amber-500"><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg></div>
                <h2 class="text-lg font-bold text-[var(--color-wfsc-dark)]">Biografi & Profil</h2>
            </div>

            <div class="space-y-6">
                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Bio Singkat</label>
                    <textarea wire:model="short_bio" rows="3" class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"></textarea>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Biografi Lengkap</label>
                    <textarea wire:model="bio" rows="5" class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"></textarea>
                </div>
            </div>
        </div>

        {{-- Education & Certifications --}}
        <div class="relative overflow-hidden rounded-2xl border border-gray-100/50 bg-white p-8 elegant-shadow">
            <div class="absolute left-0 top-0 h-full w-1 bg-emerald-400"></div>
            
            <div class="mb-6 flex items-center gap-3">
                <div class="rounded-lg bg-emerald-50 p-2 text-emerald-500"><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg></div>
                <h2 class="text-lg font-bold text-[var(--color-wfsc-dark)]">Pendidikan & Sertifikasi</h2>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Pendidikan</label>
                    <textarea wire:model="education" rows="4" class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"></textarea>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Sertifikasi</label>
                    <textarea wire:model="certifications" rows="4" class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"></textarea>
                </div>
            </div>
        </div>

        {{-- Photo & Status --}}
        <div class="relative overflow-hidden rounded-2xl border border-gray-100/50 bg-white p-8 elegant-shadow">
            <div class="absolute left-0 top-0 h-full w-1 bg-purple-400"></div>
            
            <div class="mb-6 flex items-center gap-3">
                <div class="rounded-lg bg-purple-50 p-2 text-purple-500"><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
                <h2 class="text-lg font-bold text-[var(--color-wfsc-dark)]">Foto & Status Profil</h2>
            </div>

            <div class="space-y-6">
                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Foto Dokter</label>
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                        @if ($photo)
                            <div class="shrink-0 relative">
                                <span class="absolute -top-2 -right-2 bg-[var(--color-wfsc-coral)] text-white text-[10px] font-bold px-2 py-0.5 rounded-full z-10">Baru</span>
                                <img src="{{ $photo->temporaryUrl() }}" alt="Preview" class="h-24 w-24 rounded-2xl object-cover shadow-sm ring-4 ring-gray-50">
                            </div>
                        @elseif ($currentPhoto)
                            <div class="shrink-0">
                                <img src="{{ asset('storage/' . $currentPhoto) }}" alt="{{ $name }}" class="h-24 w-24 rounded-2xl object-cover shadow-sm ring-4 ring-gray-50">
                            </div>
                        @endif

                        <div class="w-full">
                            <input type="file" wire:model="photo" accept="image/*" class="block w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-2.5 text-sm text-gray-600 transition-colors file:mr-4 file:rounded-lg file:border-0 file:bg-white file:px-4 file:py-2 file:text-sm file:font-bold file:text-[var(--color-wfsc-coral)] file:shadow-sm hover:file:bg-rose-50 focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]">
                            <div wire:loading wire:target="photo" class="mt-2 text-xs font-bold text-[var(--color-wfsc-coral)] flex items-center gap-1.5">
                                <svg class="h-3.5 w-3.5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Mengunggah pratinjau...
                            </div>
                            @error('photo') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <label class="inline-flex items-center gap-3 rounded-xl border border-gray-100 bg-gray-50 p-4 transition-colors hover:bg-gray-100">
                    <input type="checkbox" wire:model="is_active" class="h-5 w-5 rounded-md border-gray-300 text-[var(--color-wfsc-coral)] focus:ring-[var(--color-wfsc-coral)]">
                    <div>
                        <span class="block text-sm font-bold text-gray-800">Setel sebagai Profil Aktif</span>
                        <span class="block text-xs font-medium text-gray-500">Profil dokter akan ditampilkan pada website publik.</span>
                    </div>
                </label>
            </div>
        </div>

        {{-- Aksi --}}
        <div class="flex items-center justify-end gap-4 pt-4">
            <a href="{{ route('admin.doctors.index') }}" wire:navigate class="rounded-xl px-5 py-3 text-sm font-bold text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-800">
                Batal
            </a>

            <button type="submit" wire:loading.attr="disabled" class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[var(--color-wfsc-coral)] to-[#ff7676] px-8 py-3 text-sm font-bold text-white shadow-lg shadow-[var(--color-wfsc-coral)]/30 transition-all duration-300 hover:scale-[1.02] hover:shadow-xl hover:shadow-[var(--color-wfsc-coral)]/40 disabled:opacity-70 disabled:hover:scale-100">
                <span wire:loading.remove wire:target="update">Simpan Perubahan</span>
                <span wire:loading wire:target="update">
                    <svg class="h-4 w-4 animate-spin text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Menyimpan...
                </span>
            </button>
        </div>

    </form>
</div>
