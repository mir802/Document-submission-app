<?php
namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $documents = auth()->user()->documents()->with('currentStatus')->get();
        return view('documents.index', compact('documents'));
    }

    public function create()
    {
        return view('documents.create');
    }

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'principal_investigator.full_name' => 'required|string|max:255',
            'principal_investigator.email' => 'required|email|max:255',
            'principal_investigator.department' => 'required|string|max:255',
            'number_of_investigators' => 'required|integer|min:1',
            'co_investigators.*.full_name' => 'nullable|string|max:255',
            'co_investigators.*.email' => 'nullable|email|max:255',
            'co_investigators.*.specialization' => 'nullable|string|max:255',
            'co_investigators.*.phone' => 'nullable|string|max:15',
            'cv.*' => 'required|mimes:pdf|max:2048',
            'document' => 'required|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'notes' => 'nullable|string',
        ]);

        // Save the document file
        $documentPath = $request->file('document')->store('documents', 'public');

        // Save CV files
        $cvPaths = [];
        if ($request->hasFile('cv')) {
            foreach ($request->file('cv') as $cv) {
                $cvPaths[] = $cv->store('cvs', 'public');
            }
        }

        // Create the document record
        $document = Document::create([
            'user_id' => auth()->id(),
            'document_path' => $documentPath,
            'notes' => $request->notes,
            'title' => $request->title,
            'principal_investigator' => json_encode($validated['principal_investigator']),
            'cv_paths' => json_encode($cvPaths),
        ]);

        // Save co-investigators
        if (!empty($validated['co_investigators'])) {
            foreach ($validated['co_investigators'] as $coInvestigator) {
                $document->coInvestigators()->create($coInvestigator); // Assuming a relationship exists
            }
        }

        // Add the default document status
        DocumentStatus::create([
            'document_id' => $document->id,
            'status' => 'received',
            'message' => 'Your document has been received and is awaiting processing.',
            'admin_id' => 1, // Default admin
        ]);

        return redirect()->route('documents.index')->with('success', 'Document submitted successfully!');
    }

   public function show(Document $document)
{
    $this->authorize('view', $document);

    // Decode JSON fields
    $document->principal_investigator = json_decode($document->principal_investigator, true);
    $document->cv_paths = json_decode($document->cv_paths, true);

    $statuses = $document->statuses()->with('admin')->latest()->get();

    return view('admin.show', compact('document', 'statuses'));
}
    public function edit(Document $document)
{
    $this->authorize('update', $document); // Ensure the user has permission to edit

    $document->principal_investigator = json_decode($document->principal_investigator, true);
    $document->cv_paths = json_decode($document->cv_paths, true);

    return view('documents.edit', compact('document'));
}

public function update(Request $request, Document $document)
{
    $this->authorize('update', $document); // Ensure the user has permission to update

    // Validate the request
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'principal_investigator.full_name' => 'required|string|max:255',
        'principal_investigator.email' => 'required|email|max:255',
        'principal_investigator.department' => 'required|string|max:255',
        'number_of_investigators' => 'required|integer|min:1',
        'co_investigators.*.full_name' => 'nullable|string|max:255',
        'co_investigators.*.email' => 'nullable|email|max:255',
        'co_investigators.*.specialization' => 'nullable|string|max:255',
        'co_investigators.*.phone' => 'nullable|string|max:15',
        'cv.*' => 'nullable|mimes:pdf|max:2048',
        'document' => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        'notes' => 'nullable|string',
    ]);

    // Update the document fields
    $document->title = $validated['title'];
    $document->principal_investigator = json_encode($validated['principal_investigator']);
    $document->notes = $validated['notes'];

    // Update the document file (if a new file is uploaded)
    if ($request->hasFile('document')) {
        // Delete the old file
        Storage::disk('public')->delete($document->document_path);
        // Upload the new file
        $document->document_path = $request->file('document')->store('documents', 'public');
    }

    // Update CV files (if new files are uploaded)
    if ($request->hasFile('cv')) {
        // Delete old CV files
        foreach (json_decode($document->cv_paths, true) as $cvPath) {
            Storage::disk('public')->delete($cvPath);
        }
        // Upload new CV files
        $cvPaths = [];
        foreach ($request->file('cv') as $cv) {
            $cvPaths[] = $cv->store('cvs', 'public');
        }
        $document->cv_paths = json_encode($cvPaths);
    }

    $document->save();

    // Update co-investigators
    $document->coInvestigators()->delete(); // Remove old co-investigators
    if (!empty($validated['co_investigators'])) {
        foreach ($validated['co_investigators'] as $coInvestigator) {
            $document->coInvestigators()->create($coInvestigator);
        }
    }

    return redirect()->route('documents.index')->with('success', 'Document updated successfully!');
}
/*public function sendForReview(Request $request, Document $document)
{
    $request->validate([
        'reviewer_id' => 'required|exists:users,id',
    ]);

    $document->update([
        'reviewer_id' => $request->reviewer_id, // Assuming there's a `reviewer_id` column in the `documents` table
        'current_status' => 'in_transaction',
    ]);

    return back()->with('success', 'Document sent to the selected reviewer.');
}

//
*/



public function sendForReview(Request $request, Document $document)
{
    $request->validate([
        'reviewer_id' => 'required|array',
        'reviewer_id.*' => 'exists:users,id',
    ]);

    foreach ($request->reviewer_id as $reviewerId) {
        // Attach reviewer to document, for example:
        $document->reviewers()->attach($reviewerId); // if using a many-to-many relationship
    }

    return redirect()->back()->with('success', 'Document sent to selected reviewer(s).');
}





















}