<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    public function index()
    {
        if (!Auth::user()->isSuperAdmin()) {
            return redirect()->route('admin.verifications')
                ->with('error', 'Access Denied: Only the Main Admin (admin@800bypd.com) has authority to create or manage staff logins.');
        }

        $users = User::orderBy('role', 'asc')->orderBy('name', 'asc')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isSuperAdmin()) {
            return back()->with('error', 'Access Denied: Only the Main Admin has authority to create staff logins.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
            'role' => ['required', Rule::in(['admin', 'staff', 'customer'])],
        ]);

        $dbRole = in_array($validated['role'], ['admin', 'staff']) ? 'admin' : 'customer';

        try {
            User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'password' => Hash::make($validated['password']),
                'role' => $dbRole,
            ]);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Unable to create account: ' . $e->getMessage());
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'New ' . ucfirst($validated['role']) . ' account created successfully!');
    }

    public function update(Request $request, User $user)
    {
        if (!Auth::user()->isSuperAdmin()) {
            return back()->with('error', 'Access Denied: Only the Main Admin has authority to manage staff logins.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'role' => ['required', Rule::in(['admin', 'staff', 'customer'])],
            'password' => 'nullable|string|min:6',
        ]);

        $dbRole = in_array($validated['role'], ['admin', 'staff']) ? 'admin' : 'customer';

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;
        $user->role = $dbRole;

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'Account updated successfully for ' . $user->name);
    }

    public function destroy(User $user)
    {
        if (!Auth::user()->isSuperAdmin()) {
            return back()->with('error', 'Access Denied: Only the Main Admin has authority to delete staff logins.');
        }

        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot delete your own active main admin account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Account deleted successfully.');
    }
}
