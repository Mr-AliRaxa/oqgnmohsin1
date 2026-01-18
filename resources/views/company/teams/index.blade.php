<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 text-white">
                {{ __('Team Management') }}
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('company.teams.create') }}" class="btn btn-light btn-sm px-3 shadow-sm text-primary fw-bold">
                    <i class="bi bi-person-plus-fill me-1"></i> Add Member
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-secondary small text-uppercase fw-bold">
                            <tr>
                                <th class="ps-4 py-3">Member Name</th>
                                <th class="py-3">Designation</th>
                                <th class="py-3">Mobile</th>
                                <th class="py-3 text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($teams as $team)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        @if($team->image_path)
                                            <img src="{{ asset('storage/' . $team->image_path) }}" alt="" class="rounded-circle me-3" style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded-circle me-3 d-flex align-items-center justify-content-center text-muted border" style="width: 40px; height: 40px;">
                                                <i class="bi bi-person"></i>
                                            </div>
                                        @endif
                                        <div class="fw-bold text-dark">{{ $team->name }}</div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-secondary small">{{ $team->designation }}</span>
                                </td>
                                <td>
                                    <span class="text-secondary small"><i class="bi bi-phone me-1"></i> {{ $team->mobile }}</span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="{{ route('company.teams.show', $team) }}" class="btn btn-sm btn-outline-info border-0 rounded-circle" title="View Profile">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('company.teams.edit', $team) }}" class="btn btn-sm btn-outline-warning border-0 rounded-circle" title="Edit Member">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('company.teams.destroy', $team) }}" method="POST" class="d-inline" onsubmit="return confirmDelete(event, 'Are you sure you want to delete {{ $team->name }}? This will remove all their data.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger border-0 rounded-circle" title="Delete Member">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-people fs-1 d-block mb-3 opacity-25"></i>
                                        <p class="mb-0">No team members found.</p>
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
</x-app-layout>
