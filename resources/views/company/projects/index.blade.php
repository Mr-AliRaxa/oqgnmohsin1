<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 text-white">
                {{ __('Projects') }}
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('company.projects.create') }}" class="btn btn-light btn-sm px-3 shadow-sm text-primary fw-bold">
                    <i class="bi bi-plus-lg me-1"></i> Create Project
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        {{-- Header & Actions --}}
        <div class="mb-4">
            <h3 class="h5 mb-1 text-muted text-uppercase small fw-bold" style="letter-spacing: 0.5px;">Project Management</h3>
            <p class="small text-muted mb-0">Track and manage your company projects and deliverables.</p>
        </div>

        {{-- Status Filters --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body py-2 px-3">
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <span class="small fw-bold text-uppercase text-muted me-2" style="font-size: 0.7rem; letter-spacing: 1px;">Filter By Status:</span>
                    <a href="{{ route('company.projects.index') }}" class="btn btn-sm {{ !request('status') ? 'btn-dark' : 'btn-outline-dark border-0' }} px-3 rounded-pill">
                        All
                    </a>
                    @foreach(\App\Models\Project::getStatuses() as $key => $label)
                        <a href="{{ route('company.projects.index', ['status' => $key]) }}" 
                           class="btn btn-sm {{ request('status') === $key ? 'btn-'.$key.' shadow-sm' : 'btn-outline-'.$key.' border-0' }} px-3 rounded-pill"
                           style="{{ request('status') === $key ? '' : 'color: var(--bs-'.$key.');' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Projects Table --}}
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light border-bottom text-muted small text-uppercase fw-bold">
                            <tr>
                                <th class="ps-4 py-3">Project Details</th>
                                <th class="py-3">Client</th>
                                <th class="py-3">Location</th>
                                <th class="py-3">Status</th>
                                <th class="py-3 text-center">Invoices</th>
                                <th class="py-3 text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($projects as $project)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark">{{ $project->name }}</div>
                                    <div class="small text-muted text-truncate" style="max-width: 250px;">{{ $project->subject }}</div>
                                </td>
                                <td>
                                    <div class="text-dark small fw-semibold">{{ $project->to_client }}</div>
                                </td>
                                <td>
                                    <div class="text-muted small"><i class="bi bi-geo-alt me-1"></i> {{ $project->location }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $project->status_color }} bg-opacity-10 text-{{ $project->status_color }} border border-{{ $project->status_color }} border-opacity-25 px-2 py-1">
                                        {{ $project->status_label }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('company.invoices.index', $project) }}" class="btn btn-sm btn-outline-success border-0 rounded-pill px-3">
                                        <i class="bi bi-file-earmark-text me-1"></i> View
                                    </a>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="{{ route('company.projects.show', $project) }}" class="btn btn-sm btn-outline-info border-0 rounded-circle" title="View Details">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('company.projects.edit', $project) }}" class="btn btn-sm btn-outline-warning border-0 rounded-circle" title="Edit Project">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('company.projects.destroy', $project) }}" method="POST" class="d-inline" onsubmit="return confirmDelete(event, 'Are you sure you want to delete project {{ $project->name }}? All invoices and related data will be removed.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger border-0 rounded-circle" title="Delete Project">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                                        <p class="mb-0">No projects found.</p>
                                        @if(request('status'))
                                            <a href="{{ route('company.projects.index') }}" class="small text-primary text-decoration-none">Clear filter</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        .btn-draft { background-color: #6c757d; color: white; }
        .btn-outline-draft { color: #6c757d; border-color: #6c757d; }
        .btn-continued { background-color: #0d6efd; color: white; }
        .btn-outline-continued { color: #0d6efd; border-color: #0d6efd; }
        .btn-stopped { background-color: #ffc107; color: #212529; }
        .btn-outline-stopped { color: #ffc107; border-color: #ffc107; }
        .btn-finished { background-color: #198754; color: white; }
        .btn-outline-finished { color: #198754; border-color: #198754; }
        .btn-cancelled { background-color: #dc3545; color: white; }
        .btn-outline-cancelled { color: #dc3545; border-color: #dc3545; }
        
        /* Tooltip-like behavior for filter buttons */
        .btn-sm.rounded-pill { font-size: 0.8rem; transition: all 0.2s ease; }
        .btn-sm.rounded-pill:hover { transform: translateY(-1px); }
    </style>
</x-app-layout>
