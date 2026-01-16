<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">
            {{ __('Edit Project') }}
        </h2>
    </x-slot>

    <div class="py-4" x-data="projectForm()">
        <div class="container">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">General Information</h5>
                    <span class="badge bg-{{ $project->status_color }} bg-opacity-10 text-{{ $project->status_color }} border border-{{ $project->status_color }} border-opacity-25 px-3 py-2">
                        Currently: {{ $project->status_label }}
                    </span>
                </div>
                <div class="card-body">
                    <form action="{{ route('company.projects.update', $project) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Header Inputs -->
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold">Project Name</label>
                                <input id="name" type="text" name="name" class="form-control" value="{{ $project->name }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="to_client" class="form-label fw-semibold">Client Name</label>
                                <input id="to_client" type="text" name="to_client" class="form-control" value="{{ $project->to_client }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="location" class="form-label fw-semibold">Location</label>
                                <input id="location" type="text" name="location" class="form-control" value="{{ $project->location }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="owner_name" class="form-label fw-semibold">Project By</label>
                                <input id="owner_name" type="text" name="owner_name" class="form-control" value="{{ $project->owner_name }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="status" class="form-label fw-semibold">Project Status</label>
                                <select id="status" name="status" class="form-select border-{{ $project->status_color }} fw-bold" style="background-color: rgba(var(--bs-{{ $project->status_color }}-rgb), 0.05);">
                                    @foreach(\App\Models\Project::getStatuses() as $key => $label)
                                        <option value="{{ $key }}" {{ $project->status == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="subject" class="form-label fw-semibold">Subject</label>
                                <input id="subject" type="text" name="subject" class="form-control" value="{{ $project->subject }}" required>
                            </div>
                            <div class="col-12">
                                <label for="description" class="form-label fw-semibold">Description</label>
                                <textarea id="description" name="description" class="form-control" rows="3">{{ $project->description }}</textarea>
                            </div>
                        </div>

                        <hr class="my-5">

                        <!-- Dynamic Line Items -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 text-primary p-2 rounded me-3">
                                    <i class="bi bi-list-ul fs-5"></i>
                                </div>
                                <h5 class="mb-0 fw-bold">Line Items</h5>
                            </div>
                            <button type="button" @click="addItem()" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-plus-lg me-1"></i> Add Item
                            </button>
                        </div>

                        <div class="d-flex flex-column gap-4">
                            <template x-for="(item, index) in items" :key="index">
                                <div class="card border shadow-none bg-light bg-opacity-25 pb-3">
                                    <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center pt-3 px-3">
                                        <span class="badge bg-secondary rounded-pill" x-text="'Item #' + (index + 1)"></span>
                                        <button type="button" @click="removeItem(index)" class="btn btn-link text-danger p-0 border-0" x-show="items.length > 1">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                    <div class="card-body pt-0 px-3">
                                        <div class="row g-3">
                                            <div class="col-md-5">
                                                <label class="form-label small fw-bold text-muted">Description</label>
                                                <input x-model="item.description" x-bind:name="'items[' + index + '][description]'" type="text" class="form-control form-control-sm" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label small fw-bold text-muted">UOM</label>
                                                <input x-model="item.uom" x-bind:name="'items[' + index + '][uom]'" type="text" class="form-control form-control-sm" placeholder="e.g. m2">
                                            </div>
                                            <div class="col-md-1">
                                                <label class="form-label small fw-bold text-muted">Qty</label>
                                                <input x-model="item.quantity" x-bind:name="'items[' + index + '][quantity]'" @input="calculateTotal(index)" type="number" class="form-control form-control-sm" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label small fw-bold text-muted">Rate</label>
                                                <input x-model="item.rate" x-bind:name="'items[' + index + '][rate]'" @input="calculateTotal(index)" type="number" step="0.01" class="form-control form-control-sm" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label small fw-bold text-muted">Amount</label>
                                                <div class="form-control form-control-sm bg-white fw-bold text-end" x-text="formatMoney(item.amount)"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <hr class="my-5">

                        <!-- Dynamic Terms -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-success bg-opacity-10 text-success p-2 rounded me-3">
                                    <i class="bi bi-file-earmark-check fs-5"></i>
                                </div>
                                <h5 class="mb-0 fw-bold">Terms & Conditions</h5>
                            </div>
                            <button type="button" @click="addTerm()" class="btn btn-outline-success btn-sm">
                                <i class="bi bi-plus-lg me-1"></i> Add Term
                            </button>
                        </div>

                        <div class="list-group list-group-flush border rounded overflow-hidden shadow-sm">
                            <template x-for="(term, index) in terms" :key="index">
                                <div class="list-group-item d-flex align-items-center gap-3 py-3 border-0 border-bottom last-border-0">
                                    <span class="badge bg-light text-muted fw-bold rounded-pill" x-text="index + 1" style="width: 25px; height: 25px; display: flex; align-items: center; justify-content: center;"></span>
                                    <input x-model="terms[index]" name="terms[]" type="text" class="form-control border-0 bg-light bg-opacity-10 px-0" placeholder="Enter term text here...">
                                    <button type="button" @click="removeTerm(index)" class="btn btn-sm btn-outline-danger border-0 rounded-circle"><i class="bi bi-x-lg"></i></button>
                                </div>
                            </template>
                        </div>

                        <hr class="my-5">

                        <!-- Assign Team -->
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-info bg-opacity-10 text-info p-2 rounded me-3">
                                <i class="bi bi-people-fill fs-5"></i>
                            </div>
                            <h5 class="mb-0 fw-bold">Project Team</h5>
                        </div>
                        <div class="row g-3">
                            @foreach($teamMembers as $member)
                            <div class="col-md-3">
                                <div class="form-check p-2 border rounded transition-all {{ $project->teamMembers->contains($member->id) ? 'border-info bg-info bg-opacity-10' : 'hover-bg-light border-opacity-25' }}">
                                    <input id="team_{{ $member->id }}" type="checkbox" name="team_members[]" value="{{ $member->id }}" 
                                        class="form-check-input ms-0 me-2"
                                        {{ $project->teamMembers->contains($member->id) ? 'checked' : '' }}>
                                    <label for="team_{{ $member->id }}" class="form-check-label small d-block">
                                        <div class="fw-bold text-dark">{{ $member->name }}</div>
                                        <div class="text-muted" style="font-size: 0.7rem;">{{ $member->designation }}</div>
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="mt-5 d-flex justify-content-between border-top pt-4">
                            <a href="{{ route('company.projects.index') }}" class="btn btn-light px-4">Back to Projects</a>
                            <button type="submit" class="btn btn-warning px-5 shadow-sm fw-bold">
                                <i class="bi bi-save me-1"></i> Update Project
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        @php
            $jsItems = $project->items->map(fn($item) => [
                'description' => $item->description,
                'uom' => $item->uom,
                'quantity' => floatval($item->quantity),
                'rate' => floatval($item->rate),
                'amount' => floatval($item->amount)
            ]);
            $jsTerms = $project->terms->pluck('term_text');
        @endphp
        function projectForm() {
            return {
                items: @json($jsItems),
                terms: @json($jsTerms),
                init() {
                    if (this.items.length === 0) this.addItem();
                    if (this.terms.length === 0) this.addTerm();
                },
                addItem() {
                    this.items.push({ description: '', uom: '', quantity: 1, rate: 0, amount: 0 });
                },
                removeItem(index) {
                    if(this.items.length > 1) {
                        this.items.splice(index, 1);
                    }
                },
                calculateTotal(index) {
                    let item = this.items[index];
                    item.amount = (parseFloat(item.quantity) || 0) * (parseFloat(item.rate) || 0);
                },
                formatMoney(amount) {
                    return '$' + (parseFloat(amount) || 0).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                },
                addTerm() {
                    this.terms.push('');
                },
                removeTerm(index) {
                     this.terms.splice(index, 1);
                }
            }
        }
    </script>
    <style>
        .hover-bg-light:hover { background-color: #f8f9fa; cursor: pointer; }
        .transition-all { transition: all 0.2s ease; }
        .last-border-0:last-child { border-bottom: 0 !important; }
    </style>
</x-app-layout>
