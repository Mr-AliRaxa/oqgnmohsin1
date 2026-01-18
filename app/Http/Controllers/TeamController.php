<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $teams = auth()->user()->company->teams;
        return view('company.teams.index', compact('teams'));
    }

    public function create()
    {
        return view('company.teams.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'nullable|string',
            'designation' => 'nullable|string',
            'nationality' => 'nullable|string',
            'id_card_number' => 'nullable|string',
            'basic_salary' => 'nullable|numeric',
            'image_path' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image_path')) {
            try {
                $file = $request->file('image_path');
                \Log::info('File upload attempt', [
                    'original_name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime' => $file->getMimeType()
                ]);
                
                $imagePath = $file->store('teams', 'public');
                \Log::info('File stored successfully', ['path' => $imagePath]);
            } catch (\Exception $e) {
                \Log::error('File upload failed', ['error' => $e->getMessage()]);
                return redirect()->back()->with('error', 'Failed to upload image: ' . $e->getMessage());
            }
        }

        auth()->user()->company->teams()->create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'designation' => $request->designation,
            'nationality' => $request->nationality,
            'id_card_number' => $request->id_card_number,
            'basic_salary' => $request->basic_salary ?? 0,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('company.teams.index')->with('success', 'Team member added successfully.');
    }

    public function show(\App\Models\Team $team)
    {
        if ($team->company_id !== auth()->user()->company_id) {
            abort(403);
        }
        // Load relationships if needed, e.g. salaries
        $team->load('salaries');
        return view('company.teams.show', compact('team'));
    }

    public function edit(\App\Models\Team $team)
    {
        if ($team->company_id !== auth()->user()->company_id) {
            abort(403);
        }
        return view('company.teams.edit', compact('team'));
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\Team $team)
    {
        if ($team->company_id !== auth()->user()->company_id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'image_path' => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['image_path']);

        if ($request->hasFile('image_path')) {
            $data['image_path'] = $request->file('image_path')->store('teams', 'public');
        }

        $team->update($data);

        return redirect()->route('company.teams.index')->with('success', 'Team member updated.');
    }

    public function destroy(\App\Models\Team $team)
    {
        if ($team->company_id !== auth()->user()->company_id) {
            abort(403);
        }
        $team->delete();
        return redirect()->route('company.teams.index')->with('success', 'Team member deleted.');
    }
}
