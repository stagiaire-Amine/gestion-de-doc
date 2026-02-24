<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reclamation;
use Illuminate\Http\Request;

class AdminReclamationController extends Controller
{
    public function index(Request $request)
    {
        $query = Reclamation::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reclamations = $query->latest()->paginate(15)->withQueryString();

        return view('admin.reclamations.index', compact('reclamations'));
    }

    public function show(Reclamation $reclamation)
    {
        // Eager load user
        $reclamation->load('user');
        return view('admin.reclamations.show', compact('reclamation'));
    }

    public function update(Request $request, Reclamation $reclamation)
    {
        $validated = $request->validate([
            'status' => 'required|in:open,in_progress,resolved,closed',
        ]);

        $reclamation->update(['status' => $validated['status']]);

        return redirect()->back()->with('status', 'Reclamation ticket status updated successfully.');
    }
}
