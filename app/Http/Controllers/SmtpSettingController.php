<?php

namespace App\Http\Controllers;

use App\Models\SmtpSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class SmtpSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $smtpSettings = SmtpSetting::latest()->get();
        
        return view('super_admin.smtp.index', compact('smtpSettings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('super_admin.smtp.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'host' => 'required|string|max:255',
            'port' => 'required|integer|min:1|max:65535',
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'encryption' => 'required|in:tls,ssl,none',
            'from_address' => 'required|email|max:255',
            'from_name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        // Deactivate all other SMTP settings if this one is active
        if ($request->is_active) {
            SmtpSetting::query()->update(['is_active' => false]);
        }

        // Encrypt the password before storing
        $validated['password'] = Crypt::encryptString($validated['password']);
        $validated['encryption'] = $validated['encryption'] === 'none' ? null : $validated['encryption'];

        SmtpSetting::create($validated);

        return redirect()->route('super_admin.smtp-settings.index')
            ->with('success', 'SMTP settings created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SmtpSetting $smtpSetting)
    {
        return view('super_admin.smtp.edit', compact('smtpSetting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SmtpSetting $smtpSetting)
    {
        $validated = $request->validate([
            'host' => 'required|string|max:255',
            'port' => 'required|integer|min:1|max:65535',
            'username' => 'required|string|max:255',
            'password' => 'nullable|string|max:255',
            'encryption' => 'required|in:tls,ssl,none',
            'from_address' => 'required|email|max:255',
            'from_name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        // Deactivate all other SMTP settings if this one is active
        if ($request->is_active) {
            SmtpSetting::where('id', '!=', $smtpSetting->id)->update(['is_active' => false]);
        }

        // Only update password if provided
        if ($request->filled('password')) {
            $validated['password'] = Crypt::encryptString($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['encryption'] = $validated['encryption'] === 'none' ? null : $validated['encryption'];

        $smtpSetting->update($validated);

        return redirect()->route('super_admin.smtp-settings.index')
            ->with('success', 'SMTP settings updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SmtpSetting $smtpSetting)
    {
        $smtpSetting->delete();

        return redirect()->route('super_admin.smtp-settings.index')
            ->with('success', 'SMTP settings deleted successfully.');
    }

    /**
     * Toggle the active status of SMTP setting
     */
    public function toggleActive(SmtpSetting $smtpSetting)
    {
        if (!$smtpSetting->is_active) {
            // Deactivate all other SMTP settings
            SmtpSetting::query()->update(['is_active' => false]);
            $smtpSetting->update(['is_active' => true]);
        } else {
            $smtpSetting->update(['is_active' => false]);
        }

        return redirect()->route('super_admin.smtp-settings.index')
            ->with('success', 'SMTP settings status updated successfully.');
    }
}
