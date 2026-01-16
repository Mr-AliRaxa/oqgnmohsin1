<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 text-dark fw-bold">
                <i class="bi bi-chat-left-quote-fill text-primary me-2"></i> User Queries & Project Updates
            </h2>
            <span class="badge bg-primary rounded-pill px-3 py-2 shadow-sm">{{ $queries->total() }} Total Messages</span>
        </div>
    </x-slot>

    <div class="py-4">
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm border-0 overflow-hidden">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0 fw-bold">Recent Inquiries</h5>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-secondary small text-uppercase fw-bold">
                            <tr>
                                <th class="ps-4 border-0">Date</th>
                                <th class="border-0">Sender / Company</th>
                                <th class="border-0">Project</th>
                                <th class="border-0">Subject</th>
                                <th class="border-0" style="width: 30%;">Message</th>
                                <th class="border-0">Status</th>
                                <th class="text-end pe-4 border-0">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($queries as $query)
                                <tr class="{{ $query->status === 'pending' ? 'bg-primary bg-opacity-10' : '' }}">
                                    <td class="ps-4 small text-muted">
                                        {{ $query->created_at->format('d M, Y') }}<br>
                                        <span class="opacity-75">{{ $query->created_at->format('h:i A') }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle d-flex align-items-center justify-content-center fw-bold me-2" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                                {{ strtoupper(substr($query->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark mb-0 small">{{ $query->user->name }}</div>
                                                <div class="text-muted" style="font-size: 0.7rem;">{{ $query->company->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($query->project)
                                            <div class="badge bg-info bg-opacity-10 text-info fw-bold border-0">{{ $query->project->name }}</div>
                                        @else
                                            <span class="text-muted small italic">General Query</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $query->subject }}</div>
                                    </td>
                                    <td>
                                        <div class="text-muted small" title="{{ $query->message }}">
                                            {{ $query->message }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($query->status === 'pending')
                                            <span class="badge bg-warning text-dark border-0 rounded-pill px-3 fw-bold">
                                                <i class="bi bi-clock-fill me-1"></i> New
                                            </span>
                                        @else
                                            <span class="badge bg-success border-0 rounded-pill px-3 fw-bold">
                                                <i class="bi bi-check-all me-1"></i> Read
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        @if($query->status === 'pending')
                                            <form action="{{ route('super_admin.queries.mark-read', $query) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3 shadow-none">
                                                    Mark as Read
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn btn-sm btn-outline-secondary rounded-pill px-3 shadow-none" disabled>
                                                Archived
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted mb-3"><i class="bi bi-chat-square-text fs-1 opacity-25"></i></div>
                                        <h6 class="fw-bold">No queries found</h6>
                                        <p class="small text-muted mb-0">You're all caught up! New inquiries will appear here.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($queries->hasPages())
                    <div class="card-footer bg-white py-3">
                        {{ $queries->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
