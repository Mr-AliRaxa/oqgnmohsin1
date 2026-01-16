<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">
            {{ __('Create Project') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Project Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('company.projects.store') }}" method="POST">
                        @csrf
                        
                        <!-- Header Inputs -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold">Project Name</label>
                                <input id="name" type="text" name="name" class="form-control" placeholder="e.g. Office Renovation" required>
                            </div>
                            <div class="col-md-6">
                                <label for="to_client" class="form-label fw-semibold">Client Name</label>
                                <input id="to_client" type="text" name="to_client" class="form-control" placeholder="e.g. Acme Corp" required>
                            </div>
                            <div class="col-md-6">
                                <label for="location" class="form-label fw-semibold">Location</label>
                                <input id="location" type="text" name="location" class="form-control" placeholder="e.g. Dubai, UAE" required>
                            </div>
                            <div class="col-md-6">
                                <label for="owner_name" class="form-label fw-semibold">Project By (Owner/Company)</label>
                                <input id="owner_name" type="text" name="owner_name" class="form-control" placeholder="e.g. Your Company Name" required>
                            </div>
                             <div class="col-md-6">
                                <label for="status" class="form-label fw-semibold">Project Status</label>
                                <select id="status" name="status" class="form-select border-primary-subtle fw-bold" style="background-color: rgba(var(--bs-primary-rgb), 0.05);">
                                    @foreach(\App\Models\Project::getStatuses() as $key => $label)
                                        <option value="{{ $key }}" {{ $key == 'draft' ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="subject" class="form-label fw-semibold">Subject/Overview</label>
                                <input id="subject" type="text" name="subject" class="form-control" placeholder="Brief subject line" required>
                            </div>
                            <div class="col-12">
                                <label for="description" class="form-label fw-semibold">Detailed Description</label>
                                <textarea id="description" name="description" class="form-control" rows="3" placeholder="More details about the project..."></textarea>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Assign Team -->
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-people-fill text-primary me-2 f-5"></i>
                            <h5 class="mb-0 fw-bold">Assign Team Members</h5>
                        </div>
                        <div class="row g-3">
                            @foreach($teamMembers as $member)
                            <div class="col-md-3">
                                <div class="form-check p-2 border rounded hover-bg-light transition-all">
                                    <input id="team_{{ $member->id }}" type="checkbox" name="team_members[]" value="{{ $member->id }}" class="form-check-input ms-0 me-2">
                                    <label for="team_{{ $member->id }}" class="form-check-label small d-block">
                                        <div class="fw-bold text-dark">{{ $member->name }}</div>
                                        <div class="text-muted" style="font-size: 0.7rem;">{{ $member->designation }}</div>
                                    </label>
                                </div>
                            </div>
                            @endforeach
                            @if($teamMembers->isEmpty())
                                <div class="col-12 text-center py-3 text-muted">
                                    <p class="mb-0">No team members found. <a href="{{ route('company.teams.index') }}" class="text-primary text-decoration-none">Add team members first</a>.</p>
                                </div>
                            @endif
                        </div>

                        <div class="mt-5 d-flex justify-content-between align-items-center border-top pt-4">
                            <a href="{{ route('company.projects.index') }}" class="btn btn-light px-4">Cancel</a>
                            <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                <i class="bi bi-check2-circle me-1"></i> Create Project
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .hover-bg-light:hover { background-color: #f8f9fa; cursor: pointer; }
        .transition-all { transition: all 0.2s ease; }
    </style>
</x-app-layout>
