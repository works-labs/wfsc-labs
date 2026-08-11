<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Booking;

new #[Layout('layouts.admin')] class extends Component
{
    public function delete(int $bookingId): void
    {
        Booking::findOrFail($bookingId)->delete();

        session()->flash(
            'success',
            'Booking deleted successfully.'
        );
    }

    public function with(): array
    {
        return [
            'bookings' => Booking::with([
                    'treatment',
                    'branch',
                ])
                ->latest()
                ->get(),
        ];
    }
};

?>

<div>

    {{-- Header --}}
    <div class="mb-8 flex items-center justify-between">

        <div>
            <h1 class="text-2xl font-bold">
                Bookings
            </h1>

            <p class="mt-2 text-gray-600">
                Manage customer bookings.
            </p>
        </div>

        <a
            href="{{ route('admin.bookings.create') }}"
            wire:navigate
            class="rounded-lg bg-black px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-800"
        >
            Add Booking
        </a>

    </div>


    {{-- Flash Message --}}
    @if (session()->has('success'))
        <div
            class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700"
        >
            {{ session('success') }}
        </div>
    @endif


    {{-- Booking Table --}}
    <div class="overflow-hidden rounded-xl bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="w-full text-left">

                <thead class="border-b bg-gray-50">

                    <tr>

                        <th class="px-6 py-4 text-sm font-semibold text-gray-700">
                            Booking
                        </th>

                        <th class="px-6 py-4 text-sm font-semibold text-gray-700">
                            Customer
                        </th>

                        <th class="px-6 py-4 text-sm font-semibold text-gray-700">
                            Treatment
                        </th>

                        <th class="px-6 py-4 text-sm font-semibold text-gray-700">
                            Branch
                        </th>

                        <th class="px-6 py-4 text-sm font-semibold text-gray-700">
                            Schedule
                        </th>

                        <th class="px-6 py-4 text-sm font-semibold text-gray-700">
                            Status
                        </th>

                        <th class="px-6 py-4 text-sm font-semibold text-gray-700">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @forelse ($bookings as $booking)

                        <tr class="transition hover:bg-gray-50">

                            {{-- Booking --}}
                            <td class="px-6 py-4">

                                <div class="font-medium text-gray-900">
                                    {{ $booking->booking_code }}
                                </div>

                                <div class="mt-1 text-xs text-gray-500">
                                    {{ $booking->created_at?->format('d M Y H:i') }}
                                </div>

                            </td>


                            {{-- Customer --}}
                            <td class="px-6 py-4">

                                <div class="font-medium text-gray-900">
                                    {{ $booking->name }}
                                </div>

                                <div class="mt-1 text-sm text-gray-500">
                                    {{ $booking->phone }}
                                </div>

                                @if ($booking->email)

                                    <div class="text-sm text-gray-500">
                                        {{ $booking->email }}
                                    </div>

                                @endif

                            </td>


                            {{-- Treatment --}}
                            <td class="px-6 py-4">

                                <span class="text-sm text-gray-700">
                                    {{ $booking->treatment?->name ?? 'Treatment deleted' }}
                                </span>

                            </td>


                            {{-- Branch --}}
                            <td class="px-6 py-4">

                                <span class="text-sm text-gray-700">
                                    {{ $booking->branch?->name ?? 'Branch deleted' }}
                                </span>

                            </td>


                            {{-- Schedule --}}
                            <td class="px-6 py-4">

                                @if ($booking->preferred_date)

                                    <div class="text-sm font-medium text-gray-900">
                                        {{ \Illuminate\Support\Carbon::parse($booking->preferred_date)->format('d M Y') }}
                                    </div>

                                @else

                                    <div class="text-sm text-gray-400">
                                        No date
                                    </div>

                                @endif


                                @if ($booking->preferred_time)

                                    <div class="mt-1 text-sm text-gray-500">
                                        {{ \Illuminate\Support\Carbon::parse($booking->preferred_time)->format('H:i') }}
                                    </div>

                                @endif

                            </td>


                            {{-- Status --}}
                            <td class="px-6 py-4">

                                @switch($booking->status)

                                    @case('pending')

                                        <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-700">
                                            Pending
                                        </span>

                                        @break


                                    @case('confirmed')

                                        <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                            Confirmed
                                        </span>

                                        @break


                                    @case('cancelled')

                                        <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">
                                            Cancelled
                                        </span>

                                        @break


                                    @case('completed')

                                        <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700">
                                            Completed
                                        </span>

                                        @break


                                    @default

                                        <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
                                            {{ ucfirst($booking->status) }}
                                        </span>

                                @endswitch

                            </td>


                            {{-- Actions --}}
                            <td class="px-6 py-4">

                                <div class="flex items-center gap-3">

                                    {{-- Detail --}}
                                    <a
                                        href="{{ route('admin.bookings.show', $booking) }}"
                                        wire:navigate
                                        class="text-sm font-medium text-blue-600 hover:underline"
                                    >
                                        Detail
                                    </a>


                                    {{-- Edit --}}
                                    <a
                                        href="{{ route('admin.bookings.edit', $booking) }}"
                                        wire:navigate
                                        class="text-sm font-medium text-green-600 hover:underline"
                                    >
                                        Edit
                                    </a>


                                    {{-- Delete --}}
                                    <button
                                        type="button"
                                        wire:click="delete({{ $booking->id }})"
                                        wire:confirm="Are you sure you want to delete this booking?"
                                        class="text-sm font-medium text-red-600 hover:underline"
                                    >
                                        Delete
                                    </button>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="px-6 py-16 text-center"
                            >

                                <div class="mx-auto max-w-sm">

                                    <div class="text-4xl">
                                        📋
                                    </div>

                                    <h3 class="mt-4 text-lg font-semibold text-gray-900">
                                        No bookings yet
                                    </h3>

                                    <p class="mt-2 text-sm text-gray-500">
                                        There are no customer bookings in the system yet.
                                    </p>

                                    <a
                                        href="{{ route('admin.bookings.create') }}"
                                        wire:navigate
                                        class="mt-5 inline-flex rounded-lg bg-black px-5 py-2.5 text-sm font-semibold text-white hover:bg-gray-800"
                                    >
                                        Add First Booking
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>
```
