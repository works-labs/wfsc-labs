<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Livewire\Attributes\Computed;

use App\Models\HeroBanner;
use App\Models\Treatment;
use App\Models\Doctor;
use App\Models\News;

new #[Layout('layouts.admin')] class extends Component
{
    use WithFileUploads;

    public string $title = '';
    public string $subtitle = '';
    public $background_image = null;
    public string $cta_text = '';
    public string $cta_type = 'internal';
    public string $cta_target = '';
    public int $sort_order = 0;
    public bool $is_active = true;

    #[Computed]
    public function treatments()
    {
        return Treatment::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    #[Computed]
    public function doctors()
    {
        return Doctor::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    #[Computed]
    public function news()
    {
        return News::query()
            ->where('is_active', true)
            ->orderByDesc('published_at')
            ->get();
    }

    public function save(): void
    {
        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string'],
            'background_image' => ['nullable', 'image', 'max:4096'],
            'cta_text' => ['nullable', 'string', 'max:255'],
            'cta_type' => [
                'required',
                'in:internal,treatment,doctor,news,whatsapp,external',
            ],
            'cta_target' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        if ($this->background_image) {
            $validated['background_image'] = $this->background_image
                ->store('hero-banners', 'public');
        }

        $position = $validated['sort_order'];

        HeroBanner::where('sort_order', '>=', $position)
            ->increment('sort_order');

        HeroBanner::create($validated);

        session()->flash('success', 'Hero banner created successfully.');

        $this->redirect(
            route('admin.home.hero-banners.index'),
            navigate: true
        );
    }
};

?>

<div class="mx-auto max-w-4xl space-y-8 pb-10">

    {{-- Top Navigation & Header --}}
    <div>
        <a href="{{ route('admin.home.hero-banners.index') }}" wire:navigate 
            class="inline-flex items-center gap-2 text-sm font-bold text-gray-400 transition-colors hover:text-[var(--color-wfsc-coral)]">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to Hero Banners
        </a>
        <div class="mt-4 flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-rose-50 text-[var(--color-wfsc-coral)] shadow-sm">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </div>
            <div>
                <h1 class="text-2xl font-black tracking-tight text-[var(--color-wfsc-dark)]">Add Hero Banner</h1>
                <p class="text-sm font-medium text-gray-500">Create a hero banner displayed on the WFSC website.</p>
            </div>
        </div>
    </div>

    <form wire:submit="save" class="space-y-8">

        {{-- Hero Information Card --}}
        <div class="relative overflow-hidden rounded-2xl border border-gray-100/50 bg-white p-8 elegant-shadow">
            <div class="absolute left-0 top-0 h-full w-1 bg-emerald-400"></div>
            
            <div class="mb-6 flex items-center gap-3">
                <div class="rounded-lg bg-emerald-50 p-2 text-emerald-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </div>
                <h2 class="text-lg font-bold text-[var(--color-wfsc-dark)]">Banner Content</h2>
            </div>

            <div class="space-y-6">
                {{-- Title --}}
                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Title <span class="text-[var(--color-wfsc-coral)]">*</span></label>
                    <input
                        type="text"
                        wire:model="title"
                        placeholder="Example: Your Skin, Our Passion"
                        class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                    >
                    @error('title')
                        <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Subtitle --}}
                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-600">Subtitle</label>
                    <textarea
                        wire:model="subtitle"
                        rows="4"
                        placeholder="Short description for the hero section..."
                        class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                    ></textarea>
                    @error('subtitle')
                        <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Background Image Card --}}
        <div class="relative overflow-hidden rounded-2xl border border-gray-100/50 bg-white p-8 elegant-shadow">
            <div class="absolute left-0 top-0 h-full w-1 bg-purple-400"></div>
            
            <div class="mb-6 flex items-center gap-3">
                <div class="rounded-lg bg-purple-50 p-2 text-purple-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h2 class="text-lg font-bold text-[var(--color-wfsc-dark)]">Background Image</h2>
            </div>

            <div class="space-y-4">
                <input
                    type="file"
                    wire:model="background_image"
                    accept="image/*"
                    class="block w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-2.5 text-sm text-gray-600 transition-colors file:mr-4 file:rounded-lg file:border-0 file:bg-white file:px-4 file:py-2 file:text-sm file:font-bold file:text-[var(--color-wfsc-coral)] file:shadow-sm hover:file:bg-rose-50 focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                >
                <p class="mt-1.5 text-xs font-medium text-gray-400">
                    Recommended: large landscape image. Maximum 4 MB.
                </p>

                @error('background_image')
                    <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                @enderror

                <div wire:loading wire:target="background_image" class="mt-2 text-xs font-bold text-[var(--color-wfsc-coral)] flex items-center gap-1.5">
                    <svg class="h-3.5 w-3.5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Uploading preview...
                </div>

                @if ($background_image)
                    <div class="mt-4">
                        <p class="mb-2 text-xs font-bold text-gray-600">Preview</p>
                        <img
                            src="{{ $background_image->temporaryUrl() }}"
                            alt="Hero banner preview"
                            class="h-64 w-full rounded-2xl border border-gray-100 object-cover shadow-sm ring-4 ring-gray-50"
                        >
                    </div>
                @endif
            </div>
        </div>

        {{-- CTA Section Card --}}
        <div class="relative overflow-hidden rounded-2xl border border-gray-100/50 bg-white p-8 elegant-shadow">
            <div class="absolute left-0 top-0 h-full w-1 bg-amber-400"></div>
            
            <div class="mb-6 flex items-center gap-3">
                <div class="rounded-lg bg-amber-50 p-2 text-amber-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h2 class="text-lg font-bold text-[var(--color-wfsc-dark)]">Call To Action (CTA) Configuration</h2>
            </div>
            
            <div class="space-y-6">
                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-bold text-gray-600">CTA Text</label>
                        <input
                            type="text"
                            wire:model="cta_text"
                            placeholder="Book Appointment"
                            class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                        >
                        @error('cta_text')
                            <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-gray-600">CTA Type</label>
                        <select
                            wire:model.live="cta_type"
                            class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                        >
                            <option value="internal">Internal Page</option>
                            <option value="treatment">Treatment</option>
                            <option value="doctor">Doctor</option>
                            <option value="news">News</option>
                            <option value="whatsapp">WhatsApp</option>
                            <option value="external">External URL</option>
                        </select>
                        @error('cta_type')
                            <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                @if ($cta_type === 'internal')
                    <div>
                        <label class="mb-2 block text-sm font-bold text-gray-600">CTA Target</label>
                        <select
                            wire:model="cta_target"
                            class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                        >
                            <option value="">-- Pilih halaman --</option>
                            <option value="home">Home</option>
                            <option value="treatments">Treatments</option>
                            <option value="doctors">Doctors</option>
                            <option value="news">News</option>
                        </select>
                        @error('cta_target')
                            <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                @elseif ($cta_type === 'treatment')
                    <div>
                        <label class="mb-2 block text-sm font-bold text-gray-600">Treatment</label>
                        <select
                            wire:model="cta_target"
                            class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                        >
                            <option value="">-- Pilih treatment --</option>
                            @foreach ($this->treatments as $treatment)
                                <option value="{{ $treatment->slug }}">
                                    {{ $treatment->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('cta_target')
                            <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                @elseif ($cta_type === 'doctor')
                    <div>
                        <label class="mb-2 block text-sm font-bold text-gray-600">Doctor</label>
                        <select
                            wire:model="cta_target"
                            class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                        >
                            <option value="">-- Pilih doctor --</option>
                            @foreach ($this->doctors as $doctor)
                                <option value="{{ $doctor->slug }}">
                                    {{ $doctor->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('cta_target')
                            <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                @elseif ($cta_type === 'news')
                    <div>
                        <label class="mb-2 block text-sm font-bold text-gray-600">News</label>
                        <select
                            wire:model="cta_target"
                            class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                        >
                            <option value="">-- Pilih news --</option>
                            @foreach ($this->news as $item)
                                <option value="{{ $item->slug }}">
                                    {{ $item->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('cta_target')
                            <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                @elseif ($cta_type === 'whatsapp')
                    <div class="rounded-xl border border-emerald-100 bg-emerald-50 px-5 py-4 text-sm font-bold text-emerald-700">
                        CTA akan diarahkan ke WhatsApp perusahaan berdasarkan nomor pada Site Settings.
                    </div>

                @elseif ($cta_type === 'external')
                    <div>
                        <label class="mb-2 block text-sm font-bold text-gray-600">External URL</label>
                        <input
                            type="url"
                            wire:model="cta_target"
                            placeholder="https://example.com"
                            class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                        >
                        @error('cta_target')
                            <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                @endif
            </div>
        </div>

        {{-- Sort Order & Status Card --}}
        <div class="relative overflow-hidden rounded-2xl border border-gray-100/50 bg-white p-8 elegant-shadow">
            <div class="absolute left-0 top-0 h-full w-1 bg-indigo-400"></div>
            
            <div class="mb-6 flex items-center gap-3">
                <div class="rounded-lg bg-indigo-50 p-2 text-indigo-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h2 class="text-lg font-bold text-[var(--color-wfsc-dark)]">Display & Status</h2>
            </div>

            <div class="space-y-6">
                <div class="grid gap-6 md:grid-cols-2">
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

                    <div class="flex items-center pt-8">
                        <label class="inline-flex items-center gap-3 rounded-xl border border-gray-100 bg-gray-50 p-4 w-full transition-colors hover:bg-gray-100 cursor-pointer">
                            <input
                                type="checkbox"
                                wire:model="is_active"
                                id="is_active"
                                class="h-5 w-5 rounded-md border-gray-300 text-[var(--color-wfsc-coral)] focus:ring-[var(--color-wfsc-coral)]"
                            >
                            <div>
                                <span class="block text-sm font-bold text-gray-800">Active</span>
                                <span class="block text-xs font-medium text-gray-500">Visible on website header.</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-4 pt-4">
            <a
                href="{{ route('admin.home.hero-banners.index') }}"
                wire:navigate
                class="rounded-xl px-5 py-3 text-sm font-bold text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-800"
            >
                Cancel
            </a>

            <button
                type="submit"
                wire:loading.attr="disabled"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[var(--color-wfsc-coral)] to-[#ff7676] px-8 py-3 text-sm font-bold text-white shadow-lg shadow-[var(--color-wfsc-coral)]/30 transition-all duration-300 hover:scale-[1.02] hover:shadow-xl hover:shadow-[var(--color-wfsc-coral)]/40 disabled:opacity-70 disabled:hover:scale-100"
            >
                <span wire:loading.remove>Save Hero Banner</span>
                <span wire:loading>
                    <svg class="h-4 w-4 animate-spin text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Saving...
                </span>
            </button>
        </div>

    </form>
</div>