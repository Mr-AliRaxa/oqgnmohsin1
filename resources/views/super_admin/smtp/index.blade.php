<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 font-weight-bold text-white mb-0">
                {{ __('SMTP Settings') }}
            </h2>
            <a href="{{ route('super_admin.smtp-settings.create') }}" class="btn btn-light btn-sm px-3 shadow-sm text-primary fw-bold">
                <i class="bi bi-plus-lg me-1"></i> Add SMTP Configuration
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Host</th>
                                <th>Port</th>
                                <th>Username</th>
                                <th>Encryption</th>
                                <th>From Address</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($smtpSettings as $smtp)
                                <tr>
                                    <td class="fw-bold">{{ $smtp->host }}</td>
                                    <td>{{ $smtp->port }}</td>
                                    <td>{{ $smtp->username }}</td>
                                    <td>
                                        <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25">
                                            {{ strtoupper($smtp->encryption ?? 'none') }}
                                        </span>
                                    </td>
                                    <td>{{ $smtp->from_address }}</td>
                                    <td>
                                        <form action="{{ route('super_admin.smtp-settings.toggle', $smtp) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm {{ $smtp->is_active ? 'btn-success' : 'btn-secondary' }} px-3">
                                                <i class="bi bi-{{ $smtp->is_active ? 'check-circle-fill' : 'circle' }} me-1"></i>
                                                {{ $smtp->is_active ? 'Active' : 'Inactive' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex gap-2 justify-content-end">
                                            <a href="{{ route('super_admin.smtp-settings.edit', $smtp) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('super_admin.smtp-settings.destroy', $smtp) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this SMTP configuration?');" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox display-4 d-block mb-2"></i>
                                        No SMTP configurations added yet.
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
