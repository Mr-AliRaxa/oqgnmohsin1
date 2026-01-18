<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 font-weight-bold mb-0 text-white">
                {{ __('Super Admin Dashboard') }}
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('super_admin.registrations.index') }}" class="btn btn-light btn-sm position-relative px-3 shadow-sm text-primary">
                    <i class="bi bi-bell-fill me-1"></i> Manage Requests
                    @if($pendingCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $pendingCount }}
                        </span>
                    @endif
                </a>
                <a href="{{ route('super_admin.settings') }}" class="btn btn-light btn-sm px-3 shadow-sm">
                    <i class="bi bi-gear-fill me-1"></i> System Settings
                </a>
                <a href="{{ route('super_admin.companies.create') }}" class="btn btn-primary btn-sm px-3 shadow-sm border border-white border-opacity-25">
                    <i class="bi bi-plus-lg me-1"></i> Add Company
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <!-- Stats Row -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-circle me-3">
                                <i class="bi bi-buildings fs-4"></i>
                            </div>
                            <h6 class="card-subtitle text-secondary mb-0">Total Companies</h6>
                        </div>
                        <h2 class="card-title fw-bold mb-0 text-dark">{{ $totalCompanies }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-success bg-opacity-10 text-success p-2 rounded-circle me-3">
                                <i class="bi bi-check-circle fs-4"></i>
                            </div>
                            <h6 class="card-subtitle text-secondary mb-0">Approved</h6>
                        </div>
                        <h2 class="card-title fw-bold mb-0 text-dark">{{ $approvedCount }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-warning bg-opacity-10 text-warning p-2 rounded-circle me-3">
                                <i class="bi bi-clock-history fs-4"></i>
                            </div>
                            <h6 class="card-subtitle text-secondary mb-0">Pending</h6>
                        </div>
                        <h2 class="card-title fw-bold mb-0 text-dark">{{ $pendingCount }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-danger bg-opacity-10 text-danger p-2 rounded-circle me-3">
                                <i class="bi bi-x-circle fs-4"></i>
                            </div>
                            <h6 class="card-subtitle text-secondary mb-0">Rejected</h6>
                        </div>
                        <h2 class="card-title fw-bold mb-0 text-dark">{{ $rejectedCount }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Companies Table Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="mb-0 fw-bold">Company Directory</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-secondary small text-uppercase">
                            <tr>
                                <th class="px-4 py-3">Company Name</th>
                                <th class="py-3">Owner</th>
                                <th class="py-3 text-center">Status</th>
                                <th class="py-3 text-center">Account</th>
                                <th class="py-3">Joined Date</th>
                                <th class="px-4 py-3 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($companies as $company)
                            <tr>
                                <td class="px-4">
                                    <div class="fw-bold">{{ $company->name }}</div>
                                    <div class="small text-secondary">{{ $company->email }}</div>
                                </td>
                                <td>
                                    <div>{{ $company->owner_name }}</div>
                                </td>
                                <td class="text-center">
                                    @if($company->status === 'approved')
                                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill border border-success border-opacity-25">Approved</span>
                                    @elseif($company->status === 'pending')
                                        <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill border border-warning border-opacity-25">Pending</span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill border border-danger border-opacity-25">Rejected</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('super_admin.registrations.toggle-active', $company) }}" method="POST" id="toggle-form-{{ $company->id }}">
                                        @csrf
                                        <div class="form-check form-switch d-flex justify-content-center">
                                            <input class="form-check-input mt-0" type="checkbox" role="switch" 
                                                   id="switch-{{ $company->id }}" 
                                                   {{ $company->is_active ? 'checked' : '' }}
                                                   onchange="document.getElementById('toggle-form-{{ $company->id }}').submit()">
                                            <label class="form-check-label ms-2 small {{ $company->is_active ? 'text-success' : 'text-danger' }}" for="switch-{{ $company->id }}">
                                                {{ $company->is_active ? 'Active' : 'Inactive' }}
                                            </label>
                                        </div>
                                    </form>
                                </td>
                                <td>
                                    {{ $company->created_at->format('d M Y') }}
                                </td>
                                <td class="px-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('super_admin.companies.edit', $company) }}" class="btn btn-light btn-sm text-primary" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('super_admin.companies.destroy', $company) }}" method="POST" onsubmit="return confirmDelete(event, 'Are you sure you want to delete {{ $company->name }}? This will delete all associated data including users, projects, and invoices.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-light btn-sm text-danger" title="Delete">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
