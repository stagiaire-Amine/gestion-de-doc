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
        $sharedCount = 0; // Placeholder for robustness

        if (Auth::user()->is_admin) {
            // Admins see everything
            $pdfCount = Document::where('mime_type', 'like', '%pdf%')->count();
            $imageCount = Document::where('mime_type', 'like', 'image/%')->count();
            $wordCount = Document::where(function ($q) {
                $q->where('mime_type', 'like', '%word%')
                    ->orWhere('mime_type', 'like', '%document%');
            })->count();
            $recentDocuments = Document::with('user')->orderByDesc('updated_at')->limit(5)->get();
            $archivedDocuments = Document::onlyTrashed()->get();
        } else {
            // Standard users see only their own
            $pdfCount = Document::where('user_id', $userId)->where('mime_type', 'like', '%pdf%')->count();
            $imageCount = Document::where('user_id', $userId)->where('mime_type', 'like', 'image/%')->count();
            $wordCount = Document::where('user_id', $userId)->where(function ($q) {
                $q->where('mime_type', 'like', '%word%')
                    ->orWhere('mime_type', 'like', '%document%');
            })->count();
            $recentDocuments = Document::with('user')->where('user_id', $userId)->orderByDesc('updated_at')->limit(5)->get();
            $archivedDocuments = Document::where('user_id', $userId)->onlyTrashed()->get();
        }

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