<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Team Member') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('company.teams.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" required />
                            </div>

                            <div>
                                <x-input-label for="mobile" :value="__('Mobile Number')" />
                                <x-text-input id="mobile" class="block mt-1 w-full" type="text" name="mobile" />
                            </div>
                            
                            <div>
                                <x-input-label for="designation" :value="__('Designation')" />
                                <x-text-input id="designation" class="block mt-1 w-full" type="text" name="designation" />
                            </div>

                            <div>
                                <x-input-label for="nationality" :value="__('Nationality')" />
                                <x-text-input id="nationality" class="block mt-1 w-full" type="text" name="nationality" />
                            </div>

                            <div>
                                <x-input-label for="id_card_number" :value="__('ID Card Number')" />
                                <x-text-input id="id_card_number" class="block mt-1 w-full" type="text" name="id_card_number" />
                            </div>

                            <div>
                                <x-input-label for="basic_salary" :value="__('Basic Salary')" />
                                <x-text-input id="basic_salary" class="block mt-1 w-full" type="number" step="0.01" name="basic_salary" />
                            </div>

                            <div>
                                <x-input-label for="image_path" :value="__('Profile Image')" />
                                <input id="image_path" type="file" name="image_path" class="block mt-1 w-full" />
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <x-primary-button>
                                {{ __('Save Member') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
