<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Booking;

new #[Layout('layouts.admin')] class extends Component
{
    public Booking $booking;

    public function mount(Booking $booking): void
    {
        $this->booking = $booking->load([
            'treatment',
            'branch',
        ]);
    }
};

?>

<div>
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold">
                Booking {{ $booking->booking_code }}
            </h1>

            <p class="mt-2 text-gray-600">
                Booking details and customer information.
            </p>
        </div>

        <a
            href="{{ route('admin.bookings.index') }}"
            wire:navigate
            class="rounded-lg border px-5 py-2 font-medium"
        >
            Back
        </a>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">

        {{-- Customer --}}
        <div class="rounded-xl bg-white p-6 shadow-sm lg:col-span-2">
            <h2 class="mb-6 text-lg font-semibold">
                Customer Information
            </h2>

            <div class="grid gap-6 md:grid-cols-2">

                <div>
                    <p class="text-sm text-gray-500">
                        Name
                    </p>

                    <p class="mt-1 font-medium">
                        {{ $booking->name }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Phone
                    </p>

                    <p class="mt-1 font-medium">
                        {{ $booking->phone }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Email
                    </p>

                    <p class="mt-1 font-medium">
                        {{ $booking->email ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Booking Code
                    </p>

                    <p class="mt-1 font-medium">
                        {{ $booking->booking_code }}
                    </p>
                </div>

            </div>
        </div>

        {{-- Status --}}
        <div class="rounded-xl bg-white p-6 shadow-sm">
            <h2 class="mb-6 text-lg font-semibold">
                Status
            </h2>

            @switch($booking->status)
                @case('pending')
                    <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-700">
                        Pending
                    </span>
                    @break

                @case('confirmed')
                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                        Confirmed
                    </span>
                    @break

                @case('cancelled')
                    <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">
                        Cancelled
                    </span>
                    @break

                @case('completed')
                    <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700">
                        Completed
                    </span>
                    @break
            @endswitch
        </div>

        {{-- Booking Information --}}
        <div class="rounded-xl bg-white p-6 shadow-sm lg:col-span-2">
            <h2 class="mb-6 text-lg font-semibold">
                Booking Information
            </h2>

            <div class="grid gap-6 md:grid-cols-2">

                <div>
                    <p class="text-sm text-gray-500">
                        Treatment
                    </p>

                    <p class="mt-1 font-medium">
                        {{ $booking->treatment?->name ?? 'Treatment deleted' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Branch
                    </p>

                    <p class="mt-1 font-medium">
                        {{ $booking->branch?->name ?? 'Branch deleted' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Preferred Date
                    </p>

                    <p class="mt-1 font-medium">
                        {{ $booking->preferred_date
                            ? \Illuminate\Support\Carbon::parse($booking->preferred_date)->format('d M Y')
                            : '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Preferred Time
                    </p>

                    <p class="mt-1 font-medium">
                        {{ $booking->preferred_time
                            ? \Illuminate\Support\Carbon::parse($booking->preferred_time)->format('H:i')
                            : '-' }}
                    </p>
                </div>

            </div>
        </div>

        {{-- Message --}}
        <div class="rounded-xl bg-white p-6 shadow-sm">
            <h2 class="mb-6 text-lg font-semibold">
                Customer Message
            </h2>

            <p class="whitespace-pre-line text-sm leading-6 text-gray-600">
                {{ $booking->message ?? 'No message provided.' }}
            </p>
        </div>

    </div>
</div>