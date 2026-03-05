@extends('layouts.auth_layout')

{{-- 1. Tentukan Judul Tab Browser --}}
@section('title', 'Login | Himaprodi TI ITB STIKOM Bali')

{{-- 2. Tentukan Judul di Dalam Kartu --}}
@section('header_title')
    Login to <b>Himaprodi ITB Stikom Bali</b>
@endsection

{{-- 3. Tentukan Sub-judul --}}
@section('header_subtitle', 'Masukkan email dan kata sandi Anda untuk masuk ke sistem.')

{{-- 4. Tentukan Route Form (disesuaikan dengan rute Laravel Anda) --}}
@section('form_action', route('login'))

{{-- 5. Isi Konten Form --}}
@section('content')
    <div class="mb-3">
        <label class="form-label">Email <span class="required">*</span></label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
               placeholder="email@gmail.com" value="{{ old('email') }}" required>
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-2">
        <label class="form-label">Kata Sandi <span class="required">*</span></label>
        <div class="input-group input-group-flat">
            <input type="password" name="password" id="password" class="form-control" 
                   placeholder="Kata Sandi Anda" required>
            <span class="input-group-text px-2 px-2">
                {{-- Gunakan class 'toggle-password' dan data-target yang sesuai dengan ID input --}}
                <a href="#" class="link-secondary toggle-password" data-target="password" title="Lihat sandi">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.584 10.587a2 2 0 0 0 2.828 2.83" /><path d="M9.363 5.365a9.466 9.466 0 0 1 2.637 -.365c4 0 7.333 2.333 10 7c-.778 1.361 -1.612 2.524 -2.503 3.488m-2.14 1.861c-1.631 1.1 -3.415 1.651 -5.357 1.651c-4 0 -7.333 -2.333 -10 -7c1.369 -2.395 2.913 -4.175 4.632 -5.341" /><path d="M3 3l18 18" />
                    </svg>
                </a>
            </span>
        </div>
    </div>

    <div class="form-footer">
        <button type="submit" class="btn btn-primary w-100">Masuk</button>
    </div>
@endsection

{{-- 6. Isi Link di Bawah Kartu --}}
@section('footer_links')
    Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a><br>
    Login sebagai <a href="{{ route('admin.login') }}">Admin</a>
@endsection