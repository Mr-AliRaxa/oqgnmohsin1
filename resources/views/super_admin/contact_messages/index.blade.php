<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 text-dark fw-bold">
                <i class="bi bi-envelope-paper-fill text-primary me-2"></i> Public Contact Messages
            </h2>
            <span class="badge bg-primary rounded-pill px-3 py-2 shadow-sm">{{ $messages->total() }} Total Inquiries</span>
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
                            <h5 class="mb-0 fw-bold">Recent Messages</h5>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-secondary small text-uppercase fw-bold">
                            <tr>
                                <th class="ps-4 border-0">Received</th>
                                <th class="border-0">Sender Details</th>
                                <th class="border-0">Subject</th>
                                <th class="border-0" style="width: 35%;">Message</th>
                                <th class="border-0">Status</th>
                                <th class="text-end pe-4 border-0">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($messages as $msg)
                                <tr class="{{ $msg->status === 'new' ? 'bg-primary bg-opacity-10' : '' }}">
                                    <td class="ps-4 small text-muted">
                                        {{ $msg->created_at->format('d M, Y') }}<br>
                                        <span class="opacity-75">{{ $msg->created_at->format('h:i A') }}</span>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $msg->first_name }} {{ $msg->last_name }}</div>
                                        <div class="text-muted small"><i class="bi bi-envelope me-1"></i> {{ $msg->email }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $msg->subject }}</div>
                                    </td>
                                    <td>
                                        <div class="text-muted small" title="{{ $msg->message }}">
                                            {{ $msg->message }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($msg->status === 'new')
                                            <span class="badge bg-warning text-dark border-0 rounded-pill px-3 fw-bold">
                                                <i class="bi bi-star-fill me-1"></i> New
                                            </span>
                                        @elseif($msg->status === 'read')
                                            <span class="badge bg-info text-white border-0 rounded-pill px-3 fw-bold">
                                                <i class="bi bi-check-circle-fill me-1"></i> Read
                                            </span>
                                        @else
                                            <span class="badge bg-success border-0 rounded-pill px-3 fw-bold">
                                                <i class="bi bi-reply-fill me-1"></i> Replied
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="dropdown">
                                            <button class="btn btn-light btn-sm rounded-circle border-0 shadow-none" type="button" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg">
                                                @if($msg->status !== 'read')
                                                <li>
                                                    <form action="{{ route('super_admin.contact-messages.update-status', $msg) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="read">
                                                        <button type="submit" class="dropdown-item py-2"><i class="bi bi-check2 me-2"></i> Mark as Read</button>
                                                    </form>
                                                </li>
                                                @endif
                                                @if($msg->status !== 'replied')
                                                <li>
                                                    <form action="{{ route('super_admin.contact-messages.update-status', $msg) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="replied">
                                                        <button type="submit" class="dropdown-item py-2"><i class="bi bi-reply me-2"></i> Mark as Replied</button>
                                                    </form>
                                                </li>
                                                @endif
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('super_admin.contact-messages.destroy', $msg) }}" method="POST" onsubmit="return confirm('Delete this message permanently?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item py-2 text-danger"><i class="bi bi-trash me-2"></i> Delete</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted mb-3"><i class="bi bi-envelope-x fs-1 opacity-25"></i></div>
                                        <h6 class="fw-bold">No messages yet</h6>
                                        <p class="small text-muted mb-0">Public inquiries will appear here as soon as they are submitted.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($messages->hasPages())
                    <div class="card-footer bg-white py-3">
                        {{ $messages->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
