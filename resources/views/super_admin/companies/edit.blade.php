<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Company') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('super_admin.companies.update', $company) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Company Name -->
                        <div>
                            <x-input-label for="company_name" :value="__('Company Name')" />
                            <x-text-input id="company_name" class="block mt-1 w-full" type="text" name="company_name" :value="old('company_name', $company->name)" required autofocus />
                            <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                        </div>

                        <!-- Owner Name -->
                        <div class="mt-4">
                            <x-input-label for="owner_name" :value="__('Owner Name')" />
                            <x-text-input id="owner_name" class="block mt-1 w-full" type="text" name="owner_name" :value="old('owner_name', $company->owner_name)" required />
                            <x-input-error :messages="$errors->get('owner_name')" class="mt-2" />
                        </div>

                        <!-- Address -->
                        <div class="mt-4">
                            <x-input-label for="company_address" :value="__('Address')" />
                            <x-text-input id="company_address" class="block mt-1 w-full" type="text" name="company_address" :value="old('company_address', $company->address)" required />
                            <x-input-error :messages="$errors->get('company_address')" class="mt-2" />
                        </div>

                         <!-- CR Number -->
                        <div class="mt-4">
                            <x-input-label for="company_cr_number" :value="__('CR Number')" />
                            <x-text-input id="company_cr_number" class="block mt-1 w-full" type="text" name="company_cr_number" :value="old('company_cr_number', $company->cr_number)" />
                            <x-input-error :messages="$errors->get('company_cr_number')" class="mt-2" />
                        </div>

                        <!-- Logo -->
                        <div class="mt-4">
                            <x-input-label for="company_logo" :value="__('Company Logo')" />
                            @if($company->logo_path)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $company->logo_path) }}" alt="Current Logo" class="h-16">
                                </div>
                            @endif
                            <input id="company_logo" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" type="file" name="company_logo">
                            <x-input-error :messages="$errors->get('company_logo')" class="mt-2" />
                        </div>

                         <div class="mt-4 text-sm text-gray-500">
                            Note: Email and User Account details cannot be changed from here.
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Update Company') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
