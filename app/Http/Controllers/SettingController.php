<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        $company = auth()->user()->company;
        $settings = $company->settings()->pluck('value', 'key');
        return view('company.settings.edit', compact('settings'));
    }

    public function update(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'theme_color' => 'nullable|string|in:blue,red,green,purple,black,white,yellow',
            'theme_mode' => 'nullable|string|in:light,dark',
            'print_background' => 'nullable|image|max:2048',
            'pdf_logo' => 'nullable|image|max:2048',
            'company_email' => 'nullable|email|max:255',
        ]);

        $company = auth()->user()->company;

        // Save Color
        if ($request->has('theme_color')) {
            $company->settings()->updateOrCreate(
                ['key' => 'theme_color'],
                ['value' => $request->theme_color]
            );
        }

        // Save Mode
        if ($request->has('theme_mode')) {
            $company->settings()->updateOrCreate(
                ['key' => 'theme_mode'],
                ['value' => $request->theme_mode]
            );
        }

        // Save Print Background
        if ($request->hasFile('print_background')) {
            $path = $request->file('print_background')->store('backgrounds', 'public');
            $company->settings()->updateOrCreate(
                ['key' => 'print_background'],
                ['value' => $path]
            );
        }

        // Save PDF Logo
        if ($request->hasFile('pdf_logo')) {
            $path = $request->file('pdf_logo')->store('logos/pdf', 'public');
            $company->settings()->updateOrCreate(
                ['key' => 'pdf_logo'],
                ['value' => $path]
            );
        }

        // Save Company Email for PDF
        if ($request->has('company_email')) {
            $company->settings()->updateOrCreate(
                ['key' => 'company_email'],
                ['value' => $request->company_email]
            );
        }

        return redirect()->route('company.settings.edit')->with('success', 'Settings updated.');
    }
}
