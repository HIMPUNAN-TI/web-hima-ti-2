<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

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

    // Proses login member
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
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            
            // Proteksi: Hanya member yang bisa login lewat sini
            if ($user->role !== 'member') {
                Auth::logout();
                return redirect()->back()->withErrors(['email' => 'Akun ini bukan member. Gunakan halaman login admin.'])->withInput();
            }

            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'Login berhasil!');
        }

        return redirect()->back()->withErrors(['email' => 'Email atau kata sandi salah'])->withInput();
    }

    // Proses login admin
    public function adminLogin(Request $request)
    {
        // ... (Logika login admin tetap sama, disesuaikan dengan role admin)
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (Auth::attempt($request->only('email', 'password'), $request->has('remember'))) {
            if (Auth::user()->role !== 'admin') {
                Auth::logout();
                return redirect()->back()->withErrors(['email' => 'Hanya Admin yang diizinkan masuk.'])->withInput();
            }
            return redirect()->intended('/admin/dashboard');
        }

        return redirect()->back()->withErrors(['email' => 'Kredensial admin tidak valid.'])->withInput();
    }

    // Menampilkan halaman registrasi
    public function showRegisterForm()
    {
        return view('auth.registration');
    }

    // Proses registrasi TERBARU (STIKOM vs NON-STIKOM)
    public function register(Request $request)
    
        // 1. Validasi Kondisional Berdasarkan Pilihan User
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'telephone_number' => ['required', 'string', 'max:15'],
            'is_stikom' => ['required', 'boolean'],
            
            // Jika is_stikom = 1 (Ya)
            'nim' => ['required_if:is_stikom,1', 'nullable', 'string', 'unique:users,nim'],
            'generation' => ['required_if:is_stikom,1', 'nullable', 'string'],
            'prodi' => ['required_if:is_stikom,1', 'nullable', 'string'],

            // Jika is_stikom = 0 (Bukan)
            'instansi_type' => ['required_if:is_stikom,0', 'nullable', 'in:SMA/SMK,Kuliah,Umum'],
            'asal_sekolah' => ['required_if:instansi_type,SMA/SMK', 'nullable', 'string'],
            'asal_kampus' => ['required_if:instansi_type,Kuliah', 'nullable', 'string'],
        ], [
            'is_stikom.required' => 'Status mahasiswa wajib dipilih.',
            'nim.required_if' => 'NIM wajib diisi bagi mahasiswa STIKOM.',
            'nim.unique' => 'NIM ini sudah terdaftar.',
            'instansi_type.required_if' => 'Silakan pilih tipe instansi Anda.',
            'asal_sekolah.required_if' => 'Nama asal sekolah wajib diisi.',
            'asal_kampus.required_if' => 'Nama asal kampus wajib diisi.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // 2. Simpan Data ke Tabel Users (Menghapus penggunaan tabel Member terpisah agar sinkron dengan model baru)
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'member', // Default role untuk registrasi publik
                'telephone_number' => $request->telephone_number,
                'is_stikom' => $request->is_stikom,

                // Data Mahasiswa STIKOM
                'nim' => $request->is_stikom == '1' ? $request->nim : null,
                'generation' => $request->is_stikom == '1' ? $request->generation : null,
                'prodi' => $request->is_stikom == '1' ? $request->prodi : null,

                // Data Non-STIKOM
                'instansi_type' => $request->is_stikom == '0' ? $request->instansi_type : null,
                'asal_sekolah' => ($request->is_stikom == '0' && $request->instansi_type == 'SMA/SMK') ? $request->asal_sekolah : null,
                'asal_kampus' => ($request->is_stikom == '0' && $request->instansi_type == 'Kuliah') ? $request->asal_kampus : null,
            ]);

            // 3. Buat record di tabel Members secara otomatis
            Member::create([
                'user_id'          => $user->id,
                'nim'              => $user->nim ?? ('non-' . $user->id),
                'email'            => $user->email,
                'telephone_number' => $user->telephone_number ?? '',
                'prodi'            => $user->prodi ?? ($user->instansi_type ?? 'Umum'),
                'generation'       => $user->generation ?? '-',
            ]);

            // 4. Login otomatis setelah berhasil daftar
            Auth::login($user);

            return redirect()->intended('/')->with('success', 'Registrasi berhasil! Selamat bergabung.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memproses pendaftaran. Silakan coba lagi.')
                ->withInput();
        }
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar.');
    }
}