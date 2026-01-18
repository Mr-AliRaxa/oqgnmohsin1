<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 font-weight-bold mb-0 text-white">
                Team Member: {{ $team->name }}
            </h2>
            <div class="d-flex gap-2 no-print">
                <a href="{{ route('company.teams.index') }}" class="btn btn-light btn-sm px-3 shadow-sm text-primary fw-bold">
                    <i class="bi bi-arrow-left me-1"></i> Back to List
                </a>
                <button onclick="window.print()" class="btn btn-light btn-sm px-3 shadow-sm text-primary fw-bold">
                    <i class="bi bi-printer-fill me-1"></i> Print Profile
                </button>
            </div>
        </div>
    </x-slot>

    <style>
        @media print {
            .no-print { display: none !important; }
            .a4-page {
                box-shadow: none !important;
                margin: 0 !important;
                width: 100% !important;
                padding: 10mm !important;
            }
            body { background: white !important; }
            header, nav { display: none !important; }
            @php $bg = auth()->user()->company->settings()->where('key', 'print_background')->first()?->value @endphp
            @if($bg)
            .a4-page::before {
                content: "";
                position: absolute;
                top: 0; left: 0; right: 0; bottom: 0;
                background-image: url('{{ asset('storage/' . $bg) }}');
                background-size: cover; background-position: center; background-repeat: no-repeat;
                opacity: 0.1; z-index: -1;
            }
            @endif
        }
        .a4-page {
            max-width: 210mm;
            min-height: 297mm;
            background: white;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
            position: relative;
            z-index: 1;
            margin: 2rem auto;
            border-radius: 8px;
        }
    </style>

    <div class="py-4">
        <div class="a4-page p-5 shadow-sm">
            <!-- Header Section -->
            <div class="d-flex justify-content-between align-items-start mb-5 border-bottom pb-4">
                <div>
                    @if($team->company->logo_path)
                        <img src="{{ asset('storage/' . $team->company->logo_path) }}" alt="Logo" class="mb-3" style="height: 60px;">
                    @else
                        <h3 class="fw-bold text-primary mb-1">{{ $team->company->name }}</h3>
                    @endif
                    <p class="small text-muted mb-0" style="max-width: 300px;">{{ $team->company->address }}</p>
                    <p class="small text-muted mb-0">Email: {{ $team->company->email }}</p>
                </div>
                <div class="text-end">
                    <h4 class="fw-bold text-uppercase text-secondary mb-1" style="letter-spacing: 1px;">Employee Profile</h4>
                    <p class="small text-muted mb-0">Generated: {{ now()->format('d M, Y') }}</p>
                </div>
            </div>

            <!-- Profile Info Section -->
            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <div class="text-center">
                        @if($team->image_path)
                            <img src="{{ asset('storage/' . $team->image_path) }}" alt="{{ $team->name }}" class="img-fluid rounded shadow-sm border border-light" style="max-height: 250px; width: 100%; object-fit: cover;">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted border" style="height: 250px;">
                                <div class="text-center">
                                    <i class="bi bi-person h1 d-block opacity-25"></i>
                                    <span class="small">No Photo</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-8">
                    <h2 class="fw-bold text-dark mb-4 border-bottom pb-2">{{ $team->name }}</h2>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label class="small fw-bold text-uppercase text-muted d-block" style="font-size: 0.65rem;">Designation</label>
                            <span class="text-dark">{{ $team->designation ?? 'N/A' }}</span>
                        </div>
                        <div class="col-sm-6">
                            <label class="small fw-bold text-uppercase text-muted d-block" style="font-size: 0.65rem;">Joining Date</label>
                            <span class="text-dark">{{ $team->created_at->format('d M, Y') }}</span>
                        </div>
                        <div class="col-sm-6">
                            <label class="small fw-bold text-uppercase text-muted d-block" style="font-size: 0.65rem;">Mobile Number</label>
                            <span class="text-dark">{{ $team->mobile ?? 'N/A' }}</span>
                        </div>
                        <div class="col-sm-6">
                            <label class="small fw-bold text-uppercase text-muted d-block" style="font-size: 0.65rem;">Nationality</label>
                            <span class="text-dark">{{ $team->nationality ?? 'N/A' }}</span>
                        </div>
                        <div class="col-sm-6">
                            <label class="small fw-bold text-uppercase text-muted d-block" style="font-size: 0.65rem;">ID / Passport No.</label>
                            <span class="text-dark">{{ $team->id_card_number ?? 'N/A' }}</span>
                        </div>
                        <div class="col-sm-6">
                            <label class="small fw-bold text-uppercase text-muted d-block" style="font-size: 0.65rem;">Basic Salary</label>
                            <span class="text-dark fw-bold text-success">${{ number_format($team->basic_salary, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Salary History Section -->
            @if($team->salaries && $team->salaries->count() > 0)
            <div class="mb-5">
                <h5 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-cash-stack me-2 text-primary"></i> Recent Salary History</h5>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered align-middle" style="font-size: 0.85rem;">
                        <thead class="bg-light text-secondary small text-uppercase fw-bold">
                            <tr>
                                <th>Payment Date</th>
                                <th class="text-end">Base Amount</th>
                                <th class="text-end">Bonus</th>
                                <th>Note / Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($team->salaries->take(10) as $salary)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($salary->date)->format('d M, Y') }}</td>
                                <td class="text-end fw-bold">${{ number_format($salary->amount, 2) }}</td>
                                <td class="text-end text-success">{{ $salary->bonus > 0 ? '$'.number_format($salary->bonus, 2) : '-' }}</td>
                                <td class="text-muted">{{ $salary->note }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- Signature Section -->
            <div class="mt-auto pt-5">
                <div class="row text-center mt-5">
                    <div class="col-4 border-top pt-2">
                        <p class="small text-muted mb-0">Authorized Signature</p>
                    </div>
                    <div class="col-4"></div>
                    <div class="col-4 border-top pt-2">
                        <p class="small text-muted mb-0">Employee Signature</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
