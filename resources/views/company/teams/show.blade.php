<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Team Member: {{ $team->name }}</title>
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
            <a href="{{ route('company.teams.index') }}" class="text-blue-600 hover:underline mr-4">Back to Team List</a>
            <button onclick="window.print()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Print Profile
            </button>
        </div>

        <div class="a4-page">
            <!-- Header -->
            <div class="flex justify-between items-start mb-8 border-b pb-4">
                <div>
                     @if($team->company->logo_path)
                        <img src="{{ asset('storage/' . $team->company->logo_path) }}" alt="Logo" class="h-16 mb-2">
                    @else
                        <h1 class="text-2xl font-bold">{{ $team->company->name }}</h1>
                    @endif
                    <p class="text-sm text-gray-600 max-w-xs">{{ $team->company->address }}</p>
                    <p class="text-sm text-gray-600">Email: {{ $team->company->email }}</p>
                </div>
                <div class="text-right">
                    <h2 class="text-2xl font-bold uppercase tracking-wide text-gray-700">EMPLOYEE PROFILE</h2>
                    <p class="text-sm text-gray-600 mt-1">Generated: {{ now()->format('d M, Y') }}</p>
                </div>
            </div>

            <!-- Profile Info -->
            <div class="flex gap-8 mb-8">
                <div class="w-1/3">
                    @if($team->image_path)
                        <img src="{{ asset('storage/' . $team->image_path) }}" alt="{{ $team->name }}" class="w-full rounded-lg shadow-md border border-gray-200">
                    @else
                        <div class="w-full h-48 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500">
                            No Photo
                        </div>
                    @endif
                </div>
                <div class="w-2/3">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $team->name }}</h1>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div class="border-b border-gray-200 py-2">
                            <span class="font-semibold text-gray-600 block">Designation:</span>
                            {{ $team->designation ?? 'N/A' }}
                        </div>
                         <div class="border-b border-gray-200 py-2">
                            <span class="font-semibold text-gray-600 block">Date of Joining:</span>
                            {{ $team->created_at->format('d M, Y') }}
                        </div>
                        <div class="border-b border-gray-200 py-2">
                            <span class="font-semibold text-gray-600 block">Mobile:</span>
                            {{ $team->mobile ?? 'N/A' }}
                        </div>
                        <div class="border-b border-gray-200 py-2">
                            <span class="font-semibold text-gray-600 block">Nationality:</span>
                            {{ $team->nationality ?? 'N/A' }}
                        </div>
                        <div class="border-b border-gray-200 py-2">
                            <span class="font-semibold text-gray-600 block">ID / Passport Number:</span>
                            {{ $team->id_card_number ?? 'N/A' }}
                        </div>
                        <div class="border-b border-gray-200 py-2">
                            <span class="font-semibold text-gray-600 block">Basic Salary:</span>
                             ${{ number_format($team->basic_salary, 2) }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Salary History (Optional, good for profile view) -->
            @if($team->salaries && $team->salaries->count() > 0)
            <div class="mt-8">
                <h3 class="font-bold text-gray-700 border-b border-gray-300 mb-4 pb-2 text-lg">Recent Salary History</h3>
                <table class="w-full text-sm text-left border-collapse border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border border-gray-300 px-4 py-2">Date</th>
                            <th class="border border-gray-300 px-4 py-2 text-right">Amount</th>
                            <th class="border border-gray-300 px-4 py-2 text-right">Bonus</th>
                            <th class="border border-gray-300 px-4 py-2">Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($team->salaries->take(10) as $salary)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">{{ \Carbon\Carbon::parse($salary->date)->format('d M, Y') }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-right">${{ number_format($salary->amount, 2) }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-right">{{ $salary->bonus > 0 ? '$'.number_format($salary->bonus, 2) : '-' }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $salary->note }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            <!-- Footer Signature Area -->
            <div class="mt-auto pt-16 flex justify-between text-sm text-gray-600">
                <div class="w-1/3 border-t border-gray-400 pt-2 text-center">
                    Authorized Signature
                </div>
                 <div class="w-1/3 border-t border-gray-400 pt-2 text-center">
                    Employee Signature
                </div>
            </div>

        </div>
    </body>
</html>
