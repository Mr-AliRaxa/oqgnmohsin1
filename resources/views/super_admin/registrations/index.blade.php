<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold mb-0 text-white">
            {{ __('Pending Registrations') }}
        </h2>
    </x-slot>

    <div class="py-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Review Requests</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-secondary small text-uppercase fw-bold">
                            <tr>
                                <th class="px-4 py-3">Company Details</th>
                                <th class="py-3">Owner / Contact</th>
                                <th class="py-3">CR Number</th>
                                <th class="py-3 text-end px-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($companies as $company)
                                <tr>
                                    <td class="px-4">
                                        <div class="fw-bold">{{ $company->name }}</div>
                                        <div class="small text-secondary">{{ $company->address }}</div>
                                    </td>
                                    <td>
                                        <div>{{ $company->owner_name }}</div>
                                        <div class="small text-secondary">{{ $company->email }}</div>
                                        <div class="small text-secondary">{{ $company->phone_number }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">{{ $company->cr_number }}</span>
                                    </td>
                                    <td class="text-end px-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <form action="{{ route('super_admin.registrations.approve', $company) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm px-3">Approve</button>
                                            </form>
                                            <form action="{{ route('super_admin.registrations.reject', $company) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm px-3">Reject</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="text-secondary">No pending registration requests found.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
