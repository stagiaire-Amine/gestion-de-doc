<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class ClientDocumentController extends Controller
{
    /**
     * Store a newly created document for a specific client.
     */
    public function store(Request $request, Client $client)
    {
        // Manual check since this is a custom route, though Policy could be used
        if (!auth()->user()->is_admin && auth()->id() !== $client->user_id) {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'type' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240', // 10MB limit
            'expires_at' => 'nullable|date',
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();

        // Store in storage/app/public/clients/{client_id}/
        $path = $file->storeAs(
            "clients/{$client->id}",
            uniqid() . '_' . preg_replace('/[^A-Za-z0-9\-\.]/', '_', $originalName),
            'public'
        );

        Document::create([
            'client_id' => $client->id,
            'user_id' => auth()->id(),
            'type' => $request->type,
            'title' => $request->type . ' - ' . $client->name, // Compatibility with existing 'title' column
            'original_name' => $originalName,
            'path' => $path, // Compatibility with existing 'path' column
            'mime_type' => $file->getMimeType(),
            'size_bytes' => $file->getSize(),
            'expires_at' => $request->expires_at,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Document uploaded successfully.');
    }

    /**
     * Remove the specified document.
     */
    public function destroy(Document $document)
    {
        Gate::authorize('delete', $document);

        // Delete the physical file (optional since user didn't specify cleanup, but recommended)
        if (Storage::disk('public')->exists($document->path)) {
            Storage::disk('public')->delete($document->path);
        }

        $document->delete();

        return back()->with('success', 'Document deleted successfully.');
    }
}
