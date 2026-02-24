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
        $documents = Document::onlyTrashed()->where('user_id', Auth::id())->latest()->get();
        return view('documents.archived', compact('documents'));
    }

    public function restore($id)
    {
        $document = Document::onlyTrashed()->where('user_id', Auth::id())->findOrFail($id);
        $document->restore();

        return back()->with('status', 'Document restored successfully!');
    }

    public function forceDelete($id)
    {
        $document = Document::onlyTrashed()->where('user_id', Auth::id())->findOrFail($id);

        if (Storage::disk('public')->exists($document->path)) {
            Storage::disk('public')->delete($document->path);
        }

        $document->forceDelete();

        return back()->with('status', 'Document permanently deleted.');
    }

    public function download($id)
    {
        $document = Document::onlyTrashed()->where('user_id', Auth::id())->findOrFail($id);

        if (!Storage::disk('public')->exists($document->path)) {
            abort(404, 'File not found on server.');
        }

        return response()->download(storage_path('app/public/' . $document->path), $document->original_name);
    }
}
