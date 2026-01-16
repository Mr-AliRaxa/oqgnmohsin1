<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <h4 class="fw-bold mb-4 text-center">Company Registration</h4>

        <div class="row g-3">
            <!-- Name -->
            <div class="col-md-6">
                <x-input-label for="name" :value="__('Full Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="col-md-6">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Company Name -->
            <div class="col-md-6">
                <x-input-label for="company_name" :value="__('Company Name')" />
                <x-text-input id="company_name" class="block mt-1 w-full" type="text" name="company_name" :value="old('company_name')" required />
                <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
            </div>

            <!-- CR Number -->
            <div class="col-md-6">
                <x-input-label for="cr_number" :value="__('CR Number')" />
                <x-text-input id="cr_number" class="block mt-1 w-full" type="text" name="cr_number" :value="old('cr_number')" required />
                <x-input-error :messages="$errors->get('cr_number')" class="mt-2" />
            </div>

            <!-- Phone Number -->
            <div class="col-md-12">
                <x-input-label for="phone_number" :value="__('Phone Number')" />
                <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number')" required />
                <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
            </div>

            <!-- Address -->
            <div class="col-md-12">
                <x-input-label for="address" :value="__('Full Address')" />
                <textarea id="address" name="address" class="form-control block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('address') }}</textarea>
                <x-input-error :messages="$errors->get('address')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="col-md-6">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="col-md-6">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-end mt-4 pt-3 border-top">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Submit Registration') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
