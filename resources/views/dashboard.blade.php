<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.admin')] class extends Component {
    //
}; ?>

<div class="mb-8">
    <h1 class="text-2xl font-bold">
        Welcome back, {{ auth()->user()->name }} 👋
    </h1>

    <p class="mt-1 text-gray-600">
        Manage your WFSC website content from here.
    </p>
</div>

<div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">

    <div class="rounded-xl bg-white p-6 shadow-sm">
        <p class="text-sm text-gray-500">Doctors</p>
        <p class="mt-2 text-3xl font-bold">
            {{ \App\Models\Doctor::count() }}
        </p>
    </div>

    <div class="rounded-xl bg-white p-6 shadow-sm">
        <p class="text-sm text-gray-500">Treatments</p>
        <p class="mt-2 text-3xl font-bold">
            {{ \App\Models\Treatment::count() }}
        </p>
    </div>

    <div class="rounded-xl bg-white p-6 shadow-sm">
        <p class="text-sm text-gray-500">News</p>
        <p class="mt-2 text-3xl font-bold">
            {{ \App\Models\News::count() }}
        </p>
    </div>

    <div class="rounded-xl bg-white p-6 shadow-sm">
        <p class="text-sm text-gray-500">Bookings</p>
        <p class="mt-2 text-3xl font-bold">
            {{ \App\Models\Booking::count() }}
        </p>
    </div>

</div>