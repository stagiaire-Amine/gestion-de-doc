<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleManagementController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        $users = User::latest()->paginate(20);
        return view('admin.roles.index', compact('users'));
    }

    /**
     * Show the form for editing roles and permissions.
     */
    public function edit(User $user)
    {

        $permissionsByGroup = [
            'Clients' => [
                'clients.view' => 'View Clients',
                'clients.create' => 'Create Clients',
                'clients.update' => 'Update Clients',
                'clients.delete' => 'Delete Clients',
            ],
            'Documents' => [
                'documents.view' => 'View Documents',
                'documents.create' => 'Upload Documents',
                'documents.update' => 'Modify Documents',
                'documents.delete' => 'Delete Documents',
            ],
            'User Management' => [
                'users.view' => 'View Users',
                'users.assign_roles' => 'Assign Roles & Permissions',
            ],
        ];

        return view('admin.roles.edit', compact('user', 'permissionsByGroup'));
    }

    public function update(Request $request, User $user)
    {

        // 2. Security Check: Prevent administrators from modifying their own roles/permissions
        // This prevents self-lockouts and ensures a "four-eyes" security principle.
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Security Policy: You cannot modify your own accessibility settings through this panel. Please have another administrator perform this action for you.');
        }

        // 3. Validation
        $request->validate([
            'is_admin' => 'required|in:0,1',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|max:255',
        ]);

        // 4. THE SYNC FIX: Explicitly handle synchronization and revocation
        $user->is_admin = $request->boolean('is_admin');

        if ($user->is_admin) {
            // Admin users have full bypass; we clear the explicit permissions array to avoid redundancy
            $user->permissions = [];
        } else {
            // SYNC STEP: We replace the entire array. 
            // $request->input('permissions', []) correctly defaults to an empty array if all boxes are unchecked.
            // This is what forces the REMOVAL (revocation) of permissions.
            $rawPermissions = $request->input('permissions', []);

            // Clean/Normalize: Remove duplicates, filter empty values, and reset array keys
            $user->permissions = array_values(array_filter(array_unique($rawPermissions)));
        }

        // 5. Persistence and State Management
        $user->save();
        $user->refresh(); // Ensure we have the latest state from the DB

        // Audit Logging (Optional Debug)
        \Illuminate\Support\Facades\Log::info("Permissions synchronized for user ID {$user->id}. New status: Admin=" . ($user->is_admin ? 'Yes' : 'No') . ", Count=" . count($user->permissions));

        return redirect()->route('admin.users.roles.index')
            ->with('success', "Access permissions for '{$user->name}' have been synchronized successfully. Unchecked items were revoked.");
    }
}
