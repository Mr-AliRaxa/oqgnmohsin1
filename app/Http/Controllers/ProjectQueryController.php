<?php

namespace App\Http\Controllers;

use App\Models\ProjectQuery;
use Illuminate\Http\Request;

class ProjectQueryController extends Controller
{
    /**
     * Store a newly created project query in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'project_id' => 'nullable|exists:projects,id',
        ]);

        ProjectQuery::create([
            'user_id' => auth()->id(),
            'company_id' => auth()->user()->company_id,
            'project_id' => $request->project_id,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Your message has been sent to the Super Admin.');
    }

    /**
     * Display a listing of the queries for Super Admin.
     */
    public function index()
    {
        if (auth()->user()->role !== 'super_admin') {
            abort(403);
        }

        $queries = ProjectQuery::with(['user', 'company'])->latest()->paginate(15);
        return view('super_admin.queries.index', compact('queries'));
    }

    /**
     * Mark the query as resolved/read.
     */
    public function markAsRead(ProjectQuery $query)
    {
        if (auth()->user()->role !== 'super_admin') {
            abort(403);
        }

        $query->update(['status' => 'read']);
        return back()->with('success', 'Query marked as read.');
    }
}
