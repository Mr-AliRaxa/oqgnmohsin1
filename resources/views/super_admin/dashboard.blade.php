<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold mb-0 text-white">
            {{ __('Super Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <!-- Stats Row -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-circle me-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-buildings" viewBox="0 0 16 16">
                                    <path d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022M6 8.694 1 10.36V15h5zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5z"/>
                                    <path d="M2 11h1v1H2zm2 0h1v1H4zm-2 2h1v1H2zm2 0h1v1H4zm4-4h1v1H8zm2 0h1v1h-1zm-2 2h1v1H8zm2 0h1v1h-1zm2-2h1v1h-1zm0 2h1v1h-1zM8 7h1v1H8zm2 0h1v1h-1zm2 0h1v1h-1zM8 5h1v1H8zm2 0h1v1h-1zm2 0h1v1h-1z"/>
                                </svg>
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                    <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                                </svg>
                            </div>
                            <h6 class="card-subtitle text-secondary mb-0">Approved</h6>
                        </div>
                        <h2 class="card-title fw-bold mb-0 text-dark">{{ $approvedCount }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 text-white">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-warning bg-opacity-10 text-warning p-2 rounded-circle me-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-clock-history" viewBox="0 0 16 16">
                                    <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.74l.824-.568c.19.276.364.563.522.86l-.907.448zm1.025 1.054c-.176-.201-.366-.39-.567-.567l.67-.742c.261.235.508.49.742.75l-.745.659zm.71 1.37c-.143-.366-.256-.743-.342-1.126l.976-.219c.142.365.256.742.342 1.126l-.976.219zM15 8c0 .38-.03.754-.087 1.122l.983.164A8.005 8.005 0 0 0 16 8h-1zM8 15a7 7 0 1 1 0-14 7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="M7.5 3a.5.5 0 0 0-.5.5v5.21l3.248 1.856a.5.5 0 0 0 .496-.868L8 7.21V3.5a.5.5 0 0 0-.5-.5z"/>
                                </svg>
                            </div>
                            <h6 class="card-subtitle text-secondary mb-0 font-weight-bold">Pending</h6>
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                                </svg>
                            </div>
                            <h6 class="card-subtitle text-secondary mb-0">Rejected</h6>
                        </div>
                        <h2 class="card-title fw-bold mb-0 text-dark">{{ $rejectedCount }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex justify-content-end gap-2 mb-4">
            <a href="{{ route('super_admin.registrations.index') }}" class="btn btn-warning position-relative px-4 shadow-sm">
                Manage Requests
                @if($pendingCount > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $pendingCount }}
                    </span>
                @endif
            </a>
            <a href="{{ route('super_admin.settings') }}" class="btn btn-secondary px-4 shadow-sm">
                System Settings
            </a>
            <a href="{{ route('super_admin.companies.create') }}" class="btn btn-primary px-4 shadow-sm">
                Add New Company
            </a>
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
                                        <form action="{{ route('super_admin.companies.destroy', $company) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this company? This will delete all associated data.');">
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
