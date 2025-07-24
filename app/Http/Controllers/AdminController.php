<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class AdminController extends Controller
{
    public function __construct()
    {
        // In Laravel 12, use the new middleware registration
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $documents = Document::with(['user', 'statuses', 'currentStatus'])->latest()->get();
        return view('admin.index', compact('documents'));
    }

    public function show(Document $document)
    {
        // Bypass authorization for admin users
        if (!auth()->user()->is_admin) {
            abort(403);
        }
         $users = User::where('is_reviewer', true)->get();
        
        $statuses = $document->statuses()->with('admin')->latest()->get();
        return view('admin.show', compact('document', 'statuses','users'));
    }
    public function updateStatus(Request $request, Document $document)
    {
        $request->validate([
            'status' => 'required|in:received,in_progress,in_transaction,completed,canceled',
            'message' => 'nullable|string',
        ]);

        DocumentStatus::create([
            'document_id' => $document->id,
            'status' => $request->status,
            'message' => $request->message,
            'admin_id' => Auth::id(),
        ]);

        return back()->with('success', 'Status updated successfully!');
    }
    public function toggleAdmin(Request $request, \App\Models\User $user)
{
    $user->is_reviewer = !$user->is_reviewer;
    $user->save();

    return back()->with('success', 'User reviewer status updated successfully.');

  
}
}