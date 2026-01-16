<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Company') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('super_admin.companies.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="company_name" :value="__('Company Name')" />
                                <x-text-input id="company_name" class="block mt-1 w-full" type="text" name="company_name" required autofocus />
                                <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="company_address" :value="__('Company Address')" />
                                <x-text-input id="company_address" class="block mt-1 w-full" type="text" name="company_address" required />
                                <x-input-error :messages="$errors->get('company_address')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="company_cr_number" :value="__('Company CR Number')" />
                                <x-text-input id="company_cr_number" class="block mt-1 w-full" type="text" name="company_cr_number" />
                                <x-input-error :messages="$errors->get('company_cr_number')" class="mt-2" />
                            </div>

                             <div>
                                <x-input-label for="owner_name" :value="__('Owner Name')" />
                                <x-text-input id="owner_name" class="block mt-1 w-full" type="text" name="owner_name" required />
                                <x-input-error :messages="$errors->get('owner_name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="company_email" :value="__('Company & Admin Email')" />
                                <x-text-input id="company_email" class="block mt-1 w-full" type="email" name="company_email" required />
                                <x-input-error :messages="$errors->get('company_email')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="company_password" :value="__('Company Admin Password')" />
                                <x-text-input id="company_password" class="block mt-1 w-full" type="password" name="company_password" required />
                                <x-input-error :messages="$errors->get('company_password')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="company_logo" :value="__('Company Logo')" />
                                <input id="company_logo" type="file" name="company_logo" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                <x-input-error :messages="$errors->get('company_logo')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <x-primary-button>
                                {{ __('Create Company') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
