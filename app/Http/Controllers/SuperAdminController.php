<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function index()
    {
        $companies = \App\Models\Company::latest()->get();
        $totalCompanies = $companies->count();
        $approvedCount = $companies->where('status', 'approved')->count();
        $pendingCount = $companies->where('status', 'pending')->count();
        $rejectedCount = $companies->where('status', 'rejected')->count();
        
        // Show all companies in the table for a comprehensive view
        return view('super_admin.dashboard', compact(
            'companies', 
            'totalCompanies', 
            'approvedCount', 
            'pendingCount', 
            'rejectedCount'
        ));
    }

    public function create()
    {
        return view('super_admin.companies.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string',
            'company_cr_number' => 'nullable|string',
            'owner_name' => 'required|string|max:255',
            'company_email' => 'required|email|unique:users,email', // Check user uniqueness
            'company_password' => 'required|string|min:8',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Upload Logo
        $logoPath = null;
        if ($request->hasFile('company_logo')) {
            $logoPath = $request->file('company_logo')->store('logos', 'public');
        }

        // Create Company
        $company = \App\Models\Company::create([
            'name' => $request->company_name,
            'address' => $request->company_address,
            'cr_number' => $request->company_cr_number,
            'owner_name' => $request->owner_name,
            'email' => $request->company_email, // Treating company email as contact email
            'logo_path' => $logoPath,
        ]);

        // Create Company Admin User
        \App\Models\User::create([
            'name' => 'Admin ' . $company->name,
            'email' => $request->company_email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->company_password),
            'role' => 'company_admin',
            'company_id' => $company->id,
            'is_active' => true,
        ]);

        return redirect()->route('super_admin.dashboard')->with('success', 'Company created successfully.');
    }

    public function edit(\App\Models\Company $company)
    {
        return view('super_admin.companies.edit', compact('company'));
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\Company $company)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string',
            'company_cr_number' => 'nullable|string',
            'owner_name' => 'required|string|max:255',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = [
            'name' => $request->company_name,
            'address' => $request->company_address,
            'cr_number' => $request->company_cr_number,
            'owner_name' => $request->owner_name,
        ];

        if ($request->hasFile('company_logo')) {
            $data['logo_path'] = $request->file('company_logo')->store('logos', 'public');
        }

        $company->update($data);

        return redirect()->route('super_admin.dashboard')->with('success', 'Company updated successfully.');
    }

    public function destroy(\App\Models\Company $company)
    {
        // Delete related users? or just the company?
        // For now, let's delete the company and its users.
        $company->users()->delete();
        $company->delete();

        return redirect()->route('super_admin.dashboard')->with('success', 'Company deleted successfully.');
    }

    public function settings()
    {
        $settings = \App\Models\GlobalSetting::pluck('value', 'key');
        return view('super_admin.settings', compact('settings'));
    }

    public function updateSettings(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'global_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('global_logo')) {
            $path = $request->file('global_logo')->store('logos', 'public');
            \App\Models\GlobalSetting::updateOrCreate(
                ['key' => 'global_logo'],
                ['value' => $path]
            );
        }

        return redirect()->route('super_admin.settings')->with('success', 'Global settings updated.');
    }

    public function registrations()
    {
        $companies = \App\Models\Company::where('status', 'pending')->latest()->get();
        return view('super_admin.registrations.index', compact('companies'));
    }

    public function approve(\App\Models\Company $company)
    {
        $company->update(['status' => 'approved']);
        
        // Activate associated users
        $company->users()->update(['is_active' => true]);

        return redirect()->route('super_admin.registrations.index')->with('success', 'Company approved successfully.');
    }

    public function reject(\App\Models\Company $company)
    {
        $company->update(['status' => 'rejected']);
        
        // Keep users inactive
        $company->users()->update(['is_active' => false]);

        return redirect()->route('super_admin.registrations.index')->with('success', 'Company registration rejected.');
    }

    public function toggleActive(\App\Models\Company $company)
    {
        $company->update(['is_active' => !$company->is_active]);
        
        // Sync user activation if company is approved
        if ($company->status === 'approved') {
            $company->users()->update(['is_active' => $company->is_active]);
        }

        return back()->with('success', 'Company status updated successfully.');
    }
}
