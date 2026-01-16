<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Invoice: {{ $invoice->invoice_number }}</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <style>
             @media print {
                @page {
                    margin: 0;
                    size: A4;
                }
                body {
                    margin: 20mm; /* Simulate @page margin on body for content */
                    background: white;
                    -webkit-print-color-adjust: exact;
                }
                .no-print {
                    display: none;
                }
                /* Use fixed position for watermark to repeat on every page */
                .watermark-bg {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100vw;
                    height: 100vh;
                    z-index: -10;
                    pointer-events: none;
                    display: block !important;
                }
                .a4-page {
                    width: 100% !important;
                    min-height: 0 !important;
                    margin: 0 !important;
                    padding: 0 !important;
                    box-shadow: none !important;
                }
             }
             
            /* Screen Viewing Styles */
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
            /* Screen Watermark (handled via main wrapper or body in print, here shared) */
            @if($bg = auth()->user()->company->settings()->where('key', 'print_background')->first()?->value)
            .watermark-bg img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                opacity: 0.2;
            }
            /* For screen, we can just use the fixed one if we want, or absolute. 
               Let's reuse the fixed one but make sure it stays behind content. */
            @endif
        </style>
    </head>
    <body class="bg-light font-sans text-dark">
        
        <div class="no-print py-4 text-center">
            <a href="{{ route('company.invoices.index', $invoice->project) }}" class="text-primary text-decoration-none me-4">Back to Invoices</a>
            <button onclick="window.print()" class="btn btn-primary fw-bold">
                Print Invoice
            </button>
        </div>

        <!-- Watermark (Fixed for Print & Screen) -->
        @if($bg = auth()->user()->company->settings()->where('key', 'print_background')->first()?->value)
        <div class="watermark-bg" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; z-index: -10; pointer-events: none;">
            <img src="{{ asset('storage/' . $bg) }}" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.2;">
        </div>
        @endif

        <div class="a4-page">
            <div class="position-relative z-1 w-100"> <!-- Wrapper -->
            @php
                $settings = $invoice->company->settings->pluck('value', 'key');
                $pdfLogo = $settings['pdf_logo'] ?? null;
                $compEmail = $settings['company_email'] ?? $invoice->company->email;
            @endphp
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-start mb-5 border-bottom pb-4">
                <div>
                     @if($pdfLogo)
                        <img src="{{ asset('storage/' . $pdfLogo) }}" alt="Logo" class="mb-2" style="height: 64px;">
                     @elseif($invoice->company->logo_path)
                        <img src="{{ asset('storage/' . $invoice->company->logo_path) }}" alt="Logo" class="mb-2" style="height: 64px;">
                    @else
                        <h1 class="h2 fw-bold text-dark">{{ $invoice->company->name }}</h1>
                    @endif
                    <p class="small text-muted mb-0" style="max-width: 300px;">{{ $invoice->company->address }}</p>
                    <p class="small text-muted">Email: {{ $compEmail }}</p>
                </div>
                <div class="text-end">
                    <h2 class="h3 fw-bold text-uppercase text-secondary">INVOICE</h2>
                    <p class="lead fw-bold text-dark mt-1">{{ $invoice->invoice_number }}</p>
                    <p class="small text-muted">Date: {{ $invoice->date->format('d M, Y') }}</p>
                </div>
            </div>

            <!-- Details -->
            <div class="row mb-5">
                <div class="col-6">
                    <h6 class="fw-bold text-secondary text-uppercase mb-2">Bill To:</h6>
                    <div class="fs-5 fw-semibold text-dark">{{ $invoice->to_client }}</div>
                    <p class="small text-muted">{{ $invoice->project->location }}</p>
                </div>
                <div class="col-6 text-end">
                    <h6 class="fw-bold text-secondary text-uppercase mb-2">Project / Subject:</h6>
                    <div class="fs-5 fw-semibold text-dark">{{ $invoice->subject }}</div>
                    <div class="small text-muted">{{ $invoice->project->name }}</div>
                </div>
            </div>

            @if($invoice->value_1 || $invoice->value_2)
            <div class="row mb-4">
                @if($invoice->value_1)
                <div class="col-6">
                    <h6 class="fw-bold text-secondary text-uppercase mb-1">values 1:</h6>
                    <p class="small text-dark">{{ $invoice->value_1 }}</p>
                </div>
                @endif
                @if($invoice->value_2)
                <div class="col-6 text-end">
                    <h6 class="fw-bold text-secondary text-uppercase mb-1">value2:</h6>
                    <p class="small text-dark">{{ $invoice->value_2 }}</p>
                </div>
                @endif
            </div>
            @endif
            
            @if($invoice->description)
            <div class="mb-5">
                <p class="small text-dark text-break" style="white-space: pre-line;">{{ $invoice->description }}</p>
            </div>
            @endif

            <!-- Items Table -->
            <table class="table table-bordered mb-5 border-secondary">
                <thead class="table-light border-secondary">
                    <tr>
                        <th class="px-3 py-2 text-uppercase small fw-bold text-secondary">Description</th>
                        <th class="px-3 py-2 text-center text-uppercase small fw-bold text-secondary" style="width: 80px;">UOM</th>
                        <th class="px-3 py-2 text-center text-uppercase small fw-bold text-secondary" style="width: 80px;">Qty</th>
                        <th class="px-3 py-2 text-end text-uppercase small fw-bold text-secondary" style="width: 120px;">Rate</th>
                        <th class="px-3 py-2 text-end text-uppercase small fw-bold text-secondary" style="width: 140px;">Amount</th>
                    </tr>
                </thead>
                <tbody class="border-secondary">
                    @foreach($invoice->items as $item)
                    <tr>
                        <td class="px-3 py-2">{{ $item->description }}</td>
                        <td class="px-3 py-2 text-center small text-muted">{{ $item->uom }}</td>
                        <td class="px-3 py-2 text-center small text-muted">{{ $item->quantity }}</td>
                        <td class="px-3 py-2 text-end small text-muted">{{ number_format($item->rate, 2) }}</td>
                        <td class="px-3 py-2 text-end fw-medium">{{ number_format($item->amount, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="border-secondary">
                    <tr class="bg-light">
                        <td colspan="4" class="px-3 py-2 text-end fw-bold text-uppercase small">Total:</td>
                        <td class="px-3 py-2 text-end fw-bold fs-5">${{ number_format($invoice->total, 2) }}</td>
                    </tr>
                </tfoot>
            </table>

            <!-- Bank Details -->
            @if($invoice->company->bankDetails->count() > 0)
            <div class="mb-5">
                <h6 class="fw-bold text-secondary border-bottom border-secondary mb-3 pb-1 text-uppercase small">Bank Details:</h6>
                <table class="table table-sm table-bordered border-secondary small">
                    <thead class="table-light">
                        <tr>
                             <th>Bank Name</th>
                             <th>Account Name</th>
                             <th>Account Number</th>
                             <th>IBAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoice->company->bankDetails as $bank)
                        <tr>
                            <td>{{ $bank->bank_name }}</td>
                            <td>{{ $bank->account_name }}</td>
                            <td>{{ $bank->account_number }}</td>
                            <td>{{ $bank->iban }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            <!-- Terms -->
            @if($invoice->terms->count() > 0)
            <div class="mb-5">
                <h6 class="fw-bold text-secondary border-bottom border-secondary mb-3 pb-1 text-uppercase small">Terms & Conditions:</h6>
                <div class="small text-dark">
                    <ol class="ps-3 mb-0">
                        @foreach($invoice->terms as $term)
                            <li class="mb-1">{{ $term->term_text }}</li>
                        @endforeach
                    </ol>
                </div>
            </div>
            @endif

            <!-- Footer Signature Area -->
            <div class="mt-auto pt-5 d-flex justify-content-between small text-muted">
                <div class="text-center pt-2 border-top border-secondary" style="width: 30%;">
                    Authorized Signature
                </div>
                 <div class="text-center pt-2 border-top border-secondary" style="width: 30%;">
                    Client Acceptance
                </div>
            </div>

            </div> <!-- End content wrapper -->
        </div>
    <script>
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('print') === 'true') {
                window.print();
            }
        }
    </script>
    </body>
</html>
