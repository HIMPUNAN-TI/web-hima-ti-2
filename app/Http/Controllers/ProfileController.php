<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    // Menampilkan halaman form kelengkapan data peserta
    public function edit()
    {
        $user = Auth::user();
        
        // Pastikan relasi member tersedia
        $member = Member::firstOrCreate(
            ['user_id' => $user->id],
            [
                'email' => $user->email,
                'nim' => null,
                'prodi' => null,
                'generation' => null,
                'telephone_number' => null,
                'institution' => null,
            ]
        );

        $title = 'Profil Peserta';

        return view('landing.profile.edit', compact('user', 'member', 'title'));
    }

    // Memperbarui data profil peserta
    public function update(Request $request)
    {
        $user = Auth::user();
        $member = $user->member;

        $request->validate([
            'name' => 'required|string|max:255',
            'telephone_number' => 'required|string|min:9|max:20',
            'institution' => 'required|string|max:255',
            'nim' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('members', 'nim')->ignore($member?->id),
            ],
            'prodi' => 'nullable|string|max:255',
            'generation' => 'nullable|string|max:50',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'telephone_number.required' => 'Nomor HP / WhatsApp wajib diisi.',
            'telephone_number.min' => 'Nomor HP minimal 9 digit.',
            'institution.required' => 'Asal institusi / kampus / sekolah wajib diisi.',
            'nim.unique' => 'NIM ini sudah terdaftar oleh peserta lain.',
        ]);

        // Update nama user
        $user->update([
            'name' => $request->name,
        ]);

        // Update data member
        $member->update([
            'telephone_number' => $request->telephone_number,
            'institution' => $request->institution,
            'nim' => $request->filled('nim') ? $request->nim : null,
            'prodi' => $request->prodi,
            'generation' => $request->generation,
        ]);

        // Jika peserta sebelumnya dialihkan saat mau daftar kegiatan, kembalikan ke pendaftaran
        if (session()->has('redirect_after_profile')) {
            $redirectUrl = session()->pull('redirect_after_profile');
            return redirect($redirectUrl)->with('success', 'Data profil Anda telah lengkap! Silakan lanjutkan pendaftaran kegiatan.');
        }

        return redirect()->route('landing.profile.edit')->with('success', 'Data profil peserta berhasil diperbarui!');
    }
}
