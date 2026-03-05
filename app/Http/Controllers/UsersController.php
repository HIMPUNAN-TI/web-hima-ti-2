<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

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
            'telephone_number' => ['required', 'string', 'max:15'],
            'is_stikom' => ['required', 'boolean'],
            
            // Validasi Kondisional berdasarkan is_stikom
            'nim' => ['required_if:is_stikom,1', 'nullable', 'string', 'unique:users,nim'],
            'generation' => ['required_if:is_stikom,1', 'nullable', 'string'],
            'prodi' => ['required_if:is_stikom,1', 'nullable', 'string'],

            // Validasi Kondisional berdasarkan instansi_type
            'instansi_type' => ['required_if:is_stikom,0', 'nullable', 'in:SMA/SMK,Kuliah,Umum'],
            'asal_sekolah' => ['required_if:instansi_type,SMA/SMK', 'nullable', 'string'],
            'asal_kampus' => ['required_if:instansi_type,Kuliah', 'nullable', 'string'],
        ]);

        $password = $validated['password'] ?? null;
        if ($password === null || $password === '') {
            $password = '12345678';
        }

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($password), // Di-hash agar bisa login lewat AuthController
            'role' => $validated['role'],
            'telephone_number' => $validated['telephone_number'],
            'is_stikom' => $validated['is_stikom'],
            
            // Data Mahasiswa STIKOM
            'nim' => $validated['is_stikom'] == '1' ? $validated['nim'] : null,
            'generation' => $validated['is_stikom'] == '1' ? $validated['generation'] : null,
            'prodi' => $validated['is_stikom'] == '1' ? $validated['prodi'] : null,

            // Data Non-STIKOM
            'instansi_type' => $validated['is_stikom'] == '0' ? $validated['instansi_type'] : null,
            'asal_sekolah' => ($validated['is_stikom'] == '0' && $validated['instansi_type'] == 'SMA/SMK') ? $validated['asal_sekolah'] : null,
            'asal_kampus' => ($validated['is_stikom'] == '0' && $validated['instansi_type'] == 'Kuliah') ? $validated['asal_kampus'] : null,
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
            'telephone_number' => ['required', 'string', 'max:15'],
            'is_stikom' => ['required', 'boolean'],
            
            // Validasi Kondisional Update
            'nim' => ['required_if:is_stikom,1', 'nullable', 'string', Rule::unique('users', 'nim')->ignore($user->id)],
            'generation' => ['required_if:is_stikom,1', 'nullable', 'string'],
            'prodi' => ['required_if:is_stikom,1', 'nullable', 'string'],
            'instansi_type' => ['required_if:is_stikom,0', 'nullable', 'in:SMA/SMK,Kuliah,Umum'],
            'asal_sekolah' => ['required_if:instansi_type,SMA/SMK', 'nullable', 'string'],
            'asal_kampus' => ['required_if:instansi_type,Kuliah', 'nullable', 'string'],
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'telephone_number' => $validated['telephone_number'],
            'is_stikom' => $validated['is_stikom'],
            'nim' => $validated['is_stikom'] == '1' ? $validated['nim'] : null,
            'generation' => $validated['is_stikom'] == '1' ? $validated['generation'] : null,
            'prodi' => $validated['is_stikom'] == '1' ? $validated['prodi'] : null,
            'instansi_type' => $validated['is_stikom'] == '0' ? $validated['instansi_type'] : null,
            'asal_sekolah' => ($validated['is_stikom'] == '0' && $validated['instansi_type'] == 'SMA/SMK') ? $validated['asal_sekolah'] : null,
            'asal_kampus' => ($validated['is_stikom'] == '0' && $validated['instansi_type'] == 'Kuliah') ? $validated['asal_kampus'] : null,
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
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