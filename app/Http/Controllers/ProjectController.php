<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = auth()->user()->company->projects();
        
        if ($request->has('status') && array_key_exists($request->status, \App\Models\Project::getStatuses())) {
            $query->where('status', $request->status);
        }

        $projects = $query->latest()->get();
        return view('company.projects.index', compact('projects'));
    }

    public function create()
    {
        $teamMembers = auth()->user()->company->teams;
        return view('company.projects.create', compact('teamMembers'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'to_client' => 'required|string',
            'subject' => 'required|string',
            'name' => 'required|string', // New
            'location' => 'required|string', // New
            'description' => 'nullable|string', // New
            'owner_name' => 'required|string', // New
            'status' => 'required|in:draft,continued,stopped,finished,cancelled',
            'team_members' => 'nullable|array',
        ]);

        \Illuminate\Support\Facades\DB::transaction(function () use ($request) {
            $company = auth()->user()->company;

            $project = $company->projects()->create([
                'to_client' => $request->to_client,
                'subject' => $request->subject,
                'name' => $request->name,
                'location' => $request->location,
                'description' => $request->description,
                'owner_name' => $request->owner_name,
                'status' => $request->status ?? \App\Models\Project::STATUS_DRAFT,
            ]);

            // Items
            if ($request->has('items')) {
                foreach ($request->items as $item) {
                    $project->items()->create([
                        'description' => $item['description'],
                        'uom' => $item['uom'] ?? null,
                        'quantity' => $item['quantity'],
                        'rate' => $item['rate'],
                        'amount' => $item['quantity'] * $item['rate'],
                    ]);
                }
            }

            // Terms
            if ($request->terms) {
                foreach ($request->terms as $term) {
                    if (!empty($term)) {
                        $project->terms()->create(['term_text' => $term]);
                    }
                }
            }

            // Team
            if ($request->team_members) {
                $project->teamMembers()->attach($request->team_members);
            }
        });

        return redirect()->route('company.projects.index')->with('success', 'Project created successfully.');
    }

    public function show(\App\Models\Project $project)
    {
        if ($project->company_id !== auth()->user()->company_id) {
            abort(403);
        }
        $project->load(['items', 'terms', 'teamMembers']);
        return view('company.projects.show', compact('project'));
    }
    
    public function edit(\App\Models\Project $project)
    {
        if ($project->company_id !== auth()->user()->company_id) {
            abort(403);
        }
        $project->load(['items', 'terms', 'teamMembers']);
        $teamMembers = auth()->user()->company->teams;
        return view('company.projects.edit', compact('project', 'teamMembers'));
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\Project $project)
    {
        if ($project->company_id !== auth()->user()->company_id) {
            abort(403);
        }

        $request->validate([
            'to_client' => 'required|string',
            'subject' => 'required|string',
            'name' => 'required|string',
            'location' => 'required|string',
            'description' => 'nullable|string',
            'owner_name' => 'required|string',
            'status' => 'required|in:draft,continued,stopped,finished,cancelled',
            'team_members' => 'nullable|array',
        ]);

        \Illuminate\Support\Facades\DB::transaction(function () use ($request, $project) {
            $project->update([
                'to_client' => $request->to_client,
                'subject' => $request->subject,
                'name' => $request->name,
                'location' => $request->location,
                'description' => $request->description,
                'owner_name' => $request->owner_name,
                'status' => $request->status,
            ]);

            // Update Items (Simple strategy: delete all and recreate)
            $project->items()->delete();
            if ($request->has('items')) {
                foreach ($request->items as $item) {
                    $project->items()->create([
                        'description' => $item['description'],
                        'uom' => $item['uom'] ?? null,
                        'quantity' => $item['quantity'],
                        'rate' => $item['rate'],
                        'amount' => $item['quantity'] * $item['rate'],
                    ]);
                }
            }

            // Update Terms
            $project->terms()->delete();
            if ($request->terms) {
                foreach ($request->terms as $term) {
                    if (!empty($term)) {
                        $project->terms()->create(['term_text' => $term]);
                    }
                }
            }

            // Update Team
            $project->teamMembers()->sync($request->team_members ?? []);
        });

        return redirect()->route('company.projects.index')->with('success', 'Project updated successfully.');
    }
    public function destroy(\App\Models\Project $project)
    {
        if ($project->company_id !== auth()->user()->company_id) {
            abort(403);
        }
        $project->delete();
        return redirect()->route('company.projects.index')->with('success', 'Project deleted successfully.');
    }
}
