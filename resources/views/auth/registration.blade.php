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
        /* Collapsible slide-down transition for form sections */
        /* collapsible: smooth fade-in and slide-down animation */
        .collapsible {
            display: none;
            opacity: 0;
            animation: none;
        }
        .collapsible.open {
            display: block;
            animation: slideInDown 0.4s ease-out forwards;
        }
        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(-12px);
            }
        }
        .collapsible.closing {
            animation: fadeOut 0.3s ease-in forwards;
        }
        .right-illustration {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem;
        }
        .right-illustration img {
            max-height: 60vh;
            width: auto;
            height: auto;
            object-fit: contain;
        }
        /* shrink the page wrapper to fit its content so the white background doesn't stretch
           all the way down the viewport when the form is small */
        .page {
            min-height: auto !important;
        }
        /* give the container some sensible top/bottom spacing instead of auto centering */
        .page-center .container {
            margin-top: 2rem;
            margin-bottom: 2rem;
        }
        /* make the card narrower so initial view isn't too wide */
        .container-tight {
            max-width: 540px;
            margin: 0 auto;
        }
        .logo-pair { display:flex; gap:1rem; justify-content:center; align-items:center; }
        .logo-pair img { height:88px; }
        /* password toggle styling */
        .password-toggle { border: none; background: transparent; padding: 0.4rem; }
        .password-toggle svg { width: 20px; height: 20px; }
        /* card-md has default min-height; collapse it when content is small */
        .card.card-md {
            min-height: auto !important;
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
                        <div class="text-center mb-4 logo-pair">
                            <img src="{{ asset('image/landing/logo/hima.png') }}" alt="Logo Himaprodi TI">
                            <img src="{{ asset('image/landing/logo/logo_raw.png') }}" alt="Logo STIKOM Bali">
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
                                        <input type="text" name="name" autofocus aria-required="true"
                                            class="form-control @error('name') is-invalid @enderror"
                                            placeholder="Nama Lengkap Anda" value="{{ old('name') }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Apakah Anda mahasiswa STIKOM? <span class="required">*</span></label>
                                        <select name="is_stikom" id="is_stikom" class="form-select @error('is_stikom') is-invalid @enderror" required aria-required="true">
                                            <option value="" disabled {{ old('is_stikom') === null ? 'selected' : '' }}>-- pilih --</option>
                                            <option value="1" {{ old('is_stikom') == '1' ? 'selected' : '' }}>Ya</option>
                                            <option value="0" {{ old('is_stikom') == '0' ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                        @error('is_stikom')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div id="rest-fields" class="collapsible">
                                        <div id="stikom-fields" class="collapsible">
                                            <div class="mb-3">
                                                <label class="form-label">NIM (Nomor Induk Mahasiswa) <span
                                                        class="required">*</span></label>
                                                <input type="text" name="nim" inputmode="numeric" pattern="\d{8,15}"
                                                    class="form-control @error('nim') is-invalid @enderror"
                                                    placeholder="Contoh: 2312345678" value="{{ old('nim') }}">
                                                @error('nim')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Angkatan <span class="required">*</span></label>
                                                <input type="text" name="generation" inputmode="numeric" pattern="\d{4}"
                                                    class="form-control @error('generation') is-invalid @enderror"
                                                    placeholder="Contoh: 2023" value="{{ old('generation') }}">
                                                @error('generation')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <div class="form-label">Prodi (Program Studi) <span class="required">*</span>
                                                </div>
                                                    <select class="form-select @error('prodi') is-invalid @enderror"
                                                        name="prodi" aria-label="Pilih Program Studi">
                                                    <option value="" disabled {{ old('prodi') == '' ? 'selected' : '' }}>Pilih
                                                        program studi</option>
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
                                        </div>
                                        {{-- base fields that are always shown --}}
                                            <div class="mb-3">
                                            <label class="form-label">Surel (Email) <span class="required">*</span></label>
                                            <input type="email" name="email" inputmode="email" aria-required="true"
                                                class="form-control @error('email') is-invalid @enderror"
                                                placeholder="emailanda@gmail.com" value="{{ old('email') }}" required>
                                            <small class="form-hint text-muted">Gunakan surel aktif untuk verifikasi akun.</small>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                            <div class="mb-3">
                                            <label class="form-label">Kata Sandi <span class="required">*</span></label>
                                            <div class="input-group input-group-flat">
                                                <input type="password" name="password" minlength="8" aria-required="true"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    placeholder="Minimal 8 karakter" required>
                                            </div>
                                            <small class="form-hint text-muted">Minimal 8 karakter. Gunakan kombinasi huruf dan angka.</small>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Konfirmasi Kata Sandi <span
                                                    class="required">*</span></label>
                                            <div class="input-group input-group-flat">
                                                <input type="password" name="password_confirmation" minlength="8" class="form-control"
                                                    placeholder="Ulangi Kata Sandi" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Nomor Telepon <span class="required">*</span></label>
                                            <input type="tel" name="telephone_number" inputmode="tel" pattern="^08\d{8,12}$" aria-required="true"
                                                class="form-control @error('telephone_number') is-invalid @enderror"
                                                placeholder="08xxxxxxxxxx" value="{{ old('telephone_number') }}" required>
                                            @error('telephone_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-hint text-muted">Contoh: 081234567890</small>
                                        </div>
                                        <div class="form-footer">
                                            <button type="submit" class="btn btn-primary w-100">Daftar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="text-center text-secondary mt-3">
                            Sudah memiliki akun? <a href="{{ route('login') }}" tabindex="-1">Login</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg d-none d-md-block right-illustration">
                    <img src="{{ asset('tabler/static/illustrations/undraw_secure_login_pdn4.svg') }}"
                        class="d-block mx-auto img-fluid" alt="Ilustrasi keamanan login">
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('tabler/dist/js/tabler.min.js') }}" defer></script>
    <script src="{{ asset('tabler/dist/js/demo.min.js') }}" defer></script>
    <script>
        // toggle visibility with smooth collapsible slide-down
        document.addEventListener('DOMContentLoaded', function() {
            var select = document.getElementById('is_stikom');
            var rest = document.getElementById('rest-fields');
            var stikom = document.getElementById('stikom-fields');

            if (!select) return;

            function openSection(el) {
                if (!el) return;
                el.classList.remove('closing');
                el.classList.add('open');
                el.style.display = 'block';
            }

            function closeSection(el) {
                if (!el) return;
                el.classList.add('closing');
                el.classList.remove('open');
                // wait for animation to finish before hiding
                setTimeout(() => {
                    if (el.classList.contains('closing')) {
                        el.style.display = 'none';
                        el.classList.remove('closing');
                    }
                }, 300);
            }

            select.addEventListener('change', function(e) {
                var v = e.target.value;
                if (v === '1' || v === '0') {
                    openSection(rest);
                } else {
                    closeSection(rest);
                }

                if (v === '1') {
                    openSection(stikom);
                } else {
                    closeSection(stikom);
                }
            });

            // initialize state — hide collapsible sections, then open conditionally
            if (rest) { rest.style.display = 'none'; rest.classList.remove('open'); rest.classList.remove('closing'); }
            if (stikom) { stikom.style.display = 'none'; stikom.classList.remove('open'); stikom.classList.remove('closing'); }

            var val = select.value;
            if (val === '1' || val === '0') openSection(rest);
            if (val === '1') openSection(stikom);
            // Password show/hide toggle
            function createIconSVG(name){
                if(name==='eye') return '<svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 24 24" stroke-width="0" fill="currentColor"><path d="M12 5c-7 0-11 7-11 7s4 7 11 7 11-7 11-7-4-7-11-7zm0 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10z"/></svg>';
                return '<svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 24 24" stroke-width="0" fill="currentColor"><path d="M3 3l18 18-1.4 1.4L16.6 17C14.9 18.1 13 18.8 12 18.8 5 18.8 1 12 1 12s1.8-3 5-5l-4-4zm9 3a5 5 0 0 1 5 5c0 .6-.1 1.2-.3 1.8l-6.5-6.5c.6-.2 1.2-.3 1.8-.3z"/></svg>';
            }

            function setupPasswordToggle(selector){
                var btn = document.querySelector(selector);
                if(!btn) return;
                var targetId = btn.getAttribute('data-target');
                var input = document.getElementById(targetId);
                if(!input) return;
                btn.innerHTML = createIconSVG('eye');
                btn.addEventListener('click', function(){
                    if(input.type === 'password'){
                        input.type = 'text';
                        btn.innerHTML = createIconSVG('eye-off');
                        btn.setAttribute('aria-pressed','true');
                    } else {
                        input.type = 'password';
                        btn.innerHTML = createIconSVG('eye');
                        btn.setAttribute('aria-pressed','false');
                    }
                });
            }

            // add toggle buttons for password fields
            (function addToggleButtons(){
                var pass = document.querySelector('input[name="password"]');
                var passConfirm = document.querySelector('input[name="password_confirmation"]');
                if(pass){ pass.id = pass.id || 'password'; }
                if(passConfirm){ passConfirm.id = passConfirm.id || 'password_confirmation'; }

                // inject buttons next to inputs (input-group) if not present
                function injectButton(inputId){
                    var input = document.getElementById(inputId);
                    if(!input) return;
                    var wrapper = input.closest('.input-group');
                    if(!wrapper) return;
                    // avoid duplicate
                    if(wrapper.querySelector('.password-toggle')) return;
                    var span = document.createElement('span');
                    span.className = 'input-group-text p-0';
                    var btn = document.createElement('button');
                    btn.type = 'button'; btn.className = 'password-toggle';
                    btn.setAttribute('aria-label','Tampilkan kata sandi');
                    btn.setAttribute('data-target', inputId);
                    span.appendChild(btn);
                    wrapper.appendChild(span);
                    setupPasswordToggle('.password-toggle[data-target="'+inputId+'"]');
                }
                injectButton('password');
                injectButton('password_confirmation');
            })();
        });
    </script>
</body>

</html>
