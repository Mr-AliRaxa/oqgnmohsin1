<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 text-white">
                {{ __('Expenses') }}
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('company.expenses.create') }}" class="btn btn-light btn-sm px-3 shadow-sm text-primary fw-bold">
                    <i class="bi bi-plus-lg me-1"></i> Add Expense
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <form method="GET" action="{{ route('company.expenses.index') }}" class="row g-3 align-items-end">
                            <div class="col-auto">
                                <x-input-label for="from_date" :value="__('From Date')" />
                                <x-text-input id="from_date" name="from_date" type="date" value="{{ request('from_date') }}" class="form-control" />
                            </div>
                             <div class="col-auto">
                                <x-input-label for="to_date" :value="__('To Date')" />
                                <x-text-input id="to_date" name="to_date" type="date" value="{{ request('to_date') }}" class="form-control" />
                            </div>
                            <div class="col-auto">
                                <x-input-label for="type" :value="__('Type')" />
                                 <x-text-input id="type" name="type" type="text" value="{{ request('type') }}" placeholder="e.g. Travel" class="form-control" />
                            </div>
                            <div class="col-auto">
                                <div class="d-flex align-items-center gap-2">
                                    <x-primary-button>Filter</x-primary-button>
                                    
                                    <div class="dropdown">
                                        <button class="btn btn-success fw-bold dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Download
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{ route('company.expenses.pdf', request()->query()) }}">Download PDF</a></li>
                                            <li><a class="dropdown-item" href="{{ route('company.expenses.excel', request()->query()) }}">Download Excel</a></li>
                                        </ul>
                                    </div>

                                    @if(request()->has('type') || request()->has('from_date') || request()->has('to_date'))
                                         <a href="{{ route('company.expenses.index') }}" class="text-danger text-decoration-none border-bottom border-danger">Clear</a>
                                    @endif
                                </div>
                            </div>
                        </form>
        
                </div>
            </div>

    <style>
        @media print {
            .print-block { display: block !important; }
            .print-hidden { display: none !important; }
            .print-shadow-none { box-shadow: none !important; }
            .print-border { border-width: 1px !important; }
            .print-bg-transparent { background: transparent !important; }
            .print-p-0 { padding: 0 !important; }
            .print-text-dark { color: black !important; }
            
            body {
                background: white;
                -webkit-print-color-adjust: exact;
            }
            .a4-page {
                box-shadow: none;
                margin: 0;
                width: 100%;
            }
            @if($bg = auth()->user()->company->settings()->where('key', 'print_background')->first()?->value)
            .a4-page::before {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-image: url('{{ asset('storage/' . $bg) }}');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                opacity: 0.2;
                z-index: -1;
            }
            @endif
        }
        .a4-page {
            width: 210mm;
            min-height: 297mm;
            padding: 20mm;
            margin: 0 auto;
            background: white;
            position: relative;
            z-index: 10;
        }
    </style>
    
    <div class="print-a4-page">
        <!-- Print Header (Hidden by default, shown in print) -->
        <div class="d-none d-print-block mb-4 text-center pt-4">
            <h1 class="h3 fw-bold">{{ auth()->user()->company->name }}</h1>
            <h2 class="h4">Expense Report</h2>
            <p class="mb-0">Generated on: {{ now()->toFormattedDateString() }}</p>
            @if(request('from_date') || request('to_date'))
                <p>Period: {{ request('from_date') }} to {{ request('to_date') }}</p>
            @endif
            <hr class="my-3 border-dark">
        </div>

        <div class="card shadow-sm border-0 print-shadow-none print-bg-transparent">
            <div class="card-body print-p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle print-border print-text-dark">
                        <thead class="table-light">
                            <tr>
                                <th class="print-border">Date</th>
                                <th class="print-border">Type</th>
                                <th class="print-border">Note</th>
                                <th class="text-end print-border">Amount</th>
                                <th class="d-print-none">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach($expenses as $expense)
                            <tr class="print-border">
                                <td class="print-border text-dark">
                                    {{ \Carbon\Carbon::parse($expense->date)->format('d M Y') }}
                                </td>
                                <td class="print-border text-dark">
                                    {{ $expense->type }}
                                </td>
                                <td class="print-border text-dark">
                                    {{ $expense->note }}
                                </td>
                                <td class="text-end fw-bold text-dark print-border">
                                    ${{ number_format($expense->amount, 2) }}
                                </td>
                                <td class="d-print-none">
                                    <div class="d-flex gap-2">
                                         <a href="{{ route('company.expenses.show', $expense) }}" class="text-primary" title="View Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px;">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </a>
                                        @if($expense->receipt_path)
                                            <a href="{{ asset('storage/' . $expense->receipt_path) }}" target="_blank" class="text-secondary" title="View Receipt">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px;">
                                                  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                                </svg>
                                            </a>
                                        @endif
                                        <form action="{{ route('company.expenses.destroy', $expense) }}" method="POST" onsubmit="return confirmDelete(event, 'Are you sure you want to delete this expense record?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link p-0 text-danger" title="Delete">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px;">
                                                  <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @php $total += $expense->amount; @endphp
                            @endforeach
                        </tbody>
                         <tfoot>
                            <tr class="fw-bold bg-light">
                                <td colspan="3" class="text-end print-border">Total:</td>
                                <td class="text-end print-border">${{ number_format($total, 2) }}</td>
                                <td class="d-print-none"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
