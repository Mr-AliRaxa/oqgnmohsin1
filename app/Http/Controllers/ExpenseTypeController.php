<?php

namespace App\Http\Controllers;

use App\Models\ExpenseType;
use Illuminate\Http\Request;

class ExpenseTypeController extends Controller
{
    public function index()
    {
        $expenseTypes = auth()->user()->company->expenseTypes;
        return view('company.settings.expense_types.index', compact('expenseTypes'));
    }

    public function create()
    {
        return view('company.settings.expense_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        auth()->user()->company->expenseTypes()->create($request->all());

        return redirect()->route('company.settings.expense_types.index')
            ->with('success', 'Expense Type added successfully.');
    }

    public function edit(ExpenseType $expenseType)
    {
        if ($expenseType->company_id !== auth()->user()->company_id) {
            abort(403);
        }
        return view('company.settings.expense_types.edit', compact('expenseType'));
    }

    public function update(Request $request, ExpenseType $expenseType)
    {
        if ($expenseType->company_id !== auth()->user()->company_id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $expenseType->update($request->all());

        return redirect()->route('company.settings.expense_types.index')
            ->with('success', 'Expense Type updated successfully.');
    }

    public function destroy(ExpenseType $expenseType)
    {
        if ($expenseType->company_id !== auth()->user()->company_id) {
            abort(403);
        }

        $expenseType->delete();

        return redirect()->route('company.settings.expense_types.index')
            ->with('success', 'Expense Type deleted successfully.');
    }
}
