<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Bank Detail') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('company.settings.bank_details.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                             <x-input-label for="bank_name" :value="__('Name of Bank')" />
                             <x-text-input id="bank_name" class="block mt-1 w-full" type="text" name="bank_name" :value="old('bank_name')" required />
                             <x-input-error :messages="$errors->get('bank_name')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                             <x-input-label for="account_name" :value="__('Account Name')" />
                             <x-text-input id="account_name" class="block mt-1 w-full" type="text" name="account_name" :value="old('account_name')" required />
                             <x-input-error :messages="$errors->get('account_name')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                             <x-input-label for="account_number" :value="__('Account Number')" />
                             <x-text-input id="account_number" class="block mt-1 w-full" type="text" name="account_number" :value="old('account_number')" required />
                             <x-input-error :messages="$errors->get('account_number')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                             <x-input-label for="iban" :value="__('IBAN Number')" />
                             <x-text-input id="iban" class="block mt-1 w-full" type="text" name="iban" :value="old('iban')" required />
                             <x-input-error :messages="$errors->get('iban')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Save') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
