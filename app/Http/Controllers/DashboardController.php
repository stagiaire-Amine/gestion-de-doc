<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Counts by mime_type
        $pdfCount = Document::where('user_id', $userId)->where('mime_type', 'like', '%pdf%')->count();

        $imageCount = Document::where('user_id', $userId)->where('mime_type', 'like', 'image/%')->count();

        $wordCount = Document::where('user_id', $userId)->where(function ($q) {
            $q->where('mime_type', 'like', '%word%')
                ->orWhere('mime_type', 'like', '%document%');
        })->count();

        // sharedCount (Placeholder for robustness)
        $sharedCount = 0;

        // Recently updated documents (real DB)
        $recentDocuments = Document::where('user_id', $userId)->orderByDesc('updated_at')->limit(5)->get();

        // Archived documents (Ensure variable is present even if using shared/archived interchangeably)
        $archivedDocuments = Document::where('user_id', $userId)->onlyTrashed()->get();

        return view('dashboard', compact(
            'pdfCount',
            'imageCount',
            'wordCount',
            'sharedCount',
            'recentDocuments',
            'archivedDocuments'
        ));
    }
}