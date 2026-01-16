<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index(Project $project)
    {
        if ($project->company_id !== auth()->user()->company_id) {
            abort(403);
        }
        $invoices = $project->invoices()->orderBy('date', 'desc')->get();
        return view('company.invoices.index', compact('project', 'invoices'));
    }

    public function create(Project $project)
    {
        // Ensure user owns project
        if ($project->company_id !== auth()->user()->company_id) {
            abort(403);
        }

        // 1. Prevent if Project is Finished
        if ($project->status === 'finished') {
             return redirect()->route('company.projects.index')
                ->with('error', 'Invoices cannot be created for finished projects.');
        }

        // 2. Prevent duplicate invoice for same month (Optional/Strict as per prompt)
        // Checks if an invoice exists for the current month and year for this project
        $currentMonthInvoice = $project->invoices()
            ->whereYear('date', now()->year)
            ->whereMonth('date', now()->month)
            ->exists();

        if ($currentMonthInvoice) {
             // We can either block or just warn. Prompt says "Prevent duplicate". 
             // Let's block for strict adherence, but maybe allow override if needed? 
             // For now, strict block for the current month.
             return redirect()->route('company.invoices.index', $project)
                 ->with('error', 'An invoice for this month already exists.');
        }

        // Generate Invoice Number (Unique per company)
        // Format: INV-YYYY-XXXX (Year-Increment)
        $year = now()->year;
        $latestInvoice = auth()->user()->company->invoices()
            ->where('invoice_number', 'like', "INV-{$year}-%")
            ->latest()
            ->first();
            
        if ($latestInvoice) {
             $parts = explode('-', $latestInvoice->invoice_number);
             $number = intval(end($parts)) + 1;
        } else {
            $number = 1;
        }
        
        $invoiceNumber = 'INV-' . $year . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);

        return view('company.invoices.create', compact('project', 'invoiceNumber'));
    }

    public function store(Request $request, Project $project)
    {
        if ($project->company_id !== auth()->user()->company_id) {
            abort(403);
        }

        $request->validate([
            'invoice_number' => 'required|string',
            'date' => 'required|date',
            'to_client' => 'required|string',
            'subject' => 'required|string',
            'subject' => 'required|string',
            'value_1' => 'nullable|string',
            'value_2' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.rate' => 'required|numeric|min:0',
        ]);
        
        // Double check for duplicate month to be safe on backend
        $exists = $project->invoices()
            ->whereYear('date', \Carbon\Carbon::parse($request->date)->year)
            ->whereMonth('date', \Carbon\Carbon::parse($request->date)->month)
            ->exists();
            
        if ($exists) {
             return back()->with('error', 'An invoice for this month (' . \Carbon\Carbon::parse($request->date)->format('F Y') . ') already exists.');
        }

        $invoice = DB::transaction(function () use ($request, $project) {
            $invoice = $project->invoices()->create([
                'company_id' => auth()->user()->company_id,
                'invoice_number' => $request->invoice_number,
                'date' => $request->date,
                'to_client' => $request->to_client,
                'subject' => $request->subject,
                'description' => $request->description,
                'value_1' => $request->value_1,
                'value_2' => $request->value_2,
                'status' => 'unpaid',
                'notes' => $request->notes,
            ]);

            foreach ($request->items as $item) {
                $invoice->items()->create([
                    'description' => $item['description'],
                    'uom' => $item['uom'] ?? null,
                    'quantity' => $item['quantity'],
                    'rate' => $item['rate'],
                    'amount' => $item['quantity'] * $item['rate'],
                ]);
            }
            
            if ($request->terms) {
                foreach ($request->terms as $term) {
                    if (!empty($term)) {
                        $invoice->terms()->create(['term_text' => $term]);
                    }
                }
            }
            
            return $invoice;
        });

        return redirect()->route('company.invoices.show', $invoice)->with('success', 'Invoice created successfully.');
    }

    public function show(Invoice $invoice)
    {
        if ($invoice->company_id !== auth()->user()->company_id) {
            abort(403);
        }
        $invoice->load(['items', 'terms', 'project']);
        return view('company.invoices.show', compact('invoice'));
    }
}
