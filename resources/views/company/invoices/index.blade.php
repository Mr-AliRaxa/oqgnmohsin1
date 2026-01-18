<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 text-white">
                {{ __('Invoices: ') }} {{ $project->name }}
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('company.projects.index') }}" class="btn btn-light btn-sm px-3 shadow-sm text-primary fw-bold">
                    <i class="bi bi-arrow-left me-1"></i> Projects
                </a>
                @if($project->status !== 'finished')
                    <a href="{{ route('company.invoices.create', $project) }}" class="btn btn-light btn-sm px-3 shadow-sm text-primary fw-bold">
                        <i class="bi bi-plus-lg me-1"></i> Create Invoice
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-4">

        @if(session('error'))
            <div class="alert alert-danger mb-4" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Invoice #</th>
                                <th>Month</th>
                                <th>Date</th>
                                <th>To Client</th>
                                <th class="text-end">Amount</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($invoices as $invoice)
                            <tr>
                                <td class="fw-bold text-dark">
                                    {{ $invoice->invoice_number }}
                                </td>
                                <td>{{ $invoice->date->format('F Y') }}</td>
                                <td>{{ $invoice->date->format('d M Y') }}</td>
                                <td>{{ $invoice->to_client }}</td>
                                <td class="text-end fw-bold">
                                    ${{ number_format($invoice->total, 2) }}
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('company.invoices.show', $invoice) }}" class="text-primary" title="View">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px;">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </a>
                                        <button onclick="window.open('{{ route('company.invoices.show', $invoice) }}?print=true', '_blank')" class="btn btn-link p-0 text-secondary" title="Print">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px;">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 001.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">No invoices found for this project.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
