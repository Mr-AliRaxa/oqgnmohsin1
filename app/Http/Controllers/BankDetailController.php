<?php

namespace App\Http\Controllers;

use App\Models\BankDetail;
use Illuminate\Http\Request;

class BankDetailController extends Controller
{
    public function index()
    {
        $bankDetails = auth()->user()->company->bankDetails;
        return view('company.settings.bank_details.index', compact('bankDetails'));
    }

    public function create()
    {
        return view('company.settings.bank_details.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'iban' => 'required|string|max:255',
        ]);

        auth()->user()->company->bankDetails()->create($request->all());

        return redirect()->route('company.settings.bank_details.index')
            ->with('success', 'Bank detail added successfully.');
    }

    public function edit(BankDetail $bankDetail)
    {
        if ($bankDetail->company_id !== auth()->user()->company_id) {
            abort(403);
        }
        return view('company.settings.bank_details.edit', compact('bankDetail'));
    }

    public function update(Request $request, BankDetail $bankDetail)
    {
        if ($bankDetail->company_id !== auth()->user()->company_id) {
            abort(403);
        }

        $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'iban' => 'required|string|max:255',
        ]);

        $bankDetail->update($request->all());

        return redirect()->route('company.settings.bank_details.index')
            ->with('success', 'Bank detail updated successfully.');
    }

    public function destroy(BankDetail $bankDetail)
    {
        if ($bankDetail->company_id !== auth()->user()->company_id) {
            abort(403);
        }

        $bankDetail->delete();

        return redirect()->route('company.settings.bank_details.index')
            ->with('success', 'Bank detail deleted successfully.');
    }
}
