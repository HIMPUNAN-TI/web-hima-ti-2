<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::orderByDesc('id')->get(); // Get all users for DataTables
        $viewData = [
            'title' => 'Users',
            'users' => $users,
        ];
        
        return view('admin.users.index', $viewData);
    }

    public function create()
    {
        return view('admin.users.add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', Rule::in(['admin', 'member'])],
        ]);

        $password = $validated['password'] ?? null;
        if ($password === null || $password === '') {
            $password = '12345678';
        }

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $password,
            'role' => $validated['role'],
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil dibuat.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', Rule::in(['admin', 'member'])],
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = $validated['password']; // Password disimpan sebagai plain text
        }

        $user->update($updateData);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}


