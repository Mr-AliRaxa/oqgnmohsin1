<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = auth()->user()->company->expenses();

        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }
        if ($request->has('from_date') && $request->from_date) {
            $query->whereDate('date', '>=', $request->from_date);
        }
        if ($request->has('to_date') && $request->to_date) {
            $query->whereDate('date', '<=', $request->to_date);
        }

        $expenses = $query->latest()->get();
        return view('company.expenses.index', compact('expenses'));
    }

    public function downloadPDF(\Illuminate\Http\Request $request)
    {
        $query = auth()->user()->company->expenses();

        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }
        if ($request->has('from_date') && $request->from_date) {
            $query->whereDate('date', '>=', $request->from_date);
        }
        if ($request->has('to_date') && $request->to_date) {
            $query->whereDate('date', '<=', $request->to_date);
        }

        $expenses = $query->latest()->get();
        $company = auth()->user()->company;
        $settings = $company->settings->pluck('value', 'key');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('company.expenses.pdf', compact('expenses', 'company', 'settings'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('expense-report.pdf');
    }

    public function downloadExcel(\Illuminate\Http\Request $request)
    {
        $query = auth()->user()->company->expenses();

        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }
        if ($request->has('from_date') && $request->from_date) {
            $query->whereDate('date', '>=', $request->from_date);
        }
        if ($request->has('to_date') && $request->to_date) {
            $query->whereDate('date', '<=', $request->to_date);
        }

        $expenses = $query->latest()->get();

        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\ExpensesExport($expenses), 'expense-report.xlsx');
    }

    public function create()
    {
        $expenseTypes = auth()->user()->company->expenseTypes;
        return view('company.expenses.create', compact('expenseTypes'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'note' => 'nullable|string',
            'receipt' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
        ]);

        $receiptPath = null;
        if ($request->hasFile('receipt')) {
            $receiptPath = $request->file('receipt')->store('expenses', 'public');
        }

        auth()->user()->company->expenses()->create([
            'type' => $request->type,
            'date' => $request->date,
            'amount' => $request->amount,
            'note' => $request->note,
            'receipt_path' => $receiptPath,
        ]);

        return redirect()->route('company.expenses.index')->with('success', 'Expense created successfully.');
    }

    public function show(\App\Models\Expense $expense)
    {
        if ($expense->company_id !== auth()->user()->company_id) {
            abort(403);
        }
        return view('company.expenses.show', compact('expense'));
    }

    public function destroy(\App\Models\Expense $expense)
    {
        if ($expense->company_id !== auth()->user()->company_id) {
            abort(403);
        }
        // Optional: delete receipt file if exists
        // if ($expense->receipt_path) { Storage::disk('public')->delete($expense->receipt_path); }
        
        $expense->delete();
        return redirect()->route('company.expenses.index')->with('success', 'Expense deleted successfully.');
    }
}
