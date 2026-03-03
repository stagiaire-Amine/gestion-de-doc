<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = Document::where('user_id', Auth::id())->latest()->get();
        return view('documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('documents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'status' => 'nullable|in:pending,approved,rejected,draft',
            'document' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,txt,zip|max:10240', // 10MB
        ]);

        $file = $request->file('document');
        $originalName = $file->getClientOriginalName();
        $title = $validated['title'] ?? pathinfo($originalName, PATHINFO_FILENAME);

        $userId = Auth::id();
        $year = date('Y');
        $month = date('m');
        $path = $file->store("documents/{$userId}/{$year}/{$month}", 'public');

        try {
            $document = Document::create([
                'user_id' => $userId,
                'title' => $title,
                'original_name' => $originalName,
                'category' => $validated['category'] ?? null,
                'path' => $path,
                'mime_type' => $file->getMimeType(),
                'size_bytes' => $file->getSize(),
                'status' => $validated['status'] ?? 'pending',
                'is_starred' => false,
            ]);

            \Illuminate\Support\Facades\Log::info("Successfully inserted document into database: ID {$document->id}, Title: {$title}, User ID: {$userId}");

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Failed to insert document into database: " . $e->getMessage());
            // If DB insert fails, cleanup the stored file to avoid orphaned files
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            return back()->with('error', 'A database error occurred while saving your document upload.');
        }

        return redirect()->route('documents.index')->with('status', 'Document uploaded successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        Gate::authorize('view', $document);
        return view('documents.show', compact('document'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        Gate::authorize('update', $document);
        return view('documents.edit', compact('document'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        Gate::authorize('update', $document);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'status' => 'required|in:pending,approved,rejected,draft',
        ]);

        $document->update($validated);

        return redirect()->route('documents.index')->with('status', 'Document updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        Gate::authorize('delete', $document);

        // Soft delete the document
        $document->delete();

        return redirect()->route('documents.index')->with('status', 'Document archived successfully.');
    }

    /**
     * Download the specified resource.
     */
    public function download(Document $document)
    {
        Gate::authorize('view', $document);

        if (!Storage::disk('public')->exists($document->path)) {
            abort(404, 'File not found on server.');
        }

        return response()->download(storage_path('app/public/' . $document->path), $document->original_name);
    }
}