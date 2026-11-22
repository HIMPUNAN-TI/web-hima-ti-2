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
                            <a href="{{ url('/') }}" class="navbar-brand navbar-brand-autodark"><img
                                    src="{{ asset('tabler/static/logo/hima.png') }}" height="100" alt="Logo Hima"></a>
                            <a href="{{ url('/') }}" class="navbar-brand navbar-brand-autodark"><img
                                    src="{{ asset('tabler/static/logo/logo_raw.png') }}" height="100"
                                    alt="Logo Hima"></a>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <div class="d-flex">
                                    <div>{{ session('success') }}</div>
                                </div>
                                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <div class="d-flex">
                                    <div>{{ session('error') }}</div>
                                </div>
                                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                            </div>
                        @endif

                        @if (session('status'))
                            <div class="alert alert-info alert-dismissible" role="alert">
                                <div class="d-flex">
                                    <div>{{ session('status') }}</div>
                                </div>
                                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                            </div>
                        @endif

                        <div class="card card-md">
                            <div class="card-body">
                                <h2 class="h2 text-center mb-2" style="font-weight: 400">Login to <b>Himaprodi ITB
                                        Stikom Bali</b></h2>
                                <p class="text-muted text-center mb-4">Untuk akses sistem ini, Anda dapat login dengan akun Google, Microsoft, atau email Anda.</p>

                                <form action="{{ route('login') }}" method="POST" autocomplete="off" novalidate>
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Surel (Email) <span class="required">*</span></label>
                                        <input type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            placeholder="emailanda@gmail.com" value="{{ old('email') }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">
                                            Kata Sandi <span class="required">*</span>
                                            <span class="form-label-description">
                                                <a href="{{ route('password.request') }}">Lupa kata sandi?</a>
                                            </span>
                                        </label>
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

                                <div class="hr-text">atau masuk dengan</div>

                                <div class="row g-2">
                                    <div class="{{ config('services.microsoft.client_id') ? 'col-6' : 'col-12' }}">
                                        <a href="{{ route('oauth.redirect', 'google') }}" class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12.24 10.285V13.4h6.887C18.2 16.27 15.6 18.5 12.24 18.5c-3.59 0-6.5-2.91-6.5-6.5s2.91-6.5 6.5-6.5c1.63 0 3.12.61 4.27 1.62l2.35-2.35C17.43 3.39 14.99 2.5 12.24 2.5 7.02 2.5 2.75 6.77 2.75 12s4.27 9.5 9.49 9.5c5.46 0 9.1-3.84 9.1-9.28 0-.62-.06-1.22-.18-1.715H12.24z"/>
                                            </svg>
                                            Google
                                        </a>
                                    </div>
                                    @if(config('services.microsoft.client_id'))
                                    <div class="col-6">
                                        <a href="{{ route('oauth.redirect', 'microsoft') }}" class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M11.4 11.4H3V3h8.4v8.4zm9.6 0H12.6V3H21v8.4zM11.4 21H3v-8.4h8.4V21zm9.6 0H12.6v-8.4H21V21z"/>
                                            </svg>
                                            Microsoft
                                        </a>
                                    </div>
                                    @endif
                                </div>

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
