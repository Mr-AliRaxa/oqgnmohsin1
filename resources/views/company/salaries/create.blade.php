<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Record Salary') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('company.salaries.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="team_member_id" :value="__('Select Team Member')" />
                                <select id="team_member_id" name="team_member_id" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">-- Select --</option>
                                    @foreach($teamMembers as $member)
                                        <option value="{{ $member->id }}">{{ $member->name }}  ({{ $member->designation }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <x-input-label for="date" :value="__('Payment Date')" />
                                <x-text-input id="date" class="block mt-1 w-full" type="date" name="date" required />
                            </div>

                            <div>
                                <x-input-label for="amount" :value="__('Salary Amount')" />
                                <x-text-input id="amount" class="block mt-1 w-full" type="number" step="0.01" name="amount" required />
                            </div>

                            <div>
                                <x-input-label for="bonus" :value="__('Bonus (Optional)')" />
                                <x-text-input id="bonus" class="block mt-1 w-full" type="number" step="0.01" name="bonus" value="0" />
                            </div>

                            <div>
                                <x-input-label for="slip" :value="__('Bank Slip (Optional)')" />
                                <input id="slip" type="file" name="slip" class="block mt-1 w-full" />
                            </div>
                            
                            <div class="md:col-span-2">
                                <x-input-label for="note" :value="__('Note')" />
                                <textarea id="note" name="note" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <x-primary-button>
                                {{ __('Record Payment') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
