<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold text-dark mb-0">
            {{ __('Add Expense') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form action="{{ route('company.expenses.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <x-input-label for="type" :value="__('Expense Type')" />
                                <select id="type" name="type" class="form-select" required>
                                    <option value="">Select Type</option>
                                    @foreach($expenseTypes as $type)
                                        <option value="{{ $type->name }}" {{ old('type') == $type->name ? 'selected' : '' }}>{{ $type->name }}</option>
                                    @endforeach
                                    <option value="Other" {{ old('type') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <x-input-label for="date" :value="__('Date')" />
                                <x-text-input id="date" class="form-control" type="date" name="date" required />
                            </div>

                            <div class="col-md-6">
                                <x-input-label for="amount" :value="__('Amount')" />
                                <x-text-input id="amount" class="form-control" type="number" step="0.01" name="amount" required />
                            </div>

                            <div class="col-md-6">
                                <x-input-label for="receipt" :value="__('Receipt (Optional)')" />
                                <input id="receipt" type="file" name="receipt" class="form-control" />
                            </div>
                            
                            <div class="col-12">
                                <x-input-label for="note" :value="__('Note')" />
                                <textarea id="note" name="note" class="form-control" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-end">
                            <x-primary-button>
                                {{ __('Save Expense') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
