<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" name="email" type="email" required autofocus />
        <x-input-error :messages="$errors->get('email')" />

        <!-- Password -->
        <x-input-label for="password" :value="__('Password')" class="mt-4" />
        <x-text-input id="password" name="password" type="password" required />
        <x-input-error :messages="$errors->get('password')" />

        <!-- Remember Me + Forgot Password -->
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>

            {{-- Only show "Forgot your password?" when NOT in admin mode --}}
            @unless(isset($adminMode) && $adminMode)
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            @endunless
        </div>

        <!-- Submit -->
        <div class="flex items-center justify-end mt-4 space-x-4">
            <x-primary-button>
                {{ __('Log in') }}
            </x-primary-button>

            <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-1.5 border border-transparent text-sm font-medium rounded-md text-white bg-gray-800 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                {{ __('REGISTER') }}
            </a>

            <!-- Continue as Anonymous Button -->
            <a href="{{ route('confessions.index') }}" class="inline-flex items-center px-4 py-1.5 border border-transparent text-sm font-medium rounded-md text-white bg-gray-800 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                BE ANONYMOUS
            </a>
        </div>
    </form>

    {{-- Admin login button only in normal mode --}}
    @unless(isset($adminMode) && $adminMode)
        <div class="mt-4 text-center">
            <a href="{{ route('admin.login') }}" class="text-sm text-blue-500 hover:text-blue-700">
                {{ __('Admin Login') }}
            </a>
        </div>
    @endunless
</x-guest-layout>
