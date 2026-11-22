<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Lupa Kata Sandi | Himaprodi TI ITB STIKOM Bali</title>
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
    </style>
</head>

<body class="d-flex flex-column">
    <div class="page page-center">
        <div class="container container-tight py-4">
            <div class="text-center mb-4">
                <a href="{{ url('/') }}" class="navbar-brand navbar-brand-autodark"><img
                        src="{{ asset('tabler/static/logo/hima.png') }}" height="90" alt="Logo Hima"></a>
            </div>

            @if (session('status'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <div class="d-flex">
                        <div>{{ session('status') }}</div>
                    </div>
                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
            @endif

            <form class="card card-md" action="{{ route('password.email') }}" method="POST" autocomplete="off">
                @csrf
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Lupa Kata Sandi</h2>
                    <p class="text-secondary mb-4">
                        Masukkan alamat email Anda yang terdaftar. Kami akan mengirimkan tautan reset kata sandi ke email Anda.
                    </p>
                    <div class="mb-3">
                        <label class="form-label">Alamat Email</label>
                        <input type="email" name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="emailanda@gmail.com" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">
                            Kirim Tautan Reset Kata Sandi
                        </button>
                    </div>
                </div>
            </form>
            <div class="text-center text-secondary mt-3">
                Ingat kata sandi Anda? <a href="{{ route('login') }}" tabindex="-1">Kembali ke halaman masuk</a>
            </div>
        </div>
    </div>
    <script src="{{ asset('tabler/dist/js/tabler.min.js') }}" defer></script>
</body>

</html>
