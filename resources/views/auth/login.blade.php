<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Login | Himaprodi TI ITB STIKOM Bali</title>
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

<body class="d-flex flex-column">
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
                                <h2 class="h2 text-center mb-2" style="font-weight: 400">Login to <b>Himaprodi ITB
                                        Stikom Bali</b></h2>
                                <p class="text-muted text-center mb-4">Untuk akses sistem ini, Anda harus memasukkan
                                    nama pengguna dan sandi.</p>

                                <form action="{{ route('login') }}" method="POST" autocomplete="off" novalidate>
                                    @csrf <div class="mb-3">
                                        <label class="form-label">Surel (Email) <span class="required">*</span></label>
                                        <input type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            placeholder="emailanda@gmail.com" value="{{ old('email') }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Kata Sandi <span class="required">*</span></label>
                                        <div class="input-group input-group-flat">
                                            <input type="password" name="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="Kata Sandi Anda" required>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-check">
                                            <input type="checkbox" name="remember" class="form-check-input" />
                                            <span class="form-check-label">Ingat saya</span>
                                        </label>
                                    </div>
                                    <div class="form-footer">
                                        <button type="submit" class="btn btn-primary w-100">Masuk</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="text-center text-secondary mt-3">
                            Belum memiliki akun? <a href="{{ route('register') }}" tabindex="-1">Registrasi</a>
                        </div>
                        <div class="text-center text-secondary mt-2">
                            Login sebagai admin? <a href="{{ route('admin.login') }}" tabindex="-1">Login Admin</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg d-none d-lg-block">
                    <img src="{{ asset('tabler/static/illustrations/login.png') }}" height="700"
                        class="d-block mx-auto" alt="">
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('tabler/dist/js/tabler.min.js') }}" defer></script>
    <script src="{{ asset('tabler/dist/js/demo.min.js') }}" defer></script>
</body>

</html>
