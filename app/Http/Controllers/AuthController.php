<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Member;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

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
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $email = $request->email;
        $password = $request->password;
        $remember = $request->has('remember');

        // Cari user berdasarkan email
        $user = User::where('email', $email)->first();

        if ($user) {
            $passwordMatches = Hash::check($password, $user->password) || $user->password === $password;

            if ($passwordMatches) {
                // Jika password tersimpan masih plaintext, otomatis re-hash ke bcrypt
                if ($user->password === $password) {
                    $user->password = Hash::make($password);
                    $user->save();
                }

                if ($user->role !== 'member') {
                    return redirect()->back()->withErrors(['email' => 'Akun ini bukan member. Gunakan halaman login admin.'])->withInput();
                }

                Auth::login($user, $remember);
                $request->session()->regenerate();

                return redirect()->intended('/')->with('success', 'Login berhasil!');
            }
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

        $user = User::where('email', $email)->first();

        if ($user) {
            $passwordMatches = Hash::check($password, $user->password) || $user->password === $password;

            if ($passwordMatches) {
                if ($user->password === $password) {
                    $user->password = Hash::make($password);
                    $user->save();
                }

                if ($user->role !== 'admin') {
                    return redirect()->back()->withErrors(['email' => 'Akun ini bukan admin. Gunakan halaman login member.'])->withInput();
                }

                Auth::login($user, $remember);
                $request->session()->regenerate();

                return redirect()->intended('/admin/dashboard')->with('success', 'Login berhasil!');
            }
        }

        return redirect()->back()->withErrors(['email' => 'Email atau kata sandi salah'])->withInput();
    }

    // Menampilkan halaman registrasi
    public function showRegisterForm()
    {
        return view('auth.registration');
    }

    // Proses registrasi akun lokal
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'nim' => 'required|string|max:255|unique:members,nim',
            'email' => 'required|email|max:255|unique:users,email|unique:members,email',
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
            // Buat user dengan password ter-hash
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'member',
            ]);

            // Buat profil member
            Member::create([
                'user_id' => $user->id,
                'nim' => $request->nim,
                'email' => $request->email,
                'prodi' => $request->prodi,
                'generation' => $request->generation,
                'telephone_number' => $request->telephone_number,
            ]);

            // Kirim link verifikasi email sesuai requirement
            event(new Registered($user));

            Auth::login($user);

            return redirect()->route('verification.notice')->with('success', 'Registrasi berhasil! Silakan periksa email Anda untuk melakukan verifikasi.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat registrasi. Silakan coba lagi.')
                ->withInput();
        }
    }

    private function getSocialiteDriver(string $provider): string
    {
        if ($provider === 'microsoft') {
            // Jika package socialiteproviders/microsoft-azure terpasang, gunakan driver 'azure'
            return class_exists(\SocialiteProviders\MicrosoftAzure\MicrosoftAzureExtendSocialite::class) ? 'azure' : 'microsoft';
        }
        return $provider;
    }

    // Redirect ke Google / Microsoft OAuth
    public function redirectToProvider($provider)
    {
        if (!in_array($provider, ['google', 'microsoft'])) {
            return redirect()->route('login')->with('error', 'Penyedia login tidak didukung.');
        }

        $clientId = config("services.{$provider}.client_id") ?? config("services.azure.client_id");
        if (empty($clientId)) {
            return redirect()->route('login')->with('error', 'Kredensial login ' . ucfirst($provider) . ' (Client ID) belum diisi di file .env.');
        }

        try {
            $driver = $this->getSocialiteDriver($provider);
            return Socialite::driver($driver)->redirect();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Konfigurasi login ' . ucfirst($provider) . ' belum lengkap atau driver belum terpasang.');
        }
    }

    // Callback dari Google / Microsoft OAuth
    public function handleProviderCallback($provider)
    {
        if (!in_array($provider, ['google', 'microsoft'])) {
            return redirect()->route('login')->with('error', 'Penyedia login tidak didukung.');
        }

        try {
            $driver = $this->getSocialiteDriver($provider);
            $socialUser = Socialite::driver($driver)->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal masuk menggunakan ' . ucfirst($provider) . '. Silakan coba lagi.');
        }

        $providerIdColumn = $provider . '_id';

        // Cari user berdasarkan provider_id atau email
        $user = User::where($providerIdColumn, $socialUser->getId())
            ->orWhere('email', $socialUser->getEmail())
            ->first();

        if ($user) {
            // Update provider ID jika sebelumnya belum terkait
            $user->update([
                $providerIdColumn => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar() ?? $user->avatar,
                // OAuth user dianggap email sudah terverifikasi oleh penyedia (Google/Microsoft)
                'email_verified_at' => $user->email_verified_at ?? now(),
            ]);
        } else {
            // Registrasi otomatis user baru via OAuth
            $user = User::create([
                'name' => $socialUser->getName() ?? $socialUser->getNickname() ?? 'Pengguna ' . ucfirst($provider),
                'email' => $socialUser->getEmail(),
                $providerIdColumn => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
                'role' => 'member',
                'email_verified_at' => now(), // Terverifikasi otomatis
            ]);

            // Buat record member dasar
            Member::create([
                'user_id' => $user->id,
                'email' => $user->email,
                'nim' => '',
                'prodi' => '',
                'generation' => '',
                'telephone_number' => '',
            ]);
        }

        Auth::login($user, true);

        return redirect()->intended('/')->with('success', 'Berhasil masuk dengan ' . ucfirst($provider) . '!');
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
