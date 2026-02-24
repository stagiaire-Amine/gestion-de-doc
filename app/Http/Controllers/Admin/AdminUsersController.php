<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;

class AdminUsersController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('q')) {
            $searchTerm = $request->q;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', 'string', 'in:user,admin'],
            'is_active' => ['boolean'] // Using boolean checkbox
        ]);

        $isAdmin = $validated['role'] === 'admin';

        // Check if removing the last admin
        if ($user->is_admin && !$isAdmin) {
            $adminCount = User::where('is_admin', true)->count();
            if ($adminCount <= 1) {
                return back()->with('error', 'Cannot remove the last administrator role.');
            }
        }

        $user->update([
            'email' => $validated['email'],
            'is_admin' => $isAdmin,
            'is_active' => $request->has('is_active')
        ]);

        if ($request->filled('name')) {
            $user->update(['name' => $request->name]);
        }

        return redirect()->route('admin.users.index')->with('status', 'User details updated successfully.');
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', 'string', 'in:user,admin'],
            'is_active' => ['boolean']
        ]);

        $isAdmin = $validated['role'] === 'admin';

        Log::info("Admin creating user: {$validated['email']}");

        // Create the user with a random locked password (they will set their own)
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(32)),
            'is_admin' => $isAdmin,
            'is_active' => $request->has('is_active'),
            'must_change_password' => true
        ]);

        Log::info("User account created: ID {$user->id}");

        // Trigger real password set email via standard Laravel Password broker
        try {
            Log::info("ATTEMPTING to dispatch password reset link for: {$user->email}");
            Password::sendResetLink(['email' => $user->email]);
            Log::info("SUCCESS: Reset link dispatched for user ID {$user->id}");
        } catch (\Exception $e) {
            Log::error("CRITICAL SMTP ERROR for user {$user->id}: " . $e->getMessage());
            Log::error("Exception: " . get_class($e));
            return back()->with('error', 'User created, but email failed to send. Check SMTP settings in .env. Error: ' . $e->getMessage());
        }

        return redirect()->route('admin.users.index')->with('status', "User created successfully! A secure link to set the password has been sent to **{$user->email}**.");
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        if ($user->is_admin) {
            $adminCount = User::where('is_admin', true)->count();
            if ($adminCount <= 1) {
                return back()->with('error', 'Cannot delete the last administrator.');
            }
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('status', 'User deleted successfully.');
    }
}
