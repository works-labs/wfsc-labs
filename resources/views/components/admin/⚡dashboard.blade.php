<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Doctor;
use App\Models\Treatment;
use App\Models\Facility;
use App\Models\Branch;
use App\Models\News;
use App\Models\Promo;
use App\Models\Booking;

new #[Layout('layouts.admin')] class extends Component
{
    public function with(): array
    {
        return [
            'doctorsCount' => Doctor::count(),
            'treatmentsCount' => Treatment::count(),
            'facilitiesCount' => Facility::count(),
            'branchesCount' => Branch::count(),
            'newsCount' => News::count(),
            'promosCount' => Promo::count(),

            'bookingsCount' => Booking::count(),

            'pendingBookings' => Booking::where('status', 'pending')->count(),
            'confirmedBookings' => Booking::where('status', 'confirmed')->count(),
            'completedBookings' => Booking::where('status', 'completed')->count(),
            'cancelledBookings' => Booking::where('status', 'cancelled')->count(),

            'recentBookings' => Booking::with([
                    'treatment',
                    'branch',
                ])
                ->latest()
                ->limit(5)
                ->get(),
        ];
    }
};

?>
<div>

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold">
            Welcome back, {{ auth()->user()->name }} 👋
        </h1>

        <p class="mt-2 text-gray-600">
            Manage your WFSC website content from here.
        </p>
    </div>


    {{-- Content Statistics --}}
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

        {{-- Doctors --}}
        <a
            href="{{ route('admin.doctors.index') }}"
            wire:navigate
            class="rounded-xl bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
        >
            <p class="text-sm text-gray-500">
                Doctors
            </p>

            <p class="mt-2 text-3xl font-bold">
                {{ $doctorsCount }}
            </p>
        </a>


        {{-- Treatments --}}
        <a
            href="{{ route('admin.treatments.index') }}"
            wire:navigate
            class="rounded-xl bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
        >
            <p class="text-sm text-gray-500">
                Treatments
            </p>

            <p class="mt-2 text-3xl font-bold">
                {{ $treatmentsCount }}
            </p>
        </a>


        {{-- Facilities --}}
        <a
            href="{{ route('admin.facilities.index') }}"
            wire:navigate
            class="rounded-xl bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
        >
            <p class="text-sm text-gray-500">
                Facilities
            </p>

            <p class="mt-2 text-3xl font-bold">
                {{ $facilitiesCount }}
            </p>
        </a>


        {{-- Branches --}}
        <a
            href="{{ route('admin.branches.index') }}"
            wire:navigate
            class="rounded-xl bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
        >
            <p class="text-sm text-gray-500">
                Branches
            </p>

            <p class="mt-2 text-3xl font-bold">
                {{ $branchesCount }}
            </p>
        </a>


        {{-- News --}}
        <a
            href="{{ route('admin.news.index') }}"
            wire:navigate
            class="rounded-xl bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
        >
            <p class="text-sm text-gray-500">
                News
            </p>

            <p class="mt-2 text-3xl font-bold">
                {{ $newsCount }}
            </p>
        </a>


        {{-- Promos --}}
        <a
            href="{{ route('admin.home.promos.index') }}"
            wire:navigate
            class="rounded-xl bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
        >
            <p class="text-sm text-gray-500">
                Promos
            </p>

            <p class="mt-2 text-3xl font-bold">
                {{ $promosCount }}
            </p>
        </a>

    </div>


    {{-- Booking Statistics --}}
    <div class="mt-8">

        <div class="mb-4 flex items-center justify-between">

            <div>
                <h2 class="text-lg font-semibold">
                    Booking Overview
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Current booking status summary.
                </p>
            </div>

            <a
                href="{{ route('admin.bookings.index') }}"
                wire:navigate
                class="text-sm font-medium text-blue-600 hover:underline"
            >
                View all
            </a>

        </div>


        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-5">

            {{-- Total --}}
            <div class="rounded-xl bg-white p-6 shadow-sm">

                <p class="text-sm text-gray-500">
                    Total
                </p>

                <p class="mt-2 text-3xl font-bold">
                    {{ $bookingsCount }}
                </p>

            </div>


            {{-- Pending --}}
            <div class="rounded-xl bg-white p-6 shadow-sm">

                <p class="text-sm text-gray-500">
                    Pending
                </p>

                <p class="mt-2 text-3xl font-bold text-yellow-600">
                    {{ $pendingBookings }}
                </p>

            </div>


            {{-- Confirmed --}}
            <div class="rounded-xl bg-white p-6 shadow-sm">

                <p class="text-sm text-gray-500">
                    Confirmed
                </p>

                <p class="mt-2 text-3xl font-bold text-green-600">
                    {{ $confirmedBookings }}
                </p>

            </div>


            {{-- Completed --}}
            <div class="rounded-xl bg-white p-6 shadow-sm">

                <p class="text-sm text-gray-500">
                    Completed
                </p>

                <p class="mt-2 text-3xl font-bold text-blue-600">
                    {{ $completedBookings }}
                </p>

            </div>


            {{-- Cancelled --}}
            <div class="rounded-xl bg-white p-6 shadow-sm">

                <p class="text-sm text-gray-500">
                    Cancelled
                </p>

                <p class="mt-2 text-3xl font-bold text-red-600">
                    {{ $cancelledBookings }}
                </p>

            </div>

        </div>

    </div>


    {{-- Recent Bookings --}}
    <div class="mt-8">

        <div class="mb-4">

            <h2 class="text-lg font-semibold">
                Recent Bookings
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                The latest customer bookings.
            </p>

        </div>


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
                                Status
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-100">

                        @forelse ($recentBookings as $booking)

                            <tr class="transition hover:bg-gray-50">

                                {{-- Booking --}}
                                <td class="px-6 py-4">

                                    <a
                                        href="{{ route('admin.bookings.show', $booking) }}"
                                        wire:navigate
                                        class="font-medium text-blue-600 hover:underline"
                                    >
                                        {{ $booking->booking_code }}
                                    </a>

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

                                </td>


                                {{-- Treatment --}}
                                <td class="px-6 py-4 text-sm text-gray-700">

                                    {{ $booking->treatment?->name ?? 'Treatment deleted' }}

                                </td>


                                {{-- Branch --}}
                                <td class="px-6 py-4 text-sm text-gray-700">

                                    {{ $booking->branch?->name ?? 'Branch deleted' }}

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


                                        @case('completed')

                                            <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700">
                                                Completed
                                            </span>

                                            @break


                                        @case('cancelled')

                                            <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">
                                                Cancelled
                                            </span>

                                            @break


                                        @default

                                            <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
                                                {{ ucfirst($booking->status) }}
                                            </span>

                                    @endswitch

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="px-6 py-12 text-center"
                                >

                                    <div class="text-3xl">
                                        📋
                                    </div>

                                    <p class="mt-3 font-medium text-gray-900">
                                        No bookings yet
                                    </p>

                                    <p class="mt-1 text-sm text-gray-500">
                                        Customer bookings will appear here.
                                    </p>

                                    <a
                                        href="{{ route('admin.bookings.create') }}"
                                        wire:navigate
                                        class="mt-4 inline-block text-sm font-medium text-blue-600 hover:underline"
                                    >
                                        Create a booking
                                    </a>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

