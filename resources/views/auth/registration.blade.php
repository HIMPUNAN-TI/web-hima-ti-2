<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Registrasi | Himaprodi TI ITB STIKOM Bali</title>
    <link rel="icon" href="{{ asset('tabler/static/logo/hima.png') }}" type="image/x-icon">
    <link href="{{ asset('tabler/dist/css/tabler.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('tabler/dist/css/demo.min.css') }}" rel="stylesheet" />
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }

        .required {
            color: red;
            margin-left: 2px;
        }
    </style>
</head>

<body class=" d-flex flex-column">
    <script src="{{ asset('tabler/dist/js/demo-theme.min.js') }}"></script>
    <div class="page page-center">
        <div class="container container-normal py-4">
            <div class="row align-items-center g-4">
                <div class="col-lg">
                    <div class="container-tight">
                        <div class="text-center mb-4">
                            <a href="" class="navbar-brand navbar-brand-autodark"><img
                                    src="{{ asset('tabler/static/logo/hima.png') }}" height="100" alt="Logo Hima"></a>
                            <a href="" class="navbar-brand navbar-brand-autodark"><img
                                    src="{{ asset('tabler/static/logo/logo_raw.png') }}" height="100"
                                    alt="Logo Hima"></a>
                        </div>
                        <div class="card card-md">
                            <div class="card-body">
                                <h2 class="h2 text-center mb-2" style="font-weight: 400">Registrasi <b>Himaprodi ITB
                                        Stikom Bali</b></h2>
                                <p class="text-muted text-center mb-4">Proses registrasinya cepat dan mudah, jadi tunggu
                                    apa lagi? Daftar sekarang dan nikmati pengalaman terbaik bersama kami!</p>

                                <form action="{{ route('register') }}" method="POST" autocomplete="off" novalidate>
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Nama <span class="required">*</span></label>
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            placeholder="Nama Lengkap Anda" value="{{ old('name') }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">NIM (Nomor Induk Mahasiswa) <span
                                                class="required">*</span></label>
                                        <input type="text" name="nim"
                                            class="form-control @error('nim') is-invalid @enderror"
                                            placeholder="23xxxxxxxxx" value="{{ old('nim') }}" required>
                                        @error('nim')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Surel (Email) <span class="required">*</span></label>
                                        <input type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            placeholder="emailanda@gmail.com" value="{{ old('email') }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Kata Sandi <span class="required">*</span></label>
                                        <div class="input-group input-group-flat">
                                            <input type="password" name="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="Minimal 8 karakter" required>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Konfirmasi Kata Sandi <span
                                                class="required">*</span></label>
                                        <div class="input-group input-group-flat">
                                            <input type="password" name="password_confirmation" class="form-control"
                                                placeholder="Ulangi Kata Sandi" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Angkatan <span class="required">*</span></label>
                                        <input type="text" name="generation"
                                            class="form-control @error('generation') is-invalid @enderror"
                                            placeholder="Contoh: 2023" value="{{ old('generation') }}" required>
                                        @error('generation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nomor Telepon <span class="required">*</span></label>
                                        <input type="text" name="telephone_number"
                                            class="form-control @error('telephone_number"') is-invalid @enderror"
                                            placeholder="08xxxxxxxxxx" value="{{ old('telephone_number"') }}" required>
                                        @error('telephone_number"')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-label">Prodi (Program Studi) <span class="required">*</span>
                                        </div>
                                        <select class="form-select @error('prodi') is-invalid @enderror"
                                            name="prodi" required>
                                            <option value="Teknologi Informasi"
                                                {{ old('prodi') == 'Teknologi Informasi' ? 'selected' : '' }}>Teknologi
                                                Informasi</option>
                                            <option value="Sistem Informasi"
                                                {{ old('prodi') == 'Sistem Informasi' ? 'selected' : '' }}>Sistem
                                                Informasi</option>
                                            <option value="Sistem Komputer"
                                                {{ old('prodi') == 'Sistem Komputer' ? 'selected' : '' }}>Sistem
                                                Komputer</option>
                                            <option value="Manajemen Informatika"
                                                {{ old('prodi') == 'Manajemen Informatika' ? 'selected' : '' }}>
                                                Manajemen Informatika</option>
                                            <option value="Bisnis Digital"
                                                {{ old('prodi') == 'Bisnis Digital' ? 'selected' : '' }}>Bisnis Digital
                                            </option>
                                        </select>
                                        @error('prodi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-footer">
                                        <button type="submit" class="btn btn-primary w-100">Daftar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="text-center text-secondary mt-3">
                            Sudah memiliki akun? <a href="{{ route('login') }}" tabindex="-1">Login</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg d-none d-lg-block">
                    <img src="{{ asset('tabler/static/illustrations/undraw_secure_login_pdn4.svg') }}" height="700"
                        class="d-block mx-auto" alt="">
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('tabler/dist/js/tabler.min.js') }}" defer></script>
    <script src="{{ asset('tabler/dist/js/demo.min.js') }}" defer></script>
</body>

</html>
