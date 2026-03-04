<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Menampilkan halaman login admin
    public function showAdminLoginForm()
    {
        return view('admin.auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Kata sandi wajib diisi',
            'password.min' => 'Kata sandi minimal 8 karakter',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $email = $request->email;
        $password = $request->password;
        $remember = $request->has('remember');

        // Cari user berdasarkan email
        $user = User::where('email', $email)->first();

        if ($user && $user->password === $password) {
            // Pastikan yang login di halaman ini adalah member
            if ($user->role !== 'member') {
                return redirect()->back()->withErrors(['email' => 'Akun ini bukan member. Gunakan halaman login admin.'])->withInput();
            }
            
            Auth::login($user, $remember);
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'Login berhasil!');
        }

        return redirect()->back()
            ->withErrors(['email' => 'Email atau kata sandi salah'])
            ->withInput();
    }

    // Proses login admin
    public function adminLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Kata sandi wajib diisi',
            'password.min' => 'Kata sandi minimal 8 karakter',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $email = $request->email;
        $password = $request->password;
        $remember = $request->has('remember');

        // Cari user berdasarkan email
        $user = User::where('email', $email)->first();

        if ($user && $user->password === $password) {
            // Pastikan yang login di halaman ini adalah admin
            if ($user->role !== 'admin') {
                return redirect()->back()->withErrors(['email' => 'Akun ini bukan admin. Gunakan halaman login member.'])->withInput();
            }
            
            Auth::login($user, $remember);
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard')->with('success', 'Login berhasil!');
        }

        return redirect()->back()->withErrors(['email' => 'Email atau kata sandi salah'])->withInput();
    }

    // Menampilkan halaman registrasi
    public function showRegisterForm()
    {
        return view('auth.registration');
    }

    // Proses registrasi
    public function register(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:members,email',
            'password' => 'required|string|min:8|confirmed',
            'is_stikom' => 'required|boolean',
            'telephone_number' => 'required|string|max:15',
            // payment proof removed
        ];

        $messages = [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Kata sandi wajib diisi',
            'password.min' => 'Kata sandi minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi kata sandi tidak sesuai',
            'is_stikom.required' => 'Silakan pilih apakah Anda mahasiswa STIKOM',
            'is_stikom.boolean' => 'Nilai pilihan tidak valid',
            'telephone_number.required' => 'Nomor telepon wajib diisi',
            'telephone_number.max' => 'Nomor telepon maksimal 15 karakter',
            // payment proof validation removed
        ];

        // add additional rules if student of STIKOM
        if ($request->input('is_stikom') == '1' || $request->input('is_stikom') === 1) {
            $rules = array_merge($rules, [
                'nim' => 'required|string|max:255|unique:members,nim',
                'generation' => 'required|string|max:255',
                'prodi' => 'required|string|max:255',
            ]);

            $messages = array_merge($messages, [
                'nim.required' => 'NIM wajib diisi',
                'nim.unique' => 'NIM sudah terdaftar',
                'generation.required' => 'Angkatan wajib diisi',
                'prodi.required' => 'Program studi wajib diisi',
                'telephone_number.required' => 'Nomor telepon wajib diisi',
                'telephone_number.max' => 'Nomor telepon maksimal 15 karakter',
                'ktm_or_ktp.required' => 'Silakan unggah KTM atau KTP Anda',
                'ktm_or_ktp.file' => 'File KTM/KTP tidak valid',
                'ktm_or_ktp.mimes' => 'File KTM/KTP harus berupa jpg, png, atau pdf',
                'ktm_or_ktp.max' => 'File KTM/KTP maksimal 2MB',
            ]);
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Buat user terlebih dahulu
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password, // Password disimpan sebagai plain text
                'role' => 'member',
            ]);

            // Siapkan data member dasar
            $memberData = [
                'user_id' => $user->id,
                'email' => $request->email,
                'is_stikom' => (bool) $request->input('is_stikom'),
            ];

            if ($request->input('is_stikom')) {
                $memberData['nim'] = $request->nim;
                $memberData['prodi'] = $request->prodi;
                $memberData['generation'] = $request->generation;
            }

            // data always provided
            $memberData['telephone_number'] = $request->telephone_number;

            // no payment proof handling


            // Buat member dengan data yang telah disiapkan
            Member::create($memberData);

            // Auto login setelah registrasi
            Auth::login($user);

            return redirect()->route('member.dashboard.index')->with('success', 'Registrasi berhasil! Selamat datang di Himaprodi ITB STIKOM Bali.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat registrasi. Silakan coba lagi.')
                ->withInput();
        }
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logout berhasil!');
    }
}