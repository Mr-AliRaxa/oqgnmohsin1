<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = auth()->user()->company->salaries()->with('teamMember');

        if ($request->has('team_member_id') && $request->team_member_id) {
            $query->where('team_member_id', $request->team_member_id);
        }
        if ($request->has('from_date') && $request->from_date) {
            $query->whereDate('date', '>=', $request->from_date);
        }
        if ($request->has('to_date') && $request->to_date) {
            $query->whereDate('date', '<=', $request->to_date);
        }

        $salaries = $query->latest()->get();
        $teamMembers = auth()->user()->company->teams; // For filter dropdown

        return view('company.salaries.index', compact('salaries', 'teamMembers'));
    }

    public function downloadPDF(\Illuminate\Http\Request $request)
    {
        $query = auth()->user()->company->salaries()->with('teamMember');

        if ($request->has('team_member_id') && $request->team_member_id) {
            $query->where('team_member_id', $request->team_member_id);
        }
        if ($request->has('from_date') && $request->from_date) {
            $query->whereDate('date', '>=', $request->from_date);
        }
        if ($request->has('to_date') && $request->to_date) {
            $query->whereDate('date', '<=', $request->to_date);
        }

        $salaries = $query->latest()->get();
        $company = auth()->user()->company;
        $settings = $company->settings->pluck('value', 'key');
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('company.salaries.pdf', compact('salaries', 'company', 'settings'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('salary-report.pdf');
    }

    public function create()
    {
        $teamMembers = auth()->user()->company->teams;
        return view('company.salaries.create', compact('teamMembers'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'team_member_id' => 'required|exists:teams,id',
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'note' => 'nullable|string',
            'slip' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
        ]);

        // Verify team member belongs to company
        $teamMember = \App\Models\Team::where('company_id', auth()->user()->company_id)->findOrFail($request->team_member_id);

        $slipPath = null;
        if ($request->hasFile('slip')) {
            $slipPath = $request->file('slip')->store('salaries', 'public');
        }

        auth()->user()->company->salaries()->create([
            'team_member_id' => $teamMember->id,
            'date' => $request->date,
            'amount' => $request->amount,
            'bonus' => $request->bonus ?? 0,
            'note' => $request->note,
            'slip_path' => $slipPath,
        ]);

        return redirect()->route('company.salaries.index')->with('success', 'Salary recorded successfully.');
    }

    public function show(\App\Models\Salary $salary)
    {
        if ($salary->company_id !== auth()->user()->company_id) {
            abort(403);
        }
        $salary->load('teamMember');
        return view('company.salaries.show', compact('salary'));
    }

    public function destroy(\App\Models\Salary $salary)
    {
        if ($salary->company_id !== auth()->user()->company_id) {
            abort(403);
        }
        $salary->delete();
        return redirect()->route('company.salaries.index')->with('success', 'Salary record deleted.');
    }
}
