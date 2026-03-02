<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ArchivedDocumentController extends Controller
{
    public function index()
    {
        $query = Document::onlyTrashed()->with('user');

        if (!Auth::user()->is_admin) {
            $query->where('user_id', Auth::id());
        }

        $documents = $query->latest()->get();
        return view('documents.archived', compact('documents'));
    }

    public function restore($id)
    {
        $query = Document::onlyTrashed();

        if (!Auth::user()->is_admin) {
            $query->where('user_id', Auth::id());
        }

        $document = $query->findOrFail($id);
        $document->restore();

        return back()->with('status', 'Document restored successfully!');
    }

    public function forceDelete($id)
    {
        $query = Document::onlyTrashed();

        if (!Auth::user()->is_admin) {
            $query->where('user_id', Auth::id());
        }

        $document = $query->findOrFail($id);

        if (Storage::disk('public')->exists($document->path)) {
            Storage::disk('public')->delete($document->path);
        }

        $document->forceDelete();

        return back()->with('status', 'Document permanently deleted.');
    }

    public function download($id)
    {
        $query = Document::onlyTrashed();

        if (!Auth::user()->is_admin) {
            $query->where('user_id', Auth::id());
        }

        $document = $query->findOrFail($id);

        if (!Storage::disk('public')->exists($document->path)) {
            abort(404, 'File not found on server.');
        }

        return response()->download(storage_path('app/public/' . $document->path), $document->original_name);
    }
}
