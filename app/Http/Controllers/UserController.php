<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of users (Pustakawan).
     */
    public function index()
    {
        $users = User::where('role', 'pustakawan')->paginate(10);
        
        $stats = [
            'total' => User::where('role', 'pustakawan')->count(),
            'active' => User::where('role', 'pustakawan')->whereNull('deleted_at')->count(),
            'inactive' => User::where('role', 'pustakawan')->whereNotNull('deleted_at')->count(),
        ];
        
        return view('pages.admin.users.index', compact('users', 'stats'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('pages.admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        // Always set role to pustakawan for admin-created users
        $validated['role'] = 'pustakawan';
        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Pustakawan berhasil ditambahkan');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return view('pages.admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('pages.admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id . '|max:255',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($validated['password']) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Pustakawan berhasil diperbarui');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        if ($user->loans()->exists()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Pustakawan tidak bisa dihapus karena memiliki riwayat peminjaman');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Pustakawan berhasil dihapus');
    }
}
