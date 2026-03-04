<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

        if ($user && Hash::check($password, $user->password)) {
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

        if ($user && Hash::check($password, $user->password)) {
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'nim' => 'required|string|max:255|unique:members,nim',
            'email' => 'required|email|max:255|unique:members,email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'generation' => 'required|string|max:255',
            'prodi' => 'required|string|max:255',
            'telephone_number' => 'required|string|max:15',
        ], [
            'name.required' => 'Nama wajib diisi',
            'nim.required' => 'NIM wajib diisi',
            'nim.unique' => 'NIM sudah terdaftar',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Kata sandi wajib diisi',
            'password.min' => 'Kata sandi minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi kata sandi tidak sesuai',
            'generation.required' => 'Angkatan wajib diisi',
            'prodi.required' => 'Program studi wajib diisi',
            'telephone_number.required' => 'Nomor telepon wajib diisi',
            'telephone_number.max' => 'Nomor telepon maksimal 15 karakter',
        ]);

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
                'password' => Hash::make($request->password),
                'role' => 'member',
            ]);

            // Buat member dengan relasi ke user
            Member::create([
                'user_id' => $user->id,
                'nim' => $request->nim,
                'email' => $request->email,
                'prodi' => $request->prodi,
                'generation' => $request->generation,
                'telephone_number' => $request->telephone_number,
            ]);

            // Auto login setelah registrasi
            Auth::login($user);

            return redirect()->route('landing.index')->with('success', 'Registrasi berhasil! Selamat datang di Himaprodi ITB STIKOM Bali.');
        }
        catch (\Exception $e) {
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