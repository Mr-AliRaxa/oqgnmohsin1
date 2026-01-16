<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Expense Report</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
            margin: 0;
            padding: 0;
            line-height: 1.4;
        }
        @page {
            size: A4 portrait;
            margin: 15mm;
        }
        .header {
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
            position: relative;
        }
        .header-content {
            width: 100%;
        }
        .header-logo {
            text-align: right;
            vertical-align: top;
        }
        .header-text {
            text-align: left;
            vertical-align: top;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            color: #000;
        }
        .header p {
            margin: 2px 0 0;
            font-size: 11px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .report-info {
            margin-bottom: 25px;
            background-color: #fcfcfc;
            padding: 10px;
            border-radius: 4px;
        }
        .report-info table {
            width: 100%;
        }
        .report-info td {
            padding: 2px 0;
            font-size: 10px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            table-layout: fixed;
        }
        .table thead {
            display: table-header-group;
        }
        .table tfoot {
            display: table-footer-group;
        }
        .table tr {
            page-break-inside: avoid;
        }
        .table th {
            background-color: #343a40;
            color: #ffffff;
            border: 1px solid #dee2e6;
            padding: 10px 8px;
            text-align: left;
            text-transform: uppercase;
            font-size: 9px;
            font-weight: bold;
        }
        .table td {
            border: 1px solid #dee2e6;
            padding: 10px 8px;
            vertical-align: middle;
            word-wrap: break-word;
        }
        .table tbody tr:nth-child(even) {
            background-color: #fdfdfd;
        }
        .table tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }
        .text-right {
            text-align: right;
        }
        .font-bold {
            font-weight: bold;
        }
        .footer {
            position: fixed;
            bottom: -5mm;
            left: 0;
            right: 0;
            height: 10mm;
            text-align: center;
            font-size: 9px;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 5px;
        }
        .footer .page-number:after {
            content: "Page " counter(page);
        }
        .total-row {
            background-color: #f8f9fa !important;
            font-size: 12px;
        }
    </style>
</head>
<body>
    @if(isset($settings['print_background']))
        <div id="background" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1000; opacity: 0.1;">
            <img src="{{ public_path('storage/' . $settings['print_background']) }}" style="width: 100%; height: 100%;">
        </div>
    @endif

    <div class="header">
        <table class="header-content">
            <tr>
                <td class="header-text">
                    <h1>{{ $company->name }}</h1>
                    <p style="margin-top: 5px;">Expense Report</p>
                    <div style="font-size: 10px; color: #666; margin-top: 5px;">
                        Email: {{ $settings['company_email'] ?? $company->email }}<br>
                        Generated: {{ now()->format('d M Y') }}
                    </div>
                </td>
                <td class="header-logo">
                    @php
                        $pdfLogo = $settings['pdf_logo'] ?? null;
                        $globalLogo = \App\Models\GlobalSetting::where('key', 'global_logo')->first()?->value;
                    @endphp
                    @if($pdfLogo)
                        <img src="{{ public_path('storage/' . $pdfLogo) }}" style="max-height: 70px; width: auto;">
                    @elseif($company->logo_path)
                        <img src="{{ public_path('storage/' . $company->logo_path) }}" style="max-height: 70px; width: auto;">
                    @elseif($globalLogo)
                        <img src="{{ public_path('storage/' . $globalLogo) }}" style="max-height: 60px; width: auto;">
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="report-info">
        <table style="width: 100%;">
            <tr>
                <td width="33%"><strong>Date Generated:</strong> {{ now()->format('d M Y, h:i A') }}</td>
                <td width="33%" style="text-align: center;"><strong>By:</strong> {{ auth()->user()->name }}</td>
                <td width="33%" class="text-right">
                    @if(request('from_date') || request('to_date'))
                        <strong>Period:</strong> {{ request('from_date' , 'Start') }} - {{ request('to_date', 'End') }}
                    @else
                        <strong>Period:</strong> All Time
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th width="15%">Date</th>
                <th width="20%">Category</th>
                <th width="45%">Note / Description</th>
                <th width="20%" class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($expenses as $expense)
                @php $total += $expense->amount; @endphp
                <tr>
                    <td>{{ \Carbon\Carbon::parse($expense->date)->format('d M Y') }}</td>
                    <td>{{ $expense->type }}</td>
                    <td>{{ $expense->note ?? '-' }}</td>
                    <td class="text-right font-bold">${{ number_format($expense->amount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="font-bold total-row">
                <td colspan="3" class="text-right">GRAND TOTAL:</td>
                <td class="text-right">${{ number_format($total, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <table style="width: 100%;">
            <tr>
                <td style="text-align: left; width: 33%;">{{ $company->name }}</td>
                <td style="text-align: center; width: 34%;" class="page-number"></td>
                <td style="text-align: right; width: 33%;">Generated by {{ config('app.name') }}</td>
            </tr>
        </table>
    </div>
</body>
</html>
