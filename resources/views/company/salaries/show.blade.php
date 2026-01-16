<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Salary Slip: {{ $salary->teamMember->name }} - {{ $salary->date->format('M Y') }}</title>
        <script src="https://cdn.tailwindcss.com"></script>
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
    <body class="bg-gray-100 font-sans antialiased text-gray-900">
        
        <div class="no-print py-4 text-center">
            <a href="{{ route('company.salaries.index') }}" class="text-blue-600 hover:underline mr-4">Back to Salaries</a>
            <button onclick="window.print()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Print Slip
            </button>
        </div>

        <div class="a4-page">
            <!-- Header -->
            <div class="flex justify-between items-start mb-8 border-b pb-4">
                <div>
                     @if($salary->company->logo_path)
                        <img src="{{ asset('storage/' . $salary->company->logo_path) }}" alt="Logo" class="h-16 mb-2">
                    @else
                        <h1 class="text-2xl font-bold">{{ $salary->company->name }}</h1>
                    @endif
                    <p class="text-sm text-gray-600 max-w-xs">{{ $salary->company->address }}</p>
                </div>
                <div class="text-right">
                    <h2 class="text-2xl font-bold uppercase tracking-wide text-gray-700">SALARY SLIP</h2>
                    <p class="text-sm text-gray-600 mt-1">Ref: #SAL-{{ $salary->id }}</p>
                    <p class="text-sm text-gray-600">Date: {{ $salary->date->format('d M, Y') }}</p>
                </div>
            </div>

            <!-- Employee Info -->
            <div class="mb-8 bg-gray-50 border border-gray-200 p-4 rounded">
                 <h3 class="font-bold text-gray-700 mb-2 uppercase text-sm">Employee Details</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <span class="block text-xs text-gray-500 uppercase">Name</span>
                        <span class="font-semibold text-lg">{{ $salary->teamMember->name }}</span>
                    </div>
                     <div>
                        <span class="block text-xs text-gray-500 uppercase">Designation</span>
                        <span class="font-semibold">{{ $salary->teamMember->designation }}</span>
                    </div>
                    <div>
                        <span class="block text-xs text-gray-500 uppercase">ID Number</span>
                        <span class="font-semibold">{{ $salary->teamMember->id_card_number ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>

            <!-- Salary Details -->
            <div class="mb-8">
                <table class="w-full border-collapse border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border border-gray-300 px-4 py-2 text-left">Description</th>
                            <th class="border border-gray-300 px-4 py-2 text-right w-40">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border border-gray-300 px-4 py-3">Basic Salary / Payment</td>
                            <td class="border border-gray-300 px-4 py-3 text-right font-semibold">${{ number_format($salary->amount, 2) }}</td>
                        </tr>
                        @if($salary->bonus > 0)
                        <tr>
                            <td class="border border-gray-300 px-4 py-3">Bonus / Incentive</td>
                            <td class="border border-gray-300 px-4 py-3 text-right font-semibold text-green-600">+ ${{ number_format($salary->bonus, 2) }}</td>
                        </tr>
                        @endif
                         <tr class="bg-gray-50">
                            <td class="border border-gray-300 px-4 py-3 font-bold text-right uppercase">Total Payable</td>
                            <td class="border border-gray-300 px-4 py-3 text-right font-bold text-xl">${{ number_format($salary->amount + $salary->bonus, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            @if($salary->note)
            <div class="mb-6">
                <span class="block text-sm font-bold text-gray-600 uppercase mb-1">Notes</span>
                <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded border border-gray-200">{{ $salary->note }}</p>
            </div>
            @endif

            <!-- Attachment Image -->
            @if($salary->slip_path)
            <div class="mb-8">
                <h3 class="font-bold text-gray-700 border-b border-gray-300 mb-4 pb-2 text-sm uppercase">Attached Document</h3>
                <div class="flex justify-center">
                    <img src="{{ asset('storage/' . $salary->slip_path) }}" alt="Slip" class="max-w-full max-h-[400px] border rounded shadow-sm">
                </div>
            </div>
            @endif

            <!-- Footer Signature Area -->
            <div class="mt-auto pt-16 flex justify-between text-sm text-gray-600">
                <div class="w-1/3 border-t border-gray-400 pt-2 text-center">
                    Employer Signature
                </div>
                <div class="w-1/3 border-t border-gray-400 pt-2 text-center">
                    Employee Signature
                </div>
            </div>

        </div>
    </body>
</html>
