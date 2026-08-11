<?php

use App\Models\Doctor;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

new #[Layout('layouts.admin')] class extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function delete(int $doctorId): void
{
    $doctor = Doctor::findOrFail($doctorId);

    if ($doctor->photo && Storage::disk('public')->exists($doctor->photo)) {
        Storage::disk('public')->delete($doctor->photo);
    }

    $doctor->delete();

    $this->resetPage();
}

    public function with(): array
    {
        return [
            'doctors' => Doctor::query()
                ->when(
                    $this->search,
                    fn ($query) => $query->where(function ($query) {
                        $query
                            ->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('specialization', 'like', '%' . $this->search . '%');
                    })
                )
                ->latest()
                ->paginate(10),
        ];
    }
};
?>

<div class="space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Doctors
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Manage doctors displayed on the WFSC website.
            </p>
        </div>

        <a
            href="{{ route('admin.doctors.create') }}"
            wire:navigate
            class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800"
        >
            + Add Doctor
        </a>
    </div>

    <div>
        <input
            type="search"
            wire:model.live.debounce.300ms="search"
            placeholder="Search doctors..."
            class="w-full rounded-lg border-gray-300 px-4 py-2 shadow-sm focus:border-gray-900 focus:ring-gray-900"
        >
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-50">

                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                            Doctor
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                            Specialization
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                            Experience
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                            Status
                        </th>

                        <th class="px-6 py-3 text-right text-xs font-semibold uppercase text-gray-500">
                            Actions
                        </th>
                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-200">

                    @forelse ($doctors as $doctor)

                        <tr class="hover:bg-gray-50">

                            <td class="whitespace-nowrap px-6 py-4">

                                <div class="flex items-center gap-3">

                                    @if ($doctor->photo)

                                        <img
                                            src="{{ asset('storage/' . $doctor->photo) }}"
                                            alt="{{ $doctor->name }}"
                                            class="h-10 w-10 rounded-full object-cover"
                                        >

                                    @else

                                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-sm font-semibold text-gray-500">
                                            {{ strtoupper(substr($doctor->name, 0, 1)) }}
                                        </div>

                                    @endif

                                    <div>
                                        <div class="font-medium text-gray-900">
                                            {{ $doctor->title }} {{ $doctor->name }}
                                        </div>

                                        <div class="text-sm text-gray-500">
                                            {{ $doctor->slug }}
                                        </div>
                                    </div>

                                </div>

                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-700">
                                {{ $doctor->specialization ?? '-' }}
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-700">
                                {{ $doctor->experience ?? '-' }}
                            </td>

                            <td class="whitespace-nowrap px-6 py-4">

                                @if ($doctor->is_active)

                                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                        Active
                                    </span>

                                @else

                                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
                                        Inactive
                                    </span>

                                @endif

                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-right text-sm">

                                <a
                                    href="{{ route('admin.doctors.edit', $doctor) }}"
                                    wire:navigate
                                    class="font-medium text-gray-700 hover:text-gray-900"
                                >
                                    Edit
                                </a>

                                <button
                                    type="button"
                                    wire:click="delete({{ $doctor->id }})"
                                    wire:confirm="Delete this doctor?"
                                    class="ml-4 font-medium text-red-600 hover:text-red-800"
                                >
                                    Delete
                                </button>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500">
                                No doctors found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if ($doctors->hasPages())

            <div class="border-t border-gray-200 px-6 py-4">
                {{ $doctors->links() }}
            </div>

        @endif

    </div>

</div>
