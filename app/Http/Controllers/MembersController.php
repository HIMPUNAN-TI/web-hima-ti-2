<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class MembersController extends Controller
{
    public function index()
    {
        $members = Member::with('user')->orderByDesc('id')->get();
        $viewData = [
            'title' => 'Members',
            'members' => $members,
        ];
        
        return view('admin.members.index', $viewData);
    }

    public function create()
    {
        return view('admin.members.add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['nullable', 'string', 'min:8'],
            'nim' => ['required', 'string', 'max:255', 'unique:members,nim'],
            'telephone_number' => ['required', 'string', 'max:15'],
            'prodi' => ['required', 'string', 'max:255'],
            'generation' => ['required', 'string', 'max:255'],
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'nim.required' => 'NIM wajib diisi',
            'nim.unique' => 'NIM sudah terdaftar',
            'telephone_number.required' => 'Nomor telepon wajib diisi',
            'telephone_number.max' => 'Nomor telepon maksimal 15 karakter',
            'prodi.required' => 'Program studi wajib diisi',
            'generation.required' => 'Angkatan wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
        ]);

        try {
            DB::beginTransaction();

            // Set default password if not provided
            $password = $validated['password'] ?? '12345678';

            // Create user first
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $password,
                'role' => 'member',
            ]);

            // Create member with relation to user
            Member::create([
                'user_id' => $user->id,
                'nim' => $validated['nim'],
                'email' => $validated['email'],
                'telephone_number' => $validated['telephone_number'],
                'prodi' => $validated['prodi'],
                'generation' => $validated['generation'],
            ]);

            DB::commit();
            return redirect()->route('members.index')->with('success', 'Member berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat member.')->withInput();
        }
    }

    public function edit(Member $member)
    {
        $member->load('user');
        return view('admin.members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($member->user_id)],
            'password' => ['nullable', 'string', 'min:8'],
            'nim' => ['required', 'string', 'max:255', Rule::unique('members', 'nim')->ignore($member->id)],
            'telephone_number' => ['required', 'string', 'max:15'],
            'prodi' => ['required', 'string', 'max:255'],
            'generation' => ['required', 'string', 'max:255'],
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'nim.required' => 'NIM wajib diisi',
            'nim.unique' => 'NIM sudah terdaftar',
            'telephone_number.required' => 'Nomor telepon wajib diisi',
            'telephone_number.max' => 'Nomor telepon maksimal 15 karakter',
            'prodi.required' => 'Program studi wajib diisi',
            'generation.required' => 'Angkatan wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
        ]);

        try {
            DB::beginTransaction();

            // Update user data
            $userUpdateData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
            ];

            if (!empty($validated['password'])) {
                $userUpdateData['password'] = $validated['password'];
            }

            $member->user->update($userUpdateData);

            // Update member data
            $member->update([
                'nim' => $validated['nim'],
                'email' => $validated['email'],
                'telephone_number' => $validated['telephone_number'],
                'prodi' => $validated['prodi'],
                'generation' => $validated['generation'],
            ]);

            DB::commit();
            return redirect()->route('members.index')->with('success', 'Member berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui member.')->withInput();
        }
    }

    public function destroy(Member $member)
    {
        try {
            DB::beginTransaction();

            // Delete member first, then user
            $user = $member->user;
            $member->delete();
            $user->delete();

            DB::commit();
            return redirect()->route('members.index')->with('success', 'Member berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('members.index')->with('error', 'Terjadi kesalahan saat menghapus member.');
        }
    }
}
