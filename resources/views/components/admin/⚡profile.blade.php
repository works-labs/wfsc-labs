<?php

use App\Concerns\PasswordValidationRules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.admin')] class extends Component
{
    use PasswordValidationRules;

    public string $current_password = '';

    public string $password = '';

    public string $password_confirmation = '';

    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => $this->currentPasswordRules(),
                'password' => $this->passwordRules(),
            ]);
        } catch (ValidationException $exception) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $exception;
        }

        Auth::user()->update([
            'password' => $validated['password'],
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        session()->flash('success', 'Password berhasil diperbarui.');
    }
};
?>

<div class="mx-auto max-w-4xl space-y-8">
    <div class="rounded-2xl border border-gray-100/70 bg-white p-8 elegant-shadow">
        <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-4">
                <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-[var(--color-wfsc-coral)] to-[#ff7676] text-2xl font-black text-white shadow-lg shadow-[var(--color-wfsc-coral)]/25">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-[var(--color-wfsc-coral)]">Admin Profile</p>
                    <h1 class="mt-1 text-3xl font-black tracking-tight text-[var(--color-wfsc-dark)]">
                        {{ auth()->user()->name }}
                    </h1>
                    <p class="mt-1 text-sm font-medium text-gray-500">{{ auth()->user()->email }}</p>
                </div>
            </div>

            <a href="{{ route('admin.dashboard') }}" wire:navigate
                class="inline-flex items-center justify-center rounded-xl bg-gray-50 px-5 py-3 text-sm font-bold text-gray-500 transition-colors hover:bg-rose-50 hover:text-[var(--color-wfsc-coral)]">
                Kembali ke Dashboard
            </a>
        </div>
    </div>

    <div class="rounded-2xl border border-gray-100/70 bg-white p-8 elegant-shadow">
        <div class="mb-8">
            <h2 class="text-2xl font-black tracking-tight text-[var(--color-wfsc-dark)]">Ubah Password</h2>
            <p class="mt-2 text-sm font-medium text-gray-500">
                Gunakan password yang kuat agar akun admin tetap aman.
            </p>
        </div>

        @if (session('success'))
            <div class="mb-6 rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm font-bold text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        <form wire:submit="updatePassword" class="space-y-6">
            <div>
                <label for="current_password" class="mb-2 block text-sm font-bold text-gray-600">Password Saat Ini</label>
                <input
                    id="current_password"
                    type="password"
                    wire:model="current_password"
                    autocomplete="current-password"
                    class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:border-[var(--color-wfsc-coral)] focus:bg-white focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                    required
                >
                @error('current_password')
                    <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="password" class="mb-2 block text-sm font-bold text-gray-600">Password Baru</label>
                    <input
                        id="password"
                        type="password"
                        wire:model="password"
                        autocomplete="new-password"
                        class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:border-[var(--color-wfsc-coral)] focus:bg-white focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                        required
                    >
                    @error('password')
                        <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="mb-2 block text-sm font-bold text-gray-600">Konfirmasi Password Baru</label>
                    <input
                        id="password_confirmation"
                        type="password"
                        wire:model="password_confirmation"
                        autocomplete="new-password"
                        class="w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-sm transition-colors focus:border-[var(--color-wfsc-coral)] focus:bg-white focus:ring-1 focus:ring-[var(--color-wfsc-coral)]"
                        required
                    >
                </div>
            </div>

            <div class="flex justify-end">
                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-xl bg-[var(--color-wfsc-coral)] px-6 py-3 text-sm font-bold text-white shadow-lg shadow-[var(--color-wfsc-coral)]/25 transition-all hover:-translate-y-0.5 hover:bg-[var(--color-wfsc-coral-hover)]"
                >
                    Simpan Password
                </button>
            </div>
        </form>
    </div>
</div>
