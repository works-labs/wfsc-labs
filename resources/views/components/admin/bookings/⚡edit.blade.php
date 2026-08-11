```php
<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Booking;
use App\Models\Treatment;
use App\Models\Branch;

new #[Layout('layouts.admin')] class extends Component
{
    public Booking $booking;

    public string $booking_code = '';
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $treatment_id = '';
    public string $branch_id = '';
    public string $preferred_date = '';
    public string $preferred_time = '';
    public string $message = '';
    public string $status = 'pending';

    public function mount(Booking $booking): void
    {
        $this->booking = $booking;

        $this->booking_code = $booking->booking_code;
        $this->name = $booking->name;
        $this->email = $booking->email ?? '';
        $this->phone = $booking->phone;
        $this->treatment_id = $booking->treatment_id
            ? (string) $booking->treatment_id
            : '';
        $this->branch_id = $booking->branch_id
            ? (string) $booking->branch_id
            : '';

        $this->preferred_date = $booking->preferred_date
            ? \Illuminate\Support\Carbon::parse($booking->preferred_date)->format('Y-m-d')
            : '';

        $this->preferred_time = $booking->preferred_time
            ? \Illuminate\Support\Carbon::parse($booking->preferred_time)->format('H:i')
            : '';

        $this->message = $booking->message ?? '';
        $this->status = $booking->status;
    }

    public function update(): void
    {
        $validated = $this->validate([
            'booking_code' => [
                'required',
                'string',
                'max:255',
                'unique:bookings,booking_code,' . $this->booking->id,
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'phone' => [
                'required',
                'string',
                'max:255',
            ],

            'treatment_id' => [
                'nullable',
                'integer',
                'exists:treatments,id',
            ],

            'branch_id' => [
                'nullable',
                'integer',
                'exists:branches,id',
            ],

            'preferred_date' => [
                'nullable',
                'date',
            ],

            'preferred_time' => [
                'nullable',
                'date_format:H:i',
            ],

            'message' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                'in:pending,confirmed,cancelled,completed',
            ],
        ]);

        $this->booking->update($validated);

        session()->flash(
            'success',
            'Booking updated successfully.'
        );

        $this->redirect(
            route('admin.bookings.index'),
            navigate: true
        );
    }

    public function with(): array
    {
        return [
            'treatments' => Treatment::query()
                ->where('is_active', true)
                ->orderBy('name')
                ->get(),

            'branches' => Branch::query()
                ->where('is_active', true)
                ->orderBy('name')
                ->get(),
        ];
    }
};

?>

<div>

    {{-- Header --}}
    <div class="mb-8">
        <div class="flex items-center justify-between">

            <div>
                <h1 class="text-2xl font-bold">
                    Edit Booking
                </h1>

                <p class="mt-2 text-gray-600">
                    Update booking {{ $booking->booking_code }}.
                </p>
            </div>

            <a
                href="{{ route('admin.bookings.index') }}"
                wire:navigate
                class="rounded-lg border px-5 py-2 font-medium hover:bg-gray-50"
            >
                Back
            </a>

        </div>
    </div>


    <form wire:submit="update" class="max-w-5xl space-y-6">

        {{-- Booking Information --}}
        <div class="rounded-xl bg-white p-6 shadow-sm">

            <h2 class="mb-6 text-lg font-semibold">
                Booking Information
            </h2>

            <div class="grid gap-6 md:grid-cols-2">

                {{-- Booking Code --}}
                <div>

                    <label class="mb-2 block text-sm font-medium">
                        Booking Code
                    </label>

                    <input
                        type="text"
                        wire:model="booking_code"
                        class="w-full rounded-lg border bg-gray-50 px-4 py-2"
                    >

                    @error('booking_code')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Status --}}
                <div>

                    <label class="mb-2 block text-sm font-medium">
                        Status
                    </label>

                    <select
                        wire:model="status"
                        class="w-full rounded-lg border px-4 py-2"
                    >
                        <option value="pending">
                            Pending
                        </option>

                        <option value="confirmed">
                            Confirmed
                        </option>

                        <option value="cancelled">
                            Cancelled
                        </option>

                        <option value="completed">
                            Completed
                        </option>
                    </select>

                    @error('status')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>

        </div>


        {{-- Customer --}}
        <div class="rounded-xl bg-white p-6 shadow-sm">

            <h2 class="mb-6 text-lg font-semibold">
                Customer Information
            </h2>

            <div class="grid gap-6 md:grid-cols-2">

                {{-- Name --}}
                <div>

                    <label class="mb-2 block text-sm font-medium">
                        Customer Name
                    </label>

                    <input
                        type="text"
                        wire:model="name"
                        class="w-full rounded-lg border px-4 py-2"
                        placeholder="Customer name"
                    >

                    @error('name')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Phone --}}
                <div>

                    <label class="mb-2 block text-sm font-medium">
                        Phone
                    </label>

                    <input
                        type="text"
                        wire:model="phone"
                        class="w-full rounded-lg border px-4 py-2"
                        placeholder="08xxxxxxxxxx"
                    >

                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Email --}}
                <div class="md:col-span-2">

                    <label class="mb-2 block text-sm font-medium">
                        Email
                    </label>

                    <input
                        type="email"
                        wire:model="email"
                        class="w-full rounded-lg border px-4 py-2"
                        placeholder="customer@example.com"
                    >

                    @error('email')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>

        </div>


        {{-- Treatment & Branch --}}
        <div class="rounded-xl bg-white p-6 shadow-sm">

            <h2 class="mb-6 text-lg font-semibold">
                Treatment & Branch
            </h2>

            <div class="grid gap-6 md:grid-cols-2">

                {{-- Treatment --}}
                <div>

                    <label class="mb-2 block text-sm font-medium">
                        Treatment
                    </label>

                    <select
                        wire:model="treatment_id"
                        class="w-full rounded-lg border px-4 py-2"
                    >
                        <option value="">
                            Select treatment
                        </option>

                        @foreach ($treatments as $treatment)

                            <option value="{{ $treatment->id }}">
                                {{ $treatment->name }}
                            </option>

                        @endforeach
                    </select>

                    @error('treatment_id')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Branch --}}
                <div>

                    <label class="mb-2 block text-sm font-medium">
                        Branch
                    </label>

                    <select
                        wire:model="branch_id"
                        class="w-full rounded-lg border px-4 py-2"
                    >
                        <option value="">
                            Select branch
                        </option>

                        @foreach ($branches as $branch)

                            <option value="{{ $branch->id }}">
                                {{ $branch->name }}
                            </option>

                        @endforeach
                    </select>

                    @error('branch_id')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>

        </div>


        {{-- Schedule --}}
        <div class="rounded-xl bg-white p-6 shadow-sm">

            <h2 class="mb-6 text-lg font-semibold">
                Preferred Schedule
            </h2>

            <div class="grid gap-6 md:grid-cols-2">

                {{-- Date --}}
                <div>

                    <label class="mb-2 block text-sm font-medium">
                        Preferred Date
                    </label>

                    <input
                        type="date"
                        wire:model="preferred_date"
                        class="w-full rounded-lg border px-4 py-2"
                    >

                    @error('preferred_date')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Time --}}
                <div>

                    <label class="mb-2 block text-sm font-medium">
                        Preferred Time
                    </label>

                    <input
                        type="time"
                        wire:model="preferred_time"
                        class="w-full rounded-lg border px-4 py-2"
                    >

                    @error('preferred_time')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>

        </div>


        {{-- Message --}}
        <div class="rounded-xl bg-white p-6 shadow-sm">

            <label class="mb-2 block text-sm font-medium">
                Message
            </label>

            <textarea
                wire:model="message"
                rows="5"
                class="w-full rounded-lg border px-4 py-2"
                placeholder="Additional notes..."
            ></textarea>

            @error('message')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror

        </div>


        {{-- Actions --}}
        <div class="flex items-center gap-3">

            <button
                type="submit"
                class="rounded-lg bg-black px-5 py-2 font-semibold text-white hover:bg-gray-800"
            >
                Update Booking
            </button>

            <a
                href="{{ route('admin.bookings.index') }}"
                wire:navigate
                class="rounded-lg border px-5 py-2 font-medium hover:bg-gray-50"
            >
                Cancel
            </a>

        </div>

    </form>

</div>
```
