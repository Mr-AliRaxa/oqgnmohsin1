<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Project: {{ $project->subject }}</title>
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
                @if($bg = $project->company->settings()->where('key', 'print_background')->first()?->value)
                .a4-page::before {
                    content: "";
                    position: fixed; /* Fixed for repeating on pages */
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
            <a href="{{ route('company.projects.index') }}" class="text-primary text-decoration-none me-4">Back to Dashboard</a>
             <a href="{{ route('company.invoices.create', $project) }}" class="btn btn-success fw-bold me-2">
                Create Invoice
            </a>
            <button onclick="window.print()" class="btn btn-primary fw-bold">
                Print Project
            </button>
        </div>

        <div class="a4-page">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-start mb-5 border-bottom pb-4">
                <div>
                     @if($project->company->logo_path)
                        <img src="{{ asset('storage/' . $project->company->logo_path) }}" alt="Logo" class="mb-2" style="height: 64px;">
                    @else
                        <h1 class="h2 fw-bold">{{ $project->company->name }}</h1>
                    @endif
                    <p class="small text-muted mb-0" style="max-width: 300px;">{{ $project->company->address }}</p>
                    <p class="small text-muted">Email: {{ $project->company->email }}</p>
                </div>
                <div class="text-end">
                    <h2 class="h4 fw-bold text-uppercase text-secondary">Project Order</h2>
                    <p class="small text-muted mt-1">Date: {{ $project->created_at->format('d M, Y') }}</p>
                    <p class="small text-muted">Project ID: #{{ $project->id }}</p>
                </div>
            </div>

            <!-- Project Details -->
            <div class="row mb-5">
                <div class="col-6">
                    <h5 class="fw-bold text-secondary mb-2">Project Details:</h5>
                    <p class="mb-1"><span class="fw-semibold">Name:</span> {{ $project->name }}</p>
                    <p class="mb-1"><span class="fw-semibold">Location:</span> {{ $project->location }}</p>
                    <p class="mb-1"><span class="fw-semibold">Project By:</span> {{ $project->owner_name }}</p>
                    <p class="mt-2 small text-muted note-text" style="white-space: pre-line;">{{ $project->description }}</p>
                </div>
                <div class="col-6 text-end">
                    <h5 class="fw-bold text-secondary mb-2">To Client:</h5>
                    <div class="fs-5">{{ $project->to_client }}</div>
                    <div class="mt-3">
                        <h5 class="fw-bold text-secondary mb-1">Subject:</h5>
                        <div>{{ $project->subject }}</div>
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <table class="table table-bordered mb-5">
                <thead class="table-light">
                    <tr>
                        <th class="px-4 py-2">Description</th>
                        <th class="px-4 py-2 text-center" style="width: 80px;">UOM</th>
                        <th class="px-4 py-2 text-center" style="width: 80px;">Qty</th>
                        <th class="px-4 py-2 text-end" style="width: 120px;">Rate</th>
                        <th class="px-4 py-2 text-end" style="width: 120px;">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($project->items as $item)
                    <tr>
                        <td class="px-4 py-2">{{ $item->description }}</td>
                        <td class="px-4 py-2 text-center">{{ $item->uom }}</td>
                        <td class="px-4 py-2 text-center">{{ $item->quantity }}</td>
                        <td class="px-4 py-2 text-end">{{ number_format($item->rate, 2) }}</td>
                        <td class="px-4 py-2 text-end">{{ number_format($item->amount, 2) }}</td>
                    </tr>
                    @php $total += $item->amount; @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="fw-bold bg-light">
                        <td colspan="4" class="px-4 py-2 text-end">Total:</td>
                        <td class="px-4 py-2 text-end">{{ number_format($total, 2) }}</td>
                    </tr>
                </tfoot>
            </table>

            <!-- Terms -->
            @if($project->terms->count() > 0)
            <div class="mb-5">
                <h5 class="fw-bold text-secondary border-bottom pb-2 mb-3">Terms & Conditions:</h5>
                <ol class="small text-dark ps-3">
                    @foreach($project->terms as $term)
                        <li class="mb-1">{{ $term->term_text }}</li>
                    @endforeach
                </ol>
            </div>
            @endif

            <!-- Team (Optional to show in print) -->
            @if($project->teamMembers->count() > 0)
            <div class="mb-5">
                 <h5 class="fw-bold text-secondary border-bottom pb-2 mb-3">Assigned Team:</h5>
                 <div class="d-flex flex-wrap gap-3">
                     @foreach($project->teamMembers as $member)
                        <div class="d-flex align-items-center small text-dark">
                            <span class="fw-semibold">{{ $member->name }}</span>
                            <span class="text-muted ms-1">({{ $member->designation }})</span>
                        </div>
                     @endforeach
                 </div>
            </div>
            @endif

            <!-- Footer Signature Area -->
            <div class="mt-auto pt-5 d-flex justify-content-between text-muted small">
                <div class="text-center pt-2 border-top border-secondary" style="width: 30%;">
                    Authorized Signature
                </div>
                 <div class="text-center pt-2 border-top border-secondary" style="width: 30%;">
                    Client Acceptance
                </div>
            </div>

        </div>
    </body>
</html>
