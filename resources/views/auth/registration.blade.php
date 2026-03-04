@extends('layouts.auth_layout')

{{-- Image disamping form --}}
@php $illustration = 'Register.svg'; @endphp

{{-- 1. Tentukan Judul Tab Browser --}}
@section('title', 'Registrasi | Himaprodi TI ITB STIKOM Bali')

{{-- 2. Tentukan Judul di Dalam Kartu --}}
@section('header_title')
Registrasi <b>Himaprodi ITB Stikom Bali</b>
@endsection

{{-- 3. Tentukan Sub-judul --}}
@section('header_subtitle', 'Proses registrasinya cepat dan mudah, jadi tunggu apa lagi? Daftar sekarang dan nikmati pengalaman terbaik bersama kami!')

{{-- 4. Tentukan Route Form (disesuaikan dengan rute Laravel Anda) --}}
@section('form_action', route('register'))

{{-- 5. Isi Konten Form --}}
@section('content')
<style>
    /* Animasi halus untuk menampilkan/menyembunyikan kolom mahasiswa */
    #stikom-fields-container {
        display: none;
        transition: all 0.3s ease-in-out;
    }
</style>

<div class="mb-3">
    <label class="form-label">Nama <span class="required text-danger">*</span></label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
        placeholder="Nama Lengkap Anda" value="{{ old('name') }}" required>
    @error('name')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Apakah Anda mahasiswa STIKOM? <span class="required text-danger">*</span></label>
    <select name="is_stikom" id="is_stikom" class="form-select @error('is_stikom') is-invalid @enderror" required>
        <option value="" disabled {{ old('is_stikom') === null ? 'selected' : '' }}>-- pilih status --</option>
        <option value="1" {{ old('is_stikom') == '1' ? 'selected' : '' }}>Ya, saya mahasiswa STIKOM</option>
        <option value="0" {{ old('is_stikom') == '0' ? 'selected' : '' }}>Bukan mahasiswa STIKOM</option>
    </select>
    @error('is_stikom')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Kontainer Kolom Khusus Mahasiswa STIKOM --}}
<div id="stikom-fields-container">
    <div class="mb-3">
        <label class="form-label">NIM (Nomor Induk Mahasiswa) <span class="required text-danger">*</span></label>
        <input type="text" name="nim" id="nim_input" class="form-control @error('nim') is-invalid @enderror" placeholder="23xxxxxxxxx"
            value="{{ old('nim') }}">
        @error('nim')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Angkatan <span class="required text-danger">*</span></label>
        <input type="text" name="generation" id="generation_input" class="form-control @error('generation') is-invalid @enderror"
            placeholder="Contoh: 2023" value="{{ old('generation') }}">
        @error('generation')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <div class="form-label">Prodi (Program Studi) <span class="required text-danger">*</span></div>
        <select class="form-select @error('prodi') is-invalid @enderror" name="prodi" id="prodi_input">
            <option value="" disabled {{ old('prodi') ? '' : 'selected' }}>-- pilih prodi --</option>
            <option value="Teknologi Informasi" {{ old('prodi') == 'Teknologi Informasi' ? 'selected' : '' }}>Teknologi Informasi</option>
            <option value="Sistem Informasi" {{ old('prodi') == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
            <option value="Sistem Komputer" {{ old('prodi') == 'Sistem Komputer' ? 'selected' : '' }}>Sistem Komputer</option>
            <option value="Manajemen Informatika" {{ old('prodi') == 'Manajemen Informatika' ? 'selected' : '' }}>Manajemen Informatika</option>
            <option value="Bisnis Digital" {{ old('prodi') == 'Bisnis Digital' ? 'selected' : '' }}>Bisnis Digital</option>
        </select>
        @error('prodi')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Surel (Email) <span class="required text-danger">*</span></label>
    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
        placeholder="email@gmail.com" value="{{ old('email') }}" required>
    @error('email')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Kata Sandi <span class="required text-danger">*</span></label>
    <div class="input-group input-group-flat">
        <input type="password" name="password" id="password"
            class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter" required>
        <span class="input-group-text">
            <a href="#" class="link-secondary toggle-password" data-target="password" title="Tampilkan sandi"
                data-bs-toggle="tooltip">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M10.584 10.587a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                    <path
                        d="M9.363 5.365a9.466 9.466 0 0 1 2.637 -.365c4 0 7.333 2.333 10 7c-.778 1.361 -1.612 2.524 -2.503 3.488m-2.14 1.861c-1.631 1.1 -3.415 1.651 -5.357 1.651c-4 0 -7.333 -2.333 -10 -7c1.369 -2.395 2.913 -4.175 4.632 -5.341" />
                    <path d="M3 3l18 18" />
                </svg>
            </a>
        </span>
    </div>
    @error('password')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Konfirmasi Kata Sandi <span class="required text-danger">*</span></label>
    <div class="input-group input-group-flat">
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
            placeholder="Ulangi Kata Sandi" required>
        <span class="input-group-text">
            <a href="#" class="link-secondary toggle-password" data-target="password_confirmation"
                title="Tampilkan sandi" data-bs-toggle="tooltip">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M10.584 10.587a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                    <path
                        d="M9.363 5.365a9.466 9.466 0 0 1 2.637 -.365c4 0 7.333 2.333 10 7c-.778 1.361 -1.612 2.524 -2.503 3.488m-2.14 1.861c-1.631 1.1 -3.415 1.651 -5.357 1.651c-4 0 -7.333 -2.333 -10 -7c1.369 -2.395 2.913 -4.175 4.632 -5.341" />
                    <path d="M3 3l18 18" />
                </svg>
            </a>
        </span>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Nomor Telepon <span class="required text-danger">*</span></label>
    <input type="text" name="telephone_number" class="form-control @error('telephone_number') is-invalid @enderror"
        placeholder="08xxxxxxxxxx" value="{{ old('telephone_number') }}" required>
    @error('telephone_number')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-footer">
    <button type="submit" class="btn btn-primary w-100">Daftar</button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const isStikomSelect = document.getElementById('is_stikom');
        const stikomFields = document.getElementById('stikom-fields-container');
        
        // Input fields agar bisa di-toggle required-nya
        const nimInput = document.getElementById('nim_input');
        const genInput = document.getElementById('generation_input');
        const prodiInput = document.getElementById('prodi_input');

        function toggleStikomFields() {
            if (isStikomSelect.value === '1') {
                stikomFields.style.display = 'block';
                nimInput.setAttribute('required', 'required');
                genInput.setAttribute('required', 'required');
                prodiInput.setAttribute('required', 'required');
            } else {
                stikomFields.style.display = 'none';
                nimInput.removeAttribute('required');
                genInput.removeAttribute('required');
                prodiInput.removeAttribute('required');
            }
        }

        // Jalankan saat ada perubahan
        isStikomSelect.addEventListener('change', toggleStikomFields);

        // Jalankan saat halaman dimuat (untuk menangani 'old' value)
        toggleStikomFields();
    });
</script>
@endsection

{{-- 6. Isi Link di Bawah Kartu --}}
@section('footer_links')
Sudah memiliki akun? <a href="{{ route('login') }}" tabindex="-1">Login</a>
@endsection