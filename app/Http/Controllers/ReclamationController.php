<?php

namespace App\Http\Controllers;

use App\Models\Reclamation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ReclamationController extends Controller
{
    public function index()
    {
        $reclamations = Reclamation::where('user_id', Auth::id())->latest()->get();
        return view('reclamations.index', compact('reclamations'));
    }

    public function create()
    {
        return view('reclamations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'priority' => 'required|in:low,medium,high',
            'message' => 'required|string',
        ]);

        Reclamation::create([
            'user_id' => Auth::id(),
            'subject' => $validated['subject'],
            'priority' => $validated['priority'],
            'message' => $validated['message'],
            'status' => 'open',
        ]);

        return redirect()->route('reclamations.index')
            ->with('status', 'Your support ticket has been submitted successfully.');
    }

    public function show(Reclamation $reclamation)
    {
        Gate::authorize('view', $reclamation);

        return view('reclamations.show', compact('reclamation'));
    }
}
