<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Expense: {{ $expense->type }} - {{ $expense->date->format('d M Y') }}</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <style>
             @media print {
                body {
                    background: white;
                    -webkit-print-color-adjust: exact;
                }
                .no-print {
                    display: none;
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
                margin: 10mm auto;
                background: white;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
                position: relative;
                z-index: 10;
            }
        </style>
    </head>
    <body class="bg-light font-sans text-dark">
        
        <div class="no-print py-4 text-center">
            <a href="{{ route('company.expenses.index') }}" class="text-primary text-decoration-none me-4">Back to Expenses</a>
            <button onclick="window.print()" class="btn btn-primary fw-bold">
                Print Vouchar
            </button>
        </div>

        <div class="a4-page">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-start mb-5 border-bottom pb-4">
                <div>
                     @if($expense->company->logo_path)
                        <img src="{{ asset('storage/' . $expense->company->logo_path) }}" alt="Logo" class="mb-2" style="height: 64px;">
                    @else
                        <h1 class="h2 fw-bold text-dark">{{ $expense->company->name }}</h1>
                    @endif
                    <p class="small text-muted mb-0" style="max-width: 300px;">{{ $expense->company->address }}</p>
                    <p class="small text-muted">Email: {{ $expense->company->email }}</p>
                </div>
                <div class="text-end">
                    <h2 class="h3 fw-bold text-uppercase text-secondary">EXPENSE VOUCHER</h2>
                    <p class="small text-muted mt-1">ID: #EXP-{{ $expense->id }}</p>
                    <p class="small text-muted">Date: {{ $expense->date->format('d M, Y') }}</p>
                </div>
            </div>

            <!-- Expense Details -->
            <div class="mb-5 border rounded p-4">
                <div class="row mb-4">
                    <div class="col-6">
                        <span class="d-block small fw-bold text-secondary text-uppercase mb-1">Expense Type</span>
                        <span class="d-block fs-5 text-dark">{{ $expense->type }}</span>
                    </div>
                    <div class="col-6 text-end">
                        <span class="d-block small fw-bold text-secondary text-uppercase mb-1">Amount</span>
                        <span class="d-block h3 fw-bold text-dark">${{ number_format($expense->amount, 2) }}</span>
                    </div>
                </div>
                
                <div class="mb-2">
                    <span class="d-block small fw-bold text-secondary text-uppercase mb-1">Description / Note</span>
                    <p class="text-dark bg-light p-3 rounded border border-light-subtle" style="white-space: pre-line; min-height: 100px;">{{ $expense->note ?: 'N/A' }}</p>
                </div>
            </div>

            <!-- Receipt Image -->
            @if($expense->receipt_path)
            <div class="mb-5">
                <h6 class="fw-bold text-secondary border-bottom pb-2 mb-3 text-uppercase small">Attached Receipt</h6>
                <div class="d-flex justify-content-center">
                    <img src="{{ asset('storage/' . $expense->receipt_path) }}" alt="Receipt" class="img-fluid border rounded shadow-sm" style="max-height: 500px;">
                </div>
            </div>
            @endif

            <!-- Footer Signature Area -->
            <div class="mt-auto pt-5 d-flex justify-content-between small text-muted">
                <div class="text-center pt-2 border-top border-secondary" style="width: 30%;">
                    Submitted By
                </div>
                <div class="text-center pt-2 border-top border-secondary" style="width: 30%;">
                    Approved By
                </div>
            </div>

        </div>
    </body>
</html>
