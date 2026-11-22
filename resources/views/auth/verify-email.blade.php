<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Verifikasi Email | Himaprodi TI ITB STIKOM Bali</title>
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

            @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <div class="d-flex">
                        <div>{{ session('success') }}</div>
                    </div>
                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
            @endif

            <div class="card card-md">
                <div class="card-body text-center py-4 p-sm-5">
                    <img src="{{ asset('tabler/static/illustrations/undraw_sign_in_e6hj.svg') }}" height="120" class="mb-n2" alt="">
                    <h1 class="mt-4">Verifikasi Alamat Email Anda</h1>
                    <p class="text-secondary">
                        Terima kasih telah mendaftar! Tautan verifikasi telah dikirim ke alamat email Anda. Silakan klik tautan tersebut untuk mengaktifkan akun Anda.
                    </p>
                    <p class="text-secondary text-sm">
                        Belum menerima email verifikasi? Periksa folder spam atau minta pengiriman ulang di bawah ini.
                    </p>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100">
                            Kirim Ulang Email Verifikasi
                        </button>
                    </form>
                </div>
            </div>

            <div class="text-center text-secondary mt-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-link link-secondary">Keluar / Ganti Akun</button>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('tabler/dist/js/tabler.min.js') }}" defer></script>
</body>

</html>
