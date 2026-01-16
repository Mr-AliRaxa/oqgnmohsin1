<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold text-dark mb-0">
            {{ __('Create Monthly Invoice') }}
        </h2>
    </x-slot>

    <div class="py-4" x-data="invoiceForm()">
        <div class="container">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form action="{{ route('company.invoices.store', $project) }}" method="POST">
                        @csrf
                        
                        <!-- Invoice Header -->
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <h4 class="fw-bold mb-3">Project: {{ $project->name }}</h4>
                                <div class="mb-3">
                                     <x-input-label for="to_client" :value="__('To')" />
                                     <x-text-input id="to_client" class="block w-full" type="text" name="to_client" value="{{ old('to_client', $project->to_client) }}" required />
                                </div>
                                <div class="mb-3">
                                     <x-input-label for="subject" :value="__('Respected Sir')" />
                                     <x-text-input id="subject" class="block w-full" type="text" name="subject" value="{{ old('subject', $project->subject) }}" required />
                                </div>
                                 <div class="mb-3">
                                     <x-input-label for="description" :value="__('Description (Optional)')" />
                                     <textarea id="description" name="description" class="form-control" rows="2">{{ old('description', $project->description) }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4 class="fw-bold mb-3">Invoice Info</h4>
                                <div class="mb-3">
                                    <x-input-label for="invoice_number" :value="__('Invoice Number (Auto)')" />
                                    <x-text-input id="invoice_number" class="block w-full bg-light" type="text" name="invoice_number" value="{{ $invoiceNumber }}" readonly />
                                </div>
                                <div>
                                    <x-input-label for="date" :value="__('Invoice Date (Auto)')" />
                                    <x-text-input id="date" class="block w-full bg-light" type="date" name="date" value="{{ date('Y-m-d') }}" readonly />
                                </div>
                            </div>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <x-input-label for="value_1" :value="__('values 1')" />
                                <x-text-input id="value_1" class="block w-full" type="text" name="value_1" value="{{ old('value_1') }}" />
                            </div>
                            <div class="col-md-6">
                                <x-input-label for="value_2" :value="__('value2')" />
                                <x-text-input id="value_2" class="block w-full" type="text" name="value_2" value="{{ old('value_2') }}" />
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Dynamic Items -->
                        <h4 class="h5 mb-3">Line Items</h4>
                        <div class="d-flex flex-column gap-3">
                            <template x-for="(item, index) in items" :key="index">
                                <div class="row g-3 align-items-end border p-3 rounded bg-light">
                                    <div class="col-md-4">
                                        <x-input-label :value="__('Description')" />
                                        <x-text-input x-model="item.description" x-bind:name="'items[' + index + '][description]'" class="block w-full" type="text" required />
                                    </div>
                                    <div class="col-md-2">
                                        <x-input-label :value="__('UOM')" />
                                        <x-text-input x-model="item.uom" x-bind:name="'items[' + index + '][uom]'" class="block w-full" type="text" />
                                    </div>
                                    <div class="col-md-1">
                                        <x-input-label :value="__('Qty')" />
                                        <x-text-input x-model="item.quantity" x-bind:name="'items[' + index + '][quantity]'" @input="calculateTotal(index)" class="block w-full" type="number" step="0.01" min="1" required />
                                    </div>
                                    <div class="col-md-2">
                                        <x-input-label :value="__('Rate')" />
                                        <x-text-input x-model="item.rate" x-bind:name="'items[' + index + '][rate]'" @input="calculateTotal(index)" class="block w-full" type="number" step="0.01" min="0" required />
                                    </div>
                                    <div class="col-md-2">
                                        <x-input-label :value="__('Total Price')" />
                                        <x-text-input x-model="item.amount" class="block w-full" type="number" step="0.01" readonly />
                                    </div>
                                    <div class="col-md-1 text-center pb-1">
                                        <button type="button" @click="removeItem(index)" class="btn btn-outline-danger btn-sm" title="Remove">&times;</button>
                                    </div>
                                </div>
                            </template>
                        </div>
                        
                        <div class="mt-3">
                            <button type="button" @click="addItem()" class="btn btn-light border fw-bold">
                                <span class="me-1">+</span> Add Item
                            </button>
                            <div class="float-end h5 fw-bold text-dark">
                                Grand Total: <span x-text="formatMoney(getGrandTotal())"></span>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                         <hr class="my-4">

                        <!-- Dynamic Terms -->
                        <h4 class="h5 mb-3">Terms & Conditions</h4>
                        <div class="d-flex flex-column gap-2">
                             <template x-for="(term, index) in terms" :key="index">
                                <div class="d-flex align-items-center gap-2">
                                    <span x-text="index + 1 + '.'" class="text-muted fw-bold"></span>
                                    <x-text-input x-model="terms[index]" name="terms[]" class="block w-full" type="text" placeholder="Enter term..." />
                                     <button type="button" @click="removeTerm(index)" class="btn btn-outline-danger btn-sm">&times;</button>
                                </div>
                             </template>
                        </div>
                        <div class="mt-3">
                            <button type="button" @click="addTerm()" class="btn btn-light border fw-bold">
                                <span class="me-1">+</span> Add Term
                            </button>
                        </div>

                        <div class="mt-4 d-flex justify-content-end">
                            <x-primary-button>
                                {{ __('Generate Invoice') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function invoiceForm() {
            return {
                items: [
                    { description: '', uom: '', quantity: 1, rate: 0, amount: 0 }
                ],
                terms: [
                    'Payment is due within 30 days.',
                    'Please quote invoice number in all usage.'
                ],
                addItem() {
                    this.items.push({ description: '', uom: '', quantity: 1, rate: 0, amount: 0 });
                },
                removeItem(index) {
                    if(this.items.length > 1) {
                        this.items.splice(index, 1);
                    }
                },
                addTerm() {
                    this.terms.push('');
                },
                removeTerm(index) {
                     this.terms.splice(index, 1);
                },
                calculateTotal(index) {
                    let item = this.items[index];
                    let amt = (parseFloat(item.quantity) || 0) * (parseFloat(item.rate) || 0);
                    item.amount = Math.round(amt * 100) / 100;
                },
                getGrandTotal() {
                    return this.items.reduce((sum, item) => sum + (parseFloat(item.amount) || 0), 0);
                },
                formatMoney(amount) {
                    return '$' + (parseFloat(amount) || 0).toFixed(2);
                }
            }
        }
    </script>
</x-app-layout>
