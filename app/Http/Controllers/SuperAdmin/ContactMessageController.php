<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of public contact messages.
     */
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(15);
        return view('super_admin.contact_messages.index', compact('messages'));
    }

    /**
     * Mark message as read/processed.
     */
    public function updateStatus(ContactMessage $message, Request $request)
    {
        $request->validate([
            'status' => 'required|string|in:new,read,replied',
        ]);

        $message->update(['status' => $request->status]);

        return back()->with('success', 'Message status updated.');
    }

    /**
     * Remove the specified message.
     */
    public function destroy(ContactMessage $message)
    {
        $message->delete();
        return back()->with('success', 'Message deleted.');
    }
}
