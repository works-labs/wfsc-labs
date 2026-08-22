<x-layouts::auth :title="__('Log in')">
    <div class="flex flex-col gap-6">

        <div class="flex flex-col items-center gap-3">
            <img
                src="{{ asset('assets/logo.PNG') }}"
                alt="WFSC Clinic"
                class="h-16 w-auto object-contain"
            >

            <div class="text-center">
                <h1 class="text-xl font-semibold text-gray-900">
                    Welcome back
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Sign in to manage WFSC Clinic
                </p>
            </div>
        </div>

        <x-auth-session-status
            class="text-center"
            :status="session('status')"
        />

        <form
            method="POST"
            action="{{ route('login.store') }}"
            class="flex flex-col gap-5"
        >
            @csrf

            <flux:input
                name="email"
                :label="__('Email address')"
                :value="old('email')"
                type="email"
                required
                autofocus
                autocomplete="email"
                placeholder="email@example.com"
            />

            <flux:input
                name="password"
                :label="__('Password')"
                type="password"
                required
                autocomplete="current-password"
                placeholder="Password"
                viewable
            />

            <flux:checkbox
                name="remember"
                :label="__('Remember me')"
                :checked="old('remember')"
            />

            <flux:button
                variant="primary"
                type="submit"
                class="w-full"
                data-test="login-button"
            >
                {{ __('Log in') }}
            </flux:button>
        </form>

        <div class="text-center text-xs text-gray-400">
            © {{ date('Y') }} WFSC Clinic
        </div>

    </div>
</x-layouts::auth>