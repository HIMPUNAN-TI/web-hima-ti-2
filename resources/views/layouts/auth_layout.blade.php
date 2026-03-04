<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>@yield('title') | Himaprodi TI ITB STIKOM Bali</title>
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
            min-height: 100vh;
        }

        .page-center {
            animation: fadeIn 0.6s ease-out;
            /* Efek masuk halus */
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .required {
            color: #d63939;
            margin-left: 2px;
        }

        .footer-custom {
            margin-top: auto;
            padding: 2rem 0;
            text-align: center;
            color: var(--tblr-secondary);
            font-size: 0.875rem;
        }
    </style>
</head>

<body class="d-flex flex-column">
    <script src="{{ asset('tabler/dist/js/demo-theme.min.js') }}"></script>

    <div class="page">
        <div class="page-center py-4">
            <div class="container container-normal">

                {{-- Tombol Back --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <a href="{{ url('/') }}" class="btn btn-ghost-secondary px-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-narrow-left me-1">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l14 0" />
                                <path d="M5 12l4 4" />
                                <path d="M5 12l4 -4" />
                            </svg>
                            Beranda
                        </a>
                    </div>
                </div>

                <div class="row align-items-center g-4">
                    <div class="col-lg">
                        <div class="container-tight">
                            <div class="text-center mb-4">
                                <a href="/" class="navbar-brand navbar-brand-autodark">
                                    <img src="{{ asset('tabler/static/logo/hima.png') }}" height="80" alt="Logo Hima">
                                </a>
                                <a href="/" class="navbar-brand navbar-brand-autodark">
                                    <img src="{{ asset('tabler/static/logo/logo_raw.png') }}" height="80" alt="Logo STIKOM">
                                </a>
                                <a href="/" class="navbar-brand navbar-brand-autodark">
                                    <img src="{{ asset('tabler/static/logo/kabinet.png') }}" height="80" alt="Logo Kabinet">
                                </a>
                            </div>
                            <div class="card card-md shadow-sm border-0">
                                <div class="card-body p-5">
                                    <h2 class="h2 text-center mb-2" style="font-weight: 600; letter-spacing: -0.02em;">@yield('header_title')</h2>
                                    <p class="text-muted text-center mb-4">@yield('header_subtitle')</p>

                                    <form action="@yield('form_action')" method="POST" autocomplete="off" novalidate>
                                        @csrf
                                        @yield('content')
                                    </form>
                                </div>
                            </div>
                            <div class="text-center text-secondary mt-3">
                                @yield('footer_links')
                            </div>
                        </div>
                    </div>
                    <div class="col-lg d-none d-lg-block text-center">
                        <img src="{{ asset('tabler/static/illustrations/' . ($illustration ?? 'Login.svg')) }}" style="max-height: 500px; width: auto;" class="img-fluid" alt="Illustration">
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer Sederhana --}}
        <footer class="footer-custom">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-auto">
                        &copy; {{ date('Y') }} Himaprodi TI ITB STIKOM Bali. All rights reserved.
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="{{ asset('tabler/dist/js/tabler.min.js') }}" defer></script>
    <script src="{{ asset('tabler/dist/js/demo.min.js') }}" defer></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglers = document.querySelectorAll('.toggle-password');
            togglers.forEach(toggler => {
                toggler.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('data-target');
                    const input = document.getElementById(targetId);
                    if (input) {
                        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                        input.setAttribute('type', type);

                        // Icon Toggle logic
                        if (type === 'text') {
                            this.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>`;
                        } else {
                            this.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.584 10.587a2 2 0 0 0 2.828 2.83" /><path d="M9.363 5.365a9.466 9.466 0 0 1 2.637 -.365c4 0 7.333 2.333 10 7c-.778 1.361 -1.612 2.524 -2.503 3.488m-2.14 1.861c-1.631 1.1 -3.415 1.651 -5.357 1.651c-4 0 -7.333 -2.333 -10 -7c1.369 -2.395 2.913 -4.175 4.632 -5.341" /><path d="M3 3l18 18" /></svg>`;
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>