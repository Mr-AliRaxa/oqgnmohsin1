<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 text-white">
                {{ __('Salary Payments') }}
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('company.salaries.create') }}" class="btn btn-light btn-sm px-3 shadow-sm text-primary fw-bold">
                    <i class="bi bi-plus-lg me-1"></i> Record Salary
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body py-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <form method="GET" action="{{ route('company.salaries.index') }}" class="row g-3 align-items-end">
                        <div class="col-auto">
                            <label for="team_member_id" class="form-label small fw-bold">Team Member</label>
                            <select id="team_member_id" name="team_member_id" class="form-select">
                                <option value="">All Members</option>
                                @foreach($teamMembers as $member)
                                    <option value="{{ $member->id }}" {{ request('team_member_id') == $member->id ? 'selected' : '' }}>
                                        {{ $member->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-auto">
                            <label for="from_date" class="form-label small fw-bold">From Date</label>
                            <input id="from_date" name="from_date" type="date" value="{{ request('from_date') }}" class="form-control" />
                        </div>
                         <div class="col-auto">
                            <label for="to_date" class="form-label small fw-bold">To Date</label>
                            <input id="to_date" name="to_date" type="date" value="{{ request('to_date') }}" class="form-control" />
                        </div>
                        <div class="col-auto">
                            <div class="d-flex align-items-center gap-2">
                                <button type="submit" class="btn btn-primary fw-bold">Filter</button>
                                <a href="{{ route('company.salaries.pdf', request()->query()) }}" class="btn btn-success fw-bold">
                                    Download PDF
                                </a>
                                 @if(request('team_member_id') || request('from_date') || request('to_date'))
                                     <a href="{{ route('company.salaries.index') }}" class="text-danger text-decoration-none border-bottom border-danger">Clear</a>
                                @endif
                            </div>
                        </div>
                    </form>
    
                </div>
            </div>
        </div>

    <style>
        @media print {
            .print\:block { display: block !important; }
            .print\:hidden { display: none !important; }
            .print\:shadow-none { box-shadow: none !important; }
            .print\:border { border-width: 1px !important; }
            
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
    
    <div class="print:a4-page">
         <!-- Print Header -->
        <div class="hidden print:block mb-8 text-center pt-8">
            <h1 class="text-2xl font-bold">{{ auth()->user()->company->name }}</h1>
            <h2 class="text-xl">Salary Report</h2>
            <p>Generated on: {{ now()->toFormattedDateString() }}</p>
            @if(request('from_date') || request('to_date'))
                <p>Period: {{ request('from_date') }} to {{ request('to_date') }}</p>
            @endif
            <hr class="my-4 border-gray-400">
        </div>

        <div class="card shadow-sm border-0 print:shadow-none print:bg-transparent">
            <div class="card-body print:p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle print:border print:text-dark">
                        <thead class="table-light text-muted small text-uppercase">
                            <tr>
                                <th class="ps-4">Date</th>
                                <th>Employee</th>
                                <th class="text-end">Amount</th>
                                <th class="text-end">Bonus</th>
                                <th class="text-end pe-4 d-print-none">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; $totalBonus = 0; @endphp
                            @foreach($salaries as $salary)
                            <tr>
                                <td class="ps-4">
                                    {{ \Carbon\Carbon::parse($salary->date)->format('d M Y') }}
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $salary->teamMember->name }}</div>
                                    <div class="text-muted small">{{ $salary->teamMember->designation }}</div>
                                </td>
                                <td class="text-end fw-bold text-dark">
                                    ${{ number_format($salary->amount, 2) }}
                                </td>
                                <td class="text-end text-success">
                                    {{ $salary->bonus > 0 ? '$' . number_format($salary->bonus, 2) : '-' }}
                                </td>
                                <td class="text-end pe-4 d-print-none">
                                    <div class="d-flex justify-content-end gap-2">
                                         <a href="{{ route('company.salaries.show', $salary) }}" class="text-primary" title="View Slip">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if($salary->slip_path)
                                            <a href="{{ asset('storage/' . $salary->slip_path) }}" target="_blank" class="text-secondary" title="Download Slip">
                                                <i class="bi bi-file-earmark-pdf"></i>
                                            </a>
                                        @endif
                                        <form action="{{ route('company.salaries.destroy', $salary) }}" method="POST" onsubmit="return confirmDelete(event, 'Are you sure you want to delete this salary record for {{ $salary->teamMember->name }}?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link p-0 text-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @php $total += $salary->amount; $totalBonus += $salary->bonus; @endphp
                            @endforeach
                        </tbody>
                        <tfoot class="table-light fw-bold">
                            <tr>
                                <td colspan="2" class="text-end px-6 py-4">Total:</td>
                                <td class="text-right px-6 py-4">${{ number_format($total, 2) }}</td>
                                <td class="text-right px-6 py-4">${{ number_format($totalBonus, 2) }}</td>
                                <td class="d-print-none"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
